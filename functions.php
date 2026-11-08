<?php

// * GRIT_SET Legend | Theme bootstrap
// 01 | Load core modules (reusable helpers are in core/extras.php)
// 02 | Load Composer/Timber and configure Twig
// 03 | Shared context, theme supports and Twig extensions
// 04 | WooCommerce support and site initialization

// * GRIT_SET Agency selection | Match an agency_folder in assets/credits/credits.json.
// Available: gritlab, astratto, poliedro. A child theme may define this before the parent loads.
if (!defined('GRIT_AGENCY')) {
    define('GRIT_AGENCY', 'gritlab');
}

// * GRIT_SET 01 | Modules support child-theme overrides; missing files produce an error.

$grit_includes = array(
	'core/plugins.php',                           // Plugins
	'core/init.php',                              // Initial theme setup and constants
	'core/utils.php',                             // Utilities
	// 'core/wrapper.php',                           // Theme wrapper class
	'core/config.php',                            // Configuration
	'core/activation.php',                        // Theme activation
	'core/nav.php',                               // Custom nav modifications
	'core/scripts.php',                           // Scripts and stylesheets
	'core/write.php',                             // Writing something on files
	'core/extras.php',                            // Reusable helpers, shortcodes and plugin integrations
	'core/customizer.php',                        // Customize your layout
	'core/security.php',                          // Some security utils
	'core/admin-customizer.php',                  // Admin customize
	// 'core/woocommerce.php',                    // Optional WooCommerce customizations
);

// Load each module from the include list above.
foreach ($grit_includes as $file) {
	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion', 'grit'), $file), E_USER_ERROR);
	}
	require_once $filepath;
}
unset($file, $filepath);

/**
* Timber starter-theme
* https://github.com/timber/starter-theme
*
* @package  WordPress
* @subpackage  Timber
* @since   Timber 0.1
*/

// * GRIT_SET 02 | Load the installed Composer dependencies and initialize Timber.
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

// Show the existing fallback if Timber is unavailable.
if ( ! class_exists( 'Timber' ) ) {
	
	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);
	
	add_filter(
		'template_include',
		function( $template ) {
			return get_template_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
* Sets the directories (inside your theme) to find .twig files
*/
Timber::$dirname = array( 'templates', 'views' );

// Autoescaping is disabled here; templates escape values according to their output context.
Timber::$autoescape = false;

// * GRIT_SET 03 | Site context, WordPress theme supports and Twig extensions.
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {
		
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {
		
	}
	
	// * GRIT_SET Shared context legend
	// 01 | Site identity and logo
	// 02 | Registered menu locations
	// 03 | Theme paths and compatibility aliases
	// 04 | Footer widgets, sidebar and layout choices
	// 05 | Google Fonts URLs and readable family names
	// 06 | Public company/contact fields
	// Current post, content, heading and archive/related queries belong to the root PHP controllers.
	public function add_to_context($context) {
		// * GRIT_SET 01 | The public home URL may differ from the WordPress installation URL.
		$context['site'] = $this;
		// Active agency: validated branding from assets/credits/credits.json.
		$context['agency'] = grit_agency_data();
		$context['home'] = home_url();
		$custom_logo_id = get_theme_mod('custom_logo');
		$context['custom_logo_url'] = wp_get_attachment_image_src($custom_logo_id, 'full');

		// * GRIT_SET 02 | Locations keep their assigned menu even when its display name changes.
		// Named fallbacks preserve old installations without assigned locations.
		$context['primary_menu'] = new Timber\Menu(has_nav_menu('primary_navigation') ? 'primary_navigation' : 'Primary Navigation');
		$context['secondary_menu'] = new Timber\Menu(has_nav_menu('secondary_navigation') ? 'secondary_navigation' : 'Secondary Navigation');
		$context['mobile_menu'] = new Timber\Menu(has_nav_menu('mobile_navigation') ? 'mobile_navigation' : 'Mobile Navigation');
		$context['footer_menu'] = new Timber\Menu(has_nav_menu('footer_navigation') ? 'footer_navigation' : 'Footer Navigation');
		$context['bio_menu'] = has_nav_menu('bio_navigation') ? new Timber\Menu('bio_navigation') : null;

		// * GRIT_SET 03 | Parent theme assets and active child theme assets are distinct paths.
		$theme_url = get_template_directory_uri();
		$context['template_directory_uri'] = $theme_url;
		$context['stylesheet_directory_uri'] = get_stylesheet_directory_uri();
		// Retained aliases for custom Twig content and future project layouts.
		$context['tema_url'] = $theme_url;
		$context['urltema'] = $theme_url;

		// * GRIT_SET 04 | Shared visible widget areas; pre_footer remains registered but is not rendered.
		$context['footer_col_1'] = Timber::get_widgets('footer_col_1');
		$context['footer_col_2'] = Timber::get_widgets('footer_col_2');
		$context['footer_col_3'] = Timber::get_widgets('footer_col_3');
		$context['footer_col_4'] = Timber::get_widgets('footer_col_4');
		$context['footer_bottom'] = Timber::get_widgets('footer_bottom');
		$context['sidebar_primary'] = Timber::get_widgets('sidebar_primary');
		$context['grit_setting_header'] = get_theme_mod('grit_setting_header', 'header_1');
		$context['grit_setting_footer'] = get_theme_mod('grit_setting_footer', 'footer_1');

		// * GRIT_SET 05 | One URL per line; support classic family=A|B and repeated family= parameters.
		$font_urls = preg_split('/\R/', (string) get_theme_mod('grit_setting_google_fonts', ''));
		$context['setting_google_fonts'] = array_values(array_filter(array_map('trim', $font_urls)));
		$font_names = [];
		foreach ($context['setting_google_fonts'] as $url) {
			preg_match_all('/[?&]family=([^&]+)/', html_entity_decode($url, ENT_QUOTES, 'UTF-8'), $matches);
			foreach ($matches[1] as $encoded_family) {
				foreach (explode('|', urldecode($encoded_family)) as $family) {
					$name = trim(explode(':', $family, 2)[0]);
					$name = preg_replace('/[^\p{L}\p{N} -]/u', '', $name);
					if ($name !== '' && !in_array($name, $font_names, true)) {
						$font_names[] = $name;
					}
				}
			}
		}
		$context['setting_google_font_names'] = $font_names;

		// * GRIT_SET 06 | Public company fields; also available to reusable section layouts.
		$context['setting_intestazione'] = get_theme_mod('grit_setting_intestazione');
		$context['setting_piva'] = get_theme_mod('grit_setting_piva');
		$context['setting_rea'] = get_theme_mod('grit_setting_rea');
		$context['setting_cap_soc'] = get_theme_mod('grit_setting_cap_soc');
		// indirizzo
		$context['setting_indirizzo_1'] = get_theme_mod('grit_setting_indirizzo_1');
		$context['setting_indirizzo_2'] = get_theme_mod('grit_setting_indirizzo_2');
		$context['setting_indirizzo_3'] = get_theme_mod('grit_setting_indirizzo_3');
		// tel
		$context['setting_tel_1'] = get_theme_mod('grit_setting_tel_1');
		$context['setting_tel_2'] = get_theme_mod('grit_setting_tel_2');
		$context['setting_tel_3'] = get_theme_mod('grit_setting_tel_3');
		$context['setting_fax'] = get_theme_mod('grit_setting_fax');
		// mail
		$context['setting_mail_1'] = get_theme_mod('grit_setting_mail_1');
		$context['setting_mail_2'] = get_theme_mod('grit_setting_mail_2');
		$context['setting_mail_3'] = get_theme_mod('grit_setting_mail_3');
		// social
		$context['setting_facebook'] = get_theme_mod('grit_setting_facebook');
		$context['setting_linkedin'] = get_theme_mod('grit_setting_linkedin');
		$context['setting_instagram'] = get_theme_mod('grit_setting_instagram');
		$context['setting_tiktok'] = get_theme_mod('grit_setting_tiktok');
		

		return $context;
	}
	
	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		
		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );
		
		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );
		
		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				)
		);
			
		/*
			* Enable support for Post Formats.
			*
			* See: https://codex.wordpress.org/Post_Formats
			*/
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
				)
			);
			
		add_theme_support( 'menus' );
	}
		
	/** This Would return 'foo bar!'.
	*
	* @param string $text being 'foo', then returned 'foo bar!'.
	*/
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}
	
	/** This is where you can add your own functions to twig.
	*
	* @param string $twig get extension.
	*/
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}
 
}
		
// * GRIT_SET 04 | Declare compatibility; optional shop customizations stay in their core module.
function theme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'theme_add_woocommerce_support' );

new StarterSite();

// Reusable helpers, archive queries and plugin integrations are in core/extras.php.
