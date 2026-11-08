<?php

// * GRIT_SET Legend | Customizer
// Customizer sections, layout choices, libraries and public company fields.
// 01 | General settings
// 02 | Logo
// 03 | Header
// 04 | Footer
// 05 | Google Fonts
// 06 | Library: GSAP
// 07 | Library: Three.js
// 08 | Library: Lenis
// 09 | Library: Locomotive
// 10 | Library: Lightbox2
// 11 | Library: Fitty.js
// 12 | Library: masonry.js
// 13 | Library: Imagesloaded.js
// 14 | Library: Swiper
// 15 | owl_carousel CSS
// 16 | Library: NProgress CSS JS
// 17 | Library: Magic Mouse CSS JS
// 18 | Library: Cocoen CSS JS
// 19 | Go To Top Button
// 20 | Disable Comments
// 21 | Admin bar visibility
// 22 | Tracking settings
// 23 | Google Maps Api
// 24 | Google Recaptcha V3
// 25 | Google Tag
// 26 | Hot Jar
// 27 | Public company and contact fields
// 28 | Primary company name
// 29 | Primary VAT number
// 30 | Company registration number
// 31 | Share capital
// 32 | Primary address
// 33 | Secondary address
// 34 | Third address
// 35 | Primary phone
// 36 | Secondary phone
// 37 | Third phone
// 38 | Primary fax
// 39 | Primary email
// 40 | Secondary email
// 41 | Third email
// 42 | LinkedIn
// 43 | Facebook
// 44 | Instagram
// 45 | TikTok

/**
 * @param $wp_customize
 */
function grit_customize_register($wp_customize)
{
    // * GRIT_SET 01 | General settings

    $wp_customize->add_section('grit_framework_general_settings', array(
        'title' => __('General settings', 'grit_framework'),
        'priority' => 120,
    ));

    // * GRIT_SET 02 | Logo

    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

    // * GRIT_SET 03 | Header

    $wp_customize->add_setting('grit_setting_header', array(
        'capability'        => 'edit_theme_options',
        'default'           => 'header_1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('grit_setting_header', array(
        'type'        => 'select',
        'section'     => 'grit_framework_general_settings',
        'label'       => __('Header Style', 'grit'),
        'description' => __('Scegli la tipologia di header', 'grit'),
        'choices'     => array(
            'header_1' => __('Header 1 — Classico con menu mobile espandibile', 'grit'),
            'header_2' => __('Header 2 — Classico con overlay mobile', 'grit'),
            'header_3' => __('Header 3 — Barra flottante arrotondata', 'grit'),
            'header_4' => __('Header 4 — Trasparente con blocchi separati', 'grit'),
            'header_5' => __('Header 5 — Logo centrale tra due menu', 'grit'),
        ),
    ));

    // * GRIT_SET 04 | Footer

    $wp_customize->add_setting('grit_setting_footer', array(
        'capability' => 'edit_theme_options',
        'default' => 'footer_1',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('grit_setting_footer', array(
        'type' => 'select',
        'section' => 'grit_framework_general_settings',
        'label' => __('Footer Style', 'grit'),
        'description' => __('Scegli la tipologia di footer', 'grit'),
        'choices' => array(
            'footer_1' => __('Footer 1 — Colonne e newsletter', 'grit'),
            'footer_2' => __('Footer 2 — Menu orizzontale', 'grit'),
            'footer_3' => __('Footer 3 — Centrato', 'grit'),
            'footer_4' => __('Footer 4 — Invito al contatto', 'grit'),
            'footer_5' => __('Footer 5 — Menu editoriale', 'grit'),
        ),
    ));

    // * GRIT_SET 05 | Google Fonts
    $wp_customize->add_setting('grit_setting_google_fonts', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_google_fonts', array(
        'type' => 'textarea',
        'section' => 'grit_framework_general_settings',
        'label' => __('Google Fonts'),
        'description' => __('Attiva Google Fonts per ogni riga fonts.google.com'),
    ));

    // * GRIT_SET 06 | Library: GSAP
    // Reference: https://github.com/greensock/GSAP

    $wp_customize->add_setting('grit_setting_gsap', array(
        'capability' => 'edit_theme_options',
        'default'    => false,
    ));
    $wp_customize->add_control('grit_setting_gsap', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('GSAP'),
        'description' => __('Attiva libreria GSAP https://github.com/greensock/GSAP'),
    ));

    // * GRIT_SET 07 | Library: Three.js

    $wp_customize->add_setting('grit_setting_three', array(
        'capability' => 'edit_theme_options',
        'default'    => false,
    ));
    $wp_customize->add_control('grit_setting_three', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Three js'),
        'description' => __('Attiva libreria Three js threejs.org'),
    )); 

    // * GRIT_SET 08 | Library: Lenis
    // Reference: https://github.com/darkroomengineering/lenis

    $wp_customize->add_setting('grit_setting_lenis', array(
        'capability' => 'edit_theme_options',
        'default'    => false,
    ));
    $wp_customize->add_control('grit_setting_lenis', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Lenis'),
        'description' => __('Attiva libreria Lenis https://github.com/darkroomengineering/lenis'),
    ));

    // * GRIT_SET 09 | Library: Locomotive
    // Reference: https://github.com/locomotivemtl/locomotive-scroll

    $wp_customize->add_setting('grit_setting_locomotive', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_locomotive', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Locomotive'),
        'description' => __('Attiva libreria Locomotive https://github.com/locomotivemtl/locomotive-scroll'),
    ));

    // * GRIT_SET 10 | Library: Lightbox2
    // Reference: https://lokeshdhakar.com/projects/lightbox2/

    $wp_customize->add_setting('grit_setting_lightbox2', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_lightbox2', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Lightbox2'),
        'description' => __('Attiva libreria Lightbox2 https://lokeshdhakar.com/projects/lightbox2/'),
    ));

    // * GRIT_SET 11 | Library: Fitty.js
    // Reference: https://rikschennink.github.io/fitty/

    $wp_customize->add_setting('grit_setting_fitty', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_fitty', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Fitty js'),
        'description' => __('Attiva libreria Fitty js https://rikschennink.github.io/fitty/'),
    ));

    // * GRIT_SET 12 | Library: masonry.js
    // Reference: https://masonry.desandro.com

    $wp_customize->add_setting('grit_setting_masonry', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_setting_masonry', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Masonry js'),
        'description' => __('Attiva libreria Mesonry.js https://masonry.desandro.com'),
    ));

    // * GRIT_SET 13 | Library: Imagesloaded.js
    // Reference: https://imagesloaded.desandro.com

    $wp_customize->add_setting('grit_setting_imagesloaded', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_setting_imagesloaded', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Images Loaded js'),
        'description' => __('Attiva libreria Images Loaded js https://imagesloaded.desandro.com/'),
    ));

    // * GRIT_SET 14 | Library: Swiper
    // Reference: https://swiperjs.com/get-started

    $wp_customize->add_setting('grit_setting_swiper', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_swiper', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Swiper'),
        'description' => __('Attiva libreria Swiper 10.2 https://swiperjs.com/get-started'),
    )); 

    // * GRIT_SET 15 | owl_carousel CSS

    $wp_customize->add_setting('grit_setting_owl_carousel', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_setting_owl_carousel', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Owl Carousel CSS JS'),
        'description' => __('Attiva libreria Owl Carousel CSS JS owlcarousel2.github.io/OwlCarousel2'),

    ));

    // * GRIT_SET 16 | Library: NProgress CSS JS
    // Reference: https://ricostacruz.com/nprogress/

    // * GRIT_SET Default-on libraries with independent Customizer switches
    $grit_optional_libraries = array(
        'list' => array('List.js', 'Ricerca e paginazione nelle sezioni Collapse. Se disattivato viene mostrato l’elenco completo.'),
        'jarallax' => array('Jarallax + Video + Element', 'Attiva o disattiva insieme il parallax standard e le estensioni Video ed Element.'),
    );
    foreach ($grit_optional_libraries as $grit_library => $grit_library_info) {
        $grit_library_setting = 'grit_setting_' . $grit_library;
        $wp_customize->add_setting($grit_library_setting, array(
            'capability' => 'edit_theme_options',
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));
        $wp_customize->add_control($grit_library_setting, array(
            'type' => 'checkbox',
            'section' => 'grit_framework_general_settings',
            'label' => $grit_library_info[0],
            'description' => $grit_library_info[1],
        ));
    }

    $wp_customize->add_setting('grit_setting_nprogress', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_setting_nprogress', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('NProgress CSS JS'),
        'description' => __('Attiva libreria NProgress CSS JS https://ricostacruz.com/nprogress/'),
    ));

    // * GRIT_SET 17 | Library: Magic Mouse CSS JS

    $wp_customize->add_setting('grit_setting_magic_mouse', array(
        'capability' => 'edit_theme_options',
        'default'    => false,
    ));
    $wp_customize->add_control('grit_setting_magic_mouse', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Magic Mouse CSS JS'),
        'description' => __('Attiva libreria Magic Mouse CSS JS magicmousejs.web.app'),
    )); 

    // * GRIT_SET 18 | Library: Cocoen CSS JS

    $wp_customize->add_setting('grit_setting_cocoen', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_cocoen', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Cocoen CSS JS'),
        'description' => __('Attiva libreria Cocoen CSS JS github.com/jotform/before-after.js'),

    ));

    // * GRIT_SET 19 | Go To Top Button

    $wp_customize->add_setting('grit_setting_gototop', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_setting_gototop', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Go To Top Button'),
    ));

    // * GRIT_SET 20 | Disable Comments

    $wp_customize->add_setting('grit_setting_comments', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_comments', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Disable comments'),
    ));

        // * GRIT_SET 21 | Admin bar visibility

    $wp_customize->add_setting('grit_adv_adminbar', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_adv_adminbar', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Hide Admin Bar'),
    ));

    // * GRIT_SET 22 | Tracking settings

    $wp_customize->add_section('grit_framework_tracking_settings', array(
        'title' => __('Tracking settings', 'grit_framework'),
        'priority' => 120,
    ));

    // * GRIT_SET 23 | Google Maps Api

    $wp_customize->add_setting('grit_setting_maps', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_maps', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('GMaps API KEY'),
        'description' => __('Inserisci API key di Google Maps console.cloud.google.com'),
    ));

    // * GRIT_SET 24 | Google Recaptcha V3

    $wp_customize->add_setting('grit_setting_recaptcha', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_recaptcha', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Google Recaptcha V3 API KEY'),
        'description' => __('Inserisci API key di Google Recaptcha V3 console.cloud.google.com/security/recaptcha'),
    ));

    // * GRIT_SET 25 | Google Tag Manager fallback

    $wp_customize->add_setting('grit_setting_gtag', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'grit_sanitize_gtm_id',
    ));
    $wp_customize->add_control('grit_setting_gtag', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Google Tag Manager ID', 'grit'),
        'description' => __('Inserisci un ID GTM-… per caricare GTM dal tema. Se il caricamento è affidato a Complianz, questo campo viene ignorato. Lascia vuoto per disabilitare il caricamento dal tema. La gestione del consenso va configurata separatamente.', 'grit'),
    ));

    // * GRIT_SET 26 | Hot Jar

    $wp_customize->add_setting('grit_setting_hotjar', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_hotjar', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Hotjar ID'),
    ));

    // * GRIT_SET 27 | Public company and contact fields

    $wp_customize->add_section('grit_framework_theme_fileds', [
        'title' => __('Theme Fields', 'grit_framework'),
        'priority' => 120,
    ]);

    // * GRIT_SET 28 | Primary company name

    $wp_customize->add_setting('grit_setting_intestazione', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_intestazione', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Intestazione'),
    ]);

    // * GRIT_SET 29 | Primary VAT number

    $wp_customize->add_setting('grit_setting_piva', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_piva', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('P. IVA'),
    ]);

    // * GRIT_SET 30 | Company registration number

    $wp_customize->add_setting('grit_setting_rea', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_rea', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('N° REA'),
    ]);

    // * GRIT_SET 31 | Share capital

    $wp_customize->add_setting('grit_setting_cap_soc', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_cap_soc', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Capitale Sociale'),
    ]);

    // * GRIT_SET 32 | Primary address

    $wp_customize->add_setting('grit_setting_indirizzo_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_1', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Indirizzo 1'),
    ]);

    // * GRIT_SET 33 | Secondary address

    $wp_customize->add_setting('grit_setting_indirizzo_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Indirizzo 2'),
        'description' => __('Se presente attiva link in BIO')
    ]);

    // * GRIT_SET 34 | Third address

    $wp_customize->add_setting('grit_setting_indirizzo_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Indirizzo 3'),
        'description' => __('Se presente attiva link in BIO')

    ]);

    // * GRIT_SET 35 | Primary phone

    $wp_customize->add_setting('grit_setting_tel_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_1', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Telefono 1 Principale'),
    ]);

    // * GRIT_SET 36 | Secondary phone

    $wp_customize->add_setting('grit_setting_tel_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Telefono 2'),
        'description' => __('Se presente attiva link in BIO')
    ]);

    // * GRIT_SET 37 | Third phone

    $wp_customize->add_setting('grit_setting_tel_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Telefono 3'),
        'description' => __('Se presente attiva link Whats App in BIO')
    ]);

    // * GRIT_SET 38 | Primary fax

    $wp_customize->add_setting('grit_setting_fax', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_fax', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Fax'),
    ]);

    // * GRIT_SET 39 | Primary email

    $wp_customize->add_setting('grit_setting_mail_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_1', [
        'type' => 'text',
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Mail 1 Principale'),
    ]);

    // * GRIT_SET 40 | Secondary email

    $wp_customize->add_setting('grit_setting_mail_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Mail 2 Secondaria'),
    ]);

    // * GRIT_SET 41 | Third email

    $wp_customize->add_setting('grit_setting_mail_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Mail 3'),
    ]);

    // * GRIT_SET 42 | LinkedIn

    $wp_customize->add_setting('grit_setting_linkedin', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_linkedin', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Linkedin'),
    ]);

    // * GRIT_SET 43 | Facebook

    $wp_customize->add_setting('grit_setting_facebook', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_facebook', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Facebook'),
    ]);

    // * GRIT_SET 44 | Instagram

    $wp_customize->add_setting('grit_setting_instagram', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_instagram', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Instagram'),
    ]);

    // * GRIT_SET 45 | TikTok | Shared with the reusable contact shortcodes.
    $wp_customize->add_setting('grit_setting_tiktok', [
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('grit_setting_tiktok', [
        'type' => 'url',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('TikTok', 'grit_framework'),
    ]);

}

add_action('customize_register', 'grit_customize_register');