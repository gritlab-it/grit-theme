<?php
// * GRIT_SET Author legend
// 01 | Native author results
// 02 | Author identity and heading
if (!defined('ABSPATH')) {
    exit;
}
global $wp_query;

// * GRIT_SET 01 | Keep the main query; author ACF sections are not configured.
$context = Timber::context();
$context = grit_template_query($context, $wp_query);
$context['sections'] = [];
$context['content'] = '';

// * GRIT_SET 02 | Expose the author separately from the posts being listed.
$author = get_queried_object();
if ($author instanceof WP_User) {
    $context['author'] = new Timber\User($author->ID);
    $context['title'] = sprintf(__('Articoli di %s', 'grit_theme'), $author->display_name);
}

Timber::render(['author.twig', 'archive.twig', 'index.twig'], $context);
