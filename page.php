<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context(); 
$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
$templates       = array( 'page.twig', 'index.twig' );

// * GRIT_SET Assegno tutte le variabili di ACF a Twig
// Verifica se ACF è attivo prima di chiamare la funzione get_field_objects()
if (function_exists('get_field_objects')) {
    $fields = get_field_objects(get_queried_object_id($timber_post));
    if ($fields) {
        foreach ($fields as $field) {
            $name_id = $field['name'];
            $value_id = $field['value'];
            $context[$name_id] = $value_id;
        }
    }
} else {
    // ACF non è attivo, gestisci l'errore o continua senza i campi ACF
    error_log('ACF non è attivo. Impossibile recuperare i campi personalizzati.');
}


if ( is_front_page() ) {  
    array_unshift( $templates, 'home.twig' );
} else {
    array_unshift( $templates, 'page-' . $timber_post->post_name . '.twig', 'page.twig' ); 
}

Timber::render( $templates, $context );
