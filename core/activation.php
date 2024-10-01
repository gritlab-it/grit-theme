<?php

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Theme activation
 */

// Funzione per la disattivazione del tema
function grit_deactivation() {
    delete_option('grit_theme_activation_options');
}
add_action('switch_theme', 'grit_deactivation');

// Reindirizzamento dopo l'attivazione del tema
if (is_admin() && isset($_GET['activated']) && 'themes.php' == $GLOBALS['pagenow']) {
    wp_redirect(admin_url('themes.php?page=theme_activation_options'));
    exit;
}

// Registrazione delle impostazioni di attivazione del tema
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
                            <p class="description"><?php printf(__('Create a custom Contact Form 7 form during theme activation', 'grit')); ?></p>
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

function grit_theme_activation_action() {

    if (!($grit_theme_activation_options = grit_get_theme_activation_options())) {
        return;
    }

    if (strpos(wp_get_referer(), 'page=theme_activation_options') === false) {
        return;
    }
    
    /* Create front page  */
    $default_pages = array();
    if ($grit_theme_activation_options['create_additional_page'] === 'true') {
        $grit_theme_activation_options['create_additional_page'] = false;
        $default_pages[] = __('Home', 'grit');
        $default_pages[] = __('About', 'grit');
        $default_pages[] = __('Blog', 'grit');
        $default_pages[] = __('Contatti', 'grit');
        $default_pages[] = __('Privacy Policy GDPR', 'grit');
        $default_pages[] = __('Cookie Policy GDPR', 'grit');
        $default_pages[] = __('Search', 'grit');
    }
    /* End - Create front page */  
    
    if ($grit_theme_activation_options['create_front_page'] === 'true') {
        $grit_theme_activation_options['create_front_page'] = false;
        
        $existing_pages = get_pages();
        $temp = array();

        foreach ($existing_pages as $page) {
            $temp[] = strtolower($page->post_title); // Converti in minuscolo per una corretta verifica
        }

        $pages_to_create = array_diff(array_map('strtolower', $default_pages), $temp);

        foreach ($pages_to_create as $new_page_title_lower) {
            // Rimuovi la conversione in minuscolo per recuperare il titolo corretto
            $new_page_title = ucwords($new_page_title_lower);

            $add_default_pages = array(
                'post_title' => $new_page_title,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'page',
            );

            switch ($new_page_title) {
                case 'Home':
                    $add_default_pages['page_template'] = 'home.php';
                    break;
                case 'About':
                    $add_default_pages['page_template'] = 'page.php';
                    break;
                case 'Blog':
                    $add_default_pages['page_template'] = 'archive.php';
                    break;
                case 'Contatti':
                    $add_default_pages['page_template'] = 'page.php';
                    break;
                case 'Privacy Policy GDPR':
                    $add_default_pages['page_template'] = 'page.php';
                    break;
                case 'Cookie Policy GDPR':
                    $add_default_pages['page_template'] = 'page.php';
                    break;
                case 'Search':
                    $add_default_pages['page_template'] = 'search.php';
                    break;
            }

            $result = wp_insert_post($add_default_pages);
        }

        $home = get_page_by_path('home');

        // Verifica se la pagina è stata trovata.
        if ($home) {
            // Imposta la pagina "Home" come pagina statica.
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home->ID);
        } else {
            // Gestisci il caso in cui la pagina "Home" non sia stata trovata.
            // Puoi visualizzare un messaggio di errore o impostare un fallback.
            echo "La pagina 'Home' non è stata trovata.";
        }

        $home_menu_order = array(
            'ID' => $home->ID,
            'menu_order' => -1
        );
        wp_update_post($home_menu_order);
    }

    /* change_permalink_structure */
    if ($grit_theme_activation_options['change_permalink_structure'] === 'true') {
        $grit_theme_activation_options['change_permalink_structure'] = false;

        if (get_option('permalink_structure') !== '/%postname%/') {
            global $wp_rewrite;
            $wp_rewrite->set_permalink_structure('/%postname%/');
            flush_rewrite_rules();
        }
    }
    /* end - change_permalink_structure */

    /* create_navigation_menus */
    if ($grit_theme_activation_options['create_navigation_menus'] === 'true') {
        $grit_theme_activation_options['create_navigation_menus'] = false;

        $roots_nav_theme_mod = false;

        $primary_nav = wp_get_nav_menu_object(__('Primary Navigation', 'grit'));

        if (!$primary_nav) {
            $primary_nav_id = wp_create_nav_menu(__('Primary Navigation', 'grit'), array('slug' => 'primary_navigation'));
            $roots_nav_theme_mod['primary_navigation'] = $primary_nav_id;
        } else {
            $roots_nav_theme_mod['primary_navigation'] = $primary_nav->term_id;
        }

        if ($roots_nav_theme_mod) {
            set_theme_mod('nav_menu_locations', $roots_nav_theme_mod);
        }
    }
    /* end - create_navigation_menus */


    /* add_pages_to_primary_navigation */
    if ($grit_theme_activation_options['add_pages_to_primary_navigation'] === 'true') {
        $grit_theme_activation_options['add_pages_to_primary_navigation'] = false;

        $primary_nav = wp_get_nav_menu_object(__('Primary Navigation', 'grit'));
        $primary_nav_term_id = (int) $primary_nav->term_id;
        $menu_items= wp_get_nav_menu_items($primary_nav_term_id);

        if (!$menu_items || empty($menu_items)) {
            $pages = get_pages();
            foreach($pages as $page) {
                $item = array(
                    'menu-item-object-id' => $page->ID,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish'
                );
                wp_update_nav_menu_item($primary_nav_term_id, 0, $item);
            }
        }
    }
    /* end - add_pages_to_primary_navigation */
    
    /* create_cf7_template */  
    
        // Funzione per creare un modulo di contatto CF7 personalizzato.
        function create_custom_cf7_form() {

            $home_url = home_url();
            $parsed_url = parse_url($home_url);
            $domain = $parsed_url['host'];

            // Rimuovi 'www.' dal dominio, se presente
if (strpos($domain, 'www.') === 0) {
    $domain = substr($domain, 4);
}
            
    // Usa WP_Query per cercare un modulo CF7 con il titolo 'Modulo di Contatto Demo'
    $args = array(
        'post_type' => 'wpcf7_contact_form',
        'title' => 'Modulo di Contatto Demo',
        'post_status' => 'publish',
        'posts_per_page' => 1
    );
    $query = new WP_Query($args);

    // Se esiste già un modulo con lo stesso titolo, interrompi l'esecuzione
    if ($query->have_posts()) {
        return; // Esci dalla funzione, il modulo esiste già
    }

$cf7_id = wp_generate_uuid4();
    
            // Contenuto del modulo di contatto.
            $form_content = sprintf('
                [text* your-name placeholder "Il tuo nome+"]
                [text* your-surname placeholder "Il tuo cognome*"]
                [email* your-email placeholder "La tua email*"]
                [tel your-phone placeholder "Il tuo telefono"] 
                [textarea your-message placeholder "Il tuo messaggio"]
                <label>[acceptance privacy]I accept the <a href="' . $home_url . '/privacy-policy/"> Privacy Policy</a>[/acceptance] </label>
                [text referer-page ]
                [text current-page ]
                [submit "Invia"]
            ');
     
    
            // Corpo dell'email in HTML con campi dinamici.
        $email_body = "
        <!DOCTYPE html>
        <html lang='it'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        </head>
        <body style='background-color: #f8f9f9; padding: 60px 0; margin: 0;'>
            <table align='center' width='100%' border='0' cellspacing='0' cellpadding='0'
                   style='color: #787878; font-family: Arial, sans-serif; font-size: 14px;'>
                <tr>
                    <td align='center' valign='top'>
                        <table border='0' cellpadding='0' cellspacing='0' width='600'
                               style='background: #f7f7f7; width: 600px; border: 1px solid #e0e0e0;'>
                            <tr style='background: #000000'>
                                <td>
                                    <header style='min-height: 100px; padding: 15px 30px;'>
                                        <span style='float: left;'>
                                            <img src='$home_url' alt='Logo' style='height: 60px;' />
                                        </span>
                                        <span style='float: right; color: #ffffff; font-size: 18px; text-align: right;'>
                                            Richiesta Informazioni
                                        </span>
                                    </header>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding: 30px;'>
                                    <h3 style='color: #000; font-size: 18px; font-weight: normal; text-align: left;'>
                                        Grazie, [your-name] [your-surname]
                                    </h3>
                                    <p style='color: #000; font-size: 14px; font-weight: normal; text-align: left;'>
                                        La tua richiesta informazioni è stata inviata con successo.
                                    </p>
                                    <h4 style='color: #000; font-size: 18px; font-weight: normal; text-align: left;'>
                                        Riepilogo
                                    </h4>
                                    <p><strong>Nome e Cognome:</strong><br>[your-name] [your-surname]</p>
                                    <p><strong>Email:</strong><br>[your-email]</p>
                                    <p><strong>Tel:</strong><br>[your-phone]</p>
                                    <p><strong>Richiesta:</strong><br>[your-message]</p>
                                    <p><strong>Riferimento:</strong><br>[referer-page]</p>
                                    <p><strong>Pagina corrente:</strong><br>[current-page]</p>
                                    <p><strong>Accettazione Privacy Policy:</strong> [privacy] in data [_date]</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding: 0 30px 30px 30px; text-align: center;'>
                                    <p>
                                        <a href='$domain' style='color: #000;'>
                                            <img src='$home_url' alt='Logo' style='height: 30px;' />
                                        </a>
                                    </p>
                                    <div class='footer'>
                                        <div class='prefooter'>
                                            <p>
                                                <a href='mailto:info@$domain' style='color: #000;'>
                                                    info@$domain'
                                                </a>
                                            </p>
                                            <p>Copyright &copy; 2024 Tutti i diritti riservati</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>";
            
            // Configurazione dell'e-mail di invio.
            $mail_settings = array(
                '_mail' => array(
                    'active' => true,
                    'recipient' => 'info@' . $domain, // Email del destinatario. 
                    'sender' => '[_site_title] <wordpress@' . $domain . '>', // Email del mittente (dinamico). 
                    'subject' => 'Nuovo messaggio dal modulo di contatto', // Oggetto dell'email.
                    'body' => $email_body, // Corpo dell'email in HTML con campi dinamici.
                    'additional_headers' => 'Content-Type: text/html; charset=UTF-8', // Header per HTML.
                    'use_html' => true, // Indica che l'email è in HTML.
                ),
                '_mail_2' => array(
                    'active' => true,
                    'recipient' => '[your-email]', // Email del destinatario. 
                    'sender' => '[_site_title] <wordpress@' . $domain . '>', // Email del mittente (dinamico). 
                    'subject' => 'Messaggio inviato con successo a ' . $domain . '', // Oggetto dell'email.
                    'body' => $email_body, // Corpo dell'email in HTML con campi dinamici.
                    'additional_headers' => 'Content-Type: text/html; charset=UTF-8', // Header per HTML.
                    'use_html' => true, // Indica che l'email è in HTML.
                ),
                '_form' => $form_content
            );
            
            // Dati del modulo di contatto.
            $contact_form = array(
                'post_title' => 'Modulo di Contatto Demo', // Titolo del modulo.
                'post_status' => 'publish', // Stato del modulo.
                'post_type' => 'wpcf7_contact_form', // Tipo di post specifico per CF7.
                'post_content' => $form_content, // Contenuto del modulo.
                'meta_input' => $mail_settings, // Configurazione dell'email.
            );
            
            // Crea il modulo e ottieni l'ID.
            $post_id = wp_insert_post($contact_form);

            // Verifica se il modulo è stato creato correttamente e l'ID è stato restituito.
            if (!is_wp_error($post_id)) {
                // Memorizza l'ID alfanumerico univoco come meta_value
                update_post_meta($post_id, '_hash', $cf7_id); 
                // Crea lo shortcode con l'ID alfanumerico univoco
                $shortcode = '[contact-form-7 id="' . $cf7_id . '" title="Modulo di Contatto"]';
                // Memorizza lo shortcode in un'opzione per uso futuro.
                update_option('grit_custom_cf7_shortcode', $shortcode);
            } else {
                // Gestione dell'errore se l'inserimento del post non ha avuto successo.
                // Puoi aggiungere il codice per gestire l'errore qui.
                error_log('Errore durante la creazione del modulo CF7 personalizzato: ' . $post_id->get_error_message());
            }
            
            
        }

    // Controlla se l'opzione per creare il modulo CF7 personalizzato è selezionata.
    if (isset($grit_theme_activation_options['create_cf7_template']) &&
    $grit_theme_activation_options['create_cf7_template'] === 'true') { 
        $grit_theme_activation_options['create_cf7_template'] = false;
        create_custom_cf7_form();
    }
    /* end - create_cf7_template */




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



function update_theme_name() {
	// Percorso del file JSON
	$json_file_path = get_template_directory() . '/assets/credits/credits.json';
  
	// Leggi il contenuto del file JSON
	$json_data = file_get_contents($json_file_path);
  
	// Decodifica il contenuto JSON in un array associativo
	$data = json_decode($json_data, true);
  
	// Controlla se la decodifica è avvenuta con successo
	if ($data !== null && isset($data['agency'][0])) {
  
		// Accesso alle informazioni sull'agenzia
		$agency = $data['agency'][0]; // Prendi il primo elemento dell'array "agency" 
		// Includi lo script JavaScript per stampare i crediti nella console 

    // Nuovo nome del tema preso dal file JSON
		$new_theme_name = esc_html($agency['theme']);
  
		// === Modifica del tema padre ===
		$parent_style_css_path = get_template_directory() . '/style.css';
  
		// Verifica se il file style.css del tema padre esiste
		if (file_exists($parent_style_css_path)) {
			// Leggi il contenuto attuale di style.css del tema padre
			$parent_style_css = file_get_contents($parent_style_css_path);
  
			// Cerca e sostituisci la riga con il nome del tema nel commento del file style.css
			$parent_style_css = preg_replace('/(Theme Name:\s*)(.*)/', 'Theme Name: ' . esc_html($new_theme_name), $parent_style_css);
  
			// Scrivi il nuovo contenuto nel file style.css del tema padre
			if (file_put_contents($parent_style_css_path, $parent_style_css)) {
				// echo '<script>console.log("Il nome del tema padre è stato aggiornato a: ' . esc_js($new_theme_name) . '");</script>';
			} else {
				// echo '<script>console.error("Errore: impossibile aggiornare il file style.css del tema padre.");</script>';
			}
		} else {
			// echo '<script>console.error("Errore: il file style.css del tema padre non esiste.");</script>';
		}
  
		// === Modifica del tema child ===
		if (is_child_theme()) {
			$child_style_css_path = get_stylesheet_directory() . '/style.css';
			$new_child_theme_name = $new_theme_name . ' Child'; // Aggiungi "Child" al nome del tema per il child theme
  
			// Verifica se il file style.css del tema child esiste
			if (file_exists($child_style_css_path)) {
				// Leggi il contenuto attuale di style.css del tema child
				$child_style_css = file_get_contents($child_style_css_path);
  
				// Cerca e sostituisci la riga con il nome del tema nel commento del file style.css del tema child
				$child_style_css = preg_replace('/(Theme Name:\s*)(.*)/', 'Theme Name: ' . esc_html($new_child_theme_name), $child_style_css);
  
				// Scrivi il nuovo contenuto nel file style.css del tema child
				if (file_put_contents($child_style_css_path, $child_style_css)) {
					// echo '<script>console.log("Il nome del tema child è stato aggiornato a: ' . esc_js($new_child_theme_name) . '");</script>';
				} else {
					// echo '<script>console.error("Errore: impossibile aggiornare il file style.css del tema child.");</script>';
				}
			} else {
				// echo '<script>console.error("Errore: il file style.css del tema child non esiste.");</script>';
			}
		}
	} else {
		// Messaggio di errore se il file JSON non è stato decodificato correttamente
		echo '<span id="footer-thankyou">Errore: impossibile caricare le informazioni sull\'agenzia.</span>';
	}
  }
  

  // Funzione che aggiorna il nome del tema quando vengono salvate le opzioni di attivazione del tema
function update_theme_name_on_save() {
    if (isset($_POST['grit_theme_activation_options'])) {
        update_theme_name();
    }
}
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





