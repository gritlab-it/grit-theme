<?php
/*
Template Name: Template Archive
*/
?>
<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

$templates = array('archive.twig', 'index.twig');
$context = Timber::context(); 
$post_type_obj = get_post_type_object(get_post_type()); 

$context['post_type'] = $post_type = $post_type_obj->name ?? 'post';

$context['term'] = $term = new Timber\Term(get_queried_object_id()); 
// * GRIT_SET Assignment of the pagination number of posts per page
$paginazione = get_option('posts_per_page');
$num_pagina = $paginazione - 1;
$exp_reg_pag = '%/page/(' . $num_pagina . ')%'; 
// * GRIT_SET Pagination processing: set the next number here '%/page/([0-3]+)%' based on the assigned value in pagination
preg_match($exp_reg_pag, $_SERVER['REQUEST_URI'], $matches);
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
// * GRIT_SET Check type of post 
if (is_day()) {
    $context['title'] = 'Archive: ' . get_the_date('D M Y');
} elseif (is_month()) {
    $context['title'] = 'Archive: ' . get_the_date('M Y');
} elseif (is_year()) {
    $context['title'] = 'Archive: ' . get_the_date('Y');
} elseif (is_tag()) {
    $context['title'] = single_tag_title('', false);
    $context['content']  = term_description(); 
    array_unshift(
        $templates,
        'tag-' . $term->slug . '.twig',
        'tag.twig'
    );
} elseif (is_category() || is_tax()) {
 
    $page_id = get_the_ID();

    $context['title'] = single_cat_title('', false);
    $context['content']  = term_description(); 
    // * GRIT_SET Get Child of current cat 
    $context['childs'] = $childs = get_terms(
        $term->taxonomy,
        array(
            'parent'    => $term->term_id,
            'hide_empty' => false
        )
    ); 
    // * GRIT_SET Get Parent of current cat
    $parent_id = $term->parent;
    $context['parents'] = $parents = get_terms(
        $term->taxonomy,
        array(
            'term_taxonomy_id'  => $parent_id,
            'hide_empty' => false,
        )
    );
    array_unshift(
        $templates, 
        'taxonomy-' . $term->taxonomy . '.twig', 
        'taxonomy.twig',
        'category-' . $term->slug . '.twig', 
        'category.twig',
        'archive-' . get_query_var('cat') . '.twig',
    );
}  elseif (is_post_type_archive()) {

    // * GRIT_SET Page set with the same slug of cpt  
    $page_args = array(
        'post_type' => 'page',
        'name' => $post_type_obj->rewrite['slug'],
        'posts_per_page' => 1
    );
    $query = new WP_Query($page_args);
    // * GRIT_SET Check of posts page with same slug of current cpt slug
    if ($query->have_posts()) {
        $query->the_post();
        $context['post'] = $post = get_post(get_the_ID()); 
        $page_id = get_the_ID();
        $context['page_id'] = $page_id;
        $context['page_title'] = get_the_title($page_id);
        $context['content'] = get_the_content($page_id);  
 
        wp_reset_postdata();
    } else {
        $context['title'] = $post_type_obj->labels->singular_name;
        $context['content'] = get_the_post_type_description();
 
    }
    
    array_unshift($templates, 'archive-' . $post_type_obj->name . '.twig');
} elseif (is_page()) {
    // * GRIT_SET Page with setting tempalte archive   
} elseif (is_home()) {
    // * GRIT_SET Page articles of post set in theme option of wp 
    $page_id = get_option('page_for_posts'); 
    $context['post'] = $post = get_post($page_id);
    $context['title'] = get_the_title($page_id);
    $context['content'] = apply_filters('the_content', get_post_field('post_content', $page_id)); 
    $context['the_excerpt'] = get_the_excerpt($page_id); 

 

} else {
    echo 'not set type of archive';
} 



 
//  * GRIT_SET Assign all ACF variables to Twig
$fields = get_field_objects($page_id);
if ($fields) :
    foreach ($fields as $field) :
        $name_id = $field['name'];
        $value_id = $field['value'];
        $context[$name_id] = $value_id;
    endforeach;
endif;
 //  * GRIT_SET Main query
$args = array(
    'post_type' => $post_type,
    'posts_per_page' => $paginazione,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'ASC',
);

if (is_category()) {
    // Filtra per categoria usando `cat`
    $args['cat'] = $term->term_id;
} elseif (is_tag()) {
    // Filtra per tag usando `tag_id`
    $args['tag_id'] = $term->term_id;
} elseif (is_tax()) {
    // Filtra per tassonomia personalizzata
    $args['tax_query'] = [
        [
            'taxonomy' => $term->taxonomy, // La tassonomia corrente
            'field'    => 'term_id',
            'terms'    => $term->term_id,  // L'ID del termine corrente
        ]
    ];
}

$context['posts'] = $posts = new Timber\PostQuery($args); 
//  * GRIT_SET Managing page numbering and their corresponding values
$context['found_posts'] = $posts->found_posts;
$context['startpost'] = $startpost = 1;
$context['startpost'] = $startpost = $paginazione * ($paged - 1) + 1;
$context['endpost'] = $endpost = ($paginazione * $paged < $posts->found_posts ? $paginazione * $paged : $posts->found_posts);  
Timber::render($templates, $context);
