<?php

// * GRIT_SET Legend | Init
// Theme setup, supports, navigation and widget areas.
// 01 | Theme translations, supports and navigation
// 02 | Register sidebar and footer widget areas
// 03 | Selectable policy page templates

/**
 * Roots initial setup and constants
 */
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
    'footer_navigation' => __('Footer Navigation', 'grit')
  ));

  // Add post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // * GRIT_SET jQuery is supplied by WordPress; no CDN theme support is required.

  // Add post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

  // Add HTML5 markup for captions
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', array('caption', 'comment-form', 'comment-list'));
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

// * GRIT_SET 03 | Selectable Twig policy templates, independent of page slugs.
add_filter('theme_page_templates', function ($templates) {
    $templates['grit-privacy-policy.php'] = __('Privacy Policy', 'grit');
    $templates['grit-cookie-policy.php'] = __('Cookie Policy', 'grit');
    return $templates;
});
add_filter('template_include', function ($template) {
    if (is_page() && in_array(get_page_template_slug(get_queried_object_id()), ['grit-privacy-policy.php', 'grit-cookie-policy.php'], true)) {
        return locate_template('page.php') ?: $template;
    }
    return $template;
});
