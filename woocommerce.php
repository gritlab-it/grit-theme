<?php
// * GRIT_SET WooCommerce legend
// 01 | Native fallback when the optional Timber product bridge is disabled
// 02 | Single product and related products
// 03 | Product archive and category
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('WooCommerce') || !function_exists('woocommerce_content')) {
    return;
}

$context = Timber::context();
$context['sidebar'] = Timber::get_widgets('shop-sidebar');

// * GRIT_SET 01 | Standard WooCommerce output remains available without the optional bridge.
if (!function_exists('timber_set_product')) {
    ob_start();
    do_action('woocommerce_before_main_content');
    woocommerce_content();
    do_action('woocommerce_after_main_content');
    $context['content'] = ob_get_clean();
    Timber::render('page-plugin.twig', $context);
    return;
}

// * GRIT_SET 02 | Product page.
if (is_singular('product')) {
    $product_post = Timber::get_post();
    $context['post'] = $product_post;
    $product = wc_get_product($context['post']->ID);
    $context['product'] = $product;

    // Same related-product behavior as the existing shop layout.
    $related_limit = max(1, (int) (wc_get_loop_prop('columns') ?: 4));
    $related_ids = wc_get_related_products($context['post']->id, $related_limit);
    $context['related_products'] = Timber::get_posts($related_ids);

    // Restore the context and loop back to the main query loop.
    wp_reset_postdata();

    Timber::render('woo/single-product.twig', $context);
    return;
}

// * GRIT_SET 03 | Shop archive or product category.
$posts = Timber::get_posts();
$context['products'] = $posts;

if (is_product_category()) {
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $context['category'] = get_term($term_id, 'product_cat');
    $context['title'] = single_term_title('', false);
}

Timber::render('woo/archive.twig', $context);
