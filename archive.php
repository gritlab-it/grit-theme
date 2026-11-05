<?php
/**
 * Template Name: Template Archive
 *
 * Native archives preserve the main query. Pages resolve their archive type
 * from their path, matching the archive slug, rewrite slug or post type name.
 */

// * GRIT_SET Initialize the shared context and preserve the native WordPress query
global $wp_query;

$templates = array('archive.twig', 'index.twig');
$context = Timber::context();
$object = get_queried_object();
$page_id = null;
$post_type_obj = null;
$archive_query = $wp_query;
$paged = max(1, absint(get_query_var('paged')), is_page() ? absint(get_query_var('page')) : 0);

// * GRIT_SET Collect archive slugs, rewrite paths and post type names for page associations
$archive_slugs = static function ($type) {
    $slugs = array($type->name);
    if (is_string($type->has_archive) && $type->has_archive !== '') {
        array_unshift($slugs, trim($type->has_archive, '/'));
    }
    if (is_array($type->rewrite) && !empty($type->rewrite['slug'])) {
        $slugs[] = trim($type->rewrite['slug'], '/');
    }
    return array_unique($slugs);
};

// * GRIT_SET Set default archive title and description
$context['title'] = get_the_archive_title();
$context['content'] = get_the_archive_description();

// * GRIT_SET Resolve the CPT associated with a page using Template Archive
if (is_page()) {
    $page_id = get_queried_object_id();
    $path = get_page_uri($page_id);
    $matches = array();
    foreach (get_post_types(array('public' => true), 'objects') as $type) {
        if (in_array($type->name, array('page', 'attachment'), true)) {
            continue;
        }
        if (in_array($path, $archive_slugs($type), true)) {
            $matches[$type->name] = $type;
        }
    }
    if (count($matches) === 1) {
        $post_type_obj = reset($matches);
    }
    // A page named blog can also represent the standard posts archive.
    if (!$post_type_obj && !$matches && $path === 'blog') {
        $post_type_obj = get_post_type_object('post');
    }
    // * GRIT_SET Build a separate paginated query for the page archive
    $args = array(
        'post_type' => $post_type_obj ? $post_type_obj->name : 'post',
        'post_status' => 'publish',
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $paged,
        'orderby' => array('date' => 'DESC', 'ID' => 'DESC'),
        'ignore_sticky_posts' => true,
    );
    // Do not silently display unrelated posts when no association exists.
    if (!$post_type_obj) {
        $args['post__in'] = array(0);
    }
    $archive_query = new WP_Query($args);
} elseif (is_post_type_archive() && $object instanceof WP_Post_Type) {
    // * GRIT_SET Find a published page associated with the native CPT archive
    $post_type_obj = $object;
    foreach ($archive_slugs($post_type_obj) as $slug) {
        $page = get_page_by_path($slug, OBJECT, 'page');
        if ($page && $page->post_status === 'publish') {
            $page_id = $page->ID;
            break;
        }
    }
} elseif (is_home()) {
    // * GRIT_SET Load the posts page configured in WordPress reading settings
    $page_id = (int) get_option('page_for_posts');
    $post_type_obj = get_post_type_object('post');
    $context['title'] = $post_type_obj->labels->name;
    $context['content'] = '';
} elseif ((is_category() || is_tag() || is_tax()) && $object instanceof WP_Term) {
    // * GRIT_SET Load taxonomy content, ACF reference and related terms
    $context['term'] = new Timber\Term($object->term_id);
    $page_id = $object->taxonomy . '_' . $object->term_id;
    $context['title'] = single_term_title('', false);
    $context['content'] = term_description();
    $children = get_terms(array(
        'taxonomy' => $object->taxonomy,
        'parent' => $object->term_id,
        'hide_empty' => false,
    ));
    $context['childs'] = is_wp_error($children) ? array() : $children;
    $parent = $object->parent ? get_term($object->parent, $object->taxonomy) : null;
    $context['parents'] = $parent && !is_wp_error($parent) ? array($parent) : array();
    // * GRIT_SET Select taxonomy templates from specific to generic
    if (is_category()) {
        array_unshift($templates, 'category-' . $object->slug . '.twig', 'category-' . $object->term_id . '.twig', 'category.twig');
    } elseif (is_tag()) {
        array_unshift($templates, 'tag-' . $object->slug . '.twig', 'tag-' . $object->term_id . '.twig', 'tag.twig');
    } else {
        array_unshift($templates, 'taxonomy-' . $object->taxonomy . '-' . $object->slug . '.twig', 'taxonomy-' . $object->taxonomy . '.twig', 'taxonomy.twig');
    }
}

// * GRIT_SET Prefer the CPT-specific Twig template when available
if ($post_type_obj) {
    array_unshift($templates, 'archive-' . $post_type_obj->name . '.twig');
}
$context['post_type'] = $post_type_obj ? $post_type_obj->name : $wp_query->get('post_type');

// * GRIT_SET Load the associated page content without replacing the archive query
if (is_int($page_id) && $page_id > 0) {
    $context['post'] = new Timber\Post($page_id);
    $context['page_id'] = $page_id;
    $context['title'] = $context['page_title'] = get_the_title($page_id);
    $context['content'] = apply_filters('the_content', get_post_field('post_content', $page_id));
    $context['the_excerpt'] = get_the_excerpt($page_id);
}

// * GRIT_SET Expose page or taxonomy ACF fields to Twig when ACF is available
$fields = $page_id && function_exists('get_field_objects') ? get_field_objects($page_id) : null;
if ($fields) {
    foreach ($fields as $field) {
        $context[$field['name']] = $field['value'];
    }
}

// * GRIT_SET Wrap archive results in Timber and calculate the displayed result range
$context['posts'] = new Timber\PostQuery($archive_query);
$context['found_posts'] = (int) $archive_query->found_posts;
$count = (int) $archive_query->post_count;
$per_page = (int) $archive_query->get('posts_per_page');
$offset = $archive_query->get('offset');
$start = $per_page > 0 ? ($paged - 1) * $per_page : 0;
if (is_numeric($offset)) {
    $start = (int) $offset;
}
$context['startpost'] = $count ? $start + 1 : 0;
$context['endpost'] = $count ? $start + $count : 0;
// * GRIT_SET Render the first available archive template
Timber::render($templates, $context);
