<?php
/** Run with WP-CLI: wp eval-file bin/sync-guides.php [apply]. */
if (PHP_SAPI !== 'cli' || !defined('ABSPATH')) { exit('Load WordPress through WP-CLI.'); }
$parser_file = WP_PLUGIN_DIR . '/jetpack/_inc/lib/markdown/extra.php';
if (!class_exists('MarkdownExtra_Parser')) {
    if (!is_readable($parser_file)) { throw new RuntimeException('The Jetpack Markdown parser must be installed to build guides.'); }
    require_once $parser_file;
}
$markdown = file_get_contents(dirname(__DIR__) . '/GUIDA.md');
preg_match_all('/^## ([^\n]+)\n(.*?)(?=^## |\z)/ms', $markdown, $matches, PREG_SET_ORDER);
$chapters = [];
foreach ($matches as $match) { $chapters[$match[1]] = '## ' . $match[1] . "\n" . $match[2]; }
$common = 'Campi comuni e colonne';
$owl = 'Caroselli Owl condivisi';
$mapping = [
    'section-text' => [$common, 'Section Text', $owl],
    'section-hero-cta' => [$common, 'Section Text'],
    'section-cube' => [$common, 'Section Cube', $owl],
    'shortcode-counter' => ['Shortcode Counter'],
    'section-contact' => ['Shortcode Contacts'],
    'section-slide' => [$common, 'Section Slides', $owl],
    'shortcode-video' => ['Shortcode Video'],
    'section-archive' => [$common, 'Section Archive', 'Card Tease', $owl],
    '268' => [$common, 'Section Page e contenuti riutilizzabili', 'Plugin e librerie'],
    'section-gallery' => [$common, 'Section Gallery', $owl],
    'section-collapse' => [$common, 'Section Collapse', $owl],
    'layout-headers' => [$common, 'Section Text', 'Section Slides'],
    'section-gsap' => [$common, 'Effetti GSAP e barre'],
    'section-maps' => [$common, 'Section Maps'],
    'section-page' => [$common, 'Section Page e contenuti riutilizzabili'],
];
$parser = new MarkdownExtra_Parser();
$updates = [];
foreach ($mapping as $slug => $names) {
    $post = get_page_by_path((string) $slug, OBJECT, 'section');
    if (!$post || $post->post_status !== 'publish') { echo "Skip missing published guide: $slug\n"; continue; }
    $parts = [];
    foreach ($names as $name) {
        if (!isset($chapters[$name])) { throw new RuntimeException('Missing chapter: ' . $name); }
        $parts[] = $chapters[$name];
    }
    $html = $parser->transform(implode("\n\n", $parts));
    // Protect documented shortcodes from WordPress execution, including inline examples.
    $html = preg_replace('/(?<!\[)\[(\/?(?:grit_[a-z_]+|wpseo_breadcrumb|contact-form-7)\b[^\]]*)\](?!\])/', '[[$1]]', $html);
    $doc = new DOMDocument();
    $previous = libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8" ?><div id="grit-guide-body">' . $html . '</div>');
    libxml_clear_errors(); libxml_use_internal_errors($previous);
    $ids = [];
    foreach (['h2', 'h3'] as $tag) {
        foreach ($doc->getElementsByTagName($tag) as $heading) {
            $id = sanitize_title($heading->textContent);
            $heading->setAttribute('id', $id); $ids[$id] = true;
        }
    }
    // Chapters outside this page link to the complete manual.
    foreach ($doc->getElementsByTagName('a') as $link) {
        $href = $link->getAttribute('href');
        if (strpos($href, '#') === 0 && !isset($ids[substr($href, 1)])) {
            $link->setAttribute('href', 'https://github.com/gritlab-it/grit-theme/blob/main/GUIDA.md' . $href);
        }
    }
    $html = '';
    foreach ($doc->getElementById('grit-guide-body')->childNodes as $child) { $html .= $doc->saveHTML($child); }
    // Keep the existing explanation of this page's demonstration rows.
    $examples = '';
    if (preg_match('/<!-- grit-guide-examples -->(.*?)<!-- \/grit-guide-examples -->/s', $post->post_content, $match)) {
        $examples = $match[1];
    } elseif (preg_match('/(<h2\b[^>]*>8\..*?)(?=<h2\b[^>]*>9\.)/s', $post->post_content, $match)) {
        $examples = preg_replace('/<!--.*?-->/s', '', $match[1]);
        $examples = preg_replace('/(<h2\b[^>]*>)8\.\s*/', '$1', $examples);
    }
    $html .= "\n<!-- grit-guide-examples -->" . $examples . "<!-- /grit-guide-examples -->\n";
    if ($html === $post->post_content) { echo "Unchanged: $slug\n"; continue; }
    $updates[] = ['post' => $post->to_array(), 'html' => $html, 'meta' => get_post_meta($post->ID)];
    echo "Update: $slug\n";
}
if (($args[0] ?? '') !== 'apply' || !$updates) { echo "Read-only or already aligned.\n"; return; }
$backup = tempnam(sys_get_temp_dir(), 'grit-guides-backup-');
if (!$backup || file_put_contents($backup, wp_json_encode($updates, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
    throw new RuntimeException('Backup failed.');
}
echo 'Backup: ' . $backup . PHP_EOL;
foreach ($updates as $update) {
    $id = $update['post']['ID'];
    if (get_post($id)->post_content !== $update['post']['post_content']) { throw new RuntimeException('Guide changed during comparison: ' . $id); }
    $result = wp_update_post(wp_slash(['ID' => $id, 'post_content' => $update['html']]), true);
    if (is_wp_error($result)) { throw new RuntimeException($result->get_error_message()); }
    if (get_post_meta($id) !== $update['meta']) { throw new RuntimeException('Unexpected metadata change: ' . $id); }
    echo "Saved $id; ACF examples unchanged.\n";
}
