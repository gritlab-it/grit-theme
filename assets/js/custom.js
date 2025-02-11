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
        /* init loader effect */
        $("body").addClass("loaded");
    }, 1500);
});

$(document).ready(function () {
    /* imposta il link a disabilitato e imposta il timeout sulla transizione dell'indicatore di caricamento */
    $("a").click(function () {
        /* verifica se il link contiene lo stesso dominio */
        if ($(this).prop("hostname") === window.location.hostname) {
            /* verifica se il link è un ancoraggio */
            if ($(this).attr("href").indexOf("#") === 0) {
                return; // non fare nulla e interrompi l'esecuzione
            }
            /* verifica se il link ha come target "_blank" */
            if ($(this).attr("target") === "_blank") {
                return; // non fare nulla e interrompi l'esecuzione
            }
            if ($(this).hasClass("no-load")) {
                console.log("Il link ha la classe 'no-load'. L'azione è stata interrotta.");
                return; // non fare nulla e interrompi l'esecuzione
            }
            
            /* Nuova regola: verifica se il link appartiene alla galleria o ha l'attributo 'data-lightbox-gallery' */
            if (
                $(this).closest(".gallery-icon").length > 0 ||
                $(this).attr("data-lightbox-gallery")
            ) {
                console.log(
                    "Il link fa parte di una galleria o ha l'attributo 'data-lightbox-gallery'. L'azione è stata interrotta."
                );
                return; // non fare nulla e interrompi l'esecuzione
            }
            
            $("body").removeClass("loaded");
            
            setTimeout(
                function (url) {
                    window.location = url;
                },
                1000,
                this.href
            );
        }
    });
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
        openNav("header-2-sidenav"); // Apri il menu usando la funzione openNav
    });
    
    // Evento per chiudere il menu
    $(".menu-close").on("click", function () {
        closeNav("header-2-sidenav"); // Chiudi il menu usando la funzione closeNav
    });
    
    // Evento per chiudere il menu quando si clicca su una voce del menu
    $(".overlay-content li").on("click", function () {
        closeNav("header-2-sidenav");
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
  


  // Aspetta che il DOM sia pronto
document.addEventListener("DOMContentLoaded", function () {
    // Verifica se Lenis è disponibile
    if (typeof Lenis !== "undefined") {
        // console.log("Lenis caricato correttamente");

        const lenis = new Lenis({
            duration: 1.1,
            easing: (t) => 1 - Math.pow(1 - t, 3),
            smooth: true,
            direction: "vertical",
            gestureDirection: "vertical",
            smoothTouch: true,
            touchMultiplier: 1, // Ridotto
        });

        function raf(time) {
            lenis.raf(time);
            ScrollTrigger.update();
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Verifica che ci sia un elemento scroller valido prima di configurare ScrollTrigger
        const lenisScroller = document.querySelector("[data-lenis]");
        if (lenisScroller) {
            ScrollTrigger.defaults({
                scroller: lenisScroller,
            });
        } else {
            // console.warn("Attenzione: Nessun elemento [data-lenis] trovato per ScrollTrigger.");
        }

        // Debug degli eventi di scroll
        window.addEventListener("scroll", () => {
            // console.log('Scroll position:', window.scrollY);
        });
    } else {
        // console.error("Errore: Lenis non è definito. Assicurati che il file lenis.min.js sia caricato correttamente.");
    }
});




/* :::::::::::::: 10 * GRIT_SET GSAP js */ 
// Assicurati che GSAP e ScrollTrigger siano caricati
if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined") {
    
    // Inizializzazione di ScrollTrigger con GSAP
    gsap.registerPlugin(ScrollTrigger);
    
// Esempio di animazione parallax con ScrollTrigger usando una timeline
const parallaxImage = document.querySelector(".gsap-parallaxImage");
const parallaxContainer = document.querySelector(".gsap-parallax-container");

// Controlla se entrambi gli elementi sono presenti prima di applicare l'animazione
if (parallaxImage && parallaxContainer) {
  // Crea una timeline GSAP
  const timeline = gsap.timeline({
    scrollTrigger: {
      trigger: parallaxContainer, // Associa la timeline al contenitore specificato
      start: "top bottom",
      end: "bottom top",
      scrub: true,
      markers: true, // Usa markers per debug, rimuovi quando non più necessari
    }
  });

  // Aggiungi animazioni alla timeline
  timeline.to(parallaxImage, {
    scale: 1.2,
    y: "-30%",
    ease: "none",
  });

  // Aggiungi ulteriori animazioni alla timeline se necessario
  // timeline.to(...);
}

    
    // Refresh di ScrollTrigger su `resize` e `load`
    window.addEventListener("resize", () => ScrollTrigger.refresh());
    window.addEventListener("load", () => ScrollTrigger.refresh());
    
    
    // Smooth scroll per ancoraggi gestito con GSAP
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function(e) {
            e.preventDefault();
            const targetID = this.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetID);
            
            if (targetElement) {
                gsap.to(window, {
                    duration: 1.1,
                    scrollTo: { y: targetElement, autoKill: false },
                    ease: "power2.out"
                });
            }
        });
    });
    
    // Attiva il smooth scroll al caricamento se c'è un hash nell'URL
    window.addEventListener("load", () => {
        const hash = window.location.hash.substring(1);
        if (hash) {
            const targetElement = document.getElementById(hash);
            if (targetElement) {
                gsap.to(window, {
                    duration: 1.1,
                    scrollTo: { y: targetElement, autoKill: false },
                    ease: "power2.out"
                });
            }
        }
    });
    
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

