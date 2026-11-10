<?php

// * GRIT_SET Legend | Utils
// Request, search, body and template utilities.
// 01 | Cloudflare client address handling
// 02 | Search form and body helpers
// 03 | Response content type
// 04 | Conditional debug logging
// 05 | Admin notice and capability-based editor filters

/**
 * Utility functions
 */

// Adding Cloudflare support
// * GRIT_SET 01 | Cloudflare client address handling
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
      $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

// * GRIT_SET 02 | Search form and body helpers
if (!function_exists('grit_get_search_form')) {
  function grit_get_search_form($form) {
    if (!class_exists('Timber')) {
      return $form;
    }
    return Timber::compile('partials/searchform.twig', array(
      'search_query' => get_search_query(false),
    ));
  }
  add_filter('get_search_form', 'grit_get_search_form');
}

/**
 * Add page slug to body_class() classes if it doesn't exist
 */
if (!function_exists('grit_body_class')) {
  function grit_body_class($classes) {
    // Add post/page slug
    if (is_single() || is_page() && !is_front_page()) {
      if (!in_array(basename(get_permalink()), $classes)) {
        $classes[] = basename(get_permalink());
      }
    }
    return $classes;
  }
  add_filter('body_class', 'grit_body_class');
}

// send html formatted email only
// * GRIT_SET 03 | Response content type
if (!function_exists('grit_set_content_type')) {
  function grit_set_content_type(){
      return "text/html";
  }
  add_filter( 'wp_mail_content_type','grit_set_content_type' );
}

if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
    ini_set( 'error_log', get_template_directory().'/logs/'.date('j-m-y').'-debug.log' );
}

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// * GRIT_SET 04 | Conditional debug logging
function debug($message, $type = '') {
    if (class_exists('Monolog\\Logger')) {
      $logs = get_template_directory().'/logs/';
      $log = new Logger('debug');
      $log->pushHandler(new StreamHandler($logs.date('j-m-y').'-app.log', Logger::DEBUG));
      switch ($type) {
        case 'error':
        $log->error($message);
        break;
        case 'warning':
        $log->warning($message);
        break;
        default:
        $log->addInfo($message);
        break;
      }
    } else {
      error_log( print_r( $message, true ) );
    }
}

// rimuovo il messaggio di benvenuto di duplicate post
// * GRIT_SET 05 | Admin notice and capability-based editor filters
add_action( 'init', 'remove_duplicate_post_message' );
function remove_duplicate_post_message() {
    update_site_option('duplicate_post_show_notice', 0);
}

// Disable W3TC footer comment for all users
add_filter( 'w3tc_can_print_comment', '__return_false', 10, 1 );

// Disable W3TC footer comment for everyone but Admins (single site) / Super Admins (network mode)
if ( !current_user_can( 'unfiltered_html' ) ) {
    add_filter( 'w3tc_can_print_comment', '__return_false', 10, 1 );
}

// Disable W3TC footer comment for everyone but Admins (single site & network mode)
if ( !current_user_can( 'activate_plugins' ) ) {
    add_filter( 'w3tc_can_print_comment', '__return_false', 10, 1 );
}
