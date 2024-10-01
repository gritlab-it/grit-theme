/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * A_SETTINGS INDEX
:::::::::::::: 01 * A_SETTINGS loader
:::::::::::::: 02 * A_SETTINGS animate
:::::::::::::: 03 * A_SETTINGS sticky
:::::::::::::: 04 * A_SETTINGS magicMouse
:::::::::::::: 05 * A_SETTINGS butter-js
:::::::::::::: 06 * A_SETTINGS menu showing
:::::::::::::: 07 * A_SETTINGS jarallax-js
:::::::::::::: 08 * A_SETTINGS NProgress-js
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::




jQuery(document).ready(function($) {
// Percorso del file JSON
var json_file_path = '<?php echo get_template_directory_uri() ?>/agency/agency.json';

// Effettua la richiesta AJAX per recuperare i dati dal file JSON
$.getJSON(json_file_path, function(data) {
// Controlla se il file JSON contiene l'array 'agency'
if (data.agency && data.agency.length > 0) {
var agency = data.agency[0]; // Prendi il primo elemento dell'array 'agency'

// Stampa i crediti nella console
console.log('© ' + agency.name + '. Tutti i diritti sono riservati');
console.log('Realizzazione siti web %c' + agency.theme, 'color: #3ABEB9; font-weight:600;');
console.log(agency.url);
} else {
console.log('Errore: Nessuna informazione sull\'agenzia trovata nel file JSON.');
}
}).fail(function() {
console.log('Errore: Impossibile recuperare il file JSON.');
});
});



/* :::::::::::::: 01 * A_SETTINGS loader
:::::::::::::::::    add loaded and set timeout loader */
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

/* :::::::::::::: 02 * A_SETTINGS animate */
$(document).ready(function () {
    var viewportchecker_active = document.getElementById("viewportchecker-js");
    if (viewportchecker_active) {
        /* init animate and add visibile item in viewport after with offset */
        jQuery('.in__animate').addClass("hidden").viewportChecker({
            classToAdd: 'visible animate__animated animate__fadeIn animate__slow ',
            offset: 300,
            repeat: true,
        });
    }
});

/* :::::::::::::: 06 * A_SETTINGS menu showing  */
$(document).ready(function () {
    $(".menu-icon").on("click", function () {
        $("nav ul").toggleClass("showing");
        // alert('showing menu-icon');
    });
});


/* :::::::::::::: 06 * A_SETTINGS menu showing  */
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


/* :::::::::::::: 03 * A_SETTINGS sticky */
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

/* :::::::::::::: 04 * A_SETTINGS magicMouse */
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

/* :::::::::::::: 05 * A_SETTINGS butter-js  */
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





/* :::::::::::::: 07 * A_SETTINGS jarallax-js  */
owl_carousel_active = document.getElementById('owl_carousel-js')
if (owl_carousel_active) {
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
}


/* :::::::::::::: 08 * A_SETTINGS NProgress-js */
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
