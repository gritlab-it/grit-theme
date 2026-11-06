// * GRIT_SET Scope the dollar alias to WordPress jQuery (noConflict compatible)
(function ($) {
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 00 * GRIT_SET loader */
/* :::::::::::::: 01 * GRIT_SET animate.css  */
/* :::::::::::::: 02 * GRIT_SET menu showing */
/* :::::::::::::: 03 * GRIT_SET sticky */
/* :::::::::::::: 03 * GRIT_SET owl-carousel */
/* :::::::::::::: 03 * GRIT_SET nivoLightbox */
/* :::::::::::::: 04 * GRIT_SET magicMouse */
/* :::::::::::::: 06 * GRIT_SET jarallax-js  */
/* :::::::::::::: 07 * GRIT_SET NProgress-js */
/* :::::::::::::: 07 * GRIT_SET section_collapse */
/* :::::::::::::: 08 * GRIT_SET section_video */
/* :::::::::::::: 09 * GRIT_SET Counters js */
/* :::::::::::::: 10 * GRIT_SET GSAP + ScrollTrigger + Lenis */ 
/* :::::::::::::: 10.0 * Init Plugin */ 
/* :::::::::::::: 10.1 * Lenis Setup (Smooth Scroll) */ 
/* :::::::::::::: 10.2 * Init GSAP Animations */ 
/* :::::::::::::: 10.2.1 * Parallax Image Scroll */ 
/* :::::::::::::: 10.2.2 * Horizontal Scroll Container */ 
/* :::::::::::::: 10.2.3 * Vertical Panels Scroll */ 
/* :::::::::::::: 10.2.4 * Word Reveal (SplitText) */ 
/* :::::::::::::: 10.2.5 * Sequential Word Reveal */ 
/* :::::::::::::: 10.2.6 * Horizontal Scroll of Long Sentences */ 
/* :::::::::::::: 10.2.7 * Dual Horizontal Scroll */ 
/* :::::::::::::: 10.3 * Initialization of Animated Functions */ 
/* :::::::::::::: 10.4 * Responsive Refresh on Resize (Debounced) */ 
/* :::::::::::::: 11 * Section Bars */ 

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 00 * GRIT_SET loader */
$(function () {
    setTimeout(function () {
        $("body").addClass("loaded");
    }, 1500);
});

$(document).ready(function () {
    $("a").on("click", function (e) {
        const link = $(this);
        const href = link.attr("href");
        
        if (link.prop("hostname") !== window.location.hostname) return;
        
        if (href && href.indexOf("#") !== -1 && this.href.split("#")[0] === window.location.href.split("#")[0]) {
            return;
        }
        
        if (
            link.attr("target") === "_blank" ||
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






/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 01 * GRIT_SET animate.css  */
// example <div class="in__animate" data-animation="animate__fadeInUp animate__slow animate__delay-2s"  >
document.addEventListener("DOMContentLoaded", function () {
    var viewportchecker_active = document.getElementById("content");
    if (viewportchecker_active) {
        var elements = document.querySelectorAll(".in__animate");
        
        // Nasconde tutti gli elementi inizialmente
        elements.forEach(function (element) {
            element.classList.add("hidden"); // Nasconde gli elementi finché non sono nel viewport
        });
        
        // Usa IntersectionObserver per rilevare quando gli elementi entrano nel viewport
        var observer = new IntersectionObserver(
            function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        // Ottiene l'animazione specifica dall'attributo data-animation
                        var animationClasses = entry.target.getAttribute("data-animation");
                        
                        // Controlla che data-animation non sia vuoto o undefined
                        if (animationClasses && animationClasses.trim() !== "") {
                            // Rimuove la classe 'hidden' e aggiunge le classi di animazione dal data attribute
                            entry.target.classList.remove("hidden");
                            
                            // Forza il reflow per riapplicare le animazioni
                            void entry.target.offsetWidth; // Questo forza il reflow
                            
                            // Aggiunge animate__animated e le classi specifiche di animazione
                            entry.target.classList.add("animate__animated");
                            entry.target.classList.add(
                                ...animationClasses.trim().split(" ").filter(Boolean)
                            ); // Rimuove eventuali spazi vuoti
                        } else {
                            console.warn(
                                "data-animation è vuoto o non definito per l'elemento:",
                                entry.target
                            );
                        }
                    }
                });
            },
            {
                threshold: 0.1, // Inizia l'animazione quando il 10% dell'elemento è visibile
                rootMargin: "0px 0px -100px 0px", // Simula un offset per far iniziare l'animazione in anticipo
            }
        );
        
        // Osserva ogni elemento .in__animate
        elements.forEach(function (element) {
            observer.observe(element);
        });
    }
});

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 02 * GRIT_SET menu showing */
$(document).ready(function () {
    $(".menu-icon").on("click", function () {
        $("nav ul").toggleClass("showing");
        // alert('showing menu-icon');
    });
});

$(document).ready(function () {
    // Evento per aprire il menu
    $(".menu-toggle").on("click", function () {
        openNav("header-sidenav"); // Apri il menu usando la funzione openNav
        // alert('menu-toggle');
    });
    
    // Evento per chiudere il menu
    $(".menu-close").on("click", function () {
        closeNav("header-sidenav"); // Chiudi il menu usando la funzione closeNav
        // alert('menu-close');
    });
    
    // Evento per chiudere il menu quando si clicca su una voce del menu
    $(".overlay-content li").on("click", function () {
        closeNav("header-sidenav");
        // alert('overlay-content li');
    });
});

function openNav(elementId) {
    var element = document.getElementById(elementId);
    if (element) {
        element.classList.add("sidenav-open");
        element.classList.remove("sidenav-close");
        setTimeout(function () {
            element.style.width = "100%";
        }, 20);
    }
}

function closeNav(elementId) {
    var element = document.getElementById(elementId);
    if (element) {
        element.classList.add("sidenav-close");
        element.classList.remove("sidenav-open");
        setTimeout(function () {
            element.style.width = "0";
        }, 500);
    }  
}

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 03 * GRIT_SET sticky */
$(function () {
    // Caches a jQuery object containing the header element
    var header = $(".sticky");
    var lastScrollTop = 0;
    
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        
        if (scroll >= 500) {
            header.removeClass("sticky").addClass("sticky-in");
        } else {
            header.removeClass("sticky-in").addClass("sticky");
        }
    });
});

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 03 * GRIT_SET owl-carousel */
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
        if ($section.hasClass('section_cube') || $section.hasClass('section_slides') || $carousel.hasClass('carousel-header')) {
            counts = [1, 1, 1, 1, 1, 1];
            options.margin = 0;
        }
        if ($carousel.hasClass('carousel-header')) options.dots = false;
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

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 03 * GRIT_SET nivoLightbox */
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

lightbox_nivo_active = document.getElementById(
    "responsive-lightbox-nivo_lightbox-js"
);

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

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 04 * GRIT_SET magicMouse */
var magicmouse_active = document.getElementById("magic-mouse-js");
$(document).ready(function () {
    if (magicmouse_active) {
        $(".main").addClass("magicmouse_active");
        // Attivo su tutte le immagini
        //$("img").addClass("magic-hover", "magic-hover__square");
        $(".btn").addClass("magic-hover", "magic-hover__square");
        
        document.body.style.cursor = "none!important";
        // cursorOuter	Default: "circle-basic", other options : "disable"
        // hoverEffect	default: "circle-move", other options : "pointer-blur", "pointer-overlay"
        options = {
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

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 06 * GRIT_SET jarallax-js  */
// * GRIT_SET Initialize available Jarallax instances independently of Owl
jQuery(function ($) {
    if (typeof $.fn.jarallax !== 'function') return;
    $('.jarallax, .jarallax-keep-img, .jarallax-overlay').each(function () {
        if (this.jarallax) return;
        if ($(this).closest('.section_slides').length && window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        var speed = $(this).data('speed');
        var isSlides = $(this).closest('.section_slides').length > 0;
        // * GRIT_SET Slides | Move the image into Jarallax: a retained cover image would hide its motion.
        // Keep the animated layer above the slide background and below overlay/text.
        $(this).jarallax({
            speed: speed === undefined ? (isSlides ? 0.5 : 0.9) : speed,
            keepImg: !isSlides,
            zIndex: isSlides ? 0 : -100,
            imgPosition: '50% 50%'
        });
    });
});

// * GRIT_SET Initialize every text Masonry grid once with a Bootstrap fallback
jQuery(function () {
    if (typeof window.Masonry !== 'function') return;
    document.querySelectorAll('.section_text .js-grit-masonry').forEach(function (grid) {
        if (window.Masonry.data(grid)) return;
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

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 07 * GRIT_SET NProgress-js */
nprogress_active = document.getElementById("nprogress-js");
if (nprogress_active) {
    $("body").show();
    $(".version").text(NProgress.version);
    NProgress.start();
    setTimeout(function () {
        NProgress.done();
        $(".fade").removeClass("out");
    }, 1000);
    $("#b-0").click(function () {
        NProgress.start();
    });
    $("#b-40").click(function () {
        NProgress.set(0.4);
    });
    $("#b-inc").click(function () {
        NProgress.inc();
    });
    $("#b-100").click(function () {
        NProgress.done();
    });
}

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 07 * GRIT_SET section_collapse */
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

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 08 * GRIT_SET section_video */
function initializeVideoSections() {
    const videoSections = document.querySelectorAll('.section-video');
    
    videoSections.forEach((section) => {
        const thumbnail = section.querySelector('.video-thumbnail');
        const videoEmbed = section.querySelector('.video-embed');
        const videoIframeContainer = section.querySelector('.video-iframe');
        const videoFile = section.querySelector('.video-file video');
        
        thumbnail.addEventListener('click', function () {
            thumbnail.style.display = 'none';
            
            if (videoEmbed) {
                videoEmbed.style.display = 'block';
            } else if (videoIframeContainer) {
                const iframe = videoIframeContainer.querySelector('iframe');
                const originalSrc = iframe.getAttribute('data-src') || iframe.getAttribute('src');
                iframe.src = originalSrc.includes('autoplay=1') ? originalSrc : `${originalSrc}?autoplay=1`;
                videoIframeContainer.style.display = 'block';
            } else if (videoFile) {
                const videoContainer = section.querySelector('.video-file');
                videoContainer.style.display = 'block';
                videoFile.play().catch(function(error) {
                    console.log('Autoplay non riuscito:', error);
                });
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', initializeVideoSections);

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 09 * GRIT_SET Counters js */
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
document.addEventListener('DOMContentLoaded', startCounterAnimation);


/* :::::::::::::: 10 * GRIT_SET GSAP + ScrollTrigger + Lenis */ 

// * GRIT_SET GSAP and Lenis are independently optional
(function () {
const hasGSAP = typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined';
if (hasGSAP) {
  gsap.registerPlugin(ScrollTrigger);
  if (typeof window.SplitText !== 'undefined') gsap.registerPlugin(SplitText);
}
const lenis = typeof window.Lenis === 'function' ? new Lenis({
  duration: 1.2,
  easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
  smooth: true,
  smoothTouch: true,
}) : null;
if (lenis) {
  if (hasGSAP) {
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add(time => lenis.raf(time * 1000));
  } else {
    const raf = time => { lenis.raf(time); requestAnimationFrame(raf); };
    requestAnimationFrame(raf);
  }
}

// Scroll to anchor on click
if (lenis) document.querySelectorAll('a[href*="#"]').forEach(anchor => {
  anchor.addEventListener("click", function (e) {
    const currentUrl = window.location.href.split('#')[0];
    const targetUrl = this.href.split('#')[0];

    if (this.matches('[data-toggle], [role="tab"], [role="button"]')) return;
    if (currentUrl === targetUrl) {
      const targetId = this.getAttribute("href").split('#')[1];
      const targetElement = document.getElementById(targetId);
      if (targetElement) {
        e.preventDefault();
        lenis.scrollTo(targetElement);
      }
    }
  });
});

// Scroll to hash on load
window.addEventListener("load", () => {
  const hash = window.location.hash.substring(1);
  const target = document.getElementById(hash);
  if (target && lenis) lenis.scrollTo(target, { duration: 1.1 });
  if (hasGSAP) setTimeout(() => ScrollTrigger.refresh(), 250);
});

if (hasGSAP) window.addEventListener("resize", () => ScrollTrigger.refresh());

// * GRIT_SET Image-dependent animation still works when ImagesLoaded is disabled
function whenImageReady(image, callback) {
  if (typeof window.imagesLoaded === 'function') {
    window.imagesLoaded(image, callback);
  } else if (image.complete) {
    callback();
  } else {
    let handled = false;
    const complete = () => { if (!handled) { handled = true; callback(); } };
    image.addEventListener('load', complete, { once: true });
    image.addEventListener('error', complete, { once: true });
  }
}

// :::::::::::::: 10.2 * Init GSAP Animations
document.addEventListener("DOMContentLoaded", function () {
  if (!hasGSAP) return;

  // :::::::::::::: 10.2.1 * Parallax Image Scroll
  document.querySelectorAll(".gsap-parallax-container").forEach(container => {
    const image = container.querySelector(".gsap-parallaxImage");
    if (image) {
      whenImageReady(image, () => {
        gsap.timeline({
          scrollTrigger: {
            trigger: container,
            start: "top bottom",
            end: "bottom top",
            scrub: true,
          },
          immediateRender: false
        }).to(image, {
          scale: 1.1,
          y: "-10%",
          ease: "power1.inOut"
        });
      });
    }
  });

  // :::::::::::::: 10.2.2 * Horizontal Scroll Container
  function horizontalScrollContainer() {
    document.querySelectorAll(".section-gsap-horizontal").forEach(section => {
      const row = section.querySelector(".row");
      if (!section || !row) return;

      ScrollTrigger.getAll().forEach(t => t.trigger === section && t.kill());

      const scrollWidth = row.scrollWidth - window.innerWidth;
      if (scrollWidth > 0) {
        gsap.to(row, {
          x: -scrollWidth,
          ease: "none",
          scrollTrigger: {
            trigger: section,
            pin: true,
            scrub: 1,
            start: "top top",
            end: `+=${scrollWidth}`,
            invalidateOnRefresh: true
          }
        });
      }
    });
  }

  // :::::::::::::: 10.2.3 * Vertical Panels Scroll
  function verticalPanelsScroll() {
    document.querySelectorAll(".section-gsap-vertical").forEach(section => {
      const panels = section.querySelectorAll(".item-chapters");
      if (panels.length < 2) return;

      panels.forEach((p, i) => {
        p.style.zIndex = panels.length - i;
        p.style.boxSizing = "border-box";
      });

      const totalHeight = panels.length * window.innerHeight;
      const spacer = document.createElement("div");
      spacer.className = "vertical-scroll-spacer";
      spacer.style.height = `${totalHeight}px`;
      section.after(spacer);

      setTimeout(() => {
        const tl = gsap.timeline({
          scrollTrigger: {
            trigger: section,
            start: "top top",
            end: `+=${totalHeight}`,
            scrub: true,
            pin: true,
            pinSpacing: false,
            invalidateOnRefresh: true
          }
        });

        panels.forEach((panel, i) => {
          if (i < panels.length - 1) {
            tl.to(panel, { yPercent: -100, ease: "none", duration: 1 }, i);
          }
        });
      }, 50);
    });
  }

  // :::::::::::::: 10.2.4 * Word Reveal (SplitText)
  function splitWordReveal() {
    if (typeof window.SplitText === "undefined") return;
    document.querySelectorAll(".section-gsap-reveal").forEach(section => {
      const blocks = section.querySelectorAll(".inner-text");

      blocks.forEach(block => {
        block.querySelectorAll("h1,h2,h3,h4,h5,h6,p").forEach(el => {
          if (el.dataset.split === "true") return;

          const split = new SplitText(el, { type: "words", wordsClass: "word" });
          el.dataset.split = "true";

          split.words.forEach((word, i) => {
            gsap.fromTo(word,
              { opacity: 0.1 },
              {
                opacity: 1,
                duration: 0.2,
                ease: "power2.out",
                delay: i * 0.05,
                scrollTrigger: {
                  trigger: word,
                  start: "top 85%",
                  end: "top 15%",
                  toggleActions: "play reverse play reverse",
                }
              }
            );
          });
        });
      });
    });
  }

  // :::::::::::::: 10.2.5 * Sequential Word Reveal
  function scrollRevealStaggered() {
    if (typeof window.SplitText === "undefined") return;
    document.querySelectorAll(".section-gsap-reveal-scroll").forEach(section => {
      const innerText = section.querySelector(".inner-text");
      if (!innerText) return;

      const split = new SplitText(innerText, {
        type: "words",
        wordsClass: "word"
      });

      gsap.from(split.words, {
        opacity: 0.1,
        y: 0,
        stagger: { amount: 1.5 },
        ease: "power2.out",
        scrollTrigger: {
          trigger: section,
          start: "top 80%",
          end: "bottom 20%",
          scrub: true
        }
      });
    });
  }

  // :::::::::::::: 10.2.6 - Horizontal Scroll of Long Sentences
  function horizontalTextScroll() {
    document.querySelectorAll(".section-gsap-lateral-word").forEach(section => {
      const h1 = section.querySelector(".inner-text h1");
      if (!h1) return;

      h1.style.whiteSpace = "nowrap";
      h1.style.display = "inline-block";
      gsap.set(h1, { x: 0 });

      const scrollDistance = h1.scrollWidth - window.innerWidth;
      if (scrollDistance <= 0) return;

      gsap.to(h1, {
        x: -scrollDistance,
        ease: "none",
        scrollTrigger: {
          trigger: section,
          start: "top top",
          end: `+=${scrollDistance}`,
          scrub: true,
          pin: true,
          pinSpacing: true,
          invalidateOnRefresh: true
        }
      });
    });

    ScrollTrigger.refresh();
  }

  // :::::::::::::: 10.2.7 * Dual Horizontal Scroll
  function horizontalScrollSequenziale() {
    if (window.innerWidth < 768) return;

    setTimeout(() => {
      const section70 = document.querySelector(".section-gsap-70horizontal");
      const section30 = document.querySelector(".section-gsap-30horizontal");
      if (!section70 || !section30) return;

      const wrapper = document.createElement("div");
      wrapper.classList.add("horizontal-wrapper");
      section70.parentNode.insertBefore(wrapper, section70);
      wrapper.appendChild(section70);
      wrapper.appendChild(section30);

      const row70 = section70.querySelector(".row");
      const row30 = section30.querySelector(".row");

      const scroll70 = [...row70.children].reduce((acc, el) => acc + el.offsetWidth, 0) - window.innerWidth + 2;
      const scroll30 = [...row30.children].reduce((acc, el) => acc + el.offsetWidth, 0) - window.innerWidth + 2;
      const totalScroll = scroll70 + scroll30;

      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: wrapper,
          start: "top top",
          end: `+=${totalScroll}`,
          scrub: true,
          pin: true,
          anticipatePin: 1,
          invalidateOnRefresh: true
        }
      });

      if (scroll70 > 0) tl.to(row70, { x: -scroll70, ease: "none", duration: scroll70 / totalScroll });
      if (scroll30 > 0) tl.to(row30, { x: -scroll30, ease: "none", duration: scroll30 / totalScroll });

      ScrollTrigger.refresh();
    }, 50);
  }

  // :::::::::::::: 10.3 * Initialization of Animated Functions
  function initGSAPAnimations() {
    horizontalScrollContainer();
    verticalPanelsScroll();
    splitWordReveal();
    scrollRevealStaggered();
    horizontalTextScroll();
    horizontalScrollSequenziale();
  }

  // :::::::::::::: 10.4 * Responsive Refresh on Resize (Debounced)
  function refreshResponsiveScrolls() {
    ScrollTrigger.getAll().forEach(trigger => {
      const el = trigger.trigger;
      if (el?.classList.contains("section-gsap-horizontal") ||
          el?.classList.contains("section-gsap-lateral-word") ||
          el?.classList.contains("section-gsap-70horizontal") ||
          el?.classList.contains("section-gsap-30horizontal") ||
          el?.classList.contains("section-gsap-vertical")) {
        trigger.kill();
      }
    });

    horizontalScrollContainer();
    horizontalTextScroll();
    horizontalScrollSequenziale();
    ScrollTrigger.refresh();
  }

  // Inizializza su load
  initGSAPAnimations();

  // Debounced resize
  let resizeTimeout;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      refreshResponsiveScrolls();
    }, 200);
  });

});



})();

/* :::::::::::::: 11 * Section Bars */  

const NUM_BARS = 15;
const MIN_BARS = 5;

function random(min, max) {
  return Math.random() * (max - min) + min;
}

// 🔹 Responsive sizing
function getResponsiveSizes() {
  const w = window.innerWidth;

  if (w <= 640) {
    return { widthMin: 180, widthMax: 240, height: 25 };
  } else if (w <= 1024) {
    return { widthMin: 220, widthMax: 300, height: 30 };
  } else {
    return { widthMin: 280, widthMax: 380, height: 35 };
  }
}

// 🔹 Bounding box per posizionamento
function getPositionBounds(positionClass) {
  switch (positionClass) {
    case 'bar-top':           return { topMin: 0, topMax: 40, leftMin: 0, leftMax: 100 };
    case 'bar-bottom':        return { topMin: 60, topMax: 100, leftMin: 0, leftMax: 100 };
    case 'bar-left':          return { topMin: 0, topMax: 100, leftMin: 0, leftMax: 40 };
    case 'bar-right':         return { topMin: 0, topMax: 100, leftMin: 60, leftMax: 100 };
    case 'bar-top-left':      return { topMin: 0, topMax: 55, leftMin: 0, leftMax: 55 };
    case 'bar-top-right':     return { topMin: 0, topMax: 55, leftMin: 45, leftMax: 100 };
    case 'bar-bottom-left':   return { topMin: 45, topMax: 100, leftMin: 0, leftMax: 55 };
    case 'bar-bottom-right':  return { topMin: 45, topMax: 100, leftMin: 45, leftMax: 100 };
    case 'bar-center':        return { topMin: 20, topMax: 80, leftMin: 20, leftMax: 80 };
    case 'bar-all':
    default:                  return { topMin: 0, topMax: 100, leftMin: 0, leftMax: 100 };
  }
}

// 🔹 Generazione barre non sovrapposte
function generateNonOverlappingBars(container) {
  const sizes = getResponsiveSizes();
  const existingBars = [];

  const classList = container.classList;
  const validPositions = [
    'bar-top','bar-bottom','bar-left','bar-right',
    'bar-top-left','bar-top-right','bar-bottom-left','bar-bottom-right',
    'bar-center','bar-all'
  ];
  const positionClass = [...classList].find(c => validPositions.includes(c)) || 'bar-all';
  const { topMin, topMax, leftMin, leftMax } = getPositionBounds(positionClass);

  let placedBars = 0;
  let attempts = 0;

  while (placedBars < NUM_BARS && attempts < NUM_BARS * 25) {
    attempts++;

    const width  = random(sizes.widthMin, sizes.widthMax);
    const height = sizes.height;
    const top    = random(topMin, topMax);
    const left   = random(leftMin, leftMax);
    const angle  = random(-45, 45);

    const cx = (left / 100) * window.innerWidth;
    const cy = (top  / 100) * window.innerHeight;
    const radius = Math.sqrt((width / 2) ** 2 + (height / 2) ** 2);

    const overlap = existingBars.some(b => {
      const dx = b.cx - cx;
      const dy = b.cy - cy;
      const dist = Math.sqrt(dx * dx + dy * dy);
      return dist < (b.radius + radius + 5);
    });

    if (!overlap) {
      const bar = document.createElement('div');
      bar.classList.add('bar');
      bar.style.width = `${width}px`;
      bar.style.height = `${height}px`;
      bar.style.top = `${top}%`;
      bar.style.left = `${left}%`;
      bar.style.transform = `translate(-50%, -50%) rotate(${angle}deg)`;
      container.appendChild(bar);

      existingBars.push({ cx, cy, radius });
      placedBars++;
    }
  }
}

// 🔁 Osserva ogni sezione e genera barre in anticipo
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const section = entry.target;

      // Solo una volta
      if (!section.dataset.barsGenerated) {
        generateNonOverlappingBars(section);
        section.dataset.barsGenerated = "true";
      }
    }
  });
}, {
  threshold: 0, // inizia appena entra
  rootMargin: '-50% 0px' // 🔸 anticipa la generazione del 50% prima
});

document.querySelectorAll('.section-bars').forEach(section => {
  observer.observe(section);
});

// 🔁 Parallax Mouse + Scroll relativo alla sezione
let mouseX = 0, mouseY = 0;

document.addEventListener('mousemove', e => {
  mouseX = e.clientX;
  mouseY = e.clientY;
  animateBars();
});

window.addEventListener('scroll', () => {
  animateBars();
});

function animateBars() {
  if (typeof window.gsap === "undefined") return;
  document.querySelectorAll('.bar').forEach((el, i) => {
    const section = el.closest('.section-bars');
    if (!section || !section.dataset.barsGenerated) return;

    const sectionTop = section.offsetTop;
    const relScroll = window.scrollY - sectionTop;
    const maxOffset = 100;
    const scrollOffset = Math.max(-maxOffset, Math.min(relScroll * 0.05 * ((i % 5) + 1), maxOffset));

    const offsetX = (mouseX - window.innerWidth / 2) * 0.01 * ((i % 10) + 1);
    const offsetY = (mouseY - window.innerHeight / 2) * 0.01 * ((i % 10) + 1);

    gsap.to(el, {
      x: offsetX,
      y: offsetY + scrollOffset,
      duration: 1.1,
      ease: 'power2.out'
    });
  });
}
 
 
})(jQuery);
