<?php

// * GRIT_SET Legend | Admin-customizer
// Admin branding, agency settings and ACF editor helpers.
// 01 | Admin stylesheet loading
// 02 | Customizer admin menu bar
// 03 | Read agency branding configuration
// 04 | Login logo and background branding
// 05 | Admin, toolbar and login fonts
// 06 | ACF Flexible Content layout titles

// * GRIT_SET 01 | Admin stylesheet loading

function admin_style()
{
    wp_enqueue_style('admin-styles', get_template_directory_uri() . '/assets/css/wp-admin.css');
    /*    wp_enqueue_script( 'admin-script', get_template_directory_uri().'/assets/wp-admin.js', array( 'jquery' ), '1.2.1' );*/
}

// Esegue la funzione admin_style() all’azione admin_enqueue_scripts di WP
add_action('admin_enqueue_scripts', 'admin_style');
// * GRIT_SET 02 | Customizer admin menu bar
// Reference: https://heera.it/customize-admin-menu-bar-in-wordpress
// Reference: https://webriti.com/customizing-wordpress-admin-bar/

function add_my_own_logo($wp_admin_bar)
{
    $args = array(
        'id' => 'my-logo',
        'href' => grit_agency_data()['agency_url'],
        'meta' => array('class' => 'my-logo', 'title' => grit_agency_data()['agency'])
    );
    $wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'add_my_own_logo', 1);

function linked_url() {
    $agency = grit_agency_data();
    add_menu_page('Agency', $agency['agency'], 'read', 'gritlab_site', '', 'dashicons-info-outline', 1);
}
add_action('admin_menu', 'linked_url');

function linkedurl_function() {
    global $menu;
    $agency = grit_agency_data();
    // Find our own entry: another plugin may occupy menu position 1.
    foreach ($menu as &$item) {
        if (($item[2] ?? '') === 'gritlab_site') {
            $item[2] = $agency['agency_url'];
            break;
        }
    }
    unset($item);
}
add_action('admin_menu', 'linkedurl_function');

// * GRIT_SET 03 | Compatibility wrappers; all consumers now use the same validated active record.
function get_agency_data_from_json() {
    return [grit_agency_data()];
}

function get_agency_folder_from_json() {
    return grit_agency_data()['agency_folder'];
}

// * GRIT_SET 04 | Login and toolbar assets use Grit fallbacks when custom files are missing.
function login_logo() {
    $logo = grit_agency_asset('logo.png');
    $icon = grit_agency_asset('icon.svg');
    echo '<style type="text/css">';
    if ($logo) {
        echo '#login h1 a,.login h1 a{background-image:url("' . esc_url($logo['url']) . '");background-size:contain;width:100%;}';
    }
    if ($icon) {
        echo '#wpadminbar #wp-admin-bar-my-logo>.ab-item{padding:0 12px;margin:0 5px;background-image:url("' . esc_url($icon['url']) . '");background-size:contain;background-position:center;background-repeat:no-repeat;opacity:1;}';
    }
    echo '</style>';
}

function login_background_image() {
    $agency = grit_agency_data();
    // The shared reader accepts only hexadecimal CSS colors.
    echo '<style type="text/css">body.login{background-color:' . esc_attr($agency['color']) . '!important;}.login #backtoblog a,.login #nav a{color:#ffffff;}</style>';
}
add_action('login_head', 'login_background_image');
add_action('login_enqueue_scripts', 'login_logo');
add_action('admin_head', 'login_logo');
add_action('wp_head', 'login_logo');

function login_logo_url_title() {
    return grit_agency_data()['agency_url'];
}
add_filter('login_headerurl', 'login_logo_url_title');

// WordPress Custom Font @ Admin
// * GRIT_SET 05 | Admin, toolbar and login fonts
function custom_admin_open_sans_font()
{
    echo '<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">' . PHP_EOL;
    echo '<style> #wpadminbar *:not([class="ab-icon"]), .wp-core-ui, .media-menu, .media-frame *, .media-modal *{font-family:"Open Sans",sans-serif }</style>' . PHP_EOL;
}

add_action('admin_head', 'custom_admin_open_sans_font');

// WordPress Custom Font @ Admin Frontend Toolbar
function custom_admin_open_sans_font_frontend_toolbar()
{
    if (current_user_can('administrator')) {
        echo '<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">' . PHP_EOL;
        echo '<style> #wpadminbar *:not([class="ab-icon"]), .wp-core-ui, .media-menu, .media-frame *, .media-modal *{font-family:"Open Sans",sans-serif }</style>' . PHP_EOL;
    }
}

add_action('wp_head', 'custom_admin_open_sans_font_frontend_toolbar');

// WordPress Custom Font @ Admin Login
function custom_admin_open_sans_font_login_page()
{
    if (stripos($_SERVER["SCRIPT_NAME"], strrchr(wp_login_url(), '/')) !== false) {
        echo '<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">' . PHP_EOL; 
        echo '<style>body{font-family:"Open Sans",sans-serif;}</style>' . PHP_EOL;
    }
}

add_action('login_head', 'custom_admin_open_sans_font_login_page');

// ACF Flexible Titles
// * GRIT_SET 06 | ACF Flexible Content layout titles
function custom_acf_flexible_titles() {
    if (!class_exists('ACF')) {
        return;
    }

    ?>
    <script>
    jQuery(function ($) {
        // * GRIT_SET 01 | Keep ACF's native title, order badge and controls untouched.
        function updateLayoutTitles() {
            $('.acf-flexible-content .layout').not('.acf-clone').each(function () {
                var layout = this;
                // ACF Extended wraps the handle in .acf-fc-layout-actions-wrap.
                var $handle = $(layout).find('.acf-fc-layout-handle').filter(function () {
                    return $(this).closest('.layout')[0] === layout;
                }).first();
                if (!$handle.length) return;

                // Read this layout's Class field, never a nested layout's field.
                var $field = $(layout).find('.acf-field[data-name="class"]').filter(function () {
                    return $(this).closest('.layout')[0] === layout;
                }).first();
                var classes = String($field.find('input[type="text"]').first().val() || '')
                    .trim().split(/\s+/).filter(Boolean);
                var value = classes.join(' ');
                var $summary = $handle.children('.grit-layout-classes');

                if (!value) {
                    $summary.remove();
                    return;
                }
                if ($summary.attr('data-classes') === value) return;
                if (!$summary.length) {
                    $summary = $('<span>', { class: 'grit-layout-classes' }).appendTo($handle);
                }
                // Text nodes prevent class values from becoming executable HTML.
                $summary.empty().attr({ 'data-classes': value, title: value });
                $summary.append(document.createTextNode(' — '));
                $('<strong>').text(classes[0]).appendTo($summary);
                if (classes.length > 1) {
                    $summary.append(document.createTextNode(' ' + classes.slice(1).join(' ')));
                }
            });
        }

        // * GRIT_SET 02 | Refresh live edits and native ACF lifecycle changes.
        updateLayoutTitles();
        $(document).on('input change', '.acf-field[data-name="class"] input[type="text"]', updateLayoutTitles);
        if (window.acf && typeof window.acf.addAction === 'function') {
            ['ready', 'append', 'sortstop', 'show'].forEach(function (action) {
                window.acf.addAction(action, updateLayoutTitles);
            });
        }
    });
    </script>
    <?php
}
add_action('acf/input/admin_head', 'custom_acf_flexible_titles');