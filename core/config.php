<?php


/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * A_SETTINGS Configurazione variabili GLOBALS
                    // Asseganzione variabili grit_setting ad array assets_options
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * A_SETTINGS assets_option third parties
                    // Asseganzione variabili grit_setting ad array assets_options
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

$GLOBALS['assets_options'] = array(

    // Attiva libreria Bootstrap 4.6.2 CSS JS
    'GRIT_SETTING_BOOTSTRAP' => get_theme_mod('grit_setting_bootstrap'),

    // Attiva libreria Fontawesome 5.15.1 fontawesome.com/icons
    'GRIT_SETTING_FA' => get_theme_mod('grit_setting_fa'),

    // Attiva libreria Animate CSS animate.style
    'GRIT_SETTING_ANIMATE' => get_theme_mod('grit_setting_animate'),

    // Attiva libreria Hover CSS ianlunn.github.io/Hover
    'GRIT_SETTING_HOVER' => get_theme_mod('grit_setting_hover'),

    // Attiva libreria Three js threejs.org
    'GRIT_SETTING_THREE' => get_theme_mod('grit_setting_three'),

    // Attiva libreria Masonry js https://masonry.desandro.com
    'GRIT_SETTING_MASONRY' => get_theme_mod('grit_setting_masonry'),

    // Attiva libreria Images Loaded js https://imagesloaded.desandro.com/
    'GRIT_SETTING_IMAGESLOADED' => get_theme_mod('grit_setting_imagesloaded'),

    // Attiva libreria Lightbox2 https://lokeshdhakar.com/projects/lightbox2/
    'GRIT_SETTING_LIGHTBOX2' => get_theme_mod('grit_setting_lightbox2'),

    // Attiva libreria Fitty js https://rikschennink.github.io/fitty/
    'GRIT_SETTING_FITTY' => get_theme_mod('grit_setting_fitty'),

    // Attiva libreria GSAP https://github.com/greensock/GSAP
    'GRIT_SETTING_GSAP' => get_theme_mod('grit_setting_gsap'),

    // Attiva libreria Swiper 10.2 https://swiperjs.com/get-started
    'GRIT_SETTING_SWIPER' => get_theme_mod('grit_setting_swiper'),

    // Attiva libreria Owl Carousel CSS JS owlcarousel2.github.io/OwlCarousel2
    'GRIT_SETTING_OWL_CAROUSEL' => get_theme_mod('grit_setting_owl_carousel'),

    // Attiva libreria Jarallax https://github.com/nk-o/jarallax
    'GRIT_SETTING_JARALLAX' => get_theme_mod('grit_setting_jarallax'),

    // Attiva libreria NProgress CSS JS https://ricostacruz.com/nprogress/
    'GRIT_SETTING_NPROGRESS' => get_theme_mod('grit_setting_nprogress'),

    // Attiva libreria Magic Mouse CSS JS magicmousejs.web.app
    'GRIT_SETTING_MAGIC_MOUSE' => get_theme_mod('grit_setting_magic_mouse'),

    // Attiva libreria  Butter JS bcjdevelopment.github.io/butter.js
    'GRIT_SETTING_BUTTER' => get_theme_mod('grit_setting_butter'),

    // Attiva libreria Cocoen CSS JS github.com/jotform/before-after.js
    'GRIT_SETTING_COCOEN' => get_theme_mod('grit_setting_cocoen'),

    // Inserisci API key di Google Maps console.cloud.google.com
    'GRIT_SETTING_MAPS' => get_theme_mod('grit_setting_maps'),

    // Inserisci API key di Google Recaptcha V3 console.cloud.google.com/security/recaptcha
    'GRIT_SETTING_RECAPTCHA' => get_theme_mod('grit_setting_recaptcha'),

    // http://www.giovannifracasso.it/accettazione-cookies-privacy-banner/
    'GRIT_SETTING_COOKIES' => get_theme_mod('grit_setting_cookies'),

);

// Attivo lista percorsi CSS di terze parti in core/scripts.php
$GLOBALS['GRIT_SETTING_CSS'] = array(

    // 'data_table' => 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css',
);

// Attivo lista percorsi JS di terze parti in core/scripts.php
$GLOBALS['GRIT_SETTING_JS'] = array(

    // 'data_table' => 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js',
    // 'data_table_ita' => 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Italian.json',

);