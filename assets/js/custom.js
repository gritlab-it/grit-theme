/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/* :::::::::::::: 00 * GRIT_SET loader */
/* :::::::::::::: 01 * GRIT_SET animate.css  */
/* :::::::::::::: 02 * GRIT_SET menu showing */
/* :::::::::::::: 03 * GRIT_SET sticky */
/* :::::::::::::: 04 * GRIT_SET magicMouse */
/* :::::::::::::: 05 * GRIT_SET butter-js  */
/* :::::::::::::: 06 * GRIT_SET jarallax-js  */
/* :::::::::::::: 07 * GRIT_SET NProgress-js */
/* :::::::::::::: 08 * GRIT_SET section_video */
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/* :::::::::::::: 00 * GRIT_SET loader */
$(function () {
    setTimeout(function () {
        /* init loader effect */
        $('body').addClass('loaded');
    }, 1500);
});

$(document).ready(function () {
    /* imposta il link a disabilitato e imposta il timeout sulla transizione dell'indicatore di caricamento */
    $('a').click(function () {
        /* verifica se il link contiene lo stesso dominio */
        if ($(this).prop('hostname') === window.location.hostname) {
            /* verifica se il link è un ancoraggio */
            if ($(this).attr('href').indexOf('#') === 0) {
                return; // non fare nulla e interrompi l'esecuzione
            }
            /* verifica se il link ha come target "_blank" */
            if ($(this).attr('target') === '_blank') {
                return; // non fare nulla e interrompi l'esecuzione
            }
            if ($(this).hasClass('no-load')) {
                console.log("Il link ha la classe 'no-load'. L'azione è stata interrotta.");
                return; // non fare nulla e interrompi l'esecuzione
            }

            /* Nuova regola: verifica se il link appartiene alla galleria o ha l'attributo 'data-lightbox-gallery' */
            if ($(this).closest('.gallery-icon').length > 0 || $(this).attr('data-lightbox-gallery')) {
                console.log("Il link fa parte di una galleria o ha l'attributo 'data-lightbox-gallery'. L'azione è stata interrotta.");
                return; // non fare nulla e interrompi l'esecuzione
            }
            
            $('body').removeClass('loaded');
            
            setTimeout(function (url) {
                window.location = url
            }, 1000, this.href);
        }
    });
});

/* :::::::::::::: 01 * GRIT_SET animate.css  */
// example          <div class="in__animate" data-animation="animate__fadeInUp animate__slow animate__delay-2s"  >
document.addEventListener("DOMContentLoaded", function () { 
    var viewportchecker_active = document.getElementById("content");
    if (viewportchecker_active) {
        var elements = document.querySelectorAll('.in__animate');

        // Nasconde tutti gli elementi inizialmente
        elements.forEach(function (element) {
            element.classList.add('hidden'); // Nasconde gli elementi finché non sono nel viewport
        });

        // Usa IntersectionObserver per rilevare quando gli elementi entrano nel viewport
        var observer = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    // Ottiene l'animazione specifica dall'attributo data-animation
                    var animationClasses = entry.target.getAttribute('data-animation');
                    
                    // Controlla che data-animation non sia vuoto o undefined
                    if (animationClasses && animationClasses.trim() !== "") {
                        // Rimuove la classe 'hidden' e aggiunge le classi di animazione dal data attribute
                        entry.target.classList.remove('hidden');

                        // Forza il reflow per riapplicare le animazioni
                        void entry.target.offsetWidth; // Questo forza il reflow

                        // Aggiunge animate__animated e le classi specifiche di animazione
                        entry.target.classList.add('animate__animated');
                        entry.target.classList.add(...animationClasses.trim().split(' ').filter(Boolean)); // Rimuove eventuali spazi vuoti
                    } else {
                        console.warn("data-animation è vuoto o non definito per l'elemento:", entry.target);
                    }
                } 
            });
        }, {
            threshold: 0.1, // Inizia l'animazione quando il 10% dell'elemento è visibile
            rootMargin: '0px 0px -100px 0px' // Simula un offset per far iniziare l'animazione in anticipo
        });

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
            header.removeClass('sticky').addClass("sticky-in");
        } else {
            header.removeClass("sticky-in").addClass('sticky');
        }
    });
});

/* :::::::::::::: 03 * GRIT_SET owl-carousel */
$(document).ready(function () { 
    $(".carousel-plus").owlCarousel({
        loop: true,
        margin: 20, 
        autoHeight: false,
        autoWidth: false, 
        center:true,
        nav: true,
        dots: true, 
        navText: [`{% include ['/partials/arrow.twig'] %}`, `{% include ['/partials/arrow.twig'] %}`], 
        /* navText: [`<i class='fa fa-chevron-left'></i>`, `<i class='fa fa-chevron-right'></i>`], */ 
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
});




/* :::::::::::::: 03 * GRIT_SET nivoLightbox */

$(document).ready(function () {
    $('.item-img-gallery').nivoLightbox({ 
        // The effect to use when showing the lightbox
        // fade, fadeScale, slideLeft, slideRight, slideUp, slideDown, fall
        effect: 'slideUp',

        // The lightbox theme to use
        theme: 'default',

        // Enable/Disable keyboard navigation
        keyboardNav: true,

        // Click image to close
        clickImgToClose: false,

        // Click overlay to close
        clickOverlayToClose: true,

        // Callback functions
        onInit: function(){},
        beforeShowLightbox: function(){},
        afterShowLightbox: function(lightbox){},
        beforeHideLightbox: function(){},
        afterHideLightbox: function(){},
        beforePrev: function(element){},
        onPrev: function(element){},
        beforeNext: function(element){},
        onNext: function(element){},

        // Error message
        errorMessage: 'The requested content cannot be loaded. Please try again later.'

    });
});


    // Prevenzione dell'apertura del link in una nuova scheda
    $('.item-img-gallery').on('click', function (event) {
    event.preventDefault(); // Previene il comportamento predefinito del link
});



/* :::::::::::::: 04 * GRIT_SET magicMouse */
var magicmouse_active = document.getElementById("magic-mouse-js");
$(document).ready(function () {
    if (magicmouse_active) {
        $(".main").addClass("magicmouse_active");
        // Attivo su tutte le immagini
        $("img").addClass("magic-hover", "magic-hover__square");
        // $("a").addClass("magic-hover","magic-hover__square");
        
        document.body.style.cursor = 'none!important';
        //cursorOuter	Default: "circle-basic", other options : "disable"
        // hoverEffect	default: "circle-move", other options : "pointer-blur", "pointer-overlay"
        options = {
            "cursorOuter": "circle-basic",
            "hoverEffect": "pointer-overlay",
            "hoverItemMove": false,
            "defaultCursor": false,
            "outerWidth": 30,
            "outerHeight": 30
        };
        magicMouse(options);
    }
});

/* :::::::::::::: 05 * GRIT_SET butter-js  */
var butter_active = document.getElementById("butter-js");
$(document).ready(function () {
    if (butter_active) {
        document.body.setAttribute('id', 'butter');
        $(".main").attr("id", "butter-active");
        /* inizializzazione butter-js standard */
        // butter.init({cancelOnTouch: true});
        /* impostazione opzioni quando si attiva butter-js */
        var options = {
            /* impostare custom id per attivare butter-js */
            wrapperId: 'butter-active',
            /* impostare velocita butter-js  */
            wrapperDamper: 0.10,
            /* impostare attivazione butter-js in responsive */
            cancelOnTouch: true,
        };
        butter.init(options);
    }
});





/* :::::::::::::: 06 * GRIT_SET jarallax-js  */
owl_carousel_active = document.getElementById('owl_carousel-js')

if (owl_carousel_active) {
    $(document).ready(function () {
    
        /* init jarallax-js with original class */
        $('.jarallax').jarallax({
            keepImg: true,
        });
    
        /* init jarallax-js with class .jarallax-keep-img */
        $('.jarallax-keep-img').jarallax({
            keepImg: true,
        });
        
        /* init jarallax-js  with class  con una class .jarallax-overlay */
        $('.jarallax-overlay').jarallax({
            keepImg: true,
        });

    });

}







/* :::::::::::::: 07 * GRIT_SET NProgress-js */
nprogress_active = document.getElementById('nprogress-js')
if (nprogress_active) {
    $('body').show();
    $('.version').text(NProgress.version);
    NProgress.start();
    setTimeout(function () {
        NProgress.done();
        $('.fade').removeClass('out');
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




/* :::::::::::::: 08 * A_SETTINGS section_video */
$(document).ready(function() {
    // Funzione per gestire la visibilità del pulsante play
    function togglePlayButton(videoElement, show) {
        const playButton = $(videoElement).parent().find('span');
        playButton.toggleClass('d-none', !show); // Mostra il pulsante se 'show' è true
    }

    // Gestisce il click sul pulsante play
    $('.video-file span').click(function() {
        const videoElement = $(this).parent().find('video').get(0);
        togglePlayButton(videoElement, false); // Nasconde il pulsante play
        videoElement.play();
    });

    // Gestisce il click sul video per fermarlo o avviarlo
    $('.video-file video').on('click', function() {
        const videoElement = $(this).get(0);
        togglePlayButton(videoElement, videoElement.paused); // Mostra il pulsante se in pausa
    });

    // Event listener per quando il video viene messo in pausa
    $('.video-file video').on('pause', function() {
        togglePlayButton(this, true); // Mostra il pulsante play
    });

    // Event listener per quando il video viene riprodotto
    $('.video-file video').on('play', function() {
        togglePlayButton(this, false); // Nasconde il pulsante play
    });
});




function startCounterAnimation() {
    const counters = document.getElementsByClassName('number-animate'); 
    for (let i = 0; i < counters.length; i++) {
        const counter = counters[i];
        const startNumber = +counter.getAttribute('number-animate-start');
        const target = +counter.getAttribute('number-animate-end');
        const delay = +counter.getAttribute('number-animate-delay');
        const add = +counter.getAttribute('number-animate-increment');
        let current = startNumber;
        let animationId;
        let isInView = false;

        function updateCounter() {
            if (current >= target) {
                clearInterval(animationId);
            } 
            else if(add){
                current+= add;
                counter.textContent = current;
            }
            else {
                current++;
                counter.textContent = current;
            }
        }

        function checkInView() {
            const rect = counter.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            const windowWidth = window.innerWidth || document.documentElement.clientWidth;

            const inView = (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= windowHeight &&
                rect.right <= windowWidth
            );

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

        window.addEventListener('scroll', checkInView);
        window.addEventListener('resize', checkInView);
        checkInView(); // Check if already in view on page load
    }
}

// Call the function when the document is ready
document.addEventListener('DOMContentLoaded', startCounterAnimation);




// gsap. set('.element', { y:100, opacity: 0});

// ScrollTrigger.batch('.element', {
//     start: 'top 50%',
//     onEnter: batch => gsap.to(batch, {
//         opacity: 1,
//         y:0, 
//         stagger: 0.15 
//     }),
//     markers:true
// })


// let tl = gsap.timeline({
//     scrollTrigger: {
//         trigger: '.container-video',
//         start: 'top center',
//         end: '50% center' ,
//         scrub: true, 
//         markers: true, 
//     }
// });
// tl.to(".container-video", {
//     opacity: 1, 
//     width: '80%', 
// });




// gsap.registerPlugin(ScrollTrigger);

// const locoScroll = new LocomotiveScroll({
//   el: document.querySelector(".smooth-scroll"),
//   smooth: true
// });

// // Assicurati che Locomotive Scroll venga aggiornato correttamente dopo il caricamento della pagina
// locoScroll.update();

// window.addEventListener('load', function () {
//   locoScroll.update();
//   ScrollTrigger.refresh();
// });

// // Ogni volta che ScrollTrigger viene aggiornato, aggiorna anche Locomotive Scroll
// ScrollTrigger.addEventListener("refresh", () => locoScroll.update());

// // Sincronizza Locomotive Scroll con ScrollTrigger
// locoScroll.on("scroll", ScrollTrigger.update);

// // Configura il proxy di ScrollTrigger per usare Locomotive Scroll
// ScrollTrigger.scrollerProxy(".smooth-scroll", {
//   scrollTop(value) {
//     return arguments.length ? locoScroll.scrollTo(value, 0, 0) : locoScroll.scroll.instance.scroll.y;
//   },
//   getBoundingClientRect() {
//     return {top: 0, left: 0, width: window.innerWidth, height: window.innerHeight};
//   },
//   pinType: document.querySelector(".smooth-scroll").style.transform ? "transform" : "fixed"
// });

// // Assicurati che Locomotive Scroll aggiorni tutto al ridimensionamento della finestra
// window.addEventListener('resize', function () {
//   locoScroll.update();
//   ScrollTrigger.refresh();
// });

// locoScroll.on("scroll", (args) => {
//     console.log("Scroll position: ", args.scroll.y);
//     ScrollTrigger.update();
//   });
  
//   ScrollTrigger.addEventListener("refresh", () => {
//     console.log("ScrollTrigger refreshed");
//   });

// var header = $(".sticky");
// var lastScrollTop = 0;

// // Ascolta l'evento di scroll di Locomotive Scroll
// locoScroll.on("scroll", (args) => {
//   // Recupera la posizione di scroll attuale
//   var scroll = args.scroll.y;

//   if (scroll >= 500) {
//     header.addClass("sticky-in");
//   } else {
//     header.removeClass("sticky-in");
//   }
// });



// // Inizializza GSAP
// gsap.registerPlugin(ScrollTrigger);

// // Inizializza Lenis
// const lenis = new Lenis({
//   duration: 1.2,      // Durata dell'effetto smooth scroll
//   easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),  // Funzione di easing per lo scroll
//   smooth: true,       // Abilita smooth scroll
//   smoothTouch: false, // Disabilita smooth scroll su dispositivi touch (opzionale)
//   direction: 'vertical', // Scroll verticale (default)
// });

// // Funzione per sincronizzare Lenis con GSAP
// function raf(time) {
//   lenis.raf(time); // Aggiorna Lenis
//   requestAnimationFrame(raf); // Continua l'animazione
// }

// requestAnimationFrame(raf);

// // Sincronizza GSAP ScrollTrigger con Lenis
// lenis.on('scroll', (e) => {
//   ScrollTrigger.update(); // Aggiorna GSAP ScrollTrigger su ogni scroll
// });

// // Esempio di animazione GSAP basata sullo scroll con ScrollTrigger
// gsap.to('.smooth-scroll', {
//     scrollTrigger: {
//       trigger: '.smooth-scroll',
//       start: 'top top',
//       end: () => document.querySelector('.smooth-scroll').offsetHeight + 'px', // Imposta l'altezza dinamica in base ai contenuti
//       scrub: true, // Attiva l'animazione con lo scroll
//       invalidateOnRefresh: true, // Garantisce che le dimensioni vengano ricalcolate correttamente
//       pinSpacing: false, // Evita lo spazio extra creato dal pinning
//     },
//     opacity: 1,  // Esempio di animazione per la trasparenza
//     y: -100,     // Trasla l'elemento verso l'alto
//     onComplete: () => {
//       ScrollTrigger.refresh(); // Forza l'aggiornamento di GSAP una volta completata l'animazione
//     }
//   });

// console.log("Scroll height: ", document.documentElement.scrollHeight);
// console.log("Viewport height: ", window.innerHeight);
