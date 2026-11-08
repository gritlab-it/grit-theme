<?php

// * GRIT_SET Legend | Security
// Header cleanup and login error filtering.
// 01 | Remove selected WordPress head metadata
// 02 | Filter login error messages
// 03 | Remove the X-Pingback response header

/**
 * Some security utils
 *
 */

// remove unnecessary header information
// * GRIT_SET 01 | Remove selected WordPress head metadata
function remove_header_info() {
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'start_post_rel_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head',10,0); // for WordPress >= 3.0
}
add_action('init', 'remove_header_info');

// Remove error mesage in login
add_filter('login_errors', 'invalid_input');

// * GRIT_SET 02 | Filter login error messages
function invalid_input() {
    return 'Invalid Input';
}

// remove xpingback header
// * GRIT_SET 03 | Remove the X-Pingback response header
function remove_x_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'remove_x_pingback');
