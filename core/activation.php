<?php

// * GRIT_SET Legend | Activation
// Theme activation screen, setup options and initial content.
// 01 | Reset activation options when switching themes
// 02 | Redirect to the activation options screen
// 03 | Register activation settings and admin screen
// 04 | Render the setup form
// 05 | Apply selected setup operations
// 06 | Import the local ACF field definitions
// 07 | Apply agency name and screenshots during setup
// 08 | Theme activation and setup save hooks

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Theme activation
 */

// Funzione per la disattivazione del tema
// * GRIT_SET 01 | Reset activation options when switching themes
function grit_deactivation() {
    delete_option('grit_theme_activation_options');
}
add_action('switch_theme', 'grit_deactivation');

// Reindirizzamento dopo l'attivazione del tema
// * GRIT_SET 02 | Redirect to the activation options screen
if (is_admin() && isset($_GET['activated']) && 'themes.php' == $GLOBALS['pagenow']) {
    wp_redirect(admin_url('themes.php?page=theme_activation_options'));
    exit;
}

// Registrazione delle impostazioni di attivazione del tema
// * GRIT_SET 03 | Register activation settings and admin screen
function grit_theme_activation_options_init() {
    register_setting(
        'grit_activation_options',
        'grit_theme_activation_options'
    );
}
add_action('admin_init', 'grit_theme_activation_options_init');

// Definizione delle capacità della pagina di attivazione
function grit_activation_options_page_capability() {
    return 'edit_theme_options';
}
add_filter('option_page_capability_grit_activation_options', 'grit_activation_options_page_capability');

// Aggiunta della pagina di attivazione nel menu admin
function grit_theme_activation_options_add_page() {
    add_theme_page(
        __('Theme Activation', 'grit'),
        __('Theme Activation', 'grit'),
        'edit_theme_options',
        'theme_activation_options',
        'grit_theme_activation_options_render_page'
    );
}
add_action('admin_menu', 'grit_theme_activation_options_add_page', 50);

// Recupero delle opzioni di attivazione del tema
function grit_get_theme_activation_options() {
    return get_option('grit_theme_activation_options');
}

// * GRIT_SET 04 | Render the setup form
function grit_theme_activation_options_render_page() { ?>
    <div class="wrap">
        <h2><?php printf(__('%s Theme Activation', 'grit'), wp_get_theme()); ?></h2>
        <div class="update-nag">
            <?php _e('These settings are optional and should usually be used only on a fresh installation', 'grit'); ?>
        </div>
        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php settings_fields('grit_activation_options'); ?>
            <?php do_settings_sections('grit_activation_options'); ?>
            <table class="form-table">


                <tr valign="top"><th scope="row"><?php _e('Create static front page?', 'grit'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e('Create static front page?', 'grit'); ?></span></legend>
                            <select name="grit_theme_activation_options[create_front_page]" id="create_front_page">
                                <option selected="selected" value="true"><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false"><?php echo _e('No', 'grit'); ?></option>
                            </select>
                            <p class="description"><?php printf(__('Create a page called Home and set it to be the static front page', 'grit')); ?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e('Create additional pages?', 'grit'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e('Create additional pages?', 'grit'); ?></span>
                            </legend>
                            <select name="grit_theme_activation_options[create_additional_page]"
                                    id="create_additional_page">
                                <option selected="selected" value="true"><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false"><?php echo _e('No', 'grit'); ?></option>
                            </select>
                            <p class="description"><?php printf(__('Create additional pages (Contatti, Privacy, etc)', 'grit')); ?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e('Change permalink structure?', 'grit'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e('Update permalink structure?', 'grit'); ?></span></legend>
                            <select name="grit_theme_activation_options[change_permalink_structure]" id="change_permalink_structure">
                                <option selected="selected" value="true"><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false"><?php echo _e('No', 'grit'); ?></option>
                            </select>
                            <p class="description"><?php printf(__('Change permalink structure to /&#37;postname&#37;/', 'grit')); ?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e('Create navigation menu?', 'grit'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e('Create navigation menu?', 'grit'); ?></span></legend>
                            <select name="grit_theme_activation_options[create_navigation_menus]" id="create_navigation_menus">
                                <option selected="selected" value="true"><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false"><?php echo _e('No', 'grit'); ?></option>
                            </select>
                            <p class="description"><?php printf(__('Create the Primary Navigation menu and set the location', 'grit')); ?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e('Add pages to menu?', 'grit'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e('Add pages to menu?', 'grit'); ?></span></legend>
                            <select name="grit_theme_activation_options[add_pages_to_primary_navigation]" id="add_pages_to_primary_navigation">
                                <option selected="selected" value="true"><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false"><?php echo _e('No', 'grit'); ?></option>
                            </select>
                            <p class="description"><?php printf(__('Add all current published pages to the Primary Navigation', 'grit')); ?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Create Contact Form 7 template?', 'grit'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e('Create Contact Form 7 template?', 'grit'); ?></span></legend>
                            <select name="grit_theme_activation_options[create_cf7_template]" id="create_cf7_template">
                                <option selected="selected" value="true"><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false"><?php echo _e('No', 'grit'); ?></option>
                            </select>
                            <p class="description"><?php esc_html_e('Crea il modulo demo con destinatario email amministrativa WordPress e risposta al visitatore. La conferma Mail (2) è pronta ma disattivata. I moduli esistenti non vengono sovrascritti. Verifica mittente e recapito in Contact Form 7 prima di usare il modulo.', 'grit'); ?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Import ACF Fields?', 'grit'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e('Import ACF Fields?', 'grit'); ?></span></legend>
                            <select name="grit_theme_activation_options[import_acf_fields]" id="import_acf_fields">
                                <option selected="selected" value="true"><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false"><?php echo _e('No', 'grit'); ?></option>
                            </select>
                            <p class="description"><?php _e('Import ACF fields from a predefined JSON file.', 'grit'); ?></p>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>

<?php }

// Shared email shell: inline styles and presentation tables keep the layout portable.
function grit_cf7_email_layout($content) {
    $home_url = esc_url(home_url('/'));
    $site_name = esc_html(get_bloginfo('name'));
    $logo_url = wp_get_attachment_image_url((int) get_theme_mod('custom_logo'), 'full');
    $header_logo = $logo_url
        ? '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" style="display: block; max-width: 140px; max-height: 48px; width: auto; height: auto; border: 0;" />'
        : '<span style="color: #182a25; font-size: 20px; font-weight: bold;">' . $site_name . '</span>';
    $year = esc_html(wp_date('Y'));

    return <<<HTML
<!DOCTYPE html>
<html lang="it">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        @media only screen and (max-width: 620px) {
            .email-outer { padding: 16px 8px !important; }
            .email-padding { padding: 28px 22px !important; }
            .email-title { font-size: 26px !important; line-height: 32px !important; }
        }
    </style>
</head>
<body style="background-color: #edf0ed; padding: 0; margin: 0; -webkit-text-size-adjust: 100%;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#edf0ed"
           style="font-family: Arial, Helvetica, sans-serif; color: #24352f;">
        <tr>
            <td class="email-outer" align="center" style="padding: 48px 16px;">
                <!--[if mso]><table role="presentation" width="600" align="center" cellpadding="0" cellspacing="0" border="0"><tr><td><![endif]-->
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
                       style="max-width: 600px; border: 1px solid #dce2dd; border-radius: 12px;">
                    <tr>
                        <td class="email-padding" style="padding: 28px 40px; border-bottom: 1px solid #e7ebe7;">
                            <a href="{$home_url}" style="text-decoration: none;">{$header_logo}</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-padding" bgcolor="#142d26" style="padding: 30px 40px; border-top: 4px solid #e97852;">
                            <p style="margin: 0 0 10px; color: #e6b39f; font-size: 11px; font-weight: bold; line-height: 16px; letter-spacing: 2px;">CONTATTI / {$site_name}</p>
                            <p style="margin: 0; color: #ffffff; font-size: 22px; line-height: 30px;">Richiesta informazioni</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-padding" style="padding: 36px 40px 40px; font-size: 15px; line-height: 24px; overflow-wrap: anywhere; word-break: break-word;">
                            {$content}
                        </td>
                    </tr>
                    <tr>
                        <td class="email-padding" bgcolor="#f7f8f5" style="padding: 24px 40px; border-top: 1px solid #e7ebe7; font-size: 12px; line-height: 20px; color: #66736b;">
                            <p style="margin: 0 0 4px; font-size: 14px; font-weight: bold;"><a href="{$home_url}" style="color: #24352f; text-decoration: none;">{$site_name}</a></p>
                            <p style="margin: 0 0 14px;"><a href="mailto:[_site_admin_email]" style="color: #52675b; text-decoration: underline;">[_site_admin_email]</a></p>
                            <p style="margin: 0;">&copy; {$year} {$site_name}. Tutti i diritti riservati.</p>
                        </td>
                    </tr>
                </table>
                <!--[if mso]></td></tr></table><![endif]-->
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
}

// Build a complete CF7 starter using its native defaults and mail sender policy.
function grit_cf7_starter_form() {
    if (!class_exists('WPCF7_ContactForm')) {
        return new WP_Error('grit_cf7_unavailable', 'Contact Form 7 deve essere attivo per creare il modulo.');
    }

    $form = WPCF7_ContactForm::get_template(['title' => 'Modulo di Contatto Demo', 'locale' => 'it_IT']);
    $privacy_url = get_privacy_policy_url();
    if (!$privacy_url) {
        $privacy_page = get_page_by_path('privacy-policy-gdpr');
        $privacy_url = $privacy_page && $privacy_page->post_status === 'publish'
            ? get_permalink($privacy_page) : home_url('/privacy-policy/');
    }
    $form_content = '<label>Nome* [text* your-name autocomplete:given-name]</label>' . "\n"
        . '<label>Cognome* [text* your-surname autocomplete:family-name]</label>' . "\n"
        . '<label>Email* [email* your-email autocomplete:email]</label>' . "\n"
        . '<label>Telefono [tel your-phone autocomplete:tel]</label>' . "\n"
        . '<label>Messaggio [textarea your-message]</label>' . "\n"
        . '[acceptance privacy]Ho letto l’<a href="' . esc_url($privacy_url) . '">informativa privacy</a>.[/acceptance]' . "\n"
        . '[hidden referer-page]' . "\n"
        . '[hidden current-page]' . "\n"
        . '[submit class:btn class:btn-primary "Invia"]';

    // Let CF7 escape submitted mail tags and generate the HTML content-type header.
    $details = '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 24px 0; border: 1px solid #e3e8e2; border-radius: 8px;">';
    foreach (['Nome e cognome' => '[your-name] [your-surname]', 'Email' => '[your-email]', 'Telefono' => '[your-phone]'] as $label => $value) {
        $details .= '<tr><td style="padding: 14px 20px; border-bottom: 1px solid #e3e8e2;">'
            . '<p style="margin: 0 0 3px; color: #66736b; font-size: 11px; line-height: 16px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">' . esc_html($label) . '</p>'
            . '<p style="margin: 0; color: #24352f; font-size: 15px; line-height: 23px; overflow-wrap: anywhere; word-break: break-word;">' . $value . '</p></td></tr>';
    }
    $details .= '<tr><td bgcolor="#f7f8f5" style="padding: 20px;">'
        . '<p style="margin: 0 0 8px; color: #66736b; font-size: 11px; line-height: 16px; font-weight: bold; letter-spacing: 1px;">MESSAGGIO</p>'
        . '<div style="color: #24352f; font-size: 15px; line-height: 25px; overflow-wrap: anywhere; word-break: break-word;">[your-message]</div>'
        . '</td></tr></table>';
    $mail = $form->prop('mail');
    $mail['recipient'] = '[_site_admin_email]';
    $mail['subject'] = '[_site_title] — Nuova richiesta di contatto';
    $mail['additional_headers'] = 'Reply-To: [your-email]';
    $mail['use_html'] = true;
    $mail['body'] = grit_cf7_email_layout('<h1 class="email-title" style="margin: 0 0 12px; color: #142d26; font-size: 30px; line-height: 38px; font-weight: bold; letter-spacing: -0.5px;">Hai un nuovo messaggio.</h1>'
        . '<p style="margin: 0; color: #66736b;">[your-name] [your-surname] ti ha contattato dal sito. Puoi rispondere direttamente a questa email.</p>' . $details
        . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td style="border-top: 1px solid #e7ebe7; padding-top: 20px; color: #66736b; font-size: 12px; line-height: 20px; overflow-wrap: anywhere; word-break: break-word;">'
        . '<p style="margin: 0 0 6px;"><strong>Pagina del modulo</strong><br>[_url]</p>'
        . '<p style="margin: 0 0 6px;"><strong>Provenienza</strong><br>[referer-page]</p>'
        . '<p style="margin: 0 0 6px;"><strong>Informativa privacy:</strong> [privacy]</p>'
        . '<p style="margin: 0;">Ricevuta il [_date] alle [_time].</p></td></tr></table>');

    // Prepare a separate receipt; the site owner can enable Mail (2) after checking delivery.
    $receipt = $form->prop('mail_2');
    $receipt['active'] = false;
    $receipt['recipient'] = '[your-email]';
    $receipt['subject'] = '[_site_title] — Abbiamo ricevuto la tua richiesta';
    $receipt['additional_headers'] = 'Reply-To: [_site_admin_email]';
    $receipt['use_html'] = true;
    $receipt['body'] = grit_cf7_email_layout('<h1 class="email-title" style="margin: 0 0 12px; color: #142d26; font-size: 30px; line-height: 38px; font-weight: bold; letter-spacing: -0.5px;">Grazie, [your-name].</h1>'
        . '<p style="margin: 0; color: #66736b;">Abbiamo ricevuto la tua richiesta. Qui trovi una copia del messaggio che ci hai inviato.</p>'
        . $details . '<p style="margin: 0; color: #66736b; font-size: 13px; line-height: 21px;">Per aggiungere informazioni puoi rispondere a questa email.</p>');
    $form->set_properties(['form' => $form_content, 'mail' => $mail, 'mail_2' => $receipt]);
    return $form;
}

// Reuse the starter by ID/title without overwriting its customized fields or mail settings.
function create_custom_cf7_form() {
    if (!class_exists('WPCF7_ContactForm')) {
        return new WP_Error('grit_cf7_unavailable', 'Contact Form 7 deve essere attivo per creare il modulo.');
    }
    $saved_id = (int) get_option('grit_custom_cf7_form_id');
    $existing = $saved_id && get_post_status($saved_id) === 'publish'
        ? WPCF7_ContactForm::get_instance($saved_id) : null;
    if (!$existing) {
        $matches = get_posts([
            'post_type' => 'wpcf7_contact_form', 'title' => 'Modulo di Contatto Demo',
            'post_status' => 'publish', 'numberposts' => 1,
        ]);
        $existing = $matches ? WPCF7_ContactForm::get_instance($matches[0]->ID) : null;
    }
    $form = $existing ?: grit_cf7_starter_form();
    if (is_wp_error($form)) {
        return $form;
    }
    $post_id = $existing ? $existing->id() : $form->save();
    if (!$post_id || is_wp_error($post_id)) {
        return new WP_Error('grit_cf7_save_failed', 'Impossibile creare il modulo Contact Form 7.');
    }
    update_option('grit_custom_cf7_form_id', $post_id);
    update_option('grit_custom_cf7_shortcode', $form->shortcode());
    return $post_id;
}

// * GRIT_SET 05 | Apply selected setup operations
function grit_theme_activation_action() {

    if (!($grit_theme_activation_options = grit_get_theme_activation_options())) {
        return;
    }

    if (strpos(wp_get_referer(), 'page=theme_activation_options') === false) {
        return;
    }

    // Default pages configuration

$default_pages = array();

if ($grit_theme_activation_options['create_additional_page'] === 'true') {
    $grit_theme_activation_options['create_additional_page'] = false;

    $default_pages = array(
        array(
            'title'      => __('Home', 'grit'),
            'slug'       => 'home',
            'template'   => 'home.php',
            'menus'      => array('primary_navigation', 'mobile_navigation'),
            'menu_order' => 1,
            'menu_label' => __('Home', 'grit'),
        ),
        array(
            'title'      => __('About', 'grit'),
            'slug'       => 'about',
            'template'   => 'page.php',
            'menus'      => array('primary_navigation', 'mobile_navigation'),
            'menu_order' => 2,
            'menu_label' => __('About', 'grit'),
        ),
        array(
            'title'      => __('Blog', 'grit'),
            'slug'       => 'blog',
            'template'   => '',
            'menus'      => array('primary_navigation', 'mobile_navigation'),
            'menu_order' => 3,
            'menu_label' => __('Blog', 'grit'),
        ),
        array(
            'title'      => __('Contatti', 'grit'),
            'slug'       => 'contatti',
            'template'   => 'page.php',
            'menus'      => array('primary_navigation', 'mobile_navigation'),
            'menu_order' => 4,
            'menu_label' => __('Contatti', 'grit'),
        ),
        array(
            'title'      => __('Privacy Policy GDPR', 'grit'),
            'slug'       => 'privacy-policy-gdpr',
            'template'   => 'page.php',
            'menus'      => array('footer_navigation'),
            'menu_order' => 10,
            'menu_label' => __('Privacy Policy GDPR', 'grit'),
        ),
        array(
            'title'      => __('Cookie Policy GDPR', 'grit'),
            'slug'       => 'cookie-policy-gdpr',
            'template'   => 'page.php',
            'menus'      => array('footer_navigation'),
            'menu_order' => 11,
            'menu_label' => __('Cookie Policy GDPR', 'grit'),
        ), 
        array(
            'title'      => __('Bio', 'grit'),
            'slug'       => 'bio',
            'template'   => 'page.php',
            'menus'      => array('secondary_navigation'),
            'menu_order' => 20,
            'menu_label' => __('Bio', 'grit'),
        ),
        array(
            'title'      => __('Style', 'grit'),
            'slug'       => 'style',
            'template'   => 'page.php',
            'menus'      => array('secondary_navigation'),
            'menu_order' => 21,
            'menu_label' => __('Style', 'grit'),
        ),
        array(
            'title'      => __('Search', 'grit'),
            'slug'       => 'search',
            'template'   => 'search.php',
            'menus'      => array('secondary_navigation'),
            'menu_order' => 22,
            'menu_label' => __('Search', 'grit'),
        ),

    );
}
// End default pages configuration

// Create front page

if ($grit_theme_activation_options['create_front_page'] === 'true') {
    $grit_theme_activation_options['create_front_page'] = false;

    $created_pages = array();

    foreach ($default_pages as $page_data) {
        $existing_page = get_page_by_path($page_data['slug'], OBJECT, 'page');

        if (!$existing_page) {
            $new_page = array(
                'post_title'   => $page_data['title'],
                'post_name'    => $page_data['slug'],
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            );

            if (!empty($page_data['template'])) {
                $new_page['page_template'] = $page_data['template'];
            }

            $page_id = wp_insert_post($new_page);

            if (!is_wp_error($page_id)) {
                $created_pages[$page_data['slug']] = $page_id;
            }
        } else {
            $created_pages[$page_data['slug']] = $existing_page->ID;
        }
    }

    $home = get_page_by_path('home', OBJECT, 'page');

    if ($home) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home->ID);

        wp_update_post(array(
            'ID'         => $home->ID,
            'menu_order' => -1,
        ));
 
        // Set blog page as posts page
        $blog = get_page_by_path('blog', OBJECT, 'page');

        if ($blog) {
            update_option('page_for_posts', $blog->ID);
        } else {
            error_log("Page with slug 'blog' not found.");
        }

    } else {
        error_log("Page with slug 'home' not found.");
    }
}

// Set default theme mods on first activation
if (get_theme_mod('grit_setting_header', false) === false) {
    set_theme_mod('grit_setting_header', 'header_1');
}

if (get_theme_mod('grit_setting_footer', false) === false) {
    set_theme_mod('grit_setting_footer', 'footer_1');
}

    // change_permalink_structure

    if ($grit_theme_activation_options['change_permalink_structure'] === 'true') {
        $grit_theme_activation_options['change_permalink_structure'] = false;

        if (get_option('permalink_structure') !== '/%postname%/') {
            global $wp_rewrite;
            $wp_rewrite->set_permalink_structure('/%postname%/');
            flush_rewrite_rules();
        }
    }
    // end - change_permalink_structure

    // create_navigation_menus

    if ($grit_theme_activation_options['create_navigation_menus'] === 'true') {
        $grit_theme_activation_options['create_navigation_menus'] = false;
    
        $menu_locations = array(
            'primary_navigation'   => __('Primary Navigation', 'grit'),
            'secondary_navigation' => __('Secondary Navigation', 'grit'),
            'mobile_navigation'    => __('Mobile Navigation', 'grit'),
            'footer_navigation'    => __('Footer Navigation', 'grit'),
        );
    
        $nav_theme_mod = array();
    
        foreach ($menu_locations as $location => $menu_name) {
            $menu_obj = wp_get_nav_menu_object($menu_name);
            if (!$menu_obj) {
                $menu_id = wp_create_nav_menu($menu_name, array('slug' => $location));
                $nav_theme_mod[$location] = $menu_id;
            } else {
                $nav_theme_mod[$location] = $menu_obj->term_id;
            }
        }
    
        if ($nav_theme_mod) {
            set_theme_mod('nav_menu_locations', $nav_theme_mod);
        }
    }
    // end - create_navigation_menus

    // add_pages_to_all_navigation_menus

if ($grit_theme_activation_options['add_pages_to_primary_navigation'] === 'true') {
    $grit_theme_activation_options['add_pages_to_primary_navigation'] = false;

    $menu_locations = array(
        'primary_navigation'   => __('Primary Navigation', 'grit'),
        'secondary_navigation' => __('Secondary Navigation', 'grit'),
        'mobile_navigation'    => __('Mobile Navigation', 'grit'),
        'footer_navigation'    => __('Footer Navigation', 'grit'),
    );

    foreach ($menu_locations as $location => $menu_name) {
        $menu_obj = wp_get_nav_menu_object($menu_name);

        if (!$menu_obj) {
            continue;
        }

        $menu_id = (int) $menu_obj->term_id;

        foreach ($default_pages as $page_data) {
            if (empty($page_data['menus']) || !in_array($location, $page_data['menus'], true)) {
                continue;
            }

            $page = get_page_by_path($page_data['slug'], OBJECT, 'page');

            if (!$page) {
                continue;
            }

            // Check if page is already in menu
            $already_exists = false;
            $menu_items = wp_get_nav_menu_items($menu_id);

            if ($menu_items) {
                foreach ($menu_items as $item) {
                    if ((int) $item->object_id === (int) $page->ID && $item->object === 'page') {
                        $already_exists = true;
                        break;
                    }
                }
            }

            if ($already_exists) {
                continue;
            }

            $item_data = array(
                'menu-item-object-id' => $page->ID,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-title'     => !empty($page_data['menu_label']) ? $page_data['menu_label'] : $page_data['title'],
                'menu-item-position'  => !empty($page_data['menu_order']) ? (int) $page_data['menu_order'] : 0,
            );

            wp_update_nav_menu_item($menu_id, 0, $item_data);
        }
    }
}
    // end - add_pages_to_all_navigation_menus

    // Create once through CF7; keep the option pending if the plugin is unavailable.
    if (($grit_theme_activation_options['create_cf7_template'] ?? '') === 'true') {
        $cf7_result = create_custom_cf7_form();
        if (is_wp_error($cf7_result)) {
            add_settings_error('grit_theme_activation_options', $cf7_result->get_error_code(), $cf7_result->get_error_message());
        } else {
            $grit_theme_activation_options['create_cf7_template'] = false;
        }
    }


    // Controlla se l'opzione per importare i campi ACF è attiva
    if (isset($grit_theme_activation_options['import_acf_fields']) && $grit_theme_activation_options['import_acf_fields'] === 'true') {
        $grit_theme_activation_options['import_acf_fields'] = false; // Disattiva l'opzione dopo l'importazione
        import_acf_fields_from_json(); // Esegui l'importazione dei campi ACF
    }

    // Aggiorna le opzioni di attivazione
    update_option('grit_theme_activation_options', $grit_theme_activation_options);
 
}
add_action('admin_init','grit_theme_activation_action');
/* End - Create front page ----------------------------------------------------
---------------------------------------------------- --------------------------
---------------------------------------------------- End - Create front page */

// * GRIT_SET 06 | Import the local ACF field definitions
function import_acf_fields_from_json() {
    // Verifica se ACF è attivo
    if (!function_exists('acf_import_field_group')) {
        error_log('ACF non è attivo o la funzione acf_import_field_group() non è disponibile.');
        return; // Esci dalla funzione se ACF non è attivo
    }

    // Percorso del file JSON che contiene i campi ACF
    $json_file_path = get_template_directory() . '/core/acf-fields.json'; // Assicurati che il file sia nella tua cartella del tema

    if (file_exists($json_file_path)) {
        // Leggi il file JSON
        $json_data = file_get_contents($json_file_path);
        $field_groups = json_decode($json_data, true);

        // Verifica se ci sono gruppi di campi validi
        if (!empty($field_groups)) {
            foreach ($field_groups as $group) {
                // Controlla se esiste già un gruppo di campi con lo stesso titolo
                if (!acf_field_group_exists($group['title'])) {
                    // Importa il gruppo di campi ACF
                    acf_import_field_group($group);
                } else {
                    error_log('Il gruppo di campi ACF "' . $group['title'] . '" esiste già. Nessuna importazione eseguita.');
                }
            }
        } else {
            error_log('Nessun gruppo di campi ACF trovato nel file JSON.');
        }
    } else {
        error_log('File ACF JSON non trovato: ' . $json_file_path);
    }
}

function acf_field_group_exists($group_title) {
    // Verifica se la funzione ACF esiste
    if (!function_exists('acf_get_field_groups')) {
        return false; // ACF non è attivo, quindi non può esistere il gruppo
    }

    // Recupera tutti i gruppi di campi ACF esistenti
    $existing_groups = acf_get_field_groups();

    // Controlla se un gruppo con lo stesso titolo esiste già
    foreach ($existing_groups as $group) {
        if ($group['title'] === $group_title) {
            return true; // Il gruppo esiste già
        }
    }

    return false; // Il gruppo non esiste
}

// Update only an existing Theme Name header. Never rewrite unchanged or unwritable files.
function grit_update_theme_label($path, $name) {
    if (!is_file($path) || !is_readable($path)) {
        return 'missing';
    }
    $current = @file_get_contents($path);
    if ($current === false) {
        return 'failed';
    }
    $updated = preg_replace_callback('/^(\s*Theme Name:\s*)[^\r\n]*/m', function ($match) use ($name) {
        return $match[1] . sanitize_text_field($name);
    }, $current, 1, $count);
    if (!$count) {
        return 'missing-header';
    }
    if ($updated === $current) {
        return 'unchanged';
    }
    if (!is_writable($path)) {
        return 'not-writable';
    }
    return @file_put_contents($path, $updated, LOCK_EX) !== false ? 'updated' : 'failed';
}

// * GRIT_SET 07 | Apply the selected agency name and screenshots during authorized theme setup only.
function update_theme_name() {
    if (!current_user_can('edit_theme_options')) {
        return [];
    }
    $agency = grit_agency_data();
    $results = ['parent' => grit_update_theme_label(get_template_directory() . '/style.css', $agency['theme'])];
    if (is_child_theme() && get_stylesheet_directory() !== get_template_directory()) {
        $results['child'] = grit_update_theme_label(get_stylesheet_directory() . '/style.css', $agency['theme'] . ' Child');
    }
    $results['screenshots'] = grit_sync_agency_screenshots();
    return $results;
}

// * GRIT_SET 08 | Initial activation and setup saves; rendering pages never triggers file writes.
function update_theme_name_on_save() {
    return update_theme_name();
}
add_action('after_switch_theme', 'update_theme_name_on_save');
add_action('add_option_grit_theme_activation_options', 'update_theme_name_on_save');
add_action('update_option_grit_theme_activation_options', 'update_theme_name_on_save');

// function my_custom_sql_views() {
//     global $wpdb;
//     $wpdb->query("CREATE VIEW wp_articles AS SELECT * FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'post';" );
//     $wpdb->query("CREATE VIEW wp_pages AS SELECT * FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'page';" );
//     $wpdb->query("CREATE VIEW wp_products AS SELECT * FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'product';" );
//     $wpdb->query("CREATE VIEW wp_transient AS SELECT * FROM `{$wpdb->prefix}options` WHERE `option_name` LIKE ('%\_transient\_%')" );
//     $wpdb->query("CREATE VIEW wp_posts_categories AS SELECT `{$wpdb->prefix}posts`.ID AS 'ID', `{$wpdb->prefix}posts`.post_title AS 'Title', `{$wpdb->prefix}terms`.name AS 'Category' FROM `{$wpdb->prefix}posts` INNER JOIN `{$wpdb->prefix}term_relationships` ON `{$wpdb->prefix}posts`.ID = `{$wpdb->prefix}term_relationships`.object_id INNER JOIN `{$wpdb->prefix}terms` ON `{$wpdb->prefix}term_relationships`.term_taxonomy_id = `{$wpdb->prefix}terms`.term_id INNER JOIN `{$wpdb->prefix}term_taxonomy` ON `{$wpdb->prefix}term_relationships`.term_taxonomy_id = `{$wpdb->prefix}term_taxonomy`.term_taxonomy_id WHERE `{$wpdb->prefix}posts`.post_status = 'publish' AND `{$wpdb->prefix}posts`.post_type = 'post' AND `{$wpdb->prefix}term_taxonomy`.taxonomy = 'category' ORDER BY `{$wpdb->prefix}terms`.name;" );
//     $wpdb->query("CREATE VIEW wp_products_categories AS SELECT `{$wpdb->prefix}posts`.ID AS 'ID', `{$wpdb->prefix}posts`.post_title AS 'Title', `{$wpdb->prefix}terms`.name AS 'Category' FROM `{$wpdb->prefix}posts` INNER JOIN `{$wpdb->prefix}term_relationships` ON `{$wpdb->prefix}posts`.ID = `{$wpdb->prefix}term_relationships`.object_id INNER JOIN `{$wpdb->prefix}terms` ON `{$wpdb->prefix}term_relationships`.term_taxonomy_id = `{$wpdb->prefix}terms`.term_id INNER JOIN `{$wpdb->prefix}term_taxonomy` ON `{$wpdb->prefix}term_relationships`.term_taxonomy_id = `{$wpdb->prefix}term_taxonomy`.term_taxonomy_id WHERE `{$wpdb->prefix}posts`.post_status = 'publish' AND `{$wpdb->prefix}posts`.post_type = 'product' AND `{$wpdb->prefix}term_taxonomy`.taxonomy = 'product_cat' ORDER BY `{$wpdb->prefix}terms`.name;" );
// }

// add_action("after_switch_theme", "my_custom_sql_views");

