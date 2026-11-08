<?php
/**
 * Template Name: Search
 */
// * GRIT_SET Search legend
// 01 | Search term
// 02 | Optional page supplying content and ACF sections
// 03 | Results: native search or the selected Search page template
// 04 | Result counts, heading and Twig output
if (!defined('ABSPATH')) {
    exit;
}
global $wp_query;

// * GRIT_SET 01 | Read the native WordPress search term.
$context = Timber::context();
$search_term = get_query_var('s', '');
$search_term = is_scalar($search_term) ? sanitize_text_field($search_term) : '';
$context['search_query'] = $search_term;
$context['s'] = $search_term;

// * GRIT_SET 02 | Priority: current Search template, search/cerca slug, one unique Search template page.
$search_page_id = 0;
if (is_page() && get_page_template_slug(get_queried_object_id()) === 'search.php') {
    $search_page_id = get_queried_object_id();
} else {
    foreach (['search', 'cerca'] as $slug) {
        $candidate = get_page_by_path($slug, OBJECT, 'page');
        if ($candidate && $candidate->post_status === 'publish') {
            $search_page_id = $candidate->ID;
            break;
        }
    }

    if (!$search_page_id) {
        $candidates = get_posts([
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'numberposts'    => 2,
            'fields'         => 'ids',
            'meta_key'       => '_wp_page_template',
            'meta_value'     => 'search.php',
        ]);
        if (count($candidates) === 1) {
            $search_page_id = (int) reset($candidates);
        }
    }
}

$context = grit_template_fields($context, $search_page_id);
$context['content'] = '';
if ($search_page_id) {
    $context['page_id'] = $search_page_id;
    $context['post'] = Timber::get_post($search_page_id);
    $context['content'] = grit_template_content($search_page_id);
}

// * GRIT_SET 03 | Native search keeps its existing query, relevance and filters.
$results_query = $wp_query;
if (!is_search()) {
    $paged = max(1, absint(get_query_var('paged')), absint(get_query_var('page')));
    $search_args = [
        'post_type'      => 'any',
        'post_status'    => 'publish',
        'posts_per_page' => get_option('posts_per_page'),
        'paged'          => $paged,
        's'              => $search_term,
    ];
    // An empty Search page must not show unrelated posts.
    if ($search_term === '') {
        $search_args['post__in'] = [0];
    }
    $results_query = new WP_Query($search_args);
}

// * GRIT_SET 04 | Shared result counts; a search with no matches stays empty.
$context = grit_template_query($context, $results_query);
if ($results_query->found_posts) {
    $heading = sprintf(__('Risultati della ricerca per: %s', 'grit'), $search_term);
} else {
    $heading = sprintf(__('Nessun risultato trovato per: %s', 'grit'), $search_term);
}
$context['title'] = $heading;
$context['post_title'] = $heading;

Timber::render(['search.twig', 'archive.twig', 'index.twig'], $context);
