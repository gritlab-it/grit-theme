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
/* :::::::::::::: 07 * GRIT_SET section_collpase */
/* :::::::::::::: 08 * GRIT_SET section_video */
/* :::::::::::::: 09 * GRIT_SET Lenis js */ 
/* :::::::::::::: 10 * GRIT_SET GSAP js */ 
/* :::::::::::::: 11 * GRIT_SET Counters js */
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



/* :::::::::::::: 01 * GRIT_SET animate.css  */
// example          <div class="in__animate" data-animation="animate__fadeInUp animate__slow animate__delay-2s"  >
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

/* :::::::::::::: 03 * GRIT_SET owl-carousel */
owl_carousel_active = document.getElementById("owl_carousel-js");
if (owl_carousel_active) {
    $(document).ready(function () {
        
        // Definisci il contenuto HTML delle frecce direttamente nel JavaScript
        var navLeftArrow = typeof window.navLeftArrow !== 'undefined' ? window.navLeftArrow : `<i class='fa fa-chevron-left'></i>`;
        var navRightArrow = typeof window.navRightArrow !== 'undefined' ? window.navRightArrow : `<i class='fa fa-chevron-right'></i>`;
        
        function initCarouselStandard($carousel) {
            $carousel.owlCarousel({
                loop: true,
                margin: 20,
                autoHeight: false,
                autoWidth: false,
                center: false,
                nav: true,
                dots: true,
                navText: [navLeftArrow, navRightArrow],
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    768: { items: 3 },
                    992: { items: 4 },
                    1200: { items: 5 },
                    1400: { items: 5 },
                },
            });
        }
        
        function initCarouselCenter($carousel) {
            $carousel.owlCarousel({
                loop: true,
                margin: 20,
                // stagePadding: 0,   // assicurati sia 0 se vuoi che sia a margine
                autoHeight: true,
                autoWidth: true,
                center: true,
                nav: true,
                dots: true,
                navText: [navLeftArrow, navRightArrow],
                responsive: {
                    0: { items: 1.2 },
                    576: { items: 2.2 },
                    768: { items: 3.2 },
                    992: { items: 3.2 },
                    1200: { items: 3.2 },
                    1400: { items: 3.2 },
                },
            });
        }
        
        function initCarouselLeft($carousel) {
            $carousel.owlCarousel({
                loop: true,
                margin: 20,
                autoHeight: true,
                autoWidth: true,
                center: false,
                nav: true,
                dots: true,
                navText: [navLeftArrow, navRightArrow], 
                
                responsive: {
                    0: { items: 1.5 },
                    576: { items: 2.5 },
                    768: { items: 3.5 },
                    992: { items: 3.5 },
                    1200: { items: 3.5 },
                    1400: { items: 3.5 },
                },
            });
        }
        
        function initCarouselCube($carousel) {
            $carousel.owlCarousel({
                loop: true,
                margin: 0,
                responsiveClass: true, 
                nav: true,
                dots: true,
                navText: [navLeftArrow, navRightArrow], 
                items: 1, 
            });
        }
        
        function initCarouselText($carousel) {
            $carousel.owlCarousel({
                loop: true,
                margin: 20, 
                autoHeight: false,
                autoWidth: false, 
                center: false,
                nav: true,
                dots: true,  
                navText: [navLeftArrow, navRightArrow], 
                responsive: {
                    0: {
                        items: 1, // Impostazioni per schermi molto piccoli 
                    },
                    576: {
                        items: 2, // Impostazioni per schermi piccoli 
                    },
                    768: {
                        items: 3, // Impostazioni per schermi medi 
                    },
                    992: {
                        items: 3, // Impostazioni per schermi grandi 
                    },
                    1200: {
                        items: 4, // Impostazioni per schermi molto grandi 
                    }
                }
            });
        }
        
        
        function initCarouselSlide($carousel) {
            $carousel.owlCarousel({
                loop: true,
                margin: 0,
                responsiveClass: true,
                nav: true,
                dots: true,
                items: 1,
                navText: [navLeftArrow, navRightArrow],  
                
                autoplay: true, // Abilita l'autoplay
                autoplayTimeout: 5000, // Imposta il timeout dell'autoplay (in millisecondi)
                autoplayHoverPause: true // Pausa l'autoplay al passaggio del mouse
            });
        }
        
        function initCarouselArchive($carousel) {
            $carousel.owlCarousel({
                loop: false,
                margin: 20,
                responsiveClass: true,
                autoHeight: false,
                autoWidth: false,
                center: false,
                nav: true,
                dots: true,
                navText: [navLeftArrow, navRightArrow],  
                responsive: {
                    0: {
                        items: 1, // Impostazioni per schermi molto piccoli
                        
                    },
                    576: {
                        items: 2, // Impostazioni per schermi piccoli
                        
                    },
                    768: {
                        items: 3, // Impostazioni per schermi medi
                        
                    },
                    992: {
                        items: 3, // Impostazioni per schermi grandi
                        
                    },
                    1200: {
                        items: 3, // Impostazioni per schermi molto grandi
                        
                    }
                }
            });
        }
        
        $(".owl-carousel").each(function () {
            var $carousel = $(this);
            var $section = $carousel.closest('section');
            if ($section.hasClass("carousel-center")) {
                initCarouselCenter($carousel);
            } else if ($section.hasClass("carousel-left")) {
                initCarouselLeft($carousel);
            } else if ($section.hasClass("section_cube")) {
                initCarouselCube($carousel);
            } else if ($section.hasClass("section_slides")) {
                initCarouselSlide($carousel);
            } else if ($section.hasClass("section_archive_carousel")) {
                initCarouselArchive($carousel);
            } else if ($section.hasClass("section_carousel_text")) {
                initCarouselText($carousel);
            } else {
                initCarouselStandard($carousel);
            }
        });
    });
}

/* :::::::::::::: 03 * GRIT_SET nivoLightbox */
lightbox_nivo_active = document.getElementById(
    "responsive-lightbox-nivo_lightbox-js"
);

if (lightbox_nivo_active) {
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
        // Prevenzione dell'apertura del link in una nuova scheda
        $('.item-img-gallery').on('click', function (event) {
            event.preventDefault(); // Previene il comportamento predefinito del link
        });
    });
    
    // Prevenzione dell'apertura del link in una nuova scheda
    $(".item-img-gallery").on("click", function (event) {
        event.preventDefault(); // Previene il comportamento predefinito del link
    });
}

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

/* :::::::::::::: 06 * GRIT_SET jarallax-js  */
owl_carousel_active = document.getElementById("owl_carousel-js");

if (owl_carousel_active) {
    $(document).ready(function () {
        /* Inizializza jarallax-js con classi dinamiche */
        $(".jarallax, .jarallax-keep-img, .jarallax-overlay").each(function () {
            var $this = $(this);
            var speed = $this.data("speed") || 0.9; // Valore di default se data-speed non è definito
            
            $this.jarallax({
                speed: speed,
                keepImg: true,
                imgPosition: '50% 50%', 
            });
        });
    });
}

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



/* :::::::::::::: 07 * GRIT_SET section_collpase */
$(document).ready(function () {
    // Controlla se esiste una sezione con la classe 'section_collapse'
    if (document.querySelector('.section_collapse')) {
        
        var headers = document.querySelectorAll('.accordion_heading');
        
        headers.forEach(function (header) {
            header.addEventListener('click', function () {
                var symbol = this.querySelector('.collapse-symbol');
                var target = document.querySelector(this.getAttribute('data-target'));
                
                if (target.classList.contains('show')) {
                    symbol.innerHTML = `<i class="fas fa-plus"></i>`;
                    // symbol.innerHTML = `{% include '/img/plus.svg' %}`;
                } else {
                    headers.forEach(function (h) {
                        var s = h.querySelector('.collapse-symbol');
                        s.innerHTML = `<i class="fas fa-plus"></i>`;
                        // s.innerHTML = `{% include '/img/plus.svg' %}`;
                    });
                    symbol.innerHTML = `<i class="fas fa-minus"></i>`;
                    // symbol.innerHTML = `{% include '/img/minus.svg' %}`;
                }
            });
        });
        
        // Gestione clic sull'icona
        var symbols = document.querySelectorAll('.collapse-symbol');
        symbols.forEach(function (symbol) {
            symbol.addEventListener('click', function (e) {
                e.stopPropagation(); // Evita che l'evento venga gestito solo dall'icona
                this.closest('.accordion_heading').click(); // Simula il clic sull'intestazione
            });
        });
        
        var firstHeader = document.querySelector('.accordion_heading:not(.collapsed)');
        if (firstHeader) {
            var firstSymbol = firstHeader.querySelector('.collapse-symbol');
            firstSymbol.innerHTML = `<i class="fas fa-minus"></i>`;
            // firstSymbol.innerHTML = `{% include '/img/minus.svg' %}`;
        }
        
        var searchHeaders = document.querySelectorAll('.accordion_search_heading');
        
        searchHeaders.forEach(function (header) {
            header.addEventListener('click', function () {
                var symbol = this.querySelector('.collapse-symbol');
                var target = document.querySelector(this.getAttribute('data-target'));
                
                if (target.classList.contains('show')) {
                    symbol.innerHTML = `<i class="fas fa-plus"></i>`;
                    // symbol.innerHTML = `{% include '/img/plus.svg' %}`;
                } else {
                    searchHeaders.forEach(function (h) {
                        var s = h.querySelector('.collapse-symbol');
                        s.innerHTML = `<i class="fas fa-plus"></i>`;
                        // s.innerHTML = `{% include '/img/plus.svg' %}`;
                    });
                    symbol.innerHTML = `<i class="fas fa-minus"></i>`;
                    // symbol.innerHTML = `{% include '/img/minus.svg' %}`;
                    
                }
            });
        });
        
        // Gestione clic sull'icona
        var searchSymbols = document.querySelectorAll('.collapse-symbol');
        searchSymbols.forEach(function (symbol) {
            symbol.addEventListener('click', function (e) {
                e.stopPropagation(); // Evita che l'evento venga gestito solo dall'icona
                this.closest('.accordion_search_heading').click(); // Simula il clic sull'intestazione
            });
        });
        
        var firstSearchHeader = document.querySelector('.accordion_search_heading:not(.collapsed)');
        if (firstSearchHeader) {
            var firstSearchSymbol = firstSearchHeader.querySelector('.collapse-symbol');
            firstSearchSymbol.innerHTML = `<i class="fas fa-minus"></i>`;
            // firstSearchSymbol.innerHTML = `{% include '/img/minus.svg' %}`;
        }
    }
});



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



/* :::::::::::::: 09 * GRIT_SET Lenis js */


// :::::::::::::: 10 * GRIT_SET - GSAP + ScrollTrigger + Lenis ::::::::::::::

// Make sure GSAP and ScrollTrigger are available
if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined") {
    gsap.registerPlugin(ScrollTrigger);
    
    // -------------------------
    // 1. Initialize Lenis (Smooth scroll)
    // -------------------------
    const lenis = new Lenis({
        duration: 1.2, // Adjust scroll softness
        easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smooth: true,
        smoothTouch: true,
    });
    
    // Update ScrollTrigger on every Lenis scroll
    lenis.on('scroll', () => {
        ScrollTrigger.update();
    });
    
    // Let GSAP handle Lenis timing
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000); // Convert seconds to ms
    });
    
    // Optional (usually not needed with <body> scroll)
    // If you use a custom wrapper for scroll, uncomment and adjust this:
    /*
    ScrollTrigger.scrollerProxy(document.body, {
    scrollTop(value) {
    return arguments.length ? lenis.scrollTo(value, { duration: 0 }) : lenis.scroll;
    },
    getBoundingClientRect() {
    return {
    top: 0,
    left: 0,
    width: window.innerWidth,
    height: window.innerHeight
    };
    }
    });
    
    ScrollTrigger.defaults({ scroller: document.body });
    */
    
    // -------------------------
    // 2. GSAP Parallax Animation
    // -------------------------
    document.addEventListener("DOMContentLoaded", function () {
        const parallaxContainers = document.querySelectorAll(".gsap-parallax-container");
        
        parallaxContainers.forEach(container => {
            const image = container.querySelector(".gsap-parallaxImage");
            
            if (image) {
                imagesLoaded(image, function () {
                    gsap.timeline({
                        scrollTrigger: {
                            trigger: container,
                            start: "top bottom",
                            end: "bottom top",
                            scrub: true,
                            markers: false
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
    });
    
    // -------------------------
    // 3. Smooth anchor scroll using Lenis
    // -------------------------
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener("click", function(e) {
            const currentUrlWithoutHash = window.location.href.split('#')[0];
            const linkUrlWithoutHash = this.href.split('#')[0];
            
            if (currentUrlWithoutHash === linkUrlWithoutHash) {
                e.preventDefault();
                const targetID = this.getAttribute("href").split('#')[1];
                const targetElement = document.getElementById(targetID);
                
                if (targetElement) {
                    lenis.scrollTo(targetElement);
                }
            }
        });
    });
    
    // -------------------------
    // 4. Scroll to hash on load
    // -------------------------
    window.addEventListener("load", () => {
        const hash = window.location.hash.substring(1);
        const targetElement = document.getElementById(hash);
        
        if (targetElement) {
            lenis.scrollTo(targetElement, { duration: 1.1, easing: 'easeOutQuad' });
        }
        
        // Refresh ScrollTrigger after images or fonts load
        setTimeout(() => {
            ScrollTrigger.refresh();
        }, 250);
    });
    
    // -------------------------
    // 5. Refresh ScrollTrigger on resize
    // -------------------------
    window.addEventListener("resize", () => ScrollTrigger.refresh());
    
}





/* :::::::::::::: 11 * GRIT_SET Counters js */

function startCounterAnimation() {
    const counters = document.getElementsByClassName("number-animate");
    for (let i = 0; i < counters.length; i++) {
        const counter = counters[i];
        const startNumber = +counter.getAttribute("number-animate-start");
        const target = +counter.getAttribute("number-animate-end");
        const delay = +counter.getAttribute("number-animate-delay");
        const add = +counter.getAttribute("number-animate-increment");
        let current = startNumber;
        let animationId;
        let isInView = false;
        
        function updateCounter() {
            if (current >= target) {
                clearInterval(animationId);
            } else if (add) {
                current += add;
                counter.textContent = current;
            } else {
                current++;
                counter.textContent = current;
            }
        }
        
        function checkInView() {
            const rect = counter.getBoundingClientRect();
            const windowHeight =
            window.innerHeight || document.documentElement.clientHeight;
            const windowWidth =
            window.innerWidth || document.documentElement.clientWidth;
            
            const inView =
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= windowHeight &&
            rect.right <= windowWidth;
            
            if (inView && !isInView) {
                isInView = true;
                current = startNumber;
                counter.textContent = current;
                animationId = setInterval(updateCounter, delay);
                counter.style.opacity = 1;
            } else if (!inView && isInView) {
                isInView = false;
                clearInterval(animationId);
                current = startNumber;
                counter.textContent = current;
                counter.style.opacity = 0;
            }
        }
        
        window.addEventListener("scroll", checkInView);
        window.addEventListener("resize", checkInView);
        checkInView(); // Check if already in view on page load
    }
}

// Call the function when the document is ready
document.addEventListener("DOMContentLoaded", startCounterAnimation);












// ========== INIZIALIZZAZIONE ==========================================================================================
// ================================================================================
document.addEventListener("DOMContentLoaded", function () {
    gsap.registerPlugin(ScrollTrigger, SplitText);
    
    // ========== 1. Scroll orizzontale container ==========
    function horizontalScrollContainer() {
        // prendi tutte le section con quella classe
        const horizontalSections = document.querySelectorAll(".section-gsap-horizontal");
        
        horizontalSections.forEach(horizontalSection => {
            const horizontalRow = horizontalSection.querySelector(".row");
            if (!horizontalSection || !horizontalRow) return;
            
            // uccidi eventuali trigger già presenti per questa section (evita duplicati)
            ScrollTrigger.getAll().forEach(t => {
                if (t.trigger === horizontalSection) {
                    t.kill();
                }
            });
            
            const scrollDistance = Math.max(0, horizontalRow.scrollWidth - window.innerWidth);
            
            if (scrollDistance > 0) {
                gsap.to(horizontalRow, {
                    x: -scrollDistance,
                    ease: "none",
                    scrollTrigger: {
                        trigger: horizontalSection,
                        pin: true,
                        scrub: 1,
                        start: "top top",
                        end: () => `+=${scrollDistance}`,
                        markers: false,
                        invalidateOnRefresh: true
                    }
                });
            }
        });
    }
    
    
    // ========== 2. Scroll verticale a pannelli ==========
function verticalPanelsScroll() {
  const sections = document.querySelectorAll(".section-gsap-vertical");
  sections.forEach(setupSection);

  ScrollTrigger.refresh(); // assicura il ricalcolo corretto
}

function setupSection(section) {
  const panels = section.querySelectorAll(".item-chapters");
  if (panels.length < 2) return;

  // Imposta z-index decrescente
  panels.forEach((panel, i) => {
    panel.style.zIndex = panels.length - i;
    panel.style.boxSizing = "border-box";
  });

  // Calcola altezza totale scrollabile
  const totalHeight = panels.length * window.innerHeight;

  // ❗ Sposta spacer FUORI dalla section
  const spacer = document.createElement("div");
  spacer.classList.add("vertical-scroll-spacer");
  spacer.style.height = `${totalHeight}px`;
  spacer.style.pointerEvents = "none";
  spacer.style.margin = "0";
  spacer.style.padding = "0";

  // Inseriscilo DOPO la section (non dentro)
  section.after(spacer);

  // Delay per far stabilizzare layout (se caricato dinamicamente)
  setTimeout(() => {
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: section,
        start: "top top",
        end: `+=${totalHeight}`,
        scrub: true,
        pin: true,
        pinSpacing: false,
        invalidateOnRefresh: true,
        markers: true // solo per debug
      }
    });

    panels.forEach((panel, i) => {
      if (i < panels.length - 1) {
        tl.to(panel, {
          yPercent: -100,
          ease: "none",
          duration: 1
        }, i);
      }
    });

  }, 50);
}




    
    // ========== 3. Reveal parole singole ==========
function splitWordReveal() {
  // Per ogni sezione con classe .section-gsap-reveal
  document.querySelectorAll(".section-gsap-reveal").forEach(section => {
    const textBlocks = section.querySelectorAll(".inner-text");

    textBlocks.forEach(block => {
      const textElements = block.querySelectorAll("h1, h2, h3, h4, h5, h6, p");

      textElements.forEach(el => {
        if (el.dataset.split === "true") return;

        const split = new SplitText(el, {
          type: "words",
          wordsClass: "word"
        });

        el.dataset.split = "true";

        // Anima ogni parola individualmente
        split.words.forEach((word, i) => {
          gsap.fromTo(
            word,
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
                markers: false
              }
            }
          );
        });
      });
    });
  });
}

    
    // ========== 4. Scroll reveal parole in sequenza ==========
    function scrollRevealStaggered() {
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
                stagger: {
                    amount: 1.5
                },
                ease: "power2.out",
                scrollTrigger: {
                    trigger: section,
                    start: "top 80%",
                    end: "bottom 20%",
                    scrub: true,
                    markers: false
                }
            });
        });
    }
    
    // ========== 5. Scroll orizzontale di frasi lunghe ==========
    function horizontalTextScroll() {
        document.querySelectorAll(".section-gsap-lateral-word").forEach(section => {
            const h1 = section.querySelector(".inner-text h1");
            if (!h1) return;
            
            // Imposta proprietà necessarie per corretto dimensionamento
            h1.style.whiteSpace = "nowrap";
            h1.style.display = "inline-block";
            
            // Reset posizione iniziale
            gsap.set(h1, { x: 0 });
            
            // Calcola distanza da scrollare
            const scrollDistance = h1.scrollWidth - window.innerWidth;
            if (scrollDistance <= 0) return;
            
            gsap.to(h1, {
                x: -scrollDistance,
                ease: "none",
                scrollTrigger: {
                    trigger: section,
                    start: "top top", // quando la section arriva al centro
                    end: () => `+=${scrollDistance}`,
                    scrub: true,
                    pin: true, // pinna tutta la section
                    pinSpacing: true,
                    invalidateOnRefresh: true,
                    markers: true // disattiva in produzione
                }
            });
        });
        
        ScrollTrigger.refresh();
    }
    
    // ========== 6. Scroll orizzontale doppio ==========
function horizontalScrollSequenziale() {
  requestAnimationFrame(() => {
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

      const timeline = gsap.timeline({
        scrollTrigger: {
          trigger: wrapper,
          start: "top top",
          end: `+=${totalScroll}`,
          scrub: true,
          pin: true,
          anticipatePin: 1,
          invalidateOnRefresh: true,
          markers: true
        }
      });

      if (scroll70 > 0) {
        timeline.to(row70, {
          x: -scroll70,
          ease: "none",
          duration: scroll70 / totalScroll
        });
      }

      if (scroll30 > 0) {
        timeline.to(row30, {
          x: -scroll30,
          ease: "none",
          duration: scroll30 / totalScroll
        });
      }

      ScrollTrigger.refresh(); // forzato
    }, 50); // attesa per layout completato
  });
}

    
    
    
    
    
    
    // ========== INIZIALIZZAZIONE ==========
    function initGSAPAnimations() {
        horizontalScrollContainer();
        verticalPanelsScroll();
        splitWordReveal();
        scrollRevealStaggered();
        horizontalTextScroll(); 
        horizontalScrollSequenziale();
    }


    
    
    // ========== RESIZE SOLO PER SCROLL DINAMICI ==========
    function refreshResponsiveScrolls() {
        ScrollTrigger.getAll().forEach(trigger => {
            const triggerEl = trigger.trigger;
            if (
                triggerEl?.classList.contains("section-gsap-horizontal") ||
                triggerEl?.classList.contains("section-gsap-lateral-word") ||
                triggerEl?.classList.contains("section-gsap-70horizontal") || 
                triggerEl?.classList.contains("section-gsap-30horizontal")   || 
                triggerEl?.classList.contains("section-gsap-vertical")    
            ) {
                trigger.kill();
            }
        });
        
        horizontalScrollContainer();
        horizontalTextScroll();
        horizontalScrollSequenziale(); 
        
        ScrollTrigger.refresh();
    }
    
    // ========== AVVIO ==========
window.addEventListener("load", () => {
  initGSAPAnimations();

  // 👇 Nuovo resize handler con debounce
  let resizeTimeout;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      refreshResponsiveScrolls();
    }, 200); // aspetta che il layout si sistemi prima di rilanciare le animazioni
  });
});
    
    
    
    
});
