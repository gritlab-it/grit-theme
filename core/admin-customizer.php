<?php
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * A_SETTINGS Aggiorno il CSS nell’area amministratore
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function admin_style()
{
    wp_enqueue_style('admin-styles', get_template_directory_uri() . '/assets/css/wp-admin.css');
    /*    wp_enqueue_script( 'admin-script', get_template_directory_uri().'/assets/wp-admin.js', array( 'jquery' ), '1.2.1' );*/
}

// Esegue la funzione admin_style() all’azione admin_enqueue_scripts di WP
add_action('admin_enqueue_scripts', 'admin_style');
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * A_SETTINGS Customizer admin menu bar
                    https://heera.it/customize-admin-menu-bar-in-wordpress
                    https://webriti.com/customizing-wordpress-admin-bar/
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function add_my_own_logo($wp_admin_bar)
{
    $args = array(
        'id' => 'my-logo',
        'meta' => array('class' => 'my-logo', 'title' => 'logo')
    );
    $wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'add_my_own_logo', 1);


function linked_url()
{
    // Ottieni i dati dell'agenzia dal JSON
    $agency_data = get_agency_data_from_json();

    // Controlla se ci sono dati sull'agenzia e se esiste la chiave "agency_url" nel primo elemento
    if (!empty($agency_data) && isset($agency_data[0]['agency_url'])) {
        // Utilizza l'URL dell'agenzia come link per il menu
        $agency_url = $agency_data[0]['agency_url'];
        $agency = $agency_data[0]['agency'];
        // Aggiungi il menu con l'URL dell'agenzia come link
        add_menu_page('linked_url', $agency, 'read', 'gritlab_site', '', 'dashicons-info-outline', 1, $agency_url);
    }
}

add_action('admin_menu', 'linked_url');

function linkedurl_function()
{
    // Ottieni i dati dell'agenzia dal JSON
    $agency_data = get_agency_data_from_json();

    // Controlla se ci sono dati sull'agenzia e se esiste la chiave "agency_url" nel primo elemento
    if (!empty($agency_data) && isset($agency_data[0]['agency_url'])) {
        // Utilizza l'URL dell'agenzia come link per il menu
        $agency_url = $agency_data[0]['agency_url']; 
        // Aggiorna l'URL del primo elemento nel menu
        global $menu;
        $menu[1][2] = $agency_url;
    }
}

add_action('admin_menu', 'linkedurl_function');

// function login_background_image()
// {
//     echo '<style type="text/css">
//         body.login{ background: #1D1D1B!important; }
//         .login #backtoblog a, 
//         .login #nav a { color:#ffffff; }
// </style>';
// }

// add_action('login_head', 'login_background_image');






function get_agency_data_from_json() {
    // Percorso del file JSON
    $json_file_path = get_template_directory() . '/assets/credits/credits.json';

    // Leggi il contenuto del file JSON
    $json_data = file_get_contents($json_file_path);

    // Decodifica il contenuto JSON in un array associativo
    $data = json_decode($json_data, true);

    // Controlla se la decodifica è avvenuta con successo e se esiste la chiave "agency"
    if ($data !== null && isset($data['agency'])) {
        // Restituisci i dati dell'agenzia
        return $data['agency'];
    } else {
        // Restituisci un valore di default se la chiave "agency" non è definita o il file JSON non può essere letto
        return array();
    }
}

function get_agency_folder_from_json() {
    // Ottieni i dati dell'agenzia dal JSON
    $agency_data = get_agency_data_from_json();

    // Controlla se ci sono dati sull'agenzia e se esiste la chiave "agency_folder" nel primo elemento
    if (!empty($agency_data) && isset($agency_data[0]['agency_folder'])) {
        // Restituisci il valore della chiave "agency_folder" del primo elemento
        return $agency_data[0]['agency_folder'];
    } else {
        // Restituisci un valore di default se la chiave "agency_folder" non è definita o non ci sono dati sull'agenzia
        return 'default';
    }
}

function login_logo() {
    // Ottieni la cartella del logo dall'JSON
    $agency_folder = get_agency_folder_from_json();
 
    // Percorso del file del logo in base alla cartella ottenuta
    $logo_path = get_template_directory_uri() . '/assets/credits/' . $agency_folder . '/logo.png';
    $icon_path = get_template_directory_uri() . '/assets/credits/' . $agency_folder . '/icon.svg';

    ?>

    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo $logo_path; ?>);
            background-size: contain; 
            width: 100%;
        }

        #wpadminbar #wp-admin-bar-my-logo > .ab-item {
            padding: 0 12px;
            margin: 0 5px;
            background-image: url(<?php echo $icon_path; ?>); 
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 1;
        }
         
 
    </style>
<?php }




 

function login_background_image() { 
    $agency_data = get_agency_data_from_json(); 
    // Controlla se ci sono dati sull'agenzia e se esiste la chiave "color" nel primo elemento
    if (!empty($agency_data) && isset($agency_data[0]['color'])) {
        // Utilizza l'URL dell'agenzia come link per il menu
        $login_background_color = $agency_data[0]['color']; 
        echo '<style type="text/css">
        body.login { background-color: ' . esc_attr($login_background_color) . ' !important; }
        .login #backtoblog a, 
        .login #nav a { color: #ffffff; } /* Colore del testo, puoi mantenere fisso se desiderato */
        </style>';
    }  
}

add_action('login_head', 'login_background_image');




// Aggiungi la funzione login_logo all'hook login_enqueue_scripts
add_action('login_enqueue_scripts', 'login_logo');
// Aggiungi la funzione login_logo anche per l'amministrazione
add_action('admin_head', 'login_logo');
add_action('wp_head', 'login_logo');

function login_logo_url_title()
{
    // Ottieni l'URL dell'agenzia dal JSON
    $agency_data = get_agency_data_from_json();

    // Controlla se ci sono dati sull'agenzia e se esiste la chiave "agency_url" nel primo elemento
    if (!empty($agency_data) && isset($agency_data[0]['agency_url'])) {
        // Restituisci l'URL dell'agenzia
        return $agency_data[0]['agency_url'];
    } else {
        // Restituisci un URL di default se la chiave "agency_url" non è definita o non ci sono dati sull'agenzia
        return home_url('/');
    }
}

add_filter('login_headerurl', 'login_logo_url_title');


 


// WordPress Custom Font @ Admin
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