// * GRIT_SET Scope the dollar alias to WordPress jQuery (noConflict compatible)
(function ($) {
// * GRIT_SET Legend | Frontend components
// 00 | Loader and native link behavior
// 01 | Entrance animations
// 02 | Header menus and sticky state
// 03 | Owl carousels
// 04 | Gallery sizing and Nivo Lightbox
// 05 | Magic Mouse
// 06 | Jarallax
// 07 | Masonry
// 08 | NProgress
// 09 | Collapse and tabs
// 10 | Video player
// 11 | Counters
// 12 | GSAP, ScrollTrigger, Lenis and decorative bars
// * GRIT_SET 00 | Loader and native link behavior
$(function () {
    setTimeout(function () {
        $("body").addClass("loaded");
    }, 1500);
});

$(document).ready(function () {
    $("a").on("click", function (e) {
        // Preserve modified clicks, other mouse buttons and previously handled events.
        if (
            e.isDefaultPrevented() ||
            (typeof e.button === "number" && e.button !== 0) ||
            e.metaKey || e.ctrlKey || e.shiftKey || e.altKey
        ) {
            return;
        }

        const link = $(this);
        const href = link.attr("href");
        const target = (link.attr("target") || "").toLowerCase();

        // Downloads and links targeting another browsing context keep their native behavior.
        if (!href || this.hasAttribute("download") || (target && target !== "_self")) return;
        if (this.protocol !== "http:" && this.protocol !== "https:") return;
        
        if (link.prop("hostname") !== window.location.hostname) return;
        
        if (href && href.indexOf("#") !== -1 && this.href.split("#")[0] === window.location.href.split("#")[0]) {
            return;
        }
        
        if (
            link.hasClass("no-load") ||
            link.closest(".gallery-icon").length > 0 ||
            link.attr("data-lightbox-gallery")
        ) {
            return;
        }
        
        e.preventDefault();
        
        $("body").removeClass("loaded");
        
        const delay = 1000;
        let start;
        
        const goToPage = (timestamp) => {
            if (!start) start = timestamp;
            const progress = timestamp - start;
            if (progress < delay) {
                window.requestAnimationFrame(goToPage);
            } else {
                window.location.assign(href);
            }
        };
        
        if (window.requestAnimationFrame) {
            window.requestAnimationFrame(goToPage);
        } else {
            setTimeout(() => {
                window.location.assign(href);
            }, delay);
        }
    });
});

window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        $("body").addClass("loaded");
    }
});


// * GRIT_SET 01 | Entrance animations
// Example: <div class="in__animate" data-animation="animate__fadeInUp animate__slow">
$(function () {
    if (!document.getElementById("content")) return;
    const elements = Array.from(document.querySelectorAll(".in__animate"));
    const motion = window.matchMedia ? window.matchMedia("(prefers-reduced-motion: reduce)") : null;
    // Keep content readable when animation settings or browser support are missing.
    if (typeof window.IntersectionObserver !== "function" || (motion && motion.matches)) {
        elements.forEach(element => element.classList.remove("hidden"));
        return;
    }
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const classes = (entry.target.getAttribute("data-animation") || "").trim().split(/\s+/).filter(Boolean);
            entry.target.classList.remove("hidden");
            if (classes.length) entry.target.classList.add("animate__animated", ...classes);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0, rootMargin: "0px" });
    elements.forEach(element => {
        if (!(element.getAttribute("data-animation") || "").trim()) {
            element.classList.remove("hidden");
            return;
        }
        element.classList.add("hidden");
        observer.observe(element);
    });
    if (motion && typeof motion.addEventListener === "function") motion.addEventListener("change", event => {
        if (!event.matches) return;
        observer.disconnect();
        elements.forEach(element => element.classList.remove("hidden"));
    });
});

// * GRIT_SET 02 | Header menus and sticky state
// * GRIT_SET Header navigation | Inline expansion (1), overlay dialogs (2–5), shared submenus and sticky state.
$(function () {
    document.querySelectorAll(".grit-header").forEach(function (header) {
        var panel = header.querySelector("[data-mobile-panel]");
        var inlineButtons = Array.from(header.querySelectorAll("[data-inline-menu-toggle]"));
        if (!panel && !inlineButtons.length) return;
        var openers = Array.from(
            header.querySelectorAll("[data-menu-open], [data-inline-menu-toggle]"),
        );
        var sticky = header.querySelector(".sticky-fix");
        var returnFocus = null;
        var isOpen = false;
        var stickyVisible = null;

        // * GRIT_SET Preset 1 expands the matching bar in flow, independently of overlay mechanics.
        function setInline(button, expanded) {
            var menu = document.getElementById(button.getAttribute("aria-controls"));
            if (!menu) return;
            button.setAttribute("aria-expanded", String(expanded));
            menu.classList.toggle("is-menu-open", expanded);
            if (!expanded)
                menu.querySelectorAll("[data-submenu-toggle]").forEach(function (child) {
                    setSubmenu(child, false);
                });
        }

        function setSubmenu(button, expanded) {
            var menu = document.getElementById(button.getAttribute("aria-controls"));
            if (!menu) return;
            button.setAttribute("aria-expanded", String(expanded));
            menu.hidden = !expanded;
            if (!expanded)
                menu.querySelectorAll("[data-submenu-toggle]").forEach(function (child) {
                    child.setAttribute("aria-expanded", "false");
                    var nested = document.getElementById(child.getAttribute("aria-controls"));
                    if (nested) nested.hidden = true;
                });
        }
        function setPanel(expanded, opener, restoreFocus) {
            isOpen = expanded;
            if (expanded) returnFocus = opener || document.activeElement;
            panel.inert = !expanded;
            panel.setAttribute("aria-hidden", String(!expanded));
            panel.classList.toggle("sidenav-open", expanded);
            panel.classList.toggle("sidenav-close", !expanded);
            document.documentElement.classList.toggle("grit-menu-open", expanded);
            openers.forEach(function (button) {
                button.setAttribute("aria-expanded", String(expanded));
            });
            if (expanded) {
                // * GRIT_SET Keep keyboard focus inside the dialog while its content reveal is delayed.
                panel.focus({ preventScroll: true });
                requestAnimationFrame(function () {
                    var closeButton = panel.querySelector("[data-menu-close]");
                    if (isOpen && getComputedStyle(closeButton).visibility === "visible")
                        closeButton.focus({ preventScroll: true });
                });
            } else {
                panel.querySelectorAll("[data-submenu-toggle]").forEach(function (button) {
                    setSubmenu(button, false);
                });
                if (
                    restoreFocus !== false &&
                    returnFocus &&
                    getComputedStyle(returnFocus).display !== "none"
                )
                    returnFocus.focus();
            }
        }
        // * GRIT_SET Focus the close button once the delayed content reveal makes it visible.
        if (panel)
            panel.addEventListener("transitionend", function (event) {
                if (
                    isOpen &&
                    (document.activeElement === panel ||
                        openers.indexOf(document.activeElement) !== -1) &&
                    getComputedStyle(panel.querySelector("[data-menu-close]")).visibility ===
                        "visible"
                ) {
                    panel.querySelector("[data-menu-close]").focus({ preventScroll: true });
                }
            });
        header.addEventListener("click", function (event) {
            var inlineToggle = event.target.closest("[data-inline-menu-toggle]");
            if (inlineToggle) {
                var expanded = inlineToggle.getAttribute("aria-expanded") !== "true";
                inlineButtons.forEach(function (button) {
                    setInline(button, button === inlineToggle && expanded);
                });
                return;
            }
            if (event.target.closest(".header-inline-nav a[href]"))
                inlineButtons.forEach(function (button) {
                    setInline(button, false);
                });
            var opener = event.target.closest("[data-menu-open]");
            if (opener) {
                setPanel(true, opener);
                return;
            }
            if (event.target.closest("[data-menu-close]")) {
                setPanel(false);
                return;
            }
            var submenu = event.target.closest("[data-submenu-toggle]");
            if (submenu) {
                setSubmenu(submenu, submenu.getAttribute("aria-expanded") !== "true");
                return;
            }
            // Only actual links close the panel; expanding a parent never closes it.
            if (isOpen && event.target.closest(".overlay-content a[href]"))
                setPanel(false, null, false);
        });
        document.addEventListener("click", function (event) {
            if (!header.contains(event.target)) {
                inlineButtons.forEach(function (button) {
                    setInline(button, false);
                });
                header
                    .querySelectorAll('[data-submenu-toggle][aria-expanded="true"]')
                    .forEach(function (button) {
                        setSubmenu(button, false);
                    });
            }
        });
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                if (isOpen) {
                    event.preventDefault();
                    setPanel(false);
                } else {
                    inlineButtons.forEach(function (button) {
                        if (button.getAttribute("aria-expanded") === "true") {
                            setInline(button, false);
                            button.focus();
                        }
                    });
                    var expanded = header.querySelectorAll(
                        '[data-submenu-toggle][aria-expanded="true"]',
                    );
                    if (expanded.length) {
                        expanded[expanded.length - 1].focus();
                        expanded.forEach(function (button) {
                            setSubmenu(button, false);
                        });
                    }
                }
            }
            if (event.key === "Tab" && isOpen) {
                var focusable = Array.from(
                    panel.querySelectorAll('a[href], button:not([disabled]), [tabindex="0"]'),
                ).filter(function (el) {
                    return (
                        el.getClientRects().length &&
                        !el.closest("[hidden]") &&
                        getComputedStyle(el).visibility === "visible"
                    );
                });
                var first = focusable[0],
                    last = focusable[focusable.length - 1];
                if (!first) {
                    event.preventDefault();
                    panel.focus({ preventScroll: true });
                } else if (document.activeElement === panel || !panel.contains(document.activeElement)) {
                    event.preventDefault();
                    (event.shiftKey ? last : first).focus();
                } else if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });
        // Desktop hover is an enhancement; click and keyboard controls remain available everywhere.
        header.querySelectorAll(".navbar-collapse .dropdown").forEach(function (item) {
            var button = item.querySelector("[data-submenu-toggle]");
            if (!button) return;
            item.addEventListener("mouseenter", function () {
                if (
                    window.matchMedia("(hover: hover)").matches &&
                    getComputedStyle(openers[0]).display === "none"
                )
                    setSubmenu(button, true);
            });
            item.addEventListener("mouseleave", function () {
                if (!item.contains(document.activeElement)) setSubmenu(button, false);
            });
        });
        function updateSticky() {
            if (!sticky) return;
            var visible = window.scrollY >= 500;
            if (!visible && stickyVisible)
                inlineButtons.forEach(function (button) {
                    if (sticky.contains(button)) setInline(button, false);
                });
            stickyVisible = visible;
            sticky.classList.toggle("sticky-in", visible);
            sticky.inert = !visible;
            sticky.setAttribute("aria-hidden", String(!visible));
        }
        window.addEventListener("scroll", updateSticky, { passive: true });
        window.addEventListener("resize", function () {
            inlineButtons.forEach(function (button) {
                setInline(button, false);
            });
            if (isOpen && getComputedStyle(openers[0]).display === "none")
                setPanel(false, null, false);
        });
        updateSticky();
    });
});

// * GRIT_SET 03 | Owl carousels
// * GRIT_SET Shared Owl presets and responsive class overrides
(function ($) {
    var breakpoints = { base: 0, sm: 576, md: 768, lg: 992, xl: 1200, xxl: 1400 };
    var numeric = {
        items: 'items', gap: 'margin', padding: 'stagePadding',
        speed: 'smartSpeed', timeout: 'autoplayTimeout'
    };
    var flags = {
        loop: 'loop', nav: 'nav', dots: 'dots', center: 'center',
        autoplay: 'autoplay', 'auto-height': 'autoHeight', 'auto-width': 'autoWidth',
        rewind: 'rewind', drag: 'mouseDrag', touch: 'touchDrag'
    };

    // * GRIT_SET Read exact class tokens; local carousel overrides its section
    function readClasses(element, overrides) {
        if (!element) return;
        Array.from(element.classList).sort().forEach(function (token) {
            var match = token.match(/^carousel-(items|gap|padding|speed|timeout)-(?:((?:sm|md|lg|xl|xxl))-)?(\d+(?:p\d+)?)$/);
            if (match) {
                var option = numeric[match[1]];
                var value = Number(match[3].replace('p', '.'));
                if ((option === 'items' && value < 1) || (option !== 'items' && !Number.isInteger(value))) return;
                var bp = breakpoints[match[2] || 'base'];
                overrides[bp] = overrides[bp] || {};
                overrides[bp][option] = value;
                return;
            }
            match = token.match(/^carousel-(no-)?(loop|nav|dots|center|autoplay|auto-height|auto-width|rewind|drag|touch)(?:-(sm|md|lg|xl|xxl))?$/);
            if (match) {
                var bp = breakpoints[match[3] || 'base'];
                overrides[bp] = overrides[bp] || {};
                overrides[bp][flags[match[2]]] = !match[1];
            } else if (token === 'carousel-left') {
                overrides[0] = overrides[0] || {};
                overrides[0].center = false;
            }
        });
    }

    // * GRIT_SET Resolve content defaults independently from visual modifiers
    function optionsFor($carousel, $section) {
        var options = {
            loop: true, margin: 20, autoHeight: false, autoWidth: false,
            center: false, nav: true, dots: true, autoplay: false,
            autoplayHoverPause: true, autoplayTimeout: 5000, smartSpeed: 250,
            navText: [
                window.navLeftArrow || "<i class='fa fa-chevron-left' aria-hidden='true'></i><span class='screen-reader-text'>Previous</span>",
                window.navRightArrow || "<i class='fa fa-chevron-right' aria-hidden='true'></i><span class='screen-reader-text'>Next</span>"
            ]
        };
        var counts = [1, 2, 3, 4, 5, 5];
        if ($section.hasClass('section_carousel_text')) counts = [1, 2, 3, 3, 4, 4];
        if ($section.hasClass('section_archive_carousel')) {
            counts = [1, 2, 3, 3, 3, 3];
            options.loop = false;
        }
        if ($section.hasClass('section_cube') || $section.hasClass('section_slides')) {
            counts = [1, 1, 1, 1, 1, 1];
            options.margin = 0;
        }
        if ($section.hasClass('section_slides')) {
            options.autoplay = true;
            options.animateOut = 'fadeOut';
            options.animateIn = 'fadeIn';
            options.smartSpeed = 1000;
        }
        var overrides = {};
        readClasses($section[0], overrides);
        readClasses($carousel[0], overrides);
        var accumulated = {};
        options.responsive = {};
        Object.keys(breakpoints).forEach(function (name, index) {
            var bp = breakpoints[name];
            Object.assign(accumulated, overrides[bp] || {});
            options.responsive[bp] = Object.assign({ items: counts[index] }, accumulated);
            // * GRIT_SET Full-width Slides use a single item: Owl fade does not support multi-item layouts.
            if ($section.hasClass('section_slides')) {
                Object.assign(options.responsive[bp], { items: 1, autoWidth: false, center: false, margin: 0 });
            }
        });
        // Respect reduced motion even when autoplay is enabled in a preset/class.
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            options.autoplay = false;
            Object.keys(options.responsive).forEach(function (bp) {
                options.responsive[bp].autoplay = false;
            });
        }
        return options;
    }

    // * GRIT_SET Initialize each carousel once; keep controls scoped to its instance
    $(function () {
        if (typeof $.fn.owlCarousel !== 'function') return;
        $('.owl-carousel').each(function () {
            var $carousel = $(this);
            if ($carousel.data('owl.carousel')) return;
            var $section = $carousel.closest('section');
            $carousel.owlCarousel(optionsFor($carousel, $section));
        });
    });
})(jQuery);

// * GRIT_SET 04 | Gallery sizing and Nivo Lightbox
// * GRIT_SET Static gallery columns and gaps from section class tokens
jQuery(function ($) {
    $('section.section_gallery').each(function () {
        var section = this;
        Array.from(section.classList).forEach(function (token) {
            var match = token.match(/^gallery-(cols|gap)-(?:((?:sm|md|lg|xl|xxl))-)?(\d+)$/);
            if (!match) return;
            var value = Number(match[3]);
            if (match[1] === 'cols' && (value < 1 || value > 12)) return;
            if (match[1] === 'gap' && value > 500) return;
            section.style.setProperty('--gallery-' + match[1] + '-' + (match[2] || 'base'), value + (match[1] === 'gap' ? 'px' : ''));
        });
    });
});

if (typeof jQuery.fn.nivoLightbox === "function") {
    $(document).ready(function () {
        $(".item-img-gallery").nivoLightbox({
            // The effect to use when showing the lightbox
            // fade, fadeScale, slideLeft, slideRight, slideUp, slideDown, fall
            effect: "slideUp",
            
            // The lightbox theme to use
            theme: "default",
            
            // Enable/Disable keyboard navigation
            keyboardNav: true,
            
            // Click image to close
            clickImgToClose: false,
            
            // Click overlay to close
            clickOverlayToClose: true,
            
            // Callback functions
            onInit: function () {},
            beforeShowLightbox: function () {},
            afterShowLightbox: function (lightbox) {},
            beforeHideLightbox: function () {},
            afterHideLightbox: function () {},
            beforePrev: function (element) {},
            onPrev: function (element) {},
            beforeNext: function (element) {},
            onNext: function (element) {},
            
            // Error message
            errorMessage:
            "The requested content cannot be loaded. Please try again later.",
        });
    });
}

// * GRIT_SET 05 | Magic Mouse
$(document).ready(function () {
    if (typeof window.magicMouse === "function") {
        $(".main").addClass("magicmouse_active");
        $(".btn").addClass("magic-hover magic-hover__square");
        
        // cursorOuter	Default: "circle-basic", other options : "disable"
        // hoverEffect	default: "circle-move", other options : "pointer-blur", "pointer-overlay"
        const options = {
            cursorOuter: "circle-basic",
            hoverEffect: "pointer-overlay",
            hoverItemMove: false,
            defaultCursor: false,
            outerWidth: 30,
            outerHeight: 30,
        };
        magicMouse(options);
    }
});

// * GRIT_SET 06 | Jarallax
// * GRIT_SET Initialize available Jarallax instances independently of Owl
jQuery(function ($) {
    if (typeof $.fn.jarallax !== 'function') return;
    $('.jarallax, .jarallax-keep-img, .jarallax-overlay').each(function () {
        if (this.jarallax) return;
        if (($(this).closest('.section_slides, .section_cube').length || $(this).hasClass('text-section-background')) && window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        var speed = $(this).data('speed');
        var isCover = $(this).closest('.section_slides, .section_cube').length > 0 || $(this).hasClass('text-section-background');
        // * GRIT_SET Slides/Cube | Move the image into Jarallax: a retained cover image would hide its motion.
        // Keep the animated layer above the slide background and below overlay/text.
        $(this).jarallax({
            speed: speed === undefined ? (isCover ? 0.5 : 0.9) : speed,
            keepImg: !isCover,
            zIndex: isCover ? 0 : -100,
            imgPosition: '50% 50%'
        });
    });
});

// * GRIT_SET 07 | Masonry
// * GRIT_SET Initialize Text and Archive Masonry grids once; Bootstrap remains the fallback.
jQuery(function () {
    if (typeof window.Masonry !== 'function') return;
    document.querySelectorAll('.section_text .js-grit-masonry, .section_archive .js-grit-masonry').forEach(function (grid) {
        if (!grid.querySelector('.masonry-item') || window.Masonry.data(grid)) return;
        var masonry = new window.Masonry(grid, {
            itemSelector: '.masonry-item',
            columnWidth: '.masonry-item',
            percentPosition: true,
            initLayout: false
        });
        var layout = function () { masonry.layout(); };
        if (typeof window.imagesLoaded === 'function') {
            window.imagesLoaded(grid).on('progress', layout).on('always', layout);
        } else {
            grid.querySelectorAll('img').forEach(function (img) {
                img.addEventListener('load', layout);
                img.addEventListener('error', layout);
            });
        }
        layout();
        if (document.fonts && document.fonts.ready) document.fonts.ready.then(layout);
    });
});

// * GRIT_SET 08 | NProgress
// Check the API: a script tag can exist even if the request failed.
$(function () {
    if (!window.NProgress || typeof window.NProgress.start !== "function") return;
    window.NProgress.start();
    setTimeout(function () { window.NProgress.done(); }, 1000);
});

// * GRIT_SET 09 | Collapse and tabs
// * GRIT_SET Collapse legend: List.js search, Bootstrap state sync, visible-tab Owl refresh
jQuery(function ($) {
    // * GRIT_SET One independent List.js instance per search section
    document.querySelectorAll('.js-collapse-search').forEach(function (root) {
        if (typeof window.List !== 'function' || root.gritCollapseList) return;
        var empty = root.querySelector('.collapse-empty');
        // Empty lists need no List.js template; preserve the accessible empty state.
        if (!root.querySelector('.item-search')) { empty.hidden = false; return; }
        var list = new window.List(root.id, {
            valueNames: ['search_title', 'search_text', 'search_group'],
            page: 7,
            pagination: [{
                paginationClass: 'pagination-list-js',
                innerWindow: 2,
                outerWindow: 1,
                item: '<li class="page-item"><button type="button" class="page page-link"></button></li>'
            }]
        });
        root.gritCollapseList = list;
        function updateState() {
            empty.hidden = list.matchingItems.length !== 0;
            root.querySelectorAll('.pagination-list-js button').forEach(function (button) {
                var active = button.parentElement.classList.contains('active');
                var dotted = button.parentElement.classList.contains('disabled');
                button.disabled = dotted;
                button.setAttribute('aria-label', dotted ? 'Altre pagine' : 'Pagina ' + button.textContent);
                if (active) button.setAttribute('aria-current', 'page');
                else button.removeAttribute('aria-current');
            });
            root.querySelector('.pagination-list-js').hidden = list.matchingItems.length <= list.page;
        }
        list.on('updated', updateState);
        updateState();
        // Native search clear/input events must also update lists in all browsers.
        root.querySelector('input.search').addEventListener('input', function () { list.search(this.value); });
    });

    // * GRIT_SET Follow actual Bootstrap transitions instead of predicting state on click
    $('.section_collapse').on('shown.bs.collapse hidden.bs.collapse', '.accordion_body', function (event) {
        if (event.target !== this) return;
        var trigger = document.getElementById(this.getAttribute('aria-labelledby'));
        if (!trigger) return;
        var expanded = $(this).hasClass('show');
        trigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        // Icon visibility is driven by aria-expanded in SCSS, even when Font Awesome replaces i with svg.
    });

    // * GRIT_SET Recalculate Owl after a previously hidden tab becomes measurable
    $('.section_collapse [data-toggle="tab"]').on('shown.bs.tab', function () {
        var id = this.getAttribute('aria-controls');
        var panel = id ? document.getElementById(id) : null;
        if (!panel) return;
        $(panel).find('.owl-carousel').each(function () {
            if ($(this).data('owl.carousel')) $(this).trigger('refresh.owl.carousel');
        });
    });
});

// * GRIT_SET 10 | Video player
// * GRIT_SET Video controller | Independent sections; no inline handlers or forced looping.
function initializeGritVideos() {
    document.querySelectorAll('[data-grit-video]').forEach(root => {
        if (root.dataset.videoReady) return;
        root.dataset.videoReady = 'true';
        const cover = root.querySelector('.video-cover');
        const button = cover && cover.querySelector('button');
        const local = root.querySelector('video');
        const template = root.querySelector('template.video-template');
        // * GRIT_SET No poster: request the first decodable frame without autoplay.
        // A tiny seek also lets browsers that show black after metadata fetch a frame.
        if (local && !local.getAttribute('poster')) {
            const showFirstFrame = () => {
                if (!local.paused || local.currentTime > 0 || !Number.isFinite(local.duration) || local.duration <= 0) return;
                try { local.currentTime = Math.min(0.01, local.duration / 2); }
                catch (error) { /* Native controls remain usable if seeking is unsupported. */ }
            };
            local.addEventListener('loadedmetadata', showFirstFrame, { once: true });
            if (local.readyState >= 1) showFirstFrame();
        }
        if (!button) return;
        cover.hidden = false;
        button.addEventListener('click', () => {
            if (template) {
                const container = root.querySelector('.video-embed');
                if (!container.children.length) {
                    const fragment = template.content.cloneNode(true);
                    fragment.querySelectorAll('iframe').forEach(iframe => {
                        // Respect consent placeholders: never promote data-src to src.
                        const src = iframe.getAttribute('src');
                        if (src) {
                            try {
                                const url = new URL(src, document.baseURI);
                                if (['www.youtube.com', 'youtube.com', 'www.youtube-nocookie.com', 'player.vimeo.com'].includes(url.hostname)) {
                                    url.searchParams.set('autoplay', '1');
                                    iframe.setAttribute('src', url.href);
                                    const allow = iframe.getAttribute('allow') || '';
                                    if (!allow.split(';').some(value => value.trim() === 'autoplay')) iframe.setAttribute('allow', allow ? allow + '; autoplay' : 'autoplay');
                                }
                            } catch (error) { /* Preserve the original source when it cannot be parsed. */ }
                        }
                        if (!iframe.getAttribute('title')) iframe.setAttribute('title', 'Video');
                    });
                    container.appendChild(fragment);
                }
                container.hidden = false;
                const frame = container.querySelector('iframe');
                if (frame) frame.focus();
            }
            cover.hidden = true;
            if (local) {
                local.focus();
                const playing = local.play();
                if (playing && typeof playing.catch === 'function') playing.catch(() => { /* Native controls remain available if playback is blocked. */ });
            }
        });
    });
}
$(initializeGritVideos);

// * GRIT_SET 11 | Counters
// * GRIT_SET Counter legend: final fallback, locale formatting, shared observer, timed animation
function startCounterAnimation() {
    const counters = Array.from(document.querySelectorAll('.number-animate'));
    if (!counters.length) return;
    const motion = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;
    const locale = document.documentElement.lang || undefined;
    const states = new Map();
    const observer = typeof window.IntersectionObserver === 'function'
        ? new IntersectionObserver(entries => entries.forEach(entry => {
            const state = states.get(entry.target);
            if (!state) return;
            if (entry.isIntersecting) start(state);
            else if (state.repeat) {
                cancelAnimationFrame(state.frame);
                state.running = false;
                state.element.textContent = state.finalText;
            }
        }), { threshold: 0.15 }) : null;

    // * GRIT_SET Interpolate by elapsed time; clamp the last frame to the exact target
    function start(state) {
        if (state.running || (state.started && !state.repeat) || (motion && motion.matches)) return;
        state.started = true;
        state.running = true;
        if (!state.repeat && observer) observer.unobserve(state.element);
        let startTime = null;
        const tick = time => {
            if (startTime === null) startTime = time;
            const progress = Math.min(1, (time - startTime) / state.duration);
            const eased = 1 - Math.pow(1 - progress, 3);
            const value = state.target * eased;
            state.element.textContent = progress === 1 ? state.finalText : state.format(value);
            if (progress < 1) state.frame = requestAnimationFrame(tick);
            else state.running = false;
        };
        state.element.textContent = state.format(0);
        state.frame = requestAnimationFrame(tick);
    }

    // * GRIT_SET Section settings apply to all counters; item duration may override them
    counters.forEach(element => {
        const section = element.closest('section');
        const item = element.closest('.item-chapters, .item-counter');
        const component = element.closest('.grit-counter');
        const tokens = [...(section ? section.classList : []), ...(item ? item.classList : []), ...(component ? component.classList : []), ...element.classList];
        const target = Number(element.dataset.counterEnd);
        const decimals = Number(element.dataset.counterDecimals || 0);
        let duration = 3000;
        tokens.forEach(token => {
            const match = token.match(/^counter-duration-(\d+)$/);
            if (match) duration = Math.min(60000, Number(match[1]));
        });
        if (element.hasAttribute('data-counter-duration') && Number.isFinite(Number(element.dataset.counterDuration))) {
            duration = Math.max(0, Math.min(60000, Number(element.dataset.counterDuration)));
        }
        const repeat = element.hasAttribute('data-counter-repeat') ? ['true', '1'].includes(element.dataset.counterRepeat) : tokens.includes('counter-repeat');
        const disabled = ['false', '0'].includes(element.dataset.counterAnimate) || tokens.includes('counter-no-animation');
        // Unsupported browsers and disabled/reduced animations retain server-rendered final values.
        if (!Number.isFinite(target) || Math.abs(target) > Number.MAX_SAFE_INTEGER ||
            !Number.isInteger(decimals) || decimals < 0 || decimals > 6 ||
            !observer || disabled || (motion && motion.matches) || duration === 0 || target === 0) return;
        let format = value => value.toFixed(decimals);
        try {
            const formatter = new Intl.NumberFormat(locale, { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
            format = value => formatter.format(value);
        } catch (error) { /* Keep the plain decimal fallback when locale/Intl is unavailable. */ }
        const state = { element, target, duration, format, finalText: element.textContent, repeat, running: false, started: false, frame: 0 };
        states.set(element, state);
        observer.observe(element);
    });

    // * GRIT_SET Respect reduced motion if the preference changes during playback
    if (motion && typeof motion.addEventListener === 'function') motion.addEventListener('change', event => {
        if (!event.matches) return;
        states.forEach(state => {
            cancelAnimationFrame(state.frame);
            state.running = false;
            state.element.textContent = state.finalText;
        });
        if (observer) observer.disconnect();
    });
}
$(startCounterAnimation);


// * GRIT_SET 12 | GSAP, ScrollTrigger, Lenis and decorative bars

// * GRIT_SET Motion legend | Shared by Section Text and image parallax.
// 01 | Optional Lenis and anchor navigation, respecting reduced motion.
// 02 | Native word wrapping: preserve HTML, links and original text on cleanup.
// 03 | Per-section effects; matchMedia restores animations and pin spacing.
// 04 | Rebuild safely after resize/fonts; images request a debounced refresh.
(function () {
    // Project settings: durations/scrub in seconds, offsets in percent, distances in pixels.
    // Change these values to tune the effects; the initialization and cleanup follow below.
    const motionSettings = {
        smoothScroll: {
            duration: 1.2,
            initialAnchorDuration: 1.1
        },
        horizontal: {
            scrub: 1 // Scroll-following delay for horizontal panels and lateral headings.
        },
        reveal: {
            initialOpacity: 0.15,
            duration: 0.6,
            wordDelay: 0.035, // Delay between words for the timed reveal.
            scrollSpread: 1.5, // Relative distribution of words in the scroll-driven reveal.
            start: 'top 85%',
            end: 'bottom 30%'
        },
        parallax: {
            scale: 1.1,
            fromY: -5,
            toY: 5
        },
        bars: {
            maxCount: 15, // Fewer bars may fit when space is limited.
            gap: 5,
            minRotation: -45,
            maxRotation: 45,
            scrollY: -80,
            scrub: 1,
            pointerDuration: 0.8,
            pointerStrength: 0.015
        }
    };

    const hasGSAP = !!(window.gsap && window.ScrollTrigger && window.gsap.matchMedia);
    const motion = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;
    let lenis = null, lenisFrame = 0;
    if (hasGSAP) gsap.registerPlugin(ScrollTrigger);

    // * GRIT_SET 01 | Keep smooth scrolling independent from GSAP availability.
    function tickLenis(time) { if (lenis) lenis.raf(time * 1000); }
    function updateLenis() {
        if (motion && motion.matches) {
            if (lenis) {
                if (typeof lenis.destroy === 'function') lenis.destroy();
                lenis = null;
                cancelAnimationFrame(lenisFrame);
                if (hasGSAP) gsap.ticker.remove(tickLenis);
            }
            return;
        }
        if (lenis || typeof window.Lenis !== 'function') return;
        lenis = new Lenis({ duration: motionSettings.smoothScroll.duration, easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)), smooth: true, smoothTouch: true });
        if (hasGSAP) {
            lenis.on('scroll', ScrollTrigger.update);
            gsap.ticker.add(tickLenis);
        } else {
            const frame = time => {
                if (!lenis) return;
                lenis.raf(time);
                lenisFrame = requestAnimationFrame(frame);
            };
            lenisFrame = requestAnimationFrame(frame);
        }
    }
    updateLenis();
    if (motion && motion.addEventListener) motion.addEventListener('change', updateLenis);
    document.addEventListener('click', function (event) {
        const anchor = event.target.closest('a[href*="#"]');
        if (!anchor || !lenis || event.defaultPrevented || event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
        if (anchor.matches('[data-toggle], [role="tab"], [role="button"], [download]') || anchor.target === '_blank') return;
        if (anchor.href.split('#')[0] !== window.location.href.split('#')[0]) return;
        let id;
        try { id = decodeURIComponent(anchor.hash.slice(1)); } catch (_) { return; }
        const target = document.getElementById(id);
        if (target) { event.preventDefault(); lenis.scrollTo(target); }
    });
    window.addEventListener('load', function () {
        let id;
        try { id = decodeURIComponent(window.location.hash.slice(1)); } catch (_) { return; }
        const target = document.getElementById(id);
        if (target && lenis) lenis.scrollTo(target, { duration: motionSettings.smoothScroll.initialAnchorDuration });
    });

    function initMotion() {
        if (!hasGSAP) return;
        let media = null, resizeTimer = 0, refreshTimer = 0;
        const refresh = () => {
            clearTimeout(refreshTimer);
            refreshTimer = setTimeout(() => {
                ScrollTrigger.sort();
                ScrollTrigger.refresh();
            }, 100);
        };

        // * GRIT_SET 02 | Wrap text nodes without replacing the surrounding markup.
        function wrapWords(root, cleanup) {
            const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
            const nodes = [];
            while (walker.nextNode()) {
                const node = walker.currentNode;
                if (node.textContent.trim() && !node.parentElement.closest('script, style, pre, code, textarea, button, svg, .grit-counter')) nodes.push(node);
            }
            const words = [];
            nodes.forEach(node => {
                const group = document.createElement('span');
                group.className = 'grit-word-group';
                node.textContent.split(/(\s+)/).forEach(part => {
                    if (!part) return;
                    if (/^\s+$/.test(part)) { group.appendChild(document.createTextNode(part)); return; }
                    const word = document.createElement('span');
                    word.className = 'word';
                    word.textContent = part;
                    group.appendChild(word);
                    words.push(word);
                });
                node.replaceWith(group);
                cleanup.push(() => group.replaceWith(node));
            });
            return words;
        }

        // * GRIT_SET 03 | Every rebuild first restores the previous DOM and GSAP context.
        function rebuild() {
            if (media) media.revert();
            media = gsap.matchMedia();
            media.add('(prefers-reduced-motion: no-preference)', () => {
                const cleanup = [], desktop = window.innerWidth >= 768, paired = new Set();
                function activate(section, name) {
                    section.classList.add(name);
                    cleanup.push(() => section.classList.remove(name));
                }
                const sections = Array.from(document.querySelectorAll('section.section_text'));
                const compatible = section => !section.matches('.section_masonry, .section_carousel_text');
                function horizontal(section, row, trigger = section, pin = true) {
                    const distance = () => Math.max(0, row.scrollWidth - row.clientWidth);
                    if (distance() <= 1) return;
                    gsap.to(row, { x: () => -distance(), ease: 'none', scrollTrigger: {
                        trigger, pin, start: 'top top', end: () => '+=' + distance(), scrub: motionSettings.horizontal.scrub, invalidateOnRefresh: true
                    } });
                }

                // * GRIT_SET Pin order | Create each pair where it occurs in the document.
                // Earlier pins must exist before measuring any following section.
                function initHorizontalPair(first) {
                    const second = first.nextElementSibling;
                    if (!second || !second.matches('section.section_text.section-gsap-30horizontal') || !compatible(second)) return;
                    const rowA = first.querySelector(':scope > .container-fluid > .row');
                    const rowB = second.querySelector(':scope > .container-fluid > .row');
                    if (!rowA || !rowB) return;
                    const wrapper = document.createElement('div');
                    wrapper.className = 'horizontal-wrapper';
                    first.before(wrapper); wrapper.append(first, second);
                    paired.add(first); paired.add(second);
                    const restorePair = () => { if (wrapper.parentNode) { wrapper.before(first, second); wrapper.remove(); } };
                    cleanup.push(restorePair);
                    if (Array.from(wrapper.querySelectorAll('.item-chapters')).some(panel => panel.scrollHeight > panel.clientHeight + 2)) {
                        restorePair(); paired.delete(first); paired.delete(second); return;
                    }
                    const distanceA = () => Math.max(0, rowA.scrollWidth - rowA.clientWidth);
                    const distanceB = () => Math.max(0, rowB.scrollWidth - rowB.clientWidth);
                    const a = distanceA(), b = distanceB();
                    if (a + b <= 1) {
                        restorePair(); paired.delete(first); paired.delete(second); return;
                    }
                    const timeline = gsap.timeline({ scrollTrigger: { trigger: wrapper, pin: true, start: 'top top', end: () => '+=' + (distanceA() + distanceB()), scrub: motionSettings.horizontal.scrub, invalidateOnRefresh: true } });
                    if (a) timeline.to(rowA, { x: () => -distanceA(), ease: 'none', duration: a });
                    if (b) timeline.to(rowB, { x: () => -distanceB(), ease: 'none', duration: b });
                }

                sections.filter(compatible).forEach(section => {
                    if (desktop && section.classList.contains('section-gsap-70horizontal')) initHorizontalPair(section);
                    if (paired.has(section)) return;
                    const panels = Array.from(section.querySelectorAll(':scope > .container-fluid > .row > .item-chapters'));
                    if (desktop && section.classList.contains('section-gsap-horizontal')) {
                        const row = section.querySelector(':scope > .container-fluid > .row');
                        if (row) {
                            activate(section, 'is-gsap-horizontal');
                            if (panels.some(panel => panel.scrollHeight > window.innerHeight + 2)) { section.classList.remove('is-gsap-horizontal'); return; }
                            horizontal(section, row);
                        }
                    } else if (desktop && section.classList.contains('section-gsap-vertical') && panels.length > 1) {
                        activate(section, 'is-gsap-vertical');
                        // Long content stays in normal flow instead of being trapped in a pinned panel.
                        if (panels.some(panel => panel.scrollHeight > window.innerHeight + 2)) { section.classList.remove('is-gsap-vertical'); return; }
                        panels.forEach((panel, i) => gsap.set(panel, { zIndex: panels.length - i }));
                        const timeline = gsap.timeline({ scrollTrigger: { trigger: section, pin: true, start: 'top top', end: () => '+=' + ((panels.length - 1) * window.innerHeight), scrub: true, invalidateOnRefresh: true } });
                        panels.slice(0, -1).forEach(panel => timeline.to(panel, { yPercent: -100, ease: 'none', duration: 1 }));
                    } else if (desktop && section.classList.contains('section-gsap-lateral-word')) {
                        const title = section.querySelector('.inner-text .gsap-lateral-text, .inner-text h1, .inner-text h2');
                        if (!title) return;
                        activate(section, 'is-gsap-lateral');
                        title.classList.add('grit-lateral-target');
                        cleanup.push(() => title.classList.remove('grit-lateral-target'));
                        const viewport = section.querySelector(':scope > .container-fluid') || section;
                        const distance = () => {
                            const style = getComputedStyle(viewport);
                            const available = viewport.clientWidth - parseFloat(style.paddingLeft || 0) - parseFloat(style.paddingRight || 0);
                            return Math.max(0, title.scrollWidth - available);
                        };
                        // Short titles keep the normal layout instead of an empty full-screen effect.
                        if (distance() <= 1) {
                            section.classList.remove('is-gsap-lateral');
                            title.classList.remove('grit-lateral-target');
                            return;
                        }
                        gsap.to(title, { x: () => -distance(), ease: 'none', scrollTrigger: { trigger: section, pin: true, start: 'top top', end: () => '+=' + distance(), scrub: motionSettings.horizontal.scrub, invalidateOnRefresh: true } });
                    } else if (section.matches('.section-gsap-reveal, .section-gsap-reveal-scroll')) {
                        activate(section, 'is-gsap-reveal');
                        const scroll = section.classList.contains('section-gsap-reveal-scroll');
                        section.querySelectorAll('.inner-text').forEach(block => {
                            block.querySelectorAll('h1,h2,h3,h4,h5,h6,p,li').forEach(target => {
                                if (target.matches('li') && target.querySelector('p,h1,h2,h3,h4,h5,h6')) return;
                                const words = wrapWords(target, cleanup);
                                if (!words.length) return;
                                gsap.fromTo(words, { opacity: motionSettings.reveal.initialOpacity }, { opacity: 1, duration: motionSettings.reveal.duration, stagger: scroll ? { amount: motionSettings.reveal.scrollSpread } : motionSettings.reveal.wordDelay, ease: 'none', scrollTrigger: {
                                    trigger: target, start: motionSettings.reveal.start, end: motionSettings.reveal.end, scrub: scroll, toggleActions: scroll ? undefined : 'play reverse play reverse'
                                } });
                            });
                        });
                    }
                });
                document.querySelectorAll('.gsap-parallax-container').forEach(container => {
                    if (container.closest('.is-gsap-horizontal, .is-gsap-vertical, .is-gsap-lateral, .horizontal-wrapper')) return;
                    const image = container.querySelector('.gsap-parallaxImage');
                    if (image) gsap.fromTo(image, { scale: motionSettings.parallax.scale, yPercent: motionSettings.parallax.fromY }, { yPercent: motionSettings.parallax.toY, ease: 'none', scrollTrigger: { trigger: container, start: 'top bottom', end: 'bottom top', scrub: true } });
                });

                // Decorative bars are section-local; scroll and pointer use separate transform axes.
                if (desktop) document.querySelectorAll('.section-bars').forEach(section => {
                    const bounds = {
                        'bar-top': [0, 40, 0, 100], 'bar-bottom': [60, 100, 0, 100],
                        'bar-left': [0, 100, 0, 40], 'bar-right': [0, 100, 60, 100],
                        'bar-top-left': [0, 55, 0, 55], 'bar-top-right': [0, 55, 45, 100],
                        'bar-bottom-left': [45, 100, 0, 55], 'bar-bottom-right': [45, 100, 45, 100],
                        'bar-center': [20, 80, 20, 80], 'bar-all': [0, 100, 0, 100]
                    };
                    const area = bounds[Object.keys(bounds).find(name => section.classList.contains(name)) || 'bar-all'];
                    const random = (min, max) => min + Math.random() * (max - min);
                    // * GRIT_SET Bar sizes | Preserve the original responsive dimensions.
                    const sizes = window.innerWidth <= 640
                        ? { min: 180, max: 240, height: 25 }
                        : window.innerWidth <= 1024
                            ? { min: 220, max: 300, height: 30 }
                            : { min: 280, max: 380, height: 35 };
                    const placed = [], bars = [];
                    for (let attempt = 0; attempt < 375 && bars.length < motionSettings.bars.maxCount; attempt++) {
                        const width = random(sizes.min, sizes.max), height = sizes.height;
                        const left = random(area[2], area[3]), top = random(area[0], area[1]);
                        const x = left * section.clientWidth / 100, y = top * section.clientHeight / 100;
                        const radius = Math.hypot(width / 2, height / 2);
                        if (placed.some(p => Math.hypot(p.x - x, p.y - y) < p.radius + radius + motionSettings.bars.gap)) continue;
                        placed.push({ x, y, radius });
                        const bar = document.createElement('div'); bar.className = 'bar'; bar.setAttribute('aria-hidden', 'true');
                        Object.assign(bar.style, { width: width + 'px', height: height + 'px', left: left + '%', top: top + '%' });
                        section.append(bar); bars.push(bar);
                        gsap.set(bar, { xPercent: -50, yPercent: -50, rotation: random(motionSettings.bars.minRotation, motionSettings.bars.maxRotation) });
                    }
                    cleanup.push(() => bars.forEach(bar => bar.remove()));
                    if (!bars.length) return;
                    gsap.to(bars, { yPercent: motionSettings.bars.scrollY, ease: 'none', scrollTrigger: { trigger: section, start: 'top bottom', end: 'bottom top', scrub: motionSettings.bars.scrub } });
                    if (window.matchMedia('(hover: hover)').matches) {
                        const setters = bars.map(bar => [gsap.quickTo(bar, 'x', { duration: motionSettings.bars.pointerDuration }), gsap.quickTo(bar, 'y', { duration: motionSettings.bars.pointerDuration })]);
                        const move = event => {
                            const rect = section.getBoundingClientRect();
                            setters.forEach((set, i) => { set[0]((event.clientX - rect.left - rect.width / 2) * motionSettings.bars.pointerStrength * (i % 3 + 1)); set[1]((event.clientY - rect.top - rect.height / 2) * motionSettings.bars.pointerStrength * (i % 3 + 1)); });
                        };
                        section.addEventListener('pointermove', move);
                        cleanup.push(() => section.removeEventListener('pointermove', move));
                    }
                });
                refresh();
                return () => cleanup.reverse().forEach(restore => restore());
            });
        }
        rebuild();
        // * GRIT_SET 04 | Recreate measurements and restore split text at each settled resize.
        window.addEventListener('resize', () => { clearTimeout(resizeTimer); resizeTimer = setTimeout(rebuild, 200); });
        window.addEventListener('load', refresh);
        document.addEventListener('load', event => { if (event.target.tagName === 'IMG') refresh(); }, true);
        if (document.fonts && document.fonts.ready) document.fonts.ready.then(rebuild);
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initMotion, { once: true });
    else initMotion();
})();

})(jQuery);
