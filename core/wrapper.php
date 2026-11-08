<?php

// * GRIT_SET Legend | Wrapper
// Optional legacy PHP template wrapper.
// Optional module: check the include list in functions.php before enabling it.
// 01 | Resolve legacy PHP template parts
// 02 | Read the selected main template

/**
 * Theme wrapper
 */

// * GRIT_SET 01 | Resolve legacy PHP template parts
function get_part($path) {

      $is_header = explode("/", $path);

      if (get_theme_mod('grit_adv_twig')) {
        if (!in_array('head', $is_header) && !in_array('header', $is_header) && !in_array('footer', $is_header)) {
          get_template_part(str_replace('templates', 'twig', $path));
        }
      } else {
        get_template_part($path);
      }
}

// * GRIT_SET 02 | Read the selected main template
function grit_template_path() {
    return grit_Wrapping::$main_template;
}

class grit_Wrapping {
  // Stores the full path to the main template file
  public static $main_template;
  // basename of template file
  public $slug;
  // array of templates
  public $templates;
  // Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
  static $base;

  public function __construct($template = 'base.php') {
    $this->slug = basename($template, '.php');
    $this->templates = array($template);

    if (self::$base) {
      $str = substr($template, 0, -4);
      array_unshift($this->templates, sprintf($str . '-%s.php', self::$base));
    }
  }

  public function __toString() {
    $this->templates = apply_filters('grit/wrap_' . $this->slug, $this->templates);
    return locate_template($this->templates);
  }

  static function wrap($main) {
    // Check for other filters returning null
    if (!is_string($main)) {
      return $main;
    }

    self::$main_template = $main;
    self::$base = basename(self::$main_template, '.php');

    if (self::$base === 'index') {
      self::$base = false;
    }

    return new grit_Wrapping();
  }
}
add_filter('template_include', array('grit_Wrapping', 'wrap'), 99);
