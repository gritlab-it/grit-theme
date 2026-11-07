<?php

if (get_theme_mod('grit_adv_adminbar', true)) {
  show_admin_bar( false );
}

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * GRIT_SET Post IDs viewable in the back-end
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

    add_filter('manage_posts_columns', 'posts_columns_id', 5);
    add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
    add_filter('manage_pages_columns', 'posts_columns_id', 5);
    add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);
    
    function posts_columns_id($defaults){
        $defaults['wpam_post_id'] = __('ID');
    return $defaults;
    }
    function posts_custom_id_columns($column_name, $id){
        if($column_name === 'wpam_post_id'){
                echo $id;
    }
    }

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * GRIT_SET Add Modern Social support for profiles
::::::::::::::      https://laceytechsolutions.co.uk/blog/add-social-media-contact-methods-wordpress-user-profiles/
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function new_contactmethods( $contactmethods ) {
    // Add socials
    $contactmethods['instagram'] = 'Instagram';
    $contactmethods['facebook']  = 'Facebook';
    $contactmethods['linkedin']  = 'LinkedIn';
    $contactmethods['github']    = 'GitHub';
    $contactmethods['youtube']   = 'YouTube';
    $contactmethods['telegram']  = 'Telegram';
    $contactmethods['tiktok']    = 'TikTok';

    // Remove deprecated fields
    unset( $contactmethods['aim'] );
    unset( $contactmethods['yim'] );
    unset( $contactmethods['jabber'] );

    return $contactmethods;
}
add_filter('user_contactmethods','new_contactmethods',10,1);


/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * GRIT_SET Custom admin footer message
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/ 


function remove_footer_admin() {
  // Percorso del file JSON
  $json_file_path = get_template_directory() . '/assets/credits/credits.json';

  // Leggi il contenuto del file JSON
  $json_data = file_get_contents($json_file_path);

  // Decodifica il contenuto JSON in un array associativo
  $data = json_decode($json_data, true);

  // Controlla se la decodifica è avvenuta con successo
  if ($data !== null && isset($data['agency'][0])) {
      // Accesso alle informazioni sull'agenzia
      $agency = $data['agency'][0]; // Prendi il primo elemento dell'array "agency"


      // Percorso dell'immagine dello screenshot (logo o immagine del tema) dal JSON
		$screenshot_path = get_template_directory() . '/assets/credits/' . $agency['agency_folder'] . '/screenshot.png';
		$dest_path = get_template_directory() . '/screenshot.png';
  
    $child_screenshot_path = get_template_directory() . '/assets/credits/' . $agency['agency_folder'] . '/screenshot-child.png';
		$child_dest_path = get_stylesheet_directory() . '/screenshot.png';
  
		// Copia lo screenshot solo se il file sorgente esiste
		if (file_exists($screenshot_path)) {
			copy($screenshot_path, $dest_path);
		}
  
		// Copia lo screenshot solo se il file sorgente esiste
		if (file_exists($child_screenshot_path )) {
			copy($child_screenshot_path , $child_dest_path);
		}


      // Costruisci il footer admin con le informazioni dinamiche sull'agenzia
      $footer_text = '<span id="footer-thankyou">Developed by <a href="' . $agency['agency_url'] . '" target="_blank">' . $agency['agency'] . '</a> with ' . $agency['theme'] . '. Powered by <a href="' . $agency['grit_url'] . '" target="_blank">' . $agency['grit'] . '</a>.</span>';

      // Stampa il footer admin
      echo $footer_text;
 
  } else {
      // Messaggio di errore se il file JSON non è stato decodificato correttamente
      echo '<span id="footer-thankyou">Errore: impossibile caricare le informazioni sull\'agenzia.</span>';
  }
}

// Aggiungi la tua funzione di filtro
add_filter('admin_footer_text', 'remove_footer_admin');


function update_theme_credits() {
  // Percorso del file JSON
  $json_file_path = get_template_directory() . '/assets/credits/credits.json';

  // Leggi il contenuto del file JSON
  $json_data = file_get_contents($json_file_path);

  // Decodifica il contenuto JSON in un array associativo
  $data = json_decode($json_data, true);

  // Controlla se la decodifica è avvenuta con successo
  if ($data !== null && isset($data['agency'][0])) {
      // Accesso alle informazioni sull'agenzia
      $agency = $data['agency'][0]; // Prendi il primo elemento dell'array "agency" 
       

      // Stampa il console log con i dati presi dal JSON
  echo '<script>';
  echo 'console.log("© ' . $agency['client'] . '. Tutti i diritti sono riservati");'; 
  echo 'console.log("Developed by %c' . $agency['agency'] . '%c with ' . $agency['theme'] . '. Powered by ' . $agency['grit'] . '.", "color: #3ABEB9; font-weight:600;", "");';   
  echo 'console.log("' . $agency['grit_url'] . '");'; 
  echo '</script>';

  $theme = wp_get_theme();
  $theme_name = $agency['theme']; // Supponendo che $agency['theme'] sia stato definito correttamente
  $theme_version = $theme->get('Version');

  if (is_child_theme()) {
      // Recupera il tema genitore se è un tema child
      $theme_parent = wp_get_theme()->parent();
      
      // Controlla se il tema genitore esiste
      if ($theme_parent) {
          $theme_parent_name = $agency['theme'] . ' Child';
          $theme_parent_version = $theme_parent->get('Version');
          ?>
          <script>
            console.log('<?php echo $theme_name . ' ' . $theme_parent_version . ' => ' . $theme_parent_name . ' ' . $theme_version; ?>');
          </script>
          <?php
      } else {
          // Gestisci il caso in cui il tema genitore non esiste (cosa improbabile)
          ?>
          <script>
              console.error('Errore: Il tema genitore non è stato trovato.');
          </script>
          <?php
      }
  } else {
      ?>
      <script>
          console.log('<?php echo $theme_name . ' -- ' . $theme_version; ?>');
      </script>
      <?php
  }
  } else {
      // Messaggio di errore se il file JSON non è stato decodificato correttamente
      echo '<script>';
      echo 'console.error("Errore: impossibile recuperare i dati dal file JSON.");'; 
      echo '</script>';
  }
}

// Aggiungi lo script alla coda dei file JavaScript
add_action('wp_footer', 'update_theme_credits');





/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * GRIT_SET Remove anused metaboxes from dashboard
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function remove_dashboard_widgets()
{
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;    
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::    * GRIT_SET Breadcrumbs
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function breadcrumbs() {
  /* === OPTIONS === */
  $text['home']     = 'Home'; // text for the 'Home' link
  $text['category'] = 'Archive by Category "%s"'; // text for a category page
  $text['search']   = 'Search Results for "%s" Query'; // text for a search results page
  $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
  $text['author']   = 'Articles Posted by %s'; // text for an author page
  $text['404']      = 'Error 404'; // text for the 404 page
  $text['page']     = 'Page %s'; // text 'Page N'
  $text['cpage']    = 'Comment Page %s'; // text 'Comment Page N'
  $wrap_before    = '<ol class="breadcrumb"><div class="container">'; // the opening wrapper tag
  $wrap_after     = '</div></ol><!-- .breadcrumbs -->'; // the closing wrapper tag
  $sep            = '›'; // separator between crumbs
  $sep_before     = '<span class="sep">'; // tag before separator
  $sep_after      = '</span>'; // tag after separator
  $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
  $show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $show_current   = 1; // 1 - show current page title, 0 - don't show
  $before         = '<span class="active">'; // tag before the current crumb
  $after          = '</span>'; // tag after the current crumb
  /* === END OF OPTIONS === */
  global $post;
  $home_link      = home_url('/');
  $link_before    = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
  $link_after     = '</span>';
  $link_attr      = ' itemprop="url"';
  $link_in_before = '<span itemprop="title">';
  $link_in_after  = '</span>';
  $link           = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
  $frontpage_id   = get_option('page_on_front');
  $parent_id      = $post->post_parent;
  $sep            = ' ' . $sep_before . $sep . $sep_after . ' ';
  if (is_home() || is_front_page()) {
    if ($show_on_home) echo $wrap_before . '<a href="' . $home_link . '">' . $text['home'] . '</a>' . $wrap_after;
  } else {
    echo $wrap_before;
    if ($show_home_link) echo sprintf($link, $home_link, $text['home']);
    if ( is_category() ) {
      $cat = get_category(get_query_var('cat'), false);
      if ($cat->parent != 0) {
        $cats = get_category_parents($cat->parent, TRUE, $sep);
        $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        if ($show_home_link) echo $sep;
        echo $cats;
      }
      if ( get_query_var('paged') ) {
        $cat = $cat->cat_ID;
        echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
      }
    } elseif ( is_search() ) {
      if (have_posts()) {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['search'], get_search_query()) . $after;
      } else {
        if ($show_home_link) echo $sep;
        echo $before . sprintf($text['search'], get_search_query()) . $after;
      }
    } elseif ( is_day() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $sep;
      echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
      if ($show_current) echo $sep . $before . get_the_time('d') . $after;
    } elseif ( is_month() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
      if ($show_current) echo $sep . $before . get_the_time('F') . $after;
    } elseif ( is_year() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . get_the_time('Y') . $after;
    } elseif ( is_single() && !is_attachment() ) {
      if ($show_home_link) echo $sep;
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($show_current) echo $sep . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $sep);
        if (!$show_current || get_query_var('cpage')) $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        echo $cats;
        if ( get_query_var('cpage') ) {
          echo $sep . sprintf($link, get_permalink(), get_the_title()) . $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
        } else {
          if ($show_current) echo $before . get_the_title() . $after;
        }
      }
    // custom post type
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      if ( get_query_var('paged') ) {
        echo $sep . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . $post_type->label . $after;
      }
    } elseif ( is_attachment() ) {
      if ($show_home_link) echo $sep;
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $sep);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current) echo $sep . $before . get_the_title() . $after;
    } elseif ( is_page() && !$parent_id ) {
      if ($show_current) echo $sep . $before . get_the_title() . $after;
    } elseif ( is_page() && $parent_id ) {
      if ($show_home_link) echo $sep;
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $sep;
        }
      }
      if ($show_current) echo $sep . $before . get_the_title() . $after;
    } elseif ( is_tag() ) {
      if ( get_query_var('paged') ) {
        $tag_id = get_queried_object_id();
        $tag = get_tag($tag_id);
        echo $sep . sprintf($link, get_tag_link($tag_id), $tag->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
      }
    } elseif ( is_author() ) {
      global $author;
      $author = get_userdata($author);
      if ( get_query_var('paged') ) {
        if ($show_home_link) echo $sep;
        echo sprintf($link, get_author_posts_url($author->ID), $author->display_name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
      }
    } elseif ( is_404() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . $text['404'] . $after;
    } elseif ( has_post_format() && !is_singular() ) {
      if ($show_home_link) echo $sep;
      echo get_post_format_string( get_post_format() );
    }
    echo $wrap_after;
  }
} // end of breadcrumbs()



function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/*
 * GRIT_SET Responsive section images — legend
 * 01 | Shared Owl sizes calculation and responsive overrides
 * 02 | Gallery thumbnail attributes
 * 03 | Text chapter thumbnail attributes
 */

// * GRIT_SET 01 | Share item counts and autoWidth handling across image helpers
function grit_carousel_image_sizes($section_classes, $defaults) {
    $breakpoints = array('base' => 0, 'sm' => 576, 'md' => 768, 'lg' => 992, 'xl' => 1200, 'xxl' => 1400);
    $overrides = array();
    $width_overrides = array();
    $tokens = preg_split('/\s+/', trim($section_classes));
    sort($tokens);
    foreach ($tokens as $token) {
        if (preg_match('/^carousel-items-(?:(sm|md|lg|xl|xxl)-)?(\d+(?:p\d+)?)$/', $token, $match)) {
            $count = (float) str_replace('p', '.', $match[2]);
            if ($count >= 1) {
                $overrides[$breakpoints[!empty($match[1]) ? $match[1] : 'base']] = $count;
            }
        } elseif (preg_match('/^carousel-(no-)?auto-width(?:-(sm|md|lg|xl|xxl))?$/', $token, $match)) {
            $width_overrides[$breakpoints[!empty($match[2]) ? $match[2] : 'base']] = empty($match[1]);
        }
    }
    $rules = array();
    $count = null;
    $auto_width = false;
    foreach ($defaults as $bp => $default) {
        if (isset($overrides[$bp])) $count = $overrides[$bp];
        if (isset($width_overrides[$bp])) $auto_width = $width_overrides[$bp];
        // Viewport estimates are conservative for contained sections, margins and stage padding.
        $width = $auto_width ? 100 : round(100 / ($count !== null ? $count : $default), 3);
        $rules[$bp] = ($bp ? '(min-width: ' . $bp . 'px) ' : '') . $width . 'vw';
    }
    krsort($rules);
    return implode(', ', $rules);
}

// * GRIT_SET 02 | Preserve Gallery animation attributes and WordPress srcset generation
function grit_gallery_carousel_image($attachment_id, $section_classes = '') {
    return wp_get_attachment_image(absint($attachment_id), 'large', false, array(
        'class' => 'img-fluid in__animate',
        'data-animation' => 'animate__fadeIn animate__faster',
        'sizes' => grit_carousel_image_sizes($section_classes, array(0 => 1, 576 => 2, 768 => 3, 992 => 4, 1200 => 5, 1400 => 5)),
    ));
}

// * GRIT_SET 03 | Use text carousel defaults; static layouts keep a conservative sizes estimate
function grit_text_chapter_image($attachment_id, $image_class, $is_carousel = false, $section_classes = '') {
    $sizes = $is_carousel
        ? grit_carousel_image_sizes($section_classes, array(0 => 1, 576 => 2, 768 => 3, 992 => 3, 1200 => 4, 1400 => 4))
        : '100vw';
    return wp_get_attachment_image(absint($attachment_id), 'large', false, array('class' => $image_class, 'sizes' => $sizes));
}

// * GRIT_SET Shortcodes legend
// 01 | Counter: value normalization, accessible output and animation attributes.
// 02 | Contacts: public Theme Fields, independent links and custom inline labels.
// 03 | Video: source validation and reusable Timber player.

// * GRIT_SET 01 | Counter
// * GRIT_SET Counter values accept plain decimals, never ambiguous thousands separators
function grit_counter_value($raw) {
    $text = trim((string) $raw);
    $result = array('valid' => false, 'formatted' => $text);
    if (!preg_match('/^[+-]?\d+(?:[.,]\d+)?$/D', $text)) return $result;
    $canonical = str_replace(',', '.', $text);
    $value = (float) $canonical;
    $dot = strpos($canonical, '.');
    $decimals = $dot === false ? 0 : strlen($canonical) - $dot - 1;
    // Keep animation within reliable JavaScript number precision and formatting limits.
    if (!is_finite($value) || abs($value) > 9007199254740991 || $decimals > 6) return $result;
    return array('valid' => true, 'value' => $canonical, 'decimals' => $decimals, 'formatted' => number_format_i18n($value, $decimals));
}

// * GRIT_SET Standalone Counter shortcode: reusable in content and formatted ACF WYSIWYG
function grit_counter_shortcode($attributes) {
    $attributes = shortcode_atts(array(
        'number' => '0', 'prefix' => '', 'suffix' => '', 'duration' => '3000',
        'repeat' => 'false', 'animate' => 'true', 'tag' => 'span', 'class' => '',
    ), $attributes, 'grit_counter');
    $number = grit_counter_value($attributes['number']);
    $tag = in_array($attributes['tag'], array('span', 'p', 'div', 'h2', 'h3', 'h4'), true) ? $attributes['tag'] : 'span';
    $duration = is_numeric($attributes['duration']) ? max(0, min(60000, (int) $attributes['duration'])) : 3000;
    $repeat = in_array(strtolower((string) $attributes['repeat']), array('1', 'true', 'yes', 'on'), true);
    $animate = !in_array(strtolower((string) $attributes['animate']), array('0', 'false', 'no', 'off'), true);
    $html = '<' . $tag . ' class="grit-counter ' . esc_attr($attributes['class']) . '">';
    if ($attributes['prefix'] !== '') $html .= esc_html($attributes['prefix']) . ' ';
    if ($number['valid']) {
        $html .= '<span class="sr-only">' . esc_html($number['formatted']) . '</span>';
        $html .= '<span class="number-animate" aria-hidden="true" data-counter-end="' . esc_attr($number['value']) . '" data-counter-decimals="' . $number['decimals'] . '" data-counter-duration="' . $duration . '" data-counter-repeat="' . ($repeat ? 'true' : 'false') . '" data-counter-animate="' . ($animate ? 'true' : 'false') . '">' . esc_html($number['formatted']) . '</span>';
    } else {
        $html .= esc_html($number['formatted']);
    }
    if ($attributes['suffix'] !== '') $html .= ' ' . esc_html($attributes['suffix']);
    return $html . '</' . $tag . '>';
}
add_shortcode('grit_counter', 'grit_counter_shortcode');

// * GRIT_SET 02 | Contacts
// * GRIT_SET Contacts legend: 01 allowed Theme Fields; 02 single value.

// * GRIT_SET 01 | Only public business/contact fields can be requested by shortcodes.
function grit_contact_fields() {
    return [
        'intestazione' => 'company', 'piva' => 'company', 'rea' => 'company', 'cap_soc' => 'company',
        'indirizzo_1' => 'address', 'indirizzo_2' => 'address', 'indirizzo_3' => 'address',
        'tel_1' => 'phone', 'tel_2' => 'phone', 'tel_3' => 'phone', 'fax' => 'fax',
        'mail_1' => 'email', 'mail_2' => 'email', 'mail_3' => 'email',
        'facebook' => 'social', 'instagram' => 'social', 'linkedin' => 'social', 'tiktok' => 'social',
    ];
}

// * GRIT_SET 02 | Missing fields render nothing; labels/classes never replace the stored value.
function grit_contact_shortcode($attributes) {
    $a = shortcode_atts(['field' => '', 'label' => '', 'class' => '', 'tag' => 'span',
        'link' => 'true'], $attributes, 'grit_contact');
    $fields = grit_contact_fields();
    $field = sanitize_key($a['field']);
    if (!isset($fields[$field])) return '';
    $value = trim((string) get_theme_mod('grit_setting_' . $field, ''));
    if ($value === '') return '';
    $type = $fields[$field];
    $href = '';
    if ($type === 'phone') {
        $phone = preg_replace('/[^0-9+]/', '', $value);
        if (preg_match('/^\+?[0-9]+$/', $phone)) $href = 'tel:' . $phone;
    } elseif ($type === 'address') {
        // * GRIT_SET Address directions | Encode the saved address as a query value.
        $href = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($value);
    } elseif ($type === 'email') {
        if (is_email($value)) $href = 'mailto:' . $value;
    } elseif ($type === 'social') {
        $href = esc_url($value, ['http', 'https']);
        if (!$href) return '';
    }
    $text = $a['label'] !== '' ? $a['label'] : $value;
    // * GRIT_SET Custom labels | Allow inline icons without scripts, events or nested links.
    $content = $a['label'] !== '' ? wp_kses($text, [
        'i' => ['class' => true, 'aria-hidden' => true],
        'span' => ['class' => true, 'aria-hidden' => true],
        'strong' => [],
        'em' => [],
    ]) : esc_html($value);
    if ($href && filter_var($a['link'], FILTER_VALIDATE_BOOLEAN)) {
        $target = ' target="_blank" rel="noopener noreferrer"';
        $content = '<a href="' . esc_url($href, ['http', 'https', 'tel', 'mailto']) . '"' . $target . '>' . $content . '</a>';
    }
    $tag = in_array($a['tag'], ['span', 'p', 'div', 'h2', 'h3', 'h4'], true) ? $a['tag'] : 'span';
    return '<' . $tag . ' class="' . esc_attr(trim('grit-contact grit-contact-' . $field . ' ' . $a['class'])) . '">' . $content . '</' . $tag . '>';
}
add_shortcode('grit_contact', 'grit_contact_shortcode');

// * GRIT_SET 03 | Video
// * GRIT_SET Video source | One active source, native MIME and sanitized iframe embeds.
function grit_video_source($section) {
    if (!empty($section['video_file'])) {
        $file = $section['video_file'];
        $attachment = is_array($file) ? (int) ($file['ID'] ?? $file['id'] ?? 0) : (int) $file;
        $url = is_array($file) ? ($file['url'] ?? '') : wp_get_attachment_url($attachment);
        $mime = $attachment ? get_post_mime_type($attachment) : ($file['mime_type'] ?? '');
        if (!$mime && $url) $mime = wp_check_filetype($url)['type'];
        if ($url && strpos((string) $mime, 'video/') === 0) return ['type' => 'file', 'url' => esc_url($url), 'mime' => $mime];
    }
    $embed = $section['embed'] ?? '';
    if (!$embed) return [];
    if (filter_var($embed, FILTER_VALIDATE_URL)) {
        // * GRIT_SET Known providers require no remote oEmbed request on each shortcode render.
        $parts = wp_parse_url($embed);
        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        parse_str($parts['query'] ?? '', $query);
        $url = '';
        if (in_array($host, ['youtube.com', 'www.youtube.com', 'youtu.be', 'www.youtu.be', 'www.youtube-nocookie.com'], true)) {
            $video_id = strpos($host, 'youtu.be') !== false ? $path : ($query['v'] ?? preg_replace('~^(embed|shorts)/~', '', $path));
            if (is_scalar($video_id) && preg_match('/^[A-Za-z0-9_-]{11}$/D', (string) $video_id)) {
                $url = 'https://www.youtube.com/embed/' . $video_id;
                // Preserve explicit start positions when normalizing a shared YouTube URL.
                $start = $query['start'] ?? $query['t'] ?? '';
                if (is_scalar($start) && preg_match('/^\d+$/D', (string) $start)) {
                    $url = add_query_arg('start', (int) $start, $url);
                } elseif (is_scalar($start) && preg_match('/^(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?$/D', (string) $start, $time) && $start !== '') {
                    $seconds = (int) ($time[1] ?? 0) * 3600 + (int) ($time[2] ?? 0) * 60 + (int) ($time[3] ?? 0);
                    $url = add_query_arg('start', $seconds, $url);
                }
            }
        } elseif (in_array($host, ['vimeo.com', 'www.vimeo.com', 'player.vimeo.com'], true)) {
            $video_path = preg_replace('~^video/~', '', $path);
            if (preg_match('~^(\d+)(?:/([A-Za-z0-9]+))?$~D', $video_path, $vimeo)) {
                $url = 'https://player.vimeo.com/video/' . $vimeo[1];
                // Vimeo unlisted links carry their access hash in either the path or query.
                $hash = $query['h'] ?? ($vimeo[2] ?? '');
                if (is_scalar($hash) && $hash !== '' && preg_match('/^[A-Za-z0-9]+$/D', (string) $hash)) $url = add_query_arg('h', $hash, $url);
            }
        }
        $embed = $url ? '<iframe src="' . esc_url($url) . '" title="Video" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>' : '';
    }
    if (!$embed) return [];
    $allowed = [
        'iframe' => ['src'=>true, 'title'=>true, 'width'=>true, 'height'=>true, 'allow'=>true, 'allowfullscreen'=>true, 'frameborder'=>true, 'loading'=>true, 'referrerpolicy'=>true, 'class'=>true, 'data-src'=>true, 'data-cmplz-src'=>true, 'data-category'=>true, 'data-service'=>true],
        'div'=>['class'=>true], 'p'=>['class'=>true], 'span'=>['class'=>true],
        'a'=>['href'=>true, 'target'=>true, 'rel'=>true],
    ];
    $html = wp_kses($embed, $allowed);
    if (strpos($html, '<iframe') === false) return [];
    if (preg_match('/(?:^|\s)src\s*=\s*["\']([^"\']+)["\']/i', $html, $match)) $url = esc_url(html_entity_decode($match[1], ENT_QUOTES, 'UTF-8'));
    else $url = '';
    return ['type'=>'embed', 'html'=>$html, 'url'=>$url];
}

// * GRIT_SET Video shortcode | Composition belongs to Text; player settings stay local to each shortcode.
function grit_video_shortcode($attributes) {
    $a = shortcode_atts(['file'=>'', 'url'=>'', 'preview'=>'', 'ratio'=>'landscape', 'fit'=>'contain', 'loop'=>'false', 'class'=>''], $attributes, 'grit_video');
    $file = ctype_digit((string) $a['file']) ? (int) $a['file'] : 0;
    $url = esc_url_raw($a['url'], ['http', 'https']);
    $video = grit_video_source(['video_file'=>$file, 'embed'=>$url]);
    if (!$video) return '';
    $preview = ctype_digit((string) $a['preview']) ? (int) $a['preview'] : 0;
    if ($preview && !wp_attachment_is_image($preview)) $preview = 0;
    $ratio = in_array($a['ratio'], ['landscape', 'portrait', 'square'], true) ? $a['ratio'] : 'landscape';
    $classes = 'video-ratio-' . $ratio . ($a['fit'] === 'cover' ? ' video-fit-cover' : '') . ' ' . $a['class'];
    return Timber::compile('partials/video.twig', [
        'video'=>$video, 'preview'=>$preview, 'loop'=>filter_var($a['loop'], FILTER_VALIDATE_BOOLEAN), 'video_classes'=>trim($classes),
    ]);
}
add_shortcode('grit_video', 'grit_video_shortcode');
