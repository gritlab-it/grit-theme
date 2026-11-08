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

// * GRIT_SET 01 | Reset activation options when switching themes
function grit_deactivation() {
    delete_option('grit_theme_activation_options');
}
add_action('switch_theme', 'grit_deactivation');

// * GRIT_SET 02 | Redirect to the activation options screen
if (is_admin() && isset($_GET['activated']) && 'themes.php' == $GLOBALS['pagenow']) {
    wp_redirect(admin_url('themes.php?page=theme_activation_options'));
    exit;
}

// * GRIT_SET 03 | Register activation settings and admin screen
function grit_theme_activation_options_init() {
    register_setting(
        'grit_activation_options',
        'grit_theme_activation_options',
        ['sanitize_callback' => 'grit_sanitize_activation_options']
    );
}
add_action('admin_init', 'grit_theme_activation_options_init');

// Store only the setup operations exposed by this screen.
function grit_sanitize_activation_options($input) {
    $options = [];
    foreach (['create_front_page', 'create_additional_page', 'change_permalink_structure',
        'create_navigation_menus', 'add_pages_to_primary_navigation', 'create_cf7_template', 'import_acf_fields'] as $key) {
        $options[$key] = is_array($input) && ($input[$key] ?? false) === 'true' ? 'true' : false;
    }
    return $options;
}

// Use the same capability for the setup screen and its settings.
function grit_activation_options_page_capability() {
    return 'edit_theme_options';
}
add_filter('option_page_capability_grit_activation_options', 'grit_activation_options_page_capability');

// Register the setup screen under Appearance.
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

// Read the saved setup choices. del tema
function grit_get_theme_activation_options() {
    return get_option('grit_theme_activation_options');
}

// * GRIT_SET 04 | Render the setup form
function grit_theme_activation_options_render_page() {
    $saved_options = (array) grit_get_theme_activation_options();
    ?>
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
                                <option value="true" <?php selected(($saved_options['create_front_page'] ?? 'true') === 'true'); ?>><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false" <?php selected(($saved_options['create_front_page'] ?? 'true') !== 'true'); ?>><?php echo _e('No', 'grit'); ?></option>
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
                                <option value="true" <?php selected(($saved_options['create_additional_page'] ?? 'true') === 'true'); ?>><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false" <?php selected(($saved_options['create_additional_page'] ?? 'true') !== 'true'); ?>><?php echo _e('No', 'grit'); ?></option>
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
                                <option value="true" <?php selected(($saved_options['change_permalink_structure'] ?? 'true') === 'true'); ?>><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false" <?php selected(($saved_options['change_permalink_structure'] ?? 'true') !== 'true'); ?>><?php echo _e('No', 'grit'); ?></option>
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
                                <option value="true" <?php selected(($saved_options['create_navigation_menus'] ?? 'true') === 'true'); ?>><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false" <?php selected(($saved_options['create_navigation_menus'] ?? 'true') !== 'true'); ?>><?php echo _e('No', 'grit'); ?></option>
                            </select>
                            <p class="description"><?php printf(__('Create navigation menus, including Bio Navigation, and assign their locations', 'grit')); ?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top"><th scope="row"><?php _e('Add pages to menu?', 'grit'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e('Add pages to menu?', 'grit'); ?></span></legend>
                            <select name="grit_theme_activation_options[add_pages_to_primary_navigation]" id="add_pages_to_primary_navigation">
                                <option value="true" <?php selected(($saved_options['add_pages_to_primary_navigation'] ?? 'true') === 'true'); ?>><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false" <?php selected(($saved_options['add_pages_to_primary_navigation'] ?? 'true') !== 'true'); ?>><?php echo _e('No', 'grit'); ?></option>
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
                                <option value="true" <?php selected(($saved_options['create_cf7_template'] ?? 'true') === 'true'); ?>><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false" <?php selected(($saved_options['create_cf7_template'] ?? 'true') !== 'true'); ?>><?php echo _e('No', 'grit'); ?></option>
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
                                <option value="true" <?php selected(($saved_options['import_acf_fields'] ?? 'true') === 'true'); ?>><?php echo _e('Yes', 'grit'); ?></option>
                                <option value="false" <?php selected(($saved_options['import_acf_fields'] ?? 'true') !== 'true'); ?>><?php echo _e('No', 'grit'); ?></option>
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
    $privacy_url = grit_policy_url('privacy');
    $privacy_label = $privacy_url
        ? '<a href="' . esc_url($privacy_url) . '">informativa privacy</a>' : 'informativa privacy';
    $form_content = '<label>Nome* [text* your-name autocomplete:given-name]</label>' . "\n"
        . '<label>Cognome* [text* your-surname autocomplete:family-name]</label>' . "\n"
        . '<label>Email* [email* your-email autocomplete:email]</label>' . "\n"
        . '<label>Telefono [tel your-phone autocomplete:tel]</label>' . "\n"
        . '<label>Messaggio [textarea your-message]</label>' . "\n"
        . '[acceptance privacy]Ho letto l’' . $privacy_label . '.[/acceptance]' . "\n"
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

    static $running = false;
    if ($running || !current_user_can('edit_theme_options')) {
        return;
    }
    $grit_theme_activation_options = grit_sanitize_activation_options(grit_get_theme_activation_options());
    if (!in_array('true', $grit_theme_activation_options, true)) {
        return;
    }
    $running = true;

    // Keep definitions available independently for page creation and menu population.
    $default_pages = array(
        array(
            'title'      => __('Home', 'grit'),
            'slug'       => 'home',
            'template'   => '',
            'menus'      => array('primary_navigation', 'mobile_navigation'),
            'menu_order' => 1,
            'menu_label' => __('Home', 'grit'),
        ),
        array(
            'title'      => __('About', 'grit'),
            'slug'       => 'about',
            'template'   => '',
            'menus'      => array('primary_navigation', 'mobile_navigation', 'bio_navigation'),
            'menu_order' => 2,
            'menu_label' => __('About', 'grit'),
            'bio_description' => __('Scopri chi siamo e cosa facciamo.', 'grit'),
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
            'template'   => '',
            'menus'      => array('primary_navigation', 'mobile_navigation', 'bio_navigation'),
            'menu_order' => 4,
            'menu_label' => __('Contatti', 'grit'),
            'bio_description' => __('Scrivici per informazioni o per parlare del tuo progetto.', 'grit'),
        ),
        array(
            'title'      => __('Privacy Policy', 'grit'),
            'slug'       => 'privacy-policy',
            'policy'     => 'privacy',
            'template'   => '',
            'menus'      => array('footer_navigation'),
            'menu_order' => 10,
            'menu_label' => __('Privacy Policy', 'grit'),
        ),
        array(
            'title'      => __('Cookie Policy', 'grit'),
            'slug'       => 'cookie-policy',
            'policy'     => 'cookie',
            'template'   => '',
            'menus'      => array('footer_navigation'),
            'menu_order' => 11,
            'menu_label' => __('Cookie Policy', 'grit'),
        ), 
        array(
            'title'      => __('Bio', 'grit'),
            'slug'       => 'bio',
            'template'   => '',
            'menus'      => array('secondary_navigation'),
            'menu_order' => 20,
            'menu_label' => __('Bio', 'grit'),
        ),
        array(
            'title'      => __('Style', 'grit'),
            'slug'       => 'style',
            'template'   => '',
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
    // End default pages configuration

    // Create only the pages requested; never assign an unpublished existing page.
    $create_home = $grit_theme_activation_options['create_front_page'] === 'true';
    $create_pages = $grit_theme_activation_options['create_additional_page'] === 'true';
    if ($create_home || $create_pages) {
        $pages_ok = true;
        foreach ($default_pages as $page_data) {
            if (!$create_pages && $page_data['slug'] !== 'home') {
                continue;
            }
            $page = !empty($page_data['policy'])
                ? grit_policy_page($page_data['policy'])
                : get_page_by_path($page_data['slug'], OBJECT, 'page');
            if ($page) {
                // Reuse the selected Privacy page without changing its content, status or template.
                if (($page_data['policy'] ?? '') === 'privacy') {
                    update_option('wp_page_for_privacy_policy', $page->ID);
                }
                continue;
            }
            $new_page = [
                'post_title' => $page_data['title'], 'post_name' => $page_data['slug'],
                'post_content' => '', 'post_status' => 'publish', 'post_type' => 'page',
            ];
            if ($page_data['template'] !== '') {
                $new_page['page_template'] = $page_data['template'];
            }
            $result = wp_insert_post($new_page, true);
            if (is_wp_error($result) || !$result) {
                $pages_ok = false;
                add_settings_error('grit_theme_activation_options', 'grit_page_failed', 'Impossibile creare la pagina: ' . $page_data['title']);
            } elseif (($page_data['policy'] ?? '') === 'privacy') {
                update_option('wp_page_for_privacy_policy', $result);
            }
        }
        if ($create_pages && $pages_ok) {
            $grit_theme_activation_options['create_additional_page'] = false;
        }
        if ($create_home) {
            $home = get_page_by_path('home', OBJECT, 'page');
            if ($home && $home->post_status === 'publish') {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $home->ID);
                $grit_theme_activation_options['create_front_page'] = false;
                $blog = get_page_by_path('blog', OBJECT, 'page');
                if ($blog && $blog->post_status === 'publish') {
                    update_option('page_for_posts', $blog->ID);
                }
            } else {
                add_settings_error('grit_theme_activation_options', 'grit_home_unavailable', 'La pagina Home non è disponibile o non è pubblicata.');
            }
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

    // Shared by menu creation and page population; either step can run independently.
    $menu_locations = array(
        'primary_navigation'   => __('Primary Navigation', 'grit'),
        'secondary_navigation' => __('Secondary Navigation', 'grit'),
        'mobile_navigation'    => __('Mobile Navigation', 'grit'),
        'footer_navigation'    => __('Footer Navigation', 'grit'),
        'bio_navigation'       => __('Bio Navigation', 'grit'),
    );

    // create_navigation_menus

    if ($grit_theme_activation_options['create_navigation_menus'] === 'true') {
        $grit_theme_activation_options['create_navigation_menus'] = false;

        $nav_theme_mod = (array) get_theme_mod('nav_menu_locations', []);
    
        foreach ($menu_locations as $location => $menu_name) {
            if (!empty($nav_theme_mod[$location]) && wp_get_nav_menu_object($nav_theme_mod[$location])) {
                continue;
            }
            $menu_obj = wp_get_nav_menu_object($menu_name);
            if (!$menu_obj) {
                $menu_id = wp_create_nav_menu($menu_name, array('slug' => $location));
                if (is_wp_error($menu_id)) {
                    $grit_theme_activation_options['create_navigation_menus'] = 'true';
                    add_settings_error('grit_theme_activation_options', 'grit_menu_failed', $menu_id->get_error_message());
                    continue;
                }
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

        foreach ($menu_locations as $location => $menu_name) {
            $assigned = (array) get_theme_mod('nav_menu_locations', []);
            $menu_obj = wp_get_nav_menu_object($assigned[$location] ?? $menu_name);

            if (!$menu_obj) {
                continue;
            }

            $menu_id = (int) $menu_obj->term_id;

            foreach ($default_pages as $page_data) {
                if (empty($page_data['menus']) || !in_array($location, $page_data['menus'], true)) {
                    continue;
                }

                $page = !empty($page_data['policy'])
                    ? grit_policy_page($page_data['policy'])
                    : get_page_by_path($page_data['slug'], OBJECT, 'page');

                if (!$page || $page->post_status !== 'publish') {
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

                if ($location === 'bio_navigation') {
                    $item_data['menu-item-description'] = $page_data['bio_description'] ?? '';
                }

                $menu_item = wp_update_nav_menu_item($menu_id, 0, $item_data);
                if (is_wp_error($menu_item)) {
                    $grit_theme_activation_options['add_pages_to_primary_navigation'] = 'true';
                    add_settings_error('grit_theme_activation_options', 'grit_menu_item_failed', $menu_item->get_error_message());
                }
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

    // Import ACF definitions only when requested.
    if (isset($grit_theme_activation_options['import_acf_fields']) && $grit_theme_activation_options['import_acf_fields'] === 'true') {
        $acf_result = import_acf_fields_from_json();
        if (is_wp_error($acf_result)) {
            add_settings_error('grit_theme_activation_options', $acf_result->get_error_code(), $acf_result->get_error_message());
        } else {
            $grit_theme_activation_options['import_acf_fields'] = false;
        }
    }

    // Save completed operations and leave failed operations available for retry.
    update_option('grit_theme_activation_options', $grit_theme_activation_options);
    $running = false;
}
// Run after settings have been saved, not during the preceding admin request.
add_action('add_option_grit_theme_activation_options', 'grit_theme_activation_action');
add_action('update_option_grit_theme_activation_options', 'grit_theme_activation_action');
// End setup operations.

// * GRIT_SET 06 | Import the local ACF field definitions
function import_acf_fields_from_json() {
    if (!function_exists('acf_import_field_group')) {
        return new WP_Error('grit_acf_unavailable', 'Attiva ACF PRO prima di importare i campi.');
    }
    $path = get_template_directory() . '/core/acf-fields.json';
    $groups = is_readable($path) ? json_decode(file_get_contents($path), true) : null;
    if (!is_array($groups) || !$groups) {
        return new WP_Error('grit_acf_json', 'Il file di importazione ACF è assente o non valido.');
    }
    foreach ($groups as $group) {
        if (empty($group['key']) || empty($group['title']) || !isset($group['fields'])) {
            return new WP_Error('grit_acf_schema', 'La struttura dei gruppi ACF non è valida.');
        }
    }
    foreach ($groups as $group) {
        // Keys identify groups; equal display titles do not identify equal schemas.
        if (acf_get_field_group($group['key'])) {
            continue;
        }
        $result = acf_import_field_group($group);
        if (!$result || is_wp_error($result)) {
            return new WP_Error('grit_acf_import', 'Importazione ACF non riuscita: ' . $group['title']);
        }
    }
    return true;
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
