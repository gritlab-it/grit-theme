<?php

/**
 * @param $wp_customize
 */
function grit_customize_register($wp_customize)
{
    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET GENERAL SETTINGS
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_section('grit_framework_general_settings', array(
        'title' => __('General settings', 'grit_framework'),
        'priority' => 120,
    ));


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Post IDs viewable in the back-end
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Logo
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Google Fonts
                        // Attiva Google Fonts per ogni riga fonts.google.com
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Header
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_header', array(
        'capability' => 'edit_theme_options',
        'default' => 'header_1',
    ));
    $wp_customize->add_control('grit_setting_header', array(
        'type' => 'select',
        'section' => 'grit_framework_general_settings',
        'label' => __('Header Style'),
        'description' => __('Scegli la tipologia di header'),
        'choices' => array(
            'header_1' => __('header_1'),
            'header_2' => __('header_2'),
            'header_3' => __('header_3'),
            'header_4' => __('header_4'),
            'header_5' => __('header_5'),
        ),
    ));


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Footer
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_footer', array(
        'capability' => 'edit_theme_options',
        'default' => 'footer_1',
    ));
    $wp_customize->add_control('grit_setting_footer', array(
        'type' => 'select',
        'section' => 'grit_framework_general_settings',
        'label' => __('Footer Style'),
        'description' => __('Scegli la tipologia di footer'),
        'choices' => array(
            'footer_1' => __('footer_1'),
            'footer_2' => __('footer_2'),
            'footer_3' => __('footer_3'),
            'footer_4' => __('footer_4'),
            'footer_5' => __('footer_5'),
        ),
    ));


    $wp_customize->add_setting('grit_setting_google_fonts', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_google_fonts', array(
        'type' => 'textarea',
        'section' => 'grit_framework_general_settings',
        'label' => __('Google Fonts'),
        'description' => __('Attiva Google Fonts per ogni riga fonts.google.com'),
    ));


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Bootstrap 4.6.2 CSS JS
                        // Attiva libreria Bootstrap 4.6.2 CSS JS
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_bootstrap', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_bootstrap', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Activate Bootstrap 4.6.2'),
        'description' => __('Attiva libreria Bootstrap 4.6.2 css/js'),

    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Fontawesome
                        // Attiva libreria Fontawesome 5.15.1 fontawesome.com/icons
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_fa', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_fa', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Fontawesome '),
        'description' => __('Attiva libreria Fontawesome 5.15.1 fontawesome.com/icons'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Animate CSS
                        // Attiva libreria Animate CSS animate.style
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_animate', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_animate', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Animate CSS'),
        'description' => __('Attiva libreria Animate CSS animate.style'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Hover CSS
                        // Attiva libreria Hover CSS ianlunn.github.io/Hover
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_hover', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_hover', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Hover CSS'),
        'description' => __('Attiva libreria Hover CSS ianlunn.github.io/Hover'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta GSAP
                        // Attiva libreria GSAP https://github.com/greensock/GSAP
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_gsap', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_gsap', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('GSAP'),
        'description' => __('Attiva libreria GSAP https://github.com/greensock/GSAP'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Three.js
                        // Attiva libreria Three threejs.org
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_three', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_three', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Three js'),
        'description' => __('Attiva libreria Three js threejs.org'),
    )); 

    
    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Lenis
                        // Attiva libreria Lenis https://github.com/darkroomengineering/lenis
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_lenis', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_lenis', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Lenis'),
        'description' => __('Attiva libreria Lenis https://github.com/darkroomengineering/lenis'),
    ));
            

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Locomotive
                        // Attiva libreria Locomotive https://github.com/locomotivemtl/locomotive-scroll
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_locomotive', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_locomotive', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Locomotive'),
        'description' => __('Attiva libreria Locomotive https://github.com/locomotivemtl/locomotive-scroll'),
    ));



    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Lightbox2
                        // Attiva libreria Lightbox2 https://lokeshdhakar.com/projects/lightbox2/
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_lightbox2', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_lightbox2', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Lightbox2'),
        'description' => __('Attiva libreria Lightbox2 https://lokeshdhakar.com/projects/lightbox2/'),
    ));


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Fitty.js
                        // Attiva libreria Fitty js https://rikschennink.github.io/fitty/
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_fitty', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_fitty', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Fitty js'),
        'description' => __('Attiva libreria Fitty js https://rikschennink.github.io/fitty/'),
    ));


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta masonry.js
                        // Attiva libreria Mesonry js https://masonry.desandro.com
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_masonry', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_masonry', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Masonry js'),
        'description' => __('Attiva libreria Mesonry.js https://masonry.desandro.com'),
    ));

        
    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Imagesloaded.js
                        // Attiva libreria Images Loaded js https://imagesloaded.desandro.com
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_imagesloaded', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_imagesloaded', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Images Loaded js'),
        'description' => __('Attiva libreria Images Loaded js https://imagesloaded.desandro.com/'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Swiper
                        // Attiva libreria Swiper 10.2 https://swiperjs.com/get-started
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_swiper', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_swiper', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Swiper'),
        'description' => __('Attiva libreria Swiper 10.2 https://swiperjs.com/get-started'),
    )); 


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET owl_carousel CSS
                        // Attiva libreria Owl Carousel CSS JS owlcarousel2.github.io/OwlCarousel2
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_owl_carousel', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_owl_carousel', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Owl Carousel CSS JS'),
        'description' => __('Attiva libreria Owl Carousel CSS JS owlcarousel2.github.io/OwlCarousel2'),

    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET jarallax
                        // Attiva libreria Jarallax https://github.com/nk-o/jarallax
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_jarallax', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_jarallax', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Jarallax'),
        'description' => __('Attiva libreria Jarallax https://github.com/nk-o/jarallax'),

    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta NProgress CSS JS
                        // Attiva libreria NProgress CSS JS https://ricostacruz.com/nprogress/
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_nprogress', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_nprogress', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('NProgress CSS JS'),
        'description' => __('Attiva libreria NProgress CSS JS https://ricostacruz.com/nprogress/'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Magic Mouse CSS JS
                        // Attiva libreria Magic Mouse CSS JS magicmousejs.web.app
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_magic_mouse', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_magic_mouse', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Magic Mouse CSS JS'),
        'description' => __('Attiva libreria Magic Mouse CSS JS magicmousejs.web.app'),
    )); 

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Attiva in base alla scalta Cocoen CSS JS
                        // Attiva libreria Cocoen CSS JS github.com/jotform/before-after.js
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_cocoen', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_cocoen', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Cocoen CSS JS'),
        'description' => __('Attiva libreria Cocoen CSS JS github.com/jotform/before-after.js'),

    ));


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Go To Top Button
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_gototop', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_gototop', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Go To Top Button'),
    ));
 

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Disable Comments
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_comments', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_comments', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Disable comments'),
    ));


        /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET HIDE ADMIN BAR
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_adv_adminbar', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_adv_adminbar', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Hide Admin Bar'),
    ));




    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET TRACKING SETTINGS
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_section('grit_framework_tracking_settings', array(
        'title' => __('Tracking settings', 'grit_framework'),
        'priority' => 120,
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Google Analytics
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_analytics', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_analytics', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Google Analytics UID'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Google Maps Api
                    Inserisci API key di Google Maps console.cloud.google.com
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_maps', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_maps', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('GMaps API KEY'),
        'description' => __('Inserisci API key di Google Maps console.cloud.google.com'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Google Recaptcha V3
                    Inserisci API key di Google Recaptcha V3 console.cloud.google.com/security/recaptcha
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_recaptcha', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_recaptcha', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Google Recaptcha V3 API KEY'),
        'description' => __('Inserisci API key di Google Recaptcha V3 console.cloud.google.com/security/recaptcha'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Google Tag
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_gtag', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_gtag', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Google Tag ID'),
    ));


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Hot Jar
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_hotjar', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_hotjar', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Hotjar ID'),
    ));
 

 



    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET THEME FIELDS
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_section('grit_framework_theme_fileds', array(
        'title' => __('Theme Fields', 'grit_framework'),
        'priority' => 120,
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Intestazione Principale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_intestazione', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_intestazione', array(
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Intestazione'),
    ));

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET P. IVA Principale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    $wp_customize->add_setting('grit_setting_piva', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_piva', array(
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('P. IVA'),
    ));


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET THEME FIELDS
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_section('grit_framework_theme_fileds', [
        'title' => __('Theme Fields', 'grit_framework'),
        'priority' => 120,
    ]);


    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Intestazione Principale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_intestazione', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_intestazione', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Intestazione'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET P. IVA Principale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_piva', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_piva', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('P. IVA'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Numero Rea Principale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_rea', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_rea', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('N° REA'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Cap Sociale Principale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_cap_soc', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_cap_soc', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Capitale Sociale'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Indirizzo 1 Principale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_indirizzo_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_1', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Indirizzo 1'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Indirizzo 2
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_indirizzo_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Indirizzo 2'),
        'description' => __('Se presente attiva link in BIO')
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Indirizzo 3
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_indirizzo_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Indirizzo 3'),
        'description' => __('Se presente attiva link in BIO')

    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Telefono 1 Pricipale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_tel_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_1', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Telefono 1 Principale'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Telefono 2
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_tel_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Telefono 2'),
        'description' => __('Se presente attiva link in BIO')
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Telefono 3
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_tel_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Telefono 3'),
        'description' => __('Se presente attiva link Whats App in BIO')
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Fax Pricipale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_fax', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_fax', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Fax'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Mail 1 Principale
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_mail_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_1', [
        'type' => 'text',
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Mail 1 Principale'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Mail 2 Secondaria
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_mail_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Mail 2 Secondaria'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Mail 3
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_mail_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Mail 3'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET LInkedin
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_linkedin', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_linkedin', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Linkedin'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Fecebook
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_facebook', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_facebook', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Facebook'),
    ]);

    /*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    ::::::::::::::    * GRIT_SET Instagram
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    $wp_customize->add_setting('grit_setting_instagram', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_instagram', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Instagram'),
    ]);


}

add_action('customize_register', 'grit_customize_register');