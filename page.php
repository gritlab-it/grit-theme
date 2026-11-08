<?php
// * GRIT_SET Page legend
// 01 | Current page and password protection
// 02 | ACF fields and page content
// 03 | Twig template priority
if (!defined('ABSPATH')) {
    exit;
}

// * GRIT_SET 01 | Load the requested page; protected pages stop here.
$context = Timber::context();
$timber_post = Timber::get_post(get_queried_object_id());
$post_id = $timber_post ? $timber_post->ID : 0;
$context['post'] = $timber_post;

if ($timber_post && post_password_required($post_id)) {
    $context['password_form'] = get_the_password_form($post_id);
    $context['sections'] = [];
    Timber::render('single-password.twig', $context);
    return;
}

// * GRIT_SET 02 | Helpers load ACF and run content filters with the correct page ID.
$context = grit_template_fields($context, $post_id);
$context['post'] = $timber_post;
$context['title'] = $timber_post ? $timber_post->title : '';
$context['content'] = $timber_post ? grit_template_content($post_id) : '';

// * GRIT_SET 03 | Front page, page slug, then generic fallbacks.
$templates = [];
if (is_front_page()) {
    $templates[] = 'home.twig';
} elseif ($timber_post) {
    $templates[] = 'page-' . $timber_post->post_name . '.twig';
}
$templates[] = 'page.twig';
$templates[] = 'index.twig';

Timber::render($templates, $context);
