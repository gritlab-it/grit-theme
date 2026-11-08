<?php
// * GRIT_SET Single legend
// 01 | Current post and password protection
// 02 | ACF fields and post content
// 03 | Related posts: edit the query here
// 04 | Native WordPress comments
// 05 | Twig template priority
if (!defined('ABSPATH')) {
    exit;
}

// * GRIT_SET 01 | Load the requested post; protected posts stop here.
$context = Timber::context();
$timber_post = Timber::get_post(get_queried_object_id());
$post_id = $timber_post ? $timber_post->ID : 0;
$post_type = $timber_post ? $timber_post->post_type : 'post';
$context['post'] = $timber_post;

if ($timber_post && post_password_required($post_id)) {
    $context['password_form'] = get_the_password_form($post_id);
    $context['sections'] = [];
    Timber::render('single-password.twig', $context);
    return;
}

// * GRIT_SET 02 | Load the current post's fields and formatted content.
$context = grit_template_fields($context, $post_id);
$context['post'] = $timber_post;
$context['title'] = $timber_post ? $timber_post->title : '';
$context['content'] = $timber_post ? grit_template_content($post_id) : '';

// * GRIT_SET 03 | Same post type, newest first, excluding the current and password-protected posts.
$related_args = [
    'post_type'      => $post_type,
    'post_status'    => 'publish',
    'has_password'   => false,
    'posts_per_page' => max(1, (int) get_option('posts_per_page')),
    'post__not_in'   => $timber_post ? [(int) $post_id] : [],
    'orderby'       => ['date' => 'DESC', 'ID' => 'DESC'],
    'no_found_rows'  => true,
];
$context['archive_posts'] = new Timber\PostQuery($related_args);

// * GRIT_SET 04 | One comment list/form, respecting theme and post settings.
$context['comments_html'] = '';
$show_comments = $timber_post
    && !get_theme_mod('grit_setting_comments', false)
    && post_type_supports($post_type, 'comments')
    && (comments_open($post_id) || get_comments_number($post_id));

if ($show_comments) {
    wp_reset_postdata();
    ob_start();
    comments_template();
    $context['comments_html'] = ob_get_clean();
}

// * GRIT_SET 05 | Specific post, slug, child layout, post type, then single.twig.
$templates = [];
if ($timber_post) {
    $templates[] = 'single-' . $post_id . '.twig';
    $templates[] = 'single-' . $timber_post->slug . '.twig';

    if ($timber_post->post_parent) {
        $templates[] = 'single-' . $post_type . '-child.twig';
        $templates[] = 'single-child.twig';
    }
    $templates[] = 'single-' . $post_type . '.twig';
}
$templates[] = 'single.twig';

Timber::render($templates, $context);
