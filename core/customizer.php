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
// 24 | Google Tag
// 25 | Hot Jar
// 26 | Public company and contact fields
// 27 | Primary company name
// 28 | Primary VAT number
// 29 | Company registration number
// 30 | Share capital
// 31 | Primary address
// 32 | Secondary address
// 33 | Third address
// 34 | Primary phone
// 35 | Secondary phone
// 36 | Third phone
// 37 | Primary fax
// 38 | Primary email
// 39 | Secondary email
// 40 | Third email
// 41 | LinkedIn
// 42 | Facebook
// 43 | Instagram
// 44 | TikTok

/**
 * @param $wp_customize
 */
function grit_customize_register($wp_customize)
{
    // * GRIT_SET 01 | General settings

    $wp_customize->add_section('grit_framework_general_settings', array(
        'title' => __('General settings', 'grit'),
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
        'description' => __('Choose the header layout', 'grit'),
        'choices'     => array(
            'header_1' => __('Header 1 — Classic with an expandable mobile menu', 'grit'),
            'header_2' => __('Header 2 — Classic with a mobile overlay', 'grit'),
            'header_3' => __('Header 3 — Rounded floating bar', 'grit'),
            'header_4' => __('Header 4 — Transparent with separate blocks', 'grit'),
            'header_5' => __('Header 5 — Centered logo between two menus', 'grit'),
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
        'description' => __('Choose the footer layout', 'grit'),
        'choices' => array(
            'footer_1' => __('Footer 1 — Columns and newsletter', 'grit'),
            'footer_2' => __('Footer 2 — Horizontal menu', 'grit'),
            'footer_3' => __('Footer 3 — Centered', 'grit'),
            'footer_4' => __('Footer 4 — Contact invitation', 'grit'),
            'footer_5' => __('Footer 5 — Editorial menu', 'grit'),
        ),
    ));

    // * GRIT_SET 05 | Google Fonts
    $wp_customize->add_setting('grit_setting_google_fonts', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_google_fonts', array(
        'type' => 'textarea',
        'section' => 'grit_framework_general_settings',
        'label' => __('Google Fonts', 'grit'),
        'description' => __('Enable Google Fonts for each fonts.google.com row', 'grit'),
    ));

    // Library controls: keep defaults aligned with core/config.php.
    // Loading is in core/scripts.php; enabling an asset does not create a frontend component.
    // * GRIT_SET 06 | Library: GSAP
    // Reference: https://github.com/greensock/GSAP

    $wp_customize->add_setting('grit_setting_gsap', array(
        'capability' => 'edit_theme_options',
        'default'    => false,
    ));
    $wp_customize->add_control('grit_setting_gsap', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('GSAP', 'grit'),
        'description' => __('Enable the GSAP library https://github.com/greensock/GSAP', 'grit'),
    ));

    // * GRIT_SET 07 | Library: Three.js

    $wp_customize->add_setting('grit_setting_three', array(
        'capability' => 'edit_theme_options',
        'default'    => false,
    ));
    $wp_customize->add_control('grit_setting_three', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Three js', 'grit'),
        'description' => __('Enable the Three js library threejs.org', 'grit'),
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
        'label' => __('Lenis', 'grit'),
        'description' => __('Enable the Lenis library https://github.com/darkroomengineering/lenis', 'grit'),
    ));

    // * GRIT_SET 09 | Library: Locomotive
    // Reference: https://github.com/locomotivemtl/locomotive-scroll

    $wp_customize->add_setting('grit_setting_locomotive', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_locomotive', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Locomotive', 'grit'),
        'description' => __('Enable the Locomotive library https://github.com/locomotivemtl/locomotive-scroll', 'grit'),
    ));

    // * GRIT_SET 10 | Library: Lightbox2
    // Reference: https://lokeshdhakar.com/projects/lightbox2/

    $wp_customize->add_setting('grit_setting_lightbox2', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_lightbox2', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Lightbox2', 'grit'),
        'description' => __('Enable the Lightbox2 library https://lokeshdhakar.com/projects/lightbox2/', 'grit'),
    ));

    // * GRIT_SET 11 | Library: Fitty.js
    // Reference: https://rikschennink.github.io/fitty/

    $wp_customize->add_setting('grit_setting_fitty', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_fitty', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Fitty js', 'grit'),
        'description' => __('Enable the Fitty js library https://rikschennink.github.io/fitty/', 'grit'),
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
        'label' => __('Masonry js', 'grit'),
        'description' => __('Enable the Masonry.js library https://masonry.desandro.com', 'grit'),
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
        'label' => __('Images Loaded js', 'grit'),
        'description' => __('Enable the Images Loaded js library https://imagesloaded.desandro.com/', 'grit'),
    ));

    // * GRIT_SET 14 | Library: Swiper
    // Reference: https://swiperjs.com/get-started

    $wp_customize->add_setting('grit_setting_swiper', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_swiper', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Swiper', 'grit'),
        'description' => __('Enable the Swiper 10.2 library https://swiperjs.com/get-started', 'grit'),
    )); 

    // * GRIT_SET 15 | owl_carousel CSS

    $wp_customize->add_setting('grit_setting_owl_carousel', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_setting_owl_carousel', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Owl Carousel CSS JS', 'grit'),
        'description' => __('Enable the Owl Carousel CSS JS library owlcarousel2.github.io/OwlCarousel2', 'grit'),

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
        'label' => __('NProgress CSS JS', 'grit'),
        'description' => __('Enable the NProgress CSS JS library https://ricostacruz.com/nprogress/', 'grit'),
    ));

    // * GRIT_SET 17 | Library: Magic Mouse CSS JS

    $wp_customize->add_setting('grit_setting_magic_mouse', array(
        'capability' => 'edit_theme_options',
        'default'    => false,
    ));
    $wp_customize->add_control('grit_setting_magic_mouse', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Magic Mouse CSS JS', 'grit'),
        'description' => __('Enable the Magic Mouse CSS JS library magicmousejs.web.app', 'grit'),
    )); 

    // * GRIT_SET 18 | Library: Cocoen CSS JS

    $wp_customize->add_setting('grit_setting_cocoen', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_cocoen', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Cocoen CSS JS', 'grit'),
        'description' => __('Enable the Cocoen CSS JS library github.com/jotform/before-after.js', 'grit'),

    ));

    // * GRIT_SET 19 | Go To Top Button

    $wp_customize->add_setting('grit_setting_gototop', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_setting_gototop', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Go To Top Button', 'grit'),
    ));

    // * GRIT_SET 20 | Disable Comments

    $wp_customize->add_setting('grit_setting_comments', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_comments', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Disable comments', 'grit'),
    ));

        // * GRIT_SET 21 | Admin bar visibility

    $wp_customize->add_setting('grit_adv_adminbar', array(
        'capability' => 'edit_theme_options',
        'default'    => true,
    ));
    $wp_customize->add_control('grit_adv_adminbar', array(
        'type' => 'checkbox',
        'section' => 'grit_framework_general_settings',
        'label' => __('Hide Admin Bar', 'grit'),
    ));

    // * GRIT_SET 22 | Tracking settings

    $wp_customize->add_section('grit_framework_tracking_settings', array(
        'title' => __('Tracking settings', 'grit'),
        'priority' => 120,
    ));

    // * GRIT_SET 23 | Google Maps Api

    $wp_customize->add_setting('grit_setting_maps', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_maps', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('GMaps API KEY', 'grit'),
        'description' => __('Enter a Google Maps API key from console.cloud.google.com', 'grit'),
    ));

    // * GRIT_SET 24 | Google Tag Manager fallback

    $wp_customize->add_setting('grit_setting_gtag', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'grit_sanitize_gtm_id',
    ));
    $wp_customize->add_control('grit_setting_gtag', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Google Tag Manager ID', 'grit'),
        'description' => __('Enter a GTM-… ID to load GTM through the theme. This field is ignored when Complianz handles loading. Leave it empty to disable loading through the theme. Consent management must be configured separately.', 'grit'),
    ));

    // * GRIT_SET 25 | Hot Jar

    $wp_customize->add_setting('grit_setting_hotjar', array(
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control('grit_setting_hotjar', array(
        'type' => 'text',
        'section' => 'grit_framework_tracking_settings',
        'label' => __('Hotjar ID', 'grit'),
    ));

    // * GRIT_SET 26 | Public company and contact fields

    $wp_customize->add_section('grit_framework_theme_fileds', [
        'title' => __('Theme Fields', 'grit'),
        'priority' => 120,
    ]);

    // * GRIT_SET 27 | Primary company name

    $wp_customize->add_setting('grit_setting_intestazione', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_intestazione', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Company name', 'grit'),
    ]);

    // * GRIT_SET 28 | Primary VAT number

    $wp_customize->add_setting('grit_setting_piva', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_piva', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('VAT number', 'grit'),
    ]);

    // * GRIT_SET 29 | Company registration number

    $wp_customize->add_setting('grit_setting_rea', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_rea', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('REA registration number', 'grit'),
    ]);

    // * GRIT_SET 30 | Share capital

    $wp_customize->add_setting('grit_setting_cap_soc', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_cap_soc', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Share capital', 'grit'),
    ]);

    // * GRIT_SET 31 | Primary address

    $wp_customize->add_setting('grit_setting_indirizzo_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_1', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Address 1', 'grit'),
    ]);

    // * GRIT_SET 32 | Secondary address

    $wp_customize->add_setting('grit_setting_indirizzo_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Address 2', 'grit'),
        'description' => __('When provided, enables the link on the Bio page', 'grit')
    ]);

    // * GRIT_SET 33 | Third address

    $wp_customize->add_setting('grit_setting_indirizzo_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_indirizzo_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Address 3', 'grit'),
        'description' => __('When provided, enables the link on the Bio page', 'grit')

    ]);

    // * GRIT_SET 34 | Primary phone

    $wp_customize->add_setting('grit_setting_tel_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_1', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Phone 1 — Primary', 'grit'),
    ]);

    // * GRIT_SET 35 | Secondary phone

    $wp_customize->add_setting('grit_setting_tel_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Phone 2', 'grit'),
        'description' => __('When provided, enables the link on the Bio page', 'grit')
    ]);

    // * GRIT_SET 36 | Third phone

    $wp_customize->add_setting('grit_setting_tel_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_tel_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Phone 3', 'grit'),
        'description' => __('When provided, enables the WhatsApp link on the Bio page', 'grit')
    ]);

    // * GRIT_SET 37 | Primary fax

    $wp_customize->add_setting('grit_setting_fax', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_fax', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Fax', 'grit'),
    ]);

    // * GRIT_SET 38 | Primary email

    $wp_customize->add_setting('grit_setting_mail_1', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_1', [
        'type' => 'text',
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Email 1 — Primary', 'grit'),
    ]);

    // * GRIT_SET 39 | Secondary email

    $wp_customize->add_setting('grit_setting_mail_2', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_2', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Email 2 — Secondary', 'grit'),
    ]);

    // * GRIT_SET 40 | Third email

    $wp_customize->add_setting('grit_setting_mail_3', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_mail_3', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Email 3', 'grit'),
    ]);

    // * GRIT_SET 41 | LinkedIn

    $wp_customize->add_setting('grit_setting_linkedin', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_linkedin', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Linkedin', 'grit'),
    ]);

    // * GRIT_SET 42 | Facebook

    $wp_customize->add_setting('grit_setting_facebook', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_facebook', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Facebook', 'grit'),
    ]);

    // * GRIT_SET 43 | Instagram

    $wp_customize->add_setting('grit_setting_instagram', [
        'capability' => 'edit_theme_options',
    ]);
    $wp_customize->add_control('grit_setting_instagram', [
        'type' => 'text',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('Instagram', 'grit'),
    ]);

    // * GRIT_SET 44 | TikTok | Shared with the reusable contact shortcodes.
    $wp_customize->add_setting('grit_setting_tiktok', [
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('grit_setting_tiktok', [
        'type' => 'url',
        'section' => 'grit_framework_theme_fileds',
        'label' => __('TikTok', 'grit'),
    ]);

}

add_action('customize_register', 'grit_customize_register');