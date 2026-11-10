<?php

// * GRIT_SET Legend | Scripts
// Frontend asset loading and external service integrations.
// Options come from core/config.php; component initialization belongs in assets/js/custom.js.
// For a new library used by custom.js, also declare its conditional dependency in section 27.
// 01 | Add prefetching rules
// 02 | Frontend CSS and JavaScript loading
// 03 | Comment reply script
// 04 | Library: Bootstrap 4.6.2 CSS JS
// 05 | Always load Fontawesome
// 06 | Always load Animate CSS
// 07 | Always load Hover CSS
// 08 | Library: GSAP
// 09 | Library: Three.js
// 10 | Library: Lenis
// 11 | Library: Locomotive
// 12 | Library: Lightbox2
// 13 | Library: Fitty
// 14 | Library: ImagesLoaded
// 15 | Library: Masonry
// 16 | Library: Swiper
// 17 | Library: Owl Carousel CSS JS
// 18 | Configurable Jarallax core and extensions
// 19 | Library: NProgress CSS JS
// 20 | Library: Magic Mouse CSS JS
// 21 | Library: Cocoen CSS JS
// 22 | CSS
// 23 | JS
// 24 | Parent theme stylesheet
// 25 | Compiled main stylesheet
// 26 | Custom stylesheet
// 27 | Frontend script and dependencies
// 28 | Google Tag Manager
// 29 | Hotjar Tracking Code

// * GRIT_SET 01 | Add prefetching rules
// Reference: https://authoritywebsiteincome.com/speed-up-wordpress-with-dns-prefetching/

function ism_dns_prefetch()
{
    echo '<meta http-equiv="x-dns-prefetch-control" content="on"><link rel="dns-prefetch" href="//code.jquery.com" />
<link rel="dns-prefetch" href="//fonts.gstatic.com" />
<link rel="dns-prefetch" href="//use.fontawesome.com" />
<link rel="dns-prefetch" href="//www.googletagmanager.com" />';
}

add_action('wp_head', 'ism_dns_prefetch', 0);

// * GRIT_SET 02 | Frontend CSS and JavaScript loading

function grit_scripts()
{

    // * GRIT_SET Use WordPress jQuery and its dependencies without CDN replacements
    wp_enqueue_script('jquery');

    // * GRIT_SET 03 | Comment reply script

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // * GRIT_SET 04 | Library: Bootstrap 4.6.2 CSS JS

    // * GRIT_SET Bootstrap is a structural dependency and is always loaded
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap-4.6.2-dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap-4.6.2-dist/js/bootstrap.bundle.min.js', array('jquery'), '4.6.2', true);

    // * GRIT_SET 05 | Always load Fontawesome

    wp_enqueue_script('fa', 'https://use.fontawesome.com/releases/v5.15.1/js/all.js', array(), '5.15.1', true);
    wp_enqueue_style('fa', 'https://use.fontawesome.com/releases/v5.15.1/css/fontawesome.css');

    // * GRIT_SET 06 | Always load Animate CSS

    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/animate-css/animate.css');
    wp_enqueue_script('viewportchecker', get_template_directory_uri() . '/assets/animate-css/viewportchecker.js');

    // * GRIT_SET 07 | Always load Hover CSS

    wp_enqueue_style('hover', get_template_directory_uri() . '/assets/hover-css/css/hover.css');

    // * GRIT_SET 08 | Library: GSAP
    // Reference: https://github.com/greensock/GSAP

    if ($GLOBALS['assets_options']['GRIT_SETTING_GSAP']) {
        wp_enqueue_script('gsap-core', get_template_directory_uri() . '/assets/gsap/gsap.min.js', array(), '3.0.0', false);
    
        // ScrollTrigger powers the theme effects; uncomment optional plugins when needed.
        // wp_enqueue_script('gsap-cssruleplugin', get_template_directory_uri() . '/assets/gsap/CSSRulePlugin.min.js', array('gsap-core'), '3.0.0', false);
        wp_enqueue_script('gsap-scrolltrigger', get_template_directory_uri() . '/assets/gsap/ScrollTrigger.min.js', array('gsap-core'), '3.0.0', false);
        // wp_enqueue_script('gsap-scrolltoplugin', get_template_directory_uri() . '/assets/gsap/ScrollToPlugin.min.js', array('gsap-core'), '3.0.0', false);
        //wp_enqueue_script('gsap-gsdevtools', get_template_directory_uri() . '/assets/gsap/gsdevtools.js', array(), '1.0.0', true);    
    }

    // * GRIT_SET 09 | Library: Three.js

    if ($GLOBALS['assets_options']['GRIT_SETTING_THREE']) {
        wp_enqueue_script('three', get_template_directory_uri() . '/assets/three/three.min.js', array(), '1.0.0', true);
    }

    // * GRIT_SET 10 | Library: Lenis
    // Reference: https://github.com/darkroomengineering/lenis

    if ($GLOBALS['assets_options']['GRIT_SETTING_LENIS']) { 
        wp_enqueue_script('lenis', 'https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js'); 
    }

    // * GRIT_SET 11 | Library: Locomotive
    // Reference: https://github.com/locomotivemtl/locomotive-scroll

    if ($GLOBALS['assets_options']['GRIT_SETTING_LOCOMOTIVE']) {

        wp_enqueue_style('locomotive', 'https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.css' );
        wp_enqueue_script('locomotive', 'https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js'); 
    }

    // * GRIT_SET 12 | Library: Lightbox2
    // Reference: https://lokeshdhakar.com/projects/lightbox2/

    if ($GLOBALS['assets_options']['GRIT_SETTING_LIGHTBOX2']) {

        wp_enqueue_script('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js ' );
        wp_enqueue_style('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css'); 
    }

    // * GRIT_SET 13 | Library: Fitty
    // Reference: https://rikschennink.github.io/fitty/

    if ($GLOBALS['assets_options']['GRIT_SETTING_FITTY']) {
        wp_enqueue_script('fitty', get_template_directory_uri() . '/assets/fitty/fitty.min.js', array(), '1.0.0', true);
    }

    // * GRIT_SET 14 | Library: ImagesLoaded
    // Reference: https://imagesloaded.desandro.com/

    if ($GLOBALS['assets_options']['GRIT_SETTING_IMAGESLOADED']) {
        wp_enqueue_script('imagesloaded', get_template_directory_uri() . '/assets/imagesloaded/imagesloaded.pkgd.min.js', array(), '1.0.0', true);
    }

    // * GRIT_SET 15 | Library: Masonry
    // Reference: https://masonry.desandro.com

    if ($GLOBALS['assets_options']['GRIT_SETTING_MASONRY']) {
        wp_enqueue_script('masonry', get_template_directory_uri() . '/assets/masonry/masonry.js', array(), '1.0.0', true);
    }
 
    // * GRIT_SET 16 | Library: Swiper
    // Reference: https://swiperjs.com/get-started

    if ($GLOBALS['assets_options']['GRIT_SETTING_SWIPER']) {
        wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/swiper/swiper-bundle.min.js', array(), '1.0.0', true);
    }

    // * GRIT_SET 17 | Library: Owl Carousel CSS JS

    if ($GLOBALS['assets_options']['GRIT_SETTING_OWL_CAROUSEL']) {
        wp_enqueue_style('owl_carousel', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.css');
        wp_enqueue_script('owl_carousel', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.js', array('jquery'), '2.3.4', true);
    }

    // * GRIT_SET 18 | Configurable Jarallax core and extensions
    // Reference: https://github.com/nk-o/jarallax

    // * GRIT_SET One Jarallax switch controls core, Video and Element together
    if ($GLOBALS['assets_options']['GRIT_SETTING_JARALLAX']) {
        wp_enqueue_style('jarallax', get_template_directory_uri() . '/assets/jarallax-master/dist/jarallax.css');
        wp_enqueue_script('jarallax', get_template_directory_uri() . '/assets/jarallax-master/dist/jarallax.js', array('jquery'), '', true);
        wp_enqueue_script('jarallax_video', get_template_directory_uri() . '/assets/jarallax-master/dist/jarallax-video.js', array('jarallax'), '', true);
        wp_enqueue_script('jarallax_elements', get_template_directory_uri() . '/assets/jarallax-master/dist/jarallax-element.js', array('jarallax'), '', true);
    }

    // * GRIT_SET 19 | Library: NProgress CSS JS
    // Reference: https://ricostacruz.com/nprogress/

    if ($GLOBALS['assets_options']['GRIT_SETTING_NPROGRESS']) {
        wp_enqueue_style('nprogress', get_template_directory_uri() . '/assets/nprogress/nprogress.css');
        wp_enqueue_script('nprogress', get_template_directory_uri() . '/assets/nprogress/nprogress.js');
    }

    // * GRIT_SET 20 | Library: Magic Mouse CSS JS

    if ($GLOBALS['assets_options']['GRIT_SETTING_MAGIC_MOUSE']) {
        wp_enqueue_style('magic-mouse', get_template_directory_uri() . '/assets/magic-mouse-js/magic-mouse.css');
        wp_enqueue_script('magic-mouse', get_template_directory_uri() . '/assets/magic-mouse-js/magic_mouse.js');
    }

    // * GRIT_SET 21 | Library: Cocoen CSS JS

    if ($GLOBALS['assets_options']['GRIT_SETTING_COCOEN']) {
        wp_enqueue_style('cocoen', get_template_directory_uri() . '/assets/cocoen/css/cocoen.min.css');
        wp_enqueue_script('cocoen', get_template_directory_uri() . '/assets/cocoen/js/cocoen.min.js');
    }

    // * GRIT_SET 22 | CSS

    foreach ($GLOBALS['GRIT_SETTING_CSS'] as $nome => $percorso) {
        wp_enqueue_style($nome, $percorso);
    }

    // * GRIT_SET 23 | JS

    foreach ($GLOBALS['GRIT_SETTING_JS'] as $nome => $percorso) {
        wp_enqueue_script($nome, $percorso, NULL, NULL, true);
    }

}

add_action('wp_enqueue_scripts', 'grit_scripts', 100);

function grit_scripts_custom()
{
    // * GRIT_SET 24 | Parent theme stylesheet

    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');

    // * GRIT_SET 25 | Compiled main stylesheet

    wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime(get_template_directory() . '/assets/css/main.css'));

    // * GRIT_SET 26 | Custom stylesheet

    wp_enqueue_style('custom', get_template_directory_uri() . '/assets/css/custom.css');

    // * GRIT_SET 27 | Frontend script and dependencies

    // * GRIT_SET Load one local List.js copy before the shared frontend initializer
    $grit_script_dependencies = array('jquery');
    if ($GLOBALS['assets_options']['GRIT_SETTING_LIST']) {
        wp_register_script('grit-list', get_template_directory_uri() . '/assets/list-js/list.min.js', array(), '2.3.1', true);
        $grit_script_dependencies[] = 'grit-list';
    }
    if (wp_script_is('jarallax', 'enqueued')) {
        $grit_script_dependencies[] = 'jarallax';
    }
    if (wp_script_is('bootstrap', 'enqueued')) {
        $grit_script_dependencies[] = 'bootstrap';
    }
    // * GRIT_SET Optional motion/layout libraries must precede their initializer
    foreach (array('owl_carousel', 'gsap-core', 'gsap-scrolltrigger', 'lenis', 'imagesloaded', 'masonry') as $grit_dependency) {
        if (wp_script_is($grit_dependency, 'enqueued')) {
            $grit_script_dependencies[] = $grit_dependency;
        }
    }
    wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/custom.js', $grit_script_dependencies, filemtime(get_template_directory() . '/assets/js/custom.js'), true);

}

add_action('wp_enqueue_scripts', 'grit_scripts_custom', 110);

// * GRIT_SET 28 | Google Tag Manager

// Accept container IDs only; Google Analytics measurement IDs use a different integration.
function grit_sanitize_gtm_id($value) {
    $value = is_string($value) ? strtoupper(trim($value)) : '';
    return preg_match('/^GTM-[A-Z0-9]+$/D', $value) ? $value : '';
}

// Resolve at render time so plugin configuration and Customizer previews are available.
function grit_theme_gtm_id() {
    // Respect delegated loading even if Complianz is still awaiting consent/configuration.
    if (function_exists('cmplz_get_option')
        && cmplz_get_option('compile_statistics') === 'google-tag-manager'
        && cmplz_get_option('configuration_by_complianz') === 'yes') {
        return '';
    }
    return grit_sanitize_gtm_id(get_theme_mod('grit_setting_gtag', ''));
}

function grit_gtag_head_analytics() {
    $container_id = grit_theme_gtm_id();
    if ($container_id === '') {
        return;
    }
    ?>
    <!-- Google Tag Manager: theme fallback -->
    <script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', <?php echo wp_json_encode($container_id); ?>);</script>
    <!-- End Google Tag Manager -->
    <?php
}
add_action('wp_head', 'grit_gtag_head_analytics', 20);

function grit_gtag_body_analytics() {
    $container_id = grit_theme_gtm_id();
    if ($container_id === '') {
        return;
    }
    ?>
    <!-- Google Tag Manager (noscript): theme fallback -->
    <noscript><iframe src="<?php echo esc_url('https://www.googletagmanager.com/ns.html?id=' . $container_id); ?>"
        height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action('wp_body_open', 'grit_gtag_body_analytics', 20);

// * GRIT_SET 29 | Hotjar Tracking Code

if (get_theme_mod('grit_setting_hotjar') != '') {
    function grit_hotjar_analytics()
    { ?>
        <!-- Hotjar Tracking Code -->
        <script>

            (function (h, o, t, j, a, r) {
                h.hj = h.hj || function () {
                    (h.hj.q = h.hj.q || []).push(arguments)
                };
                h._hjSettings = {hjid:<?php echo get_theme_mod('grit_setting_hotjar'); ?>, hjsv: 5};
                a = o.getElementsByTagName('head')[0];
                r = o.createElement('script');
                r.async = 1;
                r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
                a.appendChild(r);
            })(window, document, '//static.hotjar.com/c/hotjar-', '.js?sv=');
        </script>
    <?php }

    add_action('wp_footer', 'grit_hotjar_analytics', 20);
}

 