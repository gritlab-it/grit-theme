<?php

// * GRIT_SET Legend | Init
// Theme setup, supports, navigation and widget areas.
// 01 | Theme translations, supports and navigation
// 02 | Register sidebar and footer widget areas

// * GRIT_SET 01 | Theme translations, supports and navigation
function grit_setup() {
  // Make theme available for translation
  load_theme_textdomain('grit', get_template_directory() . '/lang');
  
  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'grit'),
    'secondary_navigation' => __('Secondary Navigation', 'grit'),
    'mobile_navigation' => __('Mobile Navigation', 'grit'),
    'footer_navigation' => __('Footer Navigation', 'grit'),
    'bio_navigation' => __('Bio Links', 'grit')
  ));

  // WordPress manages document titles, feed links and featured images.
  add_theme_support('title-tag');
  add_theme_support('automatic-feed-links');
  add_theme_support('post-thumbnails');

  // Keep the supported post formats and native HTML5 markup in one place.
  add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio'));
  add_theme_support('html5', array('comment-form', 'comment-list', 'gallery', 'caption'));

  // register_nav_menus() above also enables the WordPress menus support.
  // Declare shop compatibility; optional customizations remain in core/woocommerce.php.
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'grit_setup');

/**
 * Register sidebars
 */
// * GRIT_SET 02 | Register sidebar and footer widget areas
function grit_widgets_init() {
  register_sidebar(array(
    'name'          => __('Primary', 'grit'),
    'id'            => 'sidebar_primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));
  register_sidebar(array(
      'name'          => __('Pre Footer', 'grit'),
      'id'            => 'pre_footer',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
  ));
  register_sidebar(array(
    'name'          => __('Footer Col 1', 'grit'),
    'id'            => 'footer_col_1',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));
  register_sidebar(array(
     'name'          => __('Footer Col 2', 'grit'),
     'id'            => 'footer_col_2',
     'before_widget' => '<section class="widget %1$s %2$s">',
     'after_widget'  => '</section>',
     'before_title'  => '<h3>',
     'after_title'   => '</h3>',
  ));
  register_sidebar(array(
     'name'          => __('Footer Col 3', 'grit'),
     'id'            => 'footer_col_3',
     'before_widget' => '<section class="widget %1$s %2$s">',
     'after_widget'  => '</section>',
     'before_title'  => '<h3>',
     'after_title'   => '</h3>',
  ));
  register_sidebar(array(
      'name'          => __('Footer Col 4', 'grit'),
      'id'            => 'footer_col_4',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
  ));
  register_sidebar(array(
       'name'          => __('Footer Bottom', 'grit'),
       'id'            => 'footer_bottom',
       'before_widget' => '<section class="widget %1$s %2$s">',
       'after_widget'  => '</section>',
       'before_title'  => '<h3>',
       'after_title'   => '</h3>',
  ));

}
add_action('widgets_init', 'grit_widgets_init');
