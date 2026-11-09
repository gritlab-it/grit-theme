<?php

// * GRIT_SET Legend | Extras
// Shared helpers and WordPress/plugin hooks. Keep presentation in the referenced Twig/SCSS files.
// Find a numbered section below before changing a helper; existing function names are kept for compatibility.
//
// Admin and branding
// 00 | Admin bar visibility
// 01 | Post/page ID columns
// 02 | User profile social links
// 03 | Agency data, assets and credits
// 04 | Dashboard widgets
//
// Images and reusable content
// 05 | Responsive images for Text and Gallery
// 06 | Counter shortcode
// 07 | Contact shortcode
// 08 | Video shortcode
// 09 | Page excerpt support
//
// Plugin and WordPress integrations
// 10 | ACF Google Maps key
// 11 | Legacy search query alias
// 12 | Contact Form 7 page URL tags
// 13 | JSON and SVG upload types
//
// Queries and template data
// 14 | Archive post types and card choices
// 15 | Section Archive: field options, posts, terms and excerpts
// 16 | Native taxonomy archive queries
// 17 | Controller helpers: ACF fields, content and pagination
// 18 | Section Maps: coordinates, styles and locations
// 19 | Policy pages and public URLs

// * GRIT_SET 00 | Admin bar visibility
if (get_theme_mod('grit_adv_adminbar', true)) {
  show_admin_bar( false );
}

// * GRIT_SET 01 | Post/page ID columns

add_filter('manage_posts_columns', 'posts_columns_id', 5);
add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'posts_columns_id', 5);
add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);

// Add the ID column label to the post/page admin tables.
function posts_columns_id($defaults) {
    $defaults['wpam_post_id'] = __('ID', 'grit');
    return $defaults;
}

// Print the numeric ID only in the dedicated admin column.
function posts_custom_id_columns($column_name, $id) {
    if ($column_name === 'wpam_post_id') {
        echo $id;
    }
}

// * GRIT_SET 02 | User profile social links
// Reference: https://laceytechsolutions.co.uk/blog/add-social-media-contact-methods-wordpress-user-profiles/

// User profile links are separate from company contacts configured in Personalizza.
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

// * GRIT_SET 03 | Agency data, assets and credits
// Used by functions.php, core/activation.php and admin branding; edit assets/credits/credits.json for agency details.

// One shared agency record for credits, login branding and setup operations.
// Select GRIT_AGENCY in functions.php; credits.json contains the available agency records.
// Missing/invalid selections fall back to Grit; array order never selects the agency.
function grit_agency_normalize($config, $selected = 'gritlab') {
    $defaults = [
        'client' => '', 'client_url' => '',
        'agency' => 'Grit Lab', 'agency_url' => 'https://www.gritlab.it',
        'agency_folder' => 'gritlab', 'grit' => 'Giorgio Rizza',
        'grit_url' => 'https://www.gritlab.it', 'theme' => 'GRIT Theme', 'color' => '#252422',
    ];
    $records = [];
    foreach (is_array($config['agency'] ?? null) ? $config['agency'] : [] as $record) {
        if (!is_array($record) || !is_string($record['agency_folder'] ?? null)) {
            continue;
        }
        $folder = $record['agency_folder'];
        if (preg_match('/^[a-z0-9_-]+$/D', $folder)) {
            $records[$folder] = $record;
        }
    }
    $selected = is_string($selected) ? $selected : 'gritlab';
    $record = $records[$selected] ?? $records['gritlab'] ?? [];
    $agency = $defaults;
    foreach ($defaults as $key => $fallback) {
        if (isset($record[$key]) && is_string($record[$key]) && trim($record[$key]) !== '') {
            $agency[$key] = sanitize_text_field($record[$key]);
        }
    }
    foreach (['client_url', 'agency_url', 'grit_url'] as $key) {
        $agency[$key] = esc_url_raw($agency[$key], ['http', 'https']) ?: $defaults[$key];
    }
    $agency['color'] = sanitize_hex_color($agency['color']) ?: $defaults['color'];
    return $agency;
}

// Read once per request. Unreadable files, malformed JSON and invalid records use safe defaults.
function grit_agency_data() {
    static $agency = null;
    if ($agency === null) {
        $path = get_template_directory() . '/assets/credits/credits.json';
        $json = is_readable($path) ? @file_get_contents($path) : false;
        $config = $json !== false ? json_decode($json, true) : [];
        $selected = defined('GRIT_AGENCY') ? GRIT_AGENCY : 'gritlab';
        $agency = grit_agency_normalize(is_array($config) ? $config : [], $selected);
    }
    return $agency;
}

// Resolve known branding files only; each missing custom image falls back to the Grit equivalent.
function grit_agency_asset($filename) {
    if (!in_array($filename, ['logo.png', 'icon.svg', 'screenshot.png', 'screenshot-child.png'], true)) {
        return [];
    }
    $agency = grit_agency_data();
    foreach (array_unique([$agency['agency_folder'], 'gritlab']) as $folder) {
        $relative = '/assets/credits/' . $folder . '/' . $filename;
        $path = get_template_directory() . $relative;
        if (is_file($path) && is_readable($path)) {
            return ['path' => $path, 'url' => get_template_directory_uri() . $relative];
        }
    }
    return [];
}

// Setup-only operation: do not write theme images while rendering an admin/footer page.
// Return a result per target so callers/tests can distinguish skipped, unchanged and failed writes.
function grit_sync_agency_screenshots() {
    $targets = ['screenshot.png' => get_template_directory() . '/screenshot.png'];
    if (is_child_theme() && get_stylesheet_directory() !== get_template_directory()) {
        $targets['screenshot-child.png'] = get_stylesheet_directory() . '/screenshot.png';
    }
    $results = [];
    foreach ($targets as $filename => $destination) {
        $asset = grit_agency_asset($filename);
        if (!$asset) {
            $results[$filename] = 'missing';
        } elseif (is_file($destination) && sha1_file($asset['path']) === @sha1_file($destination)) {
            $results[$filename] = 'unchanged';
        } elseif ((file_exists($destination) && !is_writable($destination)) || !is_writable(dirname($destination))) {
            $results[$filename] = 'not-writable';
        } else {
            $results[$filename] = @copy($asset['path'], $destination) ? 'updated' : 'failed';
        }
    }
    return $results;
}

// WordPress filters must return their replacement text. Rendering credits never modifies theme files.
function remove_footer_admin($footer_text = '') {
    $agency = grit_agency_data();
    return '<span id="footer-thankyou">Developed by <a href="' . esc_url($agency['agency_url']) . '" target="_blank" rel="noopener noreferrer">' . esc_html($agency['agency']) . '</a> with ' . esc_html($agency['theme']) . '. Powered by <a href="' . esc_url($agency['grit_url']) . '" target="_blank" rel="noopener noreferrer">' . esc_html($agency['grit']) . '</a>.</span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// JSON encoding keeps quotation marks, apostrophes and HTML-like text inside JavaScript strings.
function update_theme_credits() {
    $agency = grit_agency_data();
    $theme = wp_get_theme();
    $messages = [];
    if ($agency['client'] !== '') {
        $messages[] = '© ' . $agency['client'] . '. Tutti i diritti sono riservati';
    }
    $messages[] = 'Developed by ' . $agency['agency'] . ' with ' . $agency['theme'] . '. Powered by ' . $agency['grit'] . '.';
    $messages[] = $agency['grit_url'];
    $parent = $theme->parent();
    $messages[] = $parent
        ? $agency['theme'] . ' ' . $parent->get('Version') . ' => ' . $agency['theme'] . ' Child ' . $theme->get('Version')
        : $agency['theme'] . ' -- ' . $theme->get('Version');
    echo '<script>';
    foreach ($messages as $message) {
        echo 'console.log(' . wp_json_encode($message, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ');';
    }
    echo '</script>';
}
add_action('wp_footer', 'update_theme_credits');


// * GRIT_SET 04 | Dashboard widgets
function remove_dashboard_widgets()
{
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;    
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

// * GRIT_SET 05 | Responsive images for Text and Gallery
// Used by partials/text-chapter.twig and sections/section_gallery.twig; layout styles remain in SCSS.

// Build the HTML sizes attribute from carousel classes. This helps image selection; it does not initialize Owl.
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
    // Overrides carry forward until the next breakpoint; emit largest screens first for HTML sizes.
    $rules = array();
    $count = null;
    $auto_width = false;
    foreach ($defaults as $bp => $default) {
        if (isset($overrides[$bp])) {
            $count = $overrides[$bp];
        }
        if (isset($width_overrides[$bp])) {
            $auto_width = $width_overrides[$bp];
        }
        // Viewport estimates are conservative for contained sections, margins and stage padding.
        $width = $auto_width ? 100 : round(100 / ($count !== null ? $count : $default), 3);
        $rules[$bp] = ($bp ? '(min-width: ' . $bp . 'px) ' : '') . $width . 'vw';
    }
    krsort($rules);
    return implode(', ', $rules);
}

// Render a Gallery image through WordPress so srcset, image metadata and animation attributes are preserved.
function grit_gallery_carousel_image($attachment_id, $section_classes = '') {
    return wp_get_attachment_image(absint($attachment_id), 'large', false, array(
        'class' => 'img-fluid in__animate',
        'data-animation' => 'animate__fadeIn animate__faster',
        'sizes' => grit_carousel_image_sizes($section_classes, array(0 => 1, 576 => 2, 768 => 3, 992 => 4, 1200 => 5, 1400 => 5)),
    ));
}

// Render a Text image; carousel layouts estimate visible item widths, static layouts use 100vw.
function grit_text_chapter_image($attachment_id, $image_class, $is_carousel = false, $section_classes = '') {
    $sizes = $is_carousel
        ? grit_carousel_image_sizes($section_classes, array(0 => 1, 576 => 2, 768 => 3, 992 => 3, 1200 => 4, 1400 => 4))
        : '100vw';
    return wp_get_attachment_image(absint($attachment_id), 'large', false, array('class' => $image_class, 'sizes' => $sizes));
}

// * GRIT_SET 06 | Counter shortcode
// [grit_counter] supplies markup/data; animation is in assets/js/custom.js and styling in _shortcodes.scss.

// Accept one plain decimal number and return its animation value plus a localized display label.
function grit_counter_value($raw) {
    $text = trim((string) $raw);
    $result = array('valid' => false, 'formatted' => $text);
    if (!preg_match('/^[+-]?\d+(?:[.,]\d+)?$/D', $text)) {
        return $result;
    }
    $canonical = str_replace(',', '.', $text);
    $value = (float) $canonical;
    $dot = strpos($canonical, '.');
    $decimals = $dot === false ? 0 : strlen($canonical) - $dot - 1;
    // Keep animation within reliable JavaScript number precision and formatting limits.
    if (!is_finite($value) || abs($value) > 9007199254740991 || $decimals > 6) {
        return $result;
    }
    return array('valid' => true, 'value' => $canonical, 'decimals' => $decimals, 'formatted' => number_format_i18n($value, $decimals));
}

// Render [grit_counter]. Invalid numbers stay readable as text; valid numbers also get animation data.
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

// * GRIT_SET 07 | Contact shortcode
// [grit_contact] reads public Theme Fields from the Customizer; edit the allowlist below to expose another field.

// Public Theme Fields allowlist: each name maps to the kind of link that the shortcode may generate.
function grit_contact_fields() {
    return [
        'intestazione' => 'company', 'piva' => 'company', 'rea' => 'company', 'cap_soc' => 'company',
        'indirizzo_1' => 'address', 'indirizzo_2' => 'address', 'indirizzo_3' => 'address',
        'tel_1' => 'phone', 'tel_2' => 'phone', 'tel_3' => 'phone', 'fax' => 'fax',
        'mail_1' => 'email', 'mail_2' => 'email', 'mail_3' => 'email',
        'facebook' => 'social', 'instagram' => 'social', 'linkedin' => 'social', 'tiktok' => 'social',
    ];
}

// Render one [grit_contact] field. Missing values produce no markup; labels change display text, never the saved value.
function grit_contact_shortcode($attributes) {
    $attributes = shortcode_atts([
        'field' => '',
        'label' => '',
        'class' => '',
        'tag' => 'span',
        'link' => 'true',
    ], $attributes, 'grit_contact');
    $fields = grit_contact_fields();
    $field = sanitize_key($attributes['field']);
    if (!isset($fields[$field])) {
        return '';
    }
    $value = trim((string) get_theme_mod('grit_setting_' . $field, ''));
    if ($value === '') {
        return '';
    }
    $type = $fields[$field];
    $href = '';
    if ($type === 'phone') {
        $phone = preg_replace('/[^0-9+]/', '', $value);
        if (preg_match('/^\+?[0-9]+$/', $phone)) {
            $href = 'tel:' . $phone;
        }
    } elseif ($type === 'address') {
        // * GRIT_SET Address directions | Encode the saved address as a query value.
        $href = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($value);
    } elseif ($type === 'email') {
        if (is_email($value)) {
            $href = 'mailto:' . $value;
        }
    } elseif ($type === 'social') {
        $href = esc_url($value, ['http', 'https']);
        if (!$href) {
            return '';
        }
    }
    $text = $attributes['label'] !== '' ? $attributes['label'] : $value;
    // * GRIT_SET Custom labels | Allow inline icons without scripts, events or nested links.
    $content = $attributes['label'] !== '' ? wp_kses($text, [
        'i' => ['class' => true, 'aria-hidden' => true],
        'span' => ['class' => true, 'aria-hidden' => true],
        'strong' => [],
        'em' => [],
    ]) : esc_html($value);
    if ($href && filter_var($attributes['link'], FILTER_VALIDATE_BOOLEAN)) {
        $target = ' target="_blank" rel="noopener noreferrer"';
        $content = '<a href="' . esc_url($href, ['http', 'https', 'tel', 'mailto']) . '"' . $target . '>' . $content . '</a>';
    }
    $tag = in_array($attributes['tag'], ['span', 'p', 'div', 'h2', 'h3', 'h4'], true) ? $attributes['tag'] : 'span';
    return '<' . $tag . ' class="' . esc_attr(trim('grit-contact grit-contact-' . $field . ' ' . $attributes['class'])) . '">' . $content . '</' . $tag . '>';
}
add_shortcode('grit_contact', 'grit_contact_shortcode');

// * GRIT_SET 08 | Video shortcode
// [grit_video] prepares data for partials/video.twig; playback controls are in assets/js/custom.js.

// Resolve one source: valid local video first, then a supported URL or sanitized iframe. No remote oEmbed request is made.
function grit_video_source($section) {
    if (!empty($section['video_file'])) {
        $file = $section['video_file'];
        $attachment = is_array($file) ? (int) ($file['ID'] ?? $file['id'] ?? 0) : (int) $file;
        $url = is_array($file) ? ($file['url'] ?? '') : wp_get_attachment_url($attachment);
        $mime = $attachment ? get_post_mime_type($attachment) : ($file['mime_type'] ?? '');
        if (!$mime && $url) {
            $mime = wp_check_filetype($url)['type'];
        }
        if ($url && strpos((string) $mime, 'video/') === 0) {
            return ['type' => 'file', 'url' => esc_url($url), 'mime' => $mime];
        }
    }
    $embed = $section['embed'] ?? '';
    if (!$embed) {
        return [];
    }
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
                if (is_scalar($hash) && $hash !== '' && preg_match('/^[A-Za-z0-9]+$/D', (string) $hash)) {
                    $url = add_query_arg('h', $hash, $url);
                }
            }
        }
        $embed = $url ? '<iframe src="' . esc_url($url) . '" title="Video" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>' : '';
    }
    if (!$embed) {
        return [];
    }
    $allowed = [
        'iframe' => ['src'=>true, 'title'=>true, 'width'=>true, 'height'=>true, 'allow'=>true, 'allowfullscreen'=>true, 'frameborder'=>true, 'loading'=>true, 'referrerpolicy'=>true, 'class'=>true, 'data-src'=>true, 'data-cmplz-src'=>true, 'data-category'=>true, 'data-service'=>true],
        'div'=>['class'=>true], 'p'=>['class'=>true], 'span'=>['class'=>true],
        'a'=>['href'=>true, 'target'=>true, 'rel'=>true],
    ];
    // Keep only supported iframe/wrapper attributes; remove scripts and event handlers.
    $html = wp_kses($embed, $allowed);
    if (strpos($html, '<iframe') === false) {
        return [];
    }
    if (preg_match('/(?:^|\s)src\s*=\s*["\']([^"\']+)["\']/i', $html, $match)) {
        $url = esc_url(html_entity_decode($match[1], ENT_QUOTES, 'UTF-8'));
    }
    else $url = '';
    return ['type'=>'embed', 'html'=>$html, 'url'=>$url];
}

// Validate [grit_video] attributes, then pass only the player data to partials/video.twig.
function grit_video_shortcode($attributes) {
    $attributes = shortcode_atts([
        'file' => '',
        'url' => '',
        'preview' => '',
        'ratio' => 'landscape',
        'fit' => 'contain',
        'loop' => 'false',
        'class' => '',
    ], $attributes, 'grit_video');
    $file = ctype_digit((string) $attributes['file']) ? (int) $attributes['file'] : 0;
    $url = esc_url_raw($attributes['url'], ['http', 'https']);
    $video = grit_video_source(['video_file'=>$file, 'embed'=>$url]);
    if (!$video) {
        return '';
    }
    $preview = ctype_digit((string) $attributes['preview']) ? (int) $attributes['preview'] : 0;
    if ($preview && !wp_attachment_is_image($preview)) {
        $preview = 0;
    }
    $ratio = in_array($attributes['ratio'], ['landscape', 'portrait', 'square'], true) ? $attributes['ratio'] : 'landscape';
    $classes = 'video-ratio-' . $ratio . ($attributes['fit'] === 'cover' ? ' video-fit-cover' : '') . ' ' . $attributes['class'];
    return Timber::compile('partials/video.twig', [
        'video'=>$video, 'preview'=>$preview, 'loop'=>filter_var($attributes['loop'], FILTER_VALIDATE_BOOLEAN), 'video_classes'=>trim($classes),
    ]);
}
add_shortcode('grit_video', 'grit_video_shortcode');

// * GRIT_SET 09 | Page excerpt support
add_post_type_support('page', 'excerpt');

// * GRIT_SET 10 | ACF Google Maps key
// This configures the ACF editor field. Frontend map data is prepared in section 18 below.
// Supply the configured Maps key when ACF prepares its Google Map field.
function my_acf_google_map_api($api) {
    $api['key'] = get_theme_mod('grit_setting_maps');
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

// Supply the same Maps key to ACF initialization settings.
function my_acf_init() {
    acf_update_setting('google_api_key', get_theme_mod('grit_setting_maps'));
}
add_action('acf/init', 'my_acf_init');

// * GRIT_SET 11 | Legacy search query alias
// Native ?s= requests remain unchanged.
if (!is_admin()) {
    add_filter('query_vars', function ($vars) {
        $vars[] = 'search_query';
        return $vars;
    });
    add_filter('request', function ($request) {
        if (!isset($request['s']) && isset($request['search_query']) && is_scalar($request['search_query'])) {
            $request['s'] = sanitize_text_field($request['search_query']);
        }
        return $request;
    });
}

// * GRIT_SET 12 | Contact Form 7 page URL tags
// Used by the starter form created in core/activation.php; these filters do not configure email delivery.
// CF7 referer-page: use the browser referrer when supplied; it may legitimately be unavailable.
function getRefererPageForm( $form_tag ) {
    if ( $form_tag['name'] == 'referer-page' ) {
        // The browser may omit HTTP_REFERER.
        if ( isset($_SERVER['HTTP_REFERER']) ) {
            $form_tag['values'][] = htmlspecialchars($_SERVER['HTTP_REFERER']);
        } else {
            // Preserve the existing fallback when no referrer is supplied.
            $form_tag['values'][] = 'No referer';
        }
    }
    return $form_tag;
}
if ( !is_admin() ) {
	add_filter( 'wpcf7_form_tag', 'getRefererPageForm' );
}

// CF7 current-page: fill the tag with the current WordPress request URL.
function getCurrentPageForm($form_tag)
{
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request));

    if ($form_tag['name'] == 'current-page') {
        $form_tag['values'][] = htmlspecialchars($current_url);
    }

    return $form_tag;
}

if (!is_admin()) {
    add_filter('wpcf7_form_tag', 'getCurrentPageForm');
}

// * GRIT_SET 13 | JSON and SVG upload types
// Register JSON and SVG MIME entries; SVG upload sanitization is a separate concern.
function cc_mime_types($mimes)
{
	$mimes['json'] = 'application/json';
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Keep the SVG extension/type recognized during WordPress upload checks.
function allow_svg_mime_types( $data, $file, $filename, $mimes ) {
    $ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
    if ( $ext === 'svg' ) {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    }
    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'allow_svg_mime_types', 10, 4 );

// * GRIT_SET 14 | Archive post types and card choices
// List registered public post types for the Section Archive selector; attachments are excluded.
function grit_archive_public_types() {
    $choices = [];
    foreach (get_post_types(['public' => true], 'objects') as $type) {
        if ($type->name !== 'attachment') {
            $choices[$type->name] = $type->labels->name;
        }
    }
    return $choices;
}
// Discover tease-*.twig files in parent/child themes; hide the product option without its WooCommerce bridge.
function grit_archive_tease_choices() {
    $choices = [];
    foreach (array_unique([get_template_directory(), get_stylesheet_directory()]) as $directory) {
        foreach (glob($directory . '/templates/partials/tease-*.twig') ?: [] as $path) {
            $name = substr(basename($path), 6, -5);
            if ($name === 'term') {
                continue; // Term cards belong to term mode, not the post template selector.
            }
            if ($name === 'product' && (!class_exists('WooCommerce') || !function_exists('timber_set_product'))) {
                continue;
            }
            $choices[$name] = $name;
        }
    }
    return $choices;
}
// * GRIT_SET 15 | Section Archive: field options, posts, terms and excerpts
// Entry point: sections/section.twig; rendering: sections/section_archive.twig and partials/tease-*.twig.

// * GRIT_SET 15.1 | ACF selector options
// Update only post_type, tease and taxonomy fields inside section_archive; identically named fields elsewhere are unchanged.
function grit_archive_admin_field($field) {
    $parent = acf_get_raw_field($field['parent'] ?? 0);
    $is_archive = false;
    foreach ($parent['layouts'] ?? [] as $layout) {
        // ACF supplies the current parent/layout keys; none are hard-coded in this theme.
        $is_current_layout = ($layout['key'] ?? '') === ($field['parent_layout'] ?? '');
        $is_archive_layout = $layout['name'] === 'section_archive';
        if ($is_current_layout && $is_archive_layout) {
            $is_archive = true;
            break;
        }
    }
    if (!$is_archive) {
        return $field;
    }
    // Update the relevant control only after confirming its layout ownership.
    if ($field['name'] === 'post_type') {
        $field['choices'] = grit_archive_public_types();
    } elseif ($field['name'] === 'tease') {
        $field['instructions'] = 'Scrivi il nome senza tease- e senza .twig. Disponibili: ' .
            implode(', ', array_keys(grit_archive_tease_choices())) .
            '. Consigliati: card, vertical, horizontal, compact, text, title, editorial, overlay. Vuoto: template del post type, se disponibile, altrimenti card standard.';
    } elseif ($field['name'] === 'taxonomy') {
        $field['choices'] = [];
        foreach (get_taxonomies(['public' => true], 'objects') as $taxonomy) {
            $field['choices'][$taxonomy->name] = $taxonomy->labels->name . ' (' . $taxonomy->name . ')';
        }
    }
    return $field;
}
foreach (['post_type', 'tease', 'taxonomy'] as $grit_archive_field_name) {
    add_filter('acf/load_field/name=' . $grit_archive_field_name, 'grit_archive_admin_field');
}
unset($grit_archive_field_name);

// * GRIT_SET 15.2 | Posts for Section Archive
// Prepare an independent Section Archive query. Invalid filters return an empty result instead of unrelated posts.
function grit_archive_section_data($section) {
    if (($section['archive_mode'] ?? 'posts') === 'terms') {
        return grit_archive_terms_data($section);
    }
    $empty = ['posts' => [], 'tease' => ''];
    $post_type = sanitize_key($section['post_type'] ?? 'post') ?: 'post';
    if (!isset(grit_archive_public_types()[$post_type])) {
        return $empty;
    }
    $posts_per_page = $section['posts_per_page'] ?? '';
    if ($posts_per_page === '' || $posts_per_page === null || $posts_per_page === false) {
        $posts_per_page = (int) get_option('posts_per_page', 10);
    } else {
        $posts_per_page = (int) $posts_per_page;
    }
    $orderby = $section['orderby'] ?? 'date';
    if (!in_array($orderby, ['date', 'title', 'menu_order'], true)) {
        $orderby = 'date';
    }
    $order = strtoupper($section['order'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';
    // One section shows at most 100 published, unprotected cards; it has no numbered pagination.
    $args = [
        'post_type' => $post_type,
        'post_status' => 'publish',
        'has_password' => false,
        'posts_per_page' => max(1, min(100, $posts_per_page)),
        'no_found_rows' => true,
        'orderby' => [$orderby => $order, 'ID' => $order],
        'ignore_sticky_posts' => true,
    ];
    if (!empty($section['exclude_current']) && is_singular()) {
        $args['post__not_in'] = [(int) get_queried_object_id()];
    }
    // Comma-separated slugs apply only to this taxonomy; any matching term is sufficient (IN).
    $taxonomy = sanitize_key($section['taxonomy'] ?? '');
    $term_slugs = trim((string) ($section['term_slugs'] ?? ''));
    if ($term_slugs !== '') {
        if (!$taxonomy || !is_object_in_taxonomy($post_type, $taxonomy)) {
            return $empty;
        }
        $selected_slugs = array_filter(array_map('sanitize_title', explode(',', $term_slugs)));
        if (!$selected_slugs) {
            return $empty;
        }
        $args['tax_query'] = [['taxonomy' => $taxonomy, 'field' => 'slug', 'terms' => $selected_slugs, 'operator' => 'IN']];
    }
    $tease = sanitize_key($section['tease'] ?? '') ?: $post_type;
    if (!isset(grit_archive_tease_choices()[$tease])) {
        $tease = '';
    }
    return ['posts' => new Timber\PostQuery($args), 'tease' => $tease];
}

// * GRIT_SET 15.3 | Taxonomy terms for Section Archive
function grit_archive_terms_data($section) {
    $empty = ['posts' => [], 'terms' => [], 'mode' => 'terms', 'tease' => ''];
    $taxonomy = sanitize_key($section['taxonomy'] ?? '');
    $object = $taxonomy ? get_taxonomy($taxonomy) : false;
    if (!$object || !$object->public) {
        return $empty;
    }
    $limit = $section['posts_per_page'] ?? '';
    $limit = ($limit === '' || $limit === null || $limit === false) ? (int) get_option('posts_per_page', 10) : (int) $limit;
    $orderby = $section['terms_orderby'] ?? 'name';
    $args = [
        'taxonomy' => $taxonomy,
        'number' => max(1, min(100, $limit)),
        'orderby' => in_array($orderby, ['name', 'count', 'term_id'], true) ? $orderby : 'name',
        'order' => strtoupper($section['order'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC',
        'hide_empty' => !array_key_exists('terms_hide_empty', $section) || !empty($section['terms_hide_empty']),
    ];
    // A parent slug selects direct children only; it takes precedence over root-only mode.
    $parent_slug = trim((string) ($section['terms_parent'] ?? ''));
    if ($parent_slug !== '') {
        $parent = get_term_by('slug', sanitize_title($parent_slug), $taxonomy);
        if (!$object->hierarchical || !$parent) {
            return $empty;
        }
        $args['parent'] = (int) $parent->term_id;
    } elseif (!empty($section['terms_top_level']) && $object->hierarchical) {
        $args['parent'] = 0;
    }
    $terms = get_terms($args);
    if (is_wp_error($terms)) {
        return $empty;
    }
    $items = [];
    foreach ($terms as $term) {
        $link = get_term_link($term);
        if (is_wp_error($link)) {
            continue;
        }
        $items[] = [
            'name' => $term->name,
            'link' => esc_url($link),
            'description' => (!array_key_exists('terms_show_description', $section) || !empty($section['terms_show_description']))
                ? wp_trim_words(wp_strip_all_tags(strip_shortcodes($term->description)), 35, '…') : '',
            // WordPress owns this count; no per-CPT recalculation is performed.
            'count' => (int) $term->count,
        ];
    }
    return array_merge($empty, ['terms' => $items]);
}

// * GRIT_SET 15.4 | Card excerpt text
// Prefer the manual excerpt; otherwise trim raw content without executing shortcodes or content filters.
function grit_archive_excerpt($post, $length = 35) {
    $id = is_object($post) ? (int) $post->ID : (int) $post;
    $excerpt = get_post_field('post_excerpt', $id);
    $text = $excerpt !== '' ? $excerpt : get_post_field('post_content', $id);
    return wp_trim_words(wp_strip_all_tags(strip_shortcodes(strip_tags((string) $text))), max(1, (int) $length), '…');
}

// * GRIT_SET 16 | Native taxonomy archive queries
// Unlike Section Archive, this changes the main WordPress query rendered through archive.php.
// WordPress otherwise limits category/tag archives to standard posts. Run before pagination/404 checks.
// Filter the native main taxonomy query before SQL/pagination. Edit $archive_post_types below to choose visible types.
function grit_taxonomy_archive_post_types($query) {
    if (is_admin() || !$query->is_main_query() || $query->is_search()) {
        return;
    }
    if (!$query->is_category() && !$query->is_tag() && !$query->is_tax()) {
        return;
    }
    $term = $query->get_queried_object();
    if (!($term instanceof WP_Term)) {
        return;
    }
    $taxonomy = get_taxonomy($term->taxonomy);
    if (!$taxonomy) {
        return;
    }

    // * GRIT_SET Archive post types | Edit only this map to choose each taxonomy's content.
    // [] = all associated public types; ['post'] = blog only; ['section'] = sections only.
    // ['post', 'section'] = both. Add custom taxonomies using their registered name.
    // A configured list takes priority over URL post_type filters; it does not change term assignments.
    $archive_post_types = [
        'category' => [],
        'post_tag' => [],
        // 'custom_taxonomy' => ['custom_post_type'],
    ];
    $selected_types = $archive_post_types[$taxonomy->name] ?? [];

    // Automatic mode preserves explicit URL filters and other query customizations.
    if (!$selected_types && $query->get('post_type')) {
        return;
    }

    $post_types = [];
    foreach ($taxonomy->object_type as $name) {
        $type = get_post_type_object($name);
        if ($type && $type->public && is_post_type_viewable($type)) {
            $post_types[] = $name;
        }
    }
    if ($selected_types) {
        $post_types = array_values(array_intersect($post_types, $selected_types));
        // Invalid or unassociated names must produce no results, never unrelated content.
        if (!$post_types) {
            $query->set('post__in', [0]);
        }
    }
    if ($post_types) {
        $query->set('post_type', $post_types);
    }
}
add_action('pre_get_posts', 'grit_taxonomy_archive_post_types');

// * GRIT_SET 17 | Controller helpers: ACF fields, content and pagination
// Used by page.php, single.php and archive/search controllers.
// * GRIT_SET 17.1 | Expose ACF values to Twig
// Expose ACF values by field name for a page/post ID or a taxonomy_term ID; protected numeric sources stay private.
function grit_template_fields($context, $object_id) {
    $context['sections'] = [];
    if (!$object_id || !function_exists('get_field_objects')) {
        return $context;
    }
    if (is_numeric($object_id) && post_password_required((int) $object_id)) {
        return $context;
    }

    foreach (get_field_objects($object_id) ?: [] as $field) {
        $context[$field['name']] = $field['value'];
    }
    return $context;
}

// * GRIT_SET 17.2 | Format WordPress content
// Run content filters using the source page as the current post, then restore every affected WordPress global.
function grit_template_content($object_id) {
    $source = get_post((int) $object_id);
    if (!$source) {
        return '';
    }
    if (post_password_required($source)) {
        return get_the_password_form($source);
    }

    $previous_post = $GLOBALS['post'] ?? null;
    $post_globals = [
        'id', 'authordata', 'currentday', 'currentmonth',
        'page', 'pages', 'multipage', 'more', 'numpages',
    ];
    $previous_globals = [];

    // An empty search has no previous post: save its existing globals individually.
    if (!($previous_post instanceof WP_Post)) {
        foreach ($post_globals as $key) {
            if (array_key_exists($key, $GLOBALS)) {
                $previous_globals[$key] = $GLOBALS[$key];
            }
        }
    }

    try {
        $GLOBALS['post'] = $source;
        setup_postdata($source);
        return Timber::get_post($source->ID)->content();
    } finally {
        // Always restore the original request, even if a content filter fails.
        $GLOBALS['post'] = $previous_post;
        if ($previous_post instanceof WP_Post) {
            setup_postdata($previous_post);
        } else {
            foreach ($post_globals as $key) {
                if (array_key_exists($key, $previous_globals)) {
                    $GLOBALS[$key] = $previous_globals[$key];
                } else {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

// * GRIT_SET 17.3 | Expose query results and pagination
// Wrap an existing WP_Query for Timber and calculate visible result numbers; this does not create a second WP_Query.
function grit_template_query($context, $query) {
    $context['posts'] = new Timber\PostQuery($query);
    $context['found_posts'] = (int) $query->found_posts;

    $count = (int) $query->post_count;
    $per_page = (int) $query->get('posts_per_page');
    $paged = max(1, (int) $query->get('paged'));
    $offset = $query->get('offset');

    $start = 0;
    if ($per_page > 0) {
        $start = ($paged - 1) * $per_page;
    }
    if (is_numeric($offset)) {
        $start = (int) $offset;
    }

    $context['startpost'] = $count ? $start + 1 : 0;
    $context['endpost'] = $count ? $start + $count : 0;
    return $context;
}

// * GRIT_SET 18 | Section Maps: coordinates, styles and locations
// Data: sections/section.twig. Markup: sections/section_maps.twig. Behavior: assets/js/maps.js.
// Zero is a valid latitude/longitude. Empty, nonnumeric and out-of-range values are rejected.
function grit_maps_coordinates($value) {
    if (!is_array($value) || !isset($value['lat'], $value['lng'])) {
        return null;
    }
    if (!is_numeric($value['lat']) || !is_numeric($value['lng'])) {
        return null;
    }
    $latitude = (float) $value['lat'];
    $longitude = (float) $value['lng'];
    if (!is_finite($latitude) || !is_finite($longitude) || abs($latitude) > 90 || abs($longitude) > 180) {
        return null;
    }
    return ['lat' => $latitude, 'lng' => $longitude];
}

// Local map style: edit assets/maps/style.json; a child-theme file at the same path overrides it.
// This section always uses the local JSON palette; centering is automatic.
function grit_maps_styles() {
    static $cache = [];
    $relative = '/assets/maps/style.json';
    $child_path = get_stylesheet_directory() . $relative;
    $path = is_readable($child_path) ? $child_path : get_template_directory() . $relative;
    if (!array_key_exists($path, $cache)) {
        $json = is_readable($path) ? @file_get_contents($path) : false;
        $styles = $json !== false ? json_decode($json, true) : null;
        $valid = is_array($styles) && array_is_list($styles);
        foreach ($valid ? $styles : [] as $rule) {
            if (!is_array($rule) || !is_array($rule['stylers'] ?? null)) {
                $valid = false;
                break;
            }
        }
        $cache[$path] = $valid ? $styles : [];
    }
    return $cache[$path];
}

// Preserve existing ACF field names. Incomplete rows never break the other locations/maps.
function grit_maps_section_data($section) {
    $locations = [];
    $rows = is_array($section['section_maps'] ?? null) ? $section['section_maps'] : [];
    foreach ($rows as $row) {
        $coordinates = grit_maps_coordinates($row['section_maps_pin'] ?? null);
        if (!$coordinates) {
            continue;
        }
        $title = is_scalar($row['section_maps_title'] ?? null) ? sanitize_text_field($row['section_maps_title']) : '';
        $description = is_scalar($row['section_maps_description'] ?? null) ? sanitize_textarea_field($row['section_maps_description']) : '';
        $locations[] = [
            'title' => $title !== '' ? $title : sprintf(__('Sede %d', 'grit'), count($locations) + 1),
            'description' => $description,
            'position' => $coordinates,
            'directions' => 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($coordinates['lat'] . ',' . $coordinates['lng']),
        ];
    }
    if (!$locations) {
        return [];
    }

    $key = trim((string) get_theme_mod('grit_setting_maps', ''));
    $marker_path = get_template_directory() . '/img/pin.svg';

    // The remote Google SDK is requested by maps.js only when a map is near the viewport.
    // Enqueueing while rendering a section is safe: the controller is printed by wp_footer().
    wp_enqueue_script('grit-maps', get_template_directory_uri() . '/assets/js/maps.js', [], filemtime(get_template_directory() . '/assets/js/maps.js'), true);
    return [
        'id' => wp_unique_id('grit-map-'),
        'locations' => $locations,
        'key' => $key,
        'styles' => grit_maps_styles(),
        'markerUrl' => is_file($marker_path) ? get_template_directory_uri() . '/img/pin.svg' : '',
        'messages' => [
            'waiting' => __('La mappa verrà caricata quando sarà visibile.', 'grit'),
            'loading' => __('Caricamento della mappa…', 'grit'),
            'missingKey' => __('La mappa non è configurata. Puoi consultare le sedi e aprire le indicazioni.', 'grit'),
            'error' => __('La mappa non è disponibile. Puoi utilizzare i link alle indicazioni.', 'grit'),
            'consent' => __('Per visualizzare la mappa abilita Google Maps nelle preferenze di consenso.', 'grit'),
            'directions' => __('Apri indicazioni', 'grit'),
        ],
    ];
}

// * GRIT_SET 19 | Policy pages and public URLs
// Used by setup, the starter CF7 form, footers, Bio and policy links. Twig page selection remains slug-based.
function grit_policy_page($type) {
    if (!in_array($type, ['privacy', 'cookie'], true)) {
        return null;
    }
    if ($type === 'privacy') {
        $privacy_id = (int) get_option('wp_page_for_privacy_policy');
        $page = $privacy_id ? get_post($privacy_id) : null;
        if ($page && $page->post_type === 'page' && !in_array($page->post_status, ['trash', 'auto-draft'], true)) {
            return $page;
        }
    }
    $page = get_page_by_path($type . '-policy', OBJECT, 'page');
    if ($page && !in_array($page->post_status, ['trash', 'auto-draft'], true)) {
        return $page;
    }
    return null;
}

// Return a link only for a published policy page.
function grit_policy_url($type) {
    $page = grit_policy_page($type);
    return $page && $page->post_status === 'publish' ? get_permalink($page->ID) : '';
}
