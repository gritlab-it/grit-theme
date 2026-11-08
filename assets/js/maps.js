// * GRIT_SET Legend | Section Maps
// 01 | One Google SDK request shared by all map instances.
// 02 | Independent maps, markers and safe information windows.
// 03 | Lazy startup and consent/error states; HTML directions always remain available.
(function () {
    "use strict";

    let sdkPromise = null;
    const instances = [];
    let authenticationFailed = false;
    const previousAuthFailure = window.gm_authFailure;
    window.gm_authFailure = function () {
        authenticationFailed = true;
        instances.forEach((instance) => {
            instance.state = "error";
            instance.root.classList.remove("is-map-ready");
            instance.root.classList.add("is-map-unavailable");
            instance.status.textContent = instance.config.messages.error;
        });
        if (typeof previousAuthFailure === "function") previousAuthFailure();
    };

    // * GRIT_SET 01 | Reuse an existing SDK/importLibrary installed by another component.
    function loadMaps(key) {
        if (sdkPromise) return sdkPromise;
        if (window.google && window.google.maps && window.google.maps.Map) {
            return Promise.resolve(window.google.maps);
        }
        if (window.google && window.google.maps && window.google.maps.importLibrary) {
            sdkPromise = window.google.maps
                .importLibrary("maps")
                .then(() => window.google.maps)
                .catch((error) => {
                    sdkPromise = null;
                    throw error;
                });
            return sdkPromise;
        }
        sdkPromise = new Promise((resolve, reject) => {
            let ownScript = null;
            const timeout = window.setTimeout(() => fail(), 20000);
            function ready() {
                window.clearTimeout(timeout);
                if (window.google && window.google.maps && window.google.maps.Map) {
                    resolve(window.google.maps);
                } else {
                    reject(new Error("Maps SDK unavailable"));
                }
            }
            function fail() {
                window.clearTimeout(timeout);
                if (ownScript) ownScript.remove();
                reject(new Error("Maps SDK failed to load"));
            }
            const existing = document.querySelector(
                'script[src*="maps.googleapis.com/maps/api/js"], script[src*="maps.google.com/maps/api/js"]',
            );
            if (existing) {
                existing.addEventListener("load", ready, { once: true });
                existing.addEventListener("error", fail, { once: true });
                return;
            }
            // A unique callback avoids collisions with ACF/plugins using initMap().
            window.gritMapsReady = ready;
            const url = new URL("https://maps.googleapis.com/maps/api/js");
            url.searchParams.set("key", key);
            url.searchParams.set("callback", "gritMapsReady");
            url.searchParams.set("loading", "async");
            url.searchParams.set("v", "weekly");
            ownScript = document.createElement("script");
            ownScript.src = url.toString();
            ownScript.async = true;
            ownScript.addEventListener("error", fail, { once: true });
            document.head.appendChild(ownScript);
        }).catch((error) => {
            sdkPromise = null;
            throw error;
        });
        return sdkPromise;
    }

    // * GRIT_SET 02 | Use DOM text nodes instead of interpolating location content into HTML.
    function locationContent(location, label) {
        const content = document.createElement("div");
        content.className = "grit-map-info";
        if (location.description) {
            const description = document.createElement("p");
            description.textContent = location.description;
            content.appendChild(description);
        }
        const link = document.createElement("a");
        link.href = location.directions;
        link.target = "_blank";
        link.rel = "noopener noreferrer";
        link.textContent = label;
        content.appendChild(link);
        return content;
    }

    async function createMap(instance, maps) {
        const config = instance.config;
        const options = {
            center: config.locations[0].position,
            zoom: 12,
            gestureHandling: "cooperative",
            disableDefaultUI: true,
            zoomControl: true,
            keyboardShortcuts: true,
        };
        // Local styling is always applied; this section does not use cloud Map IDs.
        options.styles = config.styles;
        if (authenticationFailed || !consentAllowed()) {
            throw new Error("Maps initialization unavailable");
        }
        const map = new maps.Map(instance.canvas, options);
        const popup = new maps.InfoWindow();
        const bounds = new maps.LatLngBounds();
        const markers = [];
        config.locations.forEach((location) => {
            const markerOptions = { map, position: location.position, title: location.title };
            if (config.markerUrl) {
                markerOptions.icon = {
                    url: config.markerUrl,
                    scaledSize: new maps.Size(40, 40),
                    anchor: new maps.Point(20, 40),
                };
            }
            const marker = new maps.Marker(markerOptions);
            marker.addListener("click", () => {
                // Put the title beside Google's close control, not below an empty header row.
                const title = document.createElement("h3");
                title.className = "grit-map-info-title";
                title.textContent = location.title;
                popup.setOptions({ headerContent: title, ariaLabel: location.title });
                popup.setContent(locationContent(location, config.messages.directions));
                popup.open({ map, anchor: marker });
            });
            markers.push(marker);
            bounds.extend(location.position);
        });
        if (config.locations.length > 1) {
            map.fitBounds(bounds, 40);
            maps.event.addListenerOnce(map, "idle", () => {
                if (map.getZoom() > 16) map.setZoom(16);
            });
        }
        instance.map = map;
        instance.markers = markers;
        instance.popup = popup;
    }

    // * GRIT_SET 03 | Follow Complianz if present. No consent is granted or changed here.
    function consentAllowed() {
        if (typeof window.cmplz_has_service_consent === "function") {
            return window.cmplz_has_service_consent("google-maps", "marketing");
        }
        if (typeof window.cmplz_has_consent === "function") {
            return window.cmplz_has_consent("marketing");
        }
        return typeof window.complianz === "undefined";
    }

    async function initialize(instance) {
        if (!instance.visible || instance.state === "loading" || instance.state === "ready") return;
        if (!instance.config.key) {
            instance.status.textContent = instance.config.messages.missingKey;
            return;
        }
        if (!consentAllowed()) {
            instance.status.textContent = instance.config.messages.consent;
            return;
        }
        instance.state = "loading";
        instance.root.classList.remove("is-map-unavailable");
        instance.status.textContent = instance.config.messages.loading;
        instance.canvas.setAttribute("aria-busy", "true");
        try {
            const maps = await loadMaps(instance.config.key);
            // Consent may have changed while the remote script was loading.
            if (!consentAllowed()) {
                instance.state = "waiting";
                instance.status.textContent = instance.config.messages.consent;
                return;
            }
            await createMap(instance, maps);
            if (authenticationFailed) throw new Error("Maps authentication failed");
            instance.state = "ready";
            instance.root.classList.add("is-map-ready");
            instance.status.textContent = "";
        } catch (error) {
            instance.state = "error";
            instance.root.classList.add("is-map-unavailable");
            instance.status.textContent = instance.config.messages.error;
        } finally {
            instance.canvas.removeAttribute("aria-busy");
        }
    }

    function start() {
        document.querySelectorAll("[data-grit-map]").forEach((root) => {
            const data = root.querySelector(".grit-map-config");
            const canvas = root.querySelector(".grit-map-canvas");
            const status = root.querySelector(".grit-map-status");
            if (!data || !canvas || !status) return;
            let config;
            try {
                config = JSON.parse(data.textContent);
            } catch (error) {
                return;
            }
            if (!config.locations || !config.locations.length) return;
            const instance = { root, canvas, status, config, visible: false, state: "waiting" };
            instances.push(instance);
            if (typeof window.IntersectionObserver === "function") {
                const observer = new IntersectionObserver(
                    (entries) => {
                        if (entries.some((entry) => entry.isIntersecting)) {
                            instance.visible = true;
                            observer.disconnect();
                            initialize(instance);
                        }
                    },
                    { rootMargin: "200px" },
                );
                observer.observe(root);
            } else {
                instance.visible = true;
                initialize(instance);
            }
        });
    }

    // If consent is revoked, remove embedded map DOM; keep the static location list available.
    function updateConsent() {
        instances.forEach((instance) => {
            if (!consentAllowed() && instance.state === "ready") {
                instance.markers.forEach((marker) => {
                    if (marker.setMap) marker.setMap(null);
                    else marker.map = null;
                });
                instance.popup.close();
                instance.canvas.replaceChildren();
                instance.map = null;
                instance.markers = [];
                instance.root.classList.remove("is-map-ready");
                instance.state = "waiting";
            }
            initialize(instance);
        });
    }
    ["cmplz_status_change", "cmplz_status_change_service", "cmplz_enable_category"].forEach(
        (event) => {
            document.addEventListener(event, updateConsent);
        },
    );
    if (document.readyState === "loading")
        document.addEventListener("DOMContentLoaded", start, { once: true });
    else start();
})();
