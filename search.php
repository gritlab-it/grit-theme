<?php
 
/**
 * Template Name: Search
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );

$context          = Timber::context();
$context['post_title'] = 'Search results for ' . get_search_query();

// A_SETTINGS Assegnazione del numero di paginazione di post per pagina
$paginazione = get_option('posts_per_page');
$num_pagina = $paginazione -1;
$exp_reg_pag = '%/page/('.$num_pagina.')%';

// A_SETTINGS Elaborazione dell'impaginato impostare il numero successivo qui '%/page/([0-3]+)%' in base al valore assegnato nella paginazione
preg_match($exp_reg_pag, $_SERVER['REQUEST_URI'], $matches );
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
    $paged = get_query_var('page');
} elseif (isset($matches[1])) {
    $paged = $matches[1];
} elseif (!isset($paged) || !$paged) {
    $paged = 1;
} else {
    $paged = 1;
}

/* ascolta url per prendere campo di ricerca */
$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$context['search_query'] = get_search_query();
$context['s'] = $search_query;

/* assegno tutte le variabili di ACF */
$fields = get_field_objects($post);
if ($fields):
    foreach ($fields as $field):
        $name_id = $field['name'];
        $value_id = $field['value'];
        $context[$name_id] = $value_id;
    endforeach;
endif;



/*
 *  Recupero da url categorie e ricerca
$brand = $_GET['brand'];
$context['brand'] = $brand;
$applicazioni = $_GET['applicazioni'];
$context['applicazioni'] = $applicazioni;
*/

/*
 * Ricerco categorie cominate
$tax_query = array(
    'relation' => 'AND',
    array(
        'taxonomy' => 'brand',
        'field'    => 'slug',
        'terms'    => array( $brand ),
        'operator'  => 'AND'
    ),
    array(
        'taxonomy' => 'applicazioni',
        'field'    => 'slug',
        'terms'    => array( $applicazioni ),
        'operator'  => 'AND'
    )
);
*/

/*  A_SETTINGS Elaboro una query per la ricerca effettuata */

$args = array(
    'post_type' => 'any',
    'posts_per_page' => $paginazione,
    'paged' => $paged,
 
    's' => $search_query,
 
    /*'tax_query'             => $tax_query, //////////// Combo ricerca fra due categorie */

    /************************ ordinamento per quelle che prima hanno immagini o no
    'meta_query' => array(  //query post based on meta key
    array(
    'relation' => 'OR', // add condition if meta key is exists or not
    array(
    'key' => '_thumbnail_id',
    'compare' => 'NOT EXISTS' // include post without _thumbnail_id key
    ),
    array(
    'key' => '_thumbnail_id',
    'compare' => '!NOT EXISTS' // include post with _thumbnail_id key
    )
    )
    ),
     */
    /************************ ordinamento per titolo e poi per data */
    'orderby' => array(
        'title' => 'ASC',
        'date' => 'ASC',
    ),
    /************************ ordinamento per meta
    'meta_query' => array(
    'relation' => 'AND',
    array(
    'key' => 'volt',
    'value' => '36',
    'compare' => '=',
    ),
    ),
     */

);
$posts_search = new WP_Query($args);



/* se query da risultiti */
if ($posts_search->have_posts()) {

    $context['post_title'] = 'Risultati della ricerca per: ' . $search_query;
    /* elaboro query */
    $context['posts'] = $posts = new Timber\PostQuery($args);
 
} /* se query è vuota */
else {
    /*  A_SETTINGS Elaboro una query per i related incaso non la prima quesry fosse vuota */
    $context['post_title'] = 'Nessun risultato trovato per: ' . $search_query;

    /* query delle tassonomie alternativa
    $tax_query2 = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'brand',
            'field'    => 'slug',
            'terms'    => array( $brand ),
            'operator'  => 'AND'
        ),
        array(
            'taxonomy' => 'applicazioni',
            'field'    => 'slug',
            'terms'    => array( $applicazioni ),
            'operator'  => 'AND'
        )
    );
    */

    $args_empty = array(
        'post_type'             => 'any', //////////// Nome del custom post
        'posts_per_page'        => $paginazione, //////////// Numero custom post ( -1 = tutti )
        'paged'                 => $paged,
        'offset'                => 1,
        /*'tax_query'             => $tax_query2,*/

        'orderby' => array(
            'title' => 'ASC',
            'date' => 'ASC',
        ),


    );
    /* elaboro query con risultati alternativi */
    $posts = new Timber\PostQuery($args_empty);
}
/*  A_SETTINGS Assegno query definitiva */
// $context['posts'] = new Timber\PostQuery();

 



//  A_SETTINGS Gestisco la numerazione della pagine e i corrispettivi valori trovati
$context['found_posts'] = $posts->found_posts;
$context['startpost'] = $startpost = 1;
$context['startpost'] = $startpost = $paginazione * ($paged - 1) + 1;
$context['endpost'] = $endpost = ($paginazione * $paged < $posts->found_posts ? $paginazione * $paged : $posts->found_posts);




Timber::render( $templates, $context );
