<?php

// * GRIT_SET Legend | Config
// Frontend library switches and additional asset lists.
// Path: core/customizer.php option -> this file -> core/scripts.php loading -> assets/js/custom.js initialization.
// See GUIDA.md: "Percorso breve: opzione → caricamento → inizializzazione".
// 01 | Frontend library options
// 02 | Additional stylesheet URLs
// 03 | Additional JavaScript URLs

// * GRIT_SET 01 | Frontend library options

$GLOBALS['assets_options'] = array(

    // These four entries are informational: core/scripts.php loads them unconditionally.
    // Setting them to false does not disable their assets.
    // Library: Bootstrap 4.6.2 CSS JS
    'GRIT_SETTING_BOOTSTRAP' => true,

    // Library: Fontawesome 5.15.1 fontawesome.com/icons
    'GRIT_SETTING_FA' => true,

    // Library: Animate CSS animate.style
    'GRIT_SETTING_ANIMATE' => true,

    // Library: Hover CSS ianlunn.github.io/Hover
    'GRIT_SETTING_HOVER' => true,

    // Library: Three js threejs.org
    'GRIT_SETTING_THREE' => get_theme_mod('grit_setting_three', false),

    // Library: Masonry js https://masonry.desandro.com
    'GRIT_SETTING_MASONRY' => get_theme_mod('grit_setting_masonry', true),

    // Library: Images Loaded js https://imagesloaded.desandro.com/
    'GRIT_SETTING_IMAGESLOADED' => get_theme_mod('grit_setting_imagesloaded', true),

    // Library: Lenis https://github.com/darkroomengineering/lenis
    'GRIT_SETTING_LENIS' => get_theme_mod('grit_setting_lenis', false),

    // Library: Locomotive https://github.com/locomotivemtl/locomotive-scroll
    'GRIT_SETTING_LOCOMOTIVE' => get_theme_mod('grit_setting_locomotive'),

    // Library: Lightbox2 https://lokeshdhakar.com/projects/lightbox2/
    'GRIT_SETTING_LIGHTBOX2' => get_theme_mod('grit_setting_lightbox2'),

    // Library: Fitty js https://rikschennink.github.io/fitty/
    'GRIT_SETTING_FITTY' => get_theme_mod('grit_setting_fitty'),

    // Library: GSAP https://github.com/greensock/GSAP
    'GRIT_SETTING_GSAP' => get_theme_mod('grit_setting_gsap', false),

    // Library: Swiper 10.2 https://swiperjs.com/get-started
    'GRIT_SETTING_SWIPER' => get_theme_mod('grit_setting_swiper'),

    // Library: Owl Carousel CSS JS owlcarousel2.github.io/OwlCarousel2
    'GRIT_SETTING_OWL_CAROUSEL' => get_theme_mod('grit_setting_owl_carousel', true),

    // Library: Jarallax https://github.com/nk-o/jarallax
    'GRIT_SETTING_JARALLAX' => get_theme_mod('grit_setting_jarallax', true),

    // * GRIT_SET Search and pagination library, enabled by default
    'GRIT_SETTING_LIST' => get_theme_mod('grit_setting_list', true),

    // Library: NProgress CSS JS https://ricostacruz.com/nprogress/
    'GRIT_SETTING_NPROGRESS' => get_theme_mod('grit_setting_nprogress', true),

    // Library: Magic Mouse CSS JS magicmousejs.web.app
    'GRIT_SETTING_MAGIC_MOUSE' => get_theme_mod('grit_setting_magic_mouse', false),
 
    // Library: Cocoen CSS JS github.com/jotform/before-after.js
    'GRIT_SETTING_COCOEN' => get_theme_mod('grit_setting_cocoen'),

    // Google Maps API key.
    'GRIT_SETTING_MAPS' => get_theme_mod('grit_setting_maps'),

);

// Additional stylesheets are loaded by core/scripts.php.
// * GRIT_SET 02 | Additional stylesheet URLs
$GLOBALS['GRIT_SETTING_CSS'] = array(

    // 'data_table' => 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css',
);

// Additional scripts are loaded by core/scripts.php.
// * GRIT_SET 03 | Additional JavaScript URLs
$GLOBALS['GRIT_SETTING_JS'] = array(

    // 'smoth' => 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollSmoother.min.js', 
    // 'split' => 'https://cdn.jsdelivr.net/npm/split-type@0.3.4/umd/index.min.js', 
    // 'data_table' => 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js',
    // 'data_table_ita' => 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Italian.json',

);