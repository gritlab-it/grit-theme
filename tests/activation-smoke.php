<?php
// Isolated installation checks: no WordPress database or filesystem writes.
$fixture = sys_get_temp_dir() . '/grit-activation-' . uniqid();
mkdir($fixture . '/wp-admin/includes', 0777, true);
file_put_contents($fixture . '/wp-admin/includes/plugin.php', '<?php');
define('ABSPATH', $fixture . '/');
define('OBJECT', 'OBJECT');
class WP_Error { public function __construct($code = '', $message = '') { $this->message = $message; } public function get_error_message() { return $this->message; } public function get_error_code() { return 'error'; } public $message; }
function add_action(...$args) {} function add_filter(...$args) {}
function is_admin() { return false; } function __($text, $domain = '') { return $text; }
function current_user_can($cap) { return $GLOBALS['allowed']; }
function get_option($key) { return $GLOBALS['options'][$key] ?? false; }
function update_option($key, $value) { $GLOBALS['options'][$key] = $value; if ($key === 'grit_theme_activation_options') grit_theme_activation_action(); }
function get_theme_mod($key, $default = false) { return $GLOBALS['mods'][$key] ?? $default; }
function set_theme_mod($key, $value) { $GLOBALS['mods'][$key] = $value; }
function get_page_by_path($slug, ...$args) { return $GLOBALS['pages'][$slug] ?? null; }
function wp_insert_post($post, $error = false) {
    if ($GLOBALS['fail_page']) return new WP_Error('failed', 'simulated');
    if (!empty($post['page_template']) && $post['page_template'] !== 'search.php') throw new Exception('Invalid page template');
    $id = count($GLOBALS['pages']) + 1;
    $GLOBALS['pages'][$post['post_name']] = (object) ['ID' => $id, 'post_status' => 'publish'];
    return $id;
}
function is_wp_error($value) { return $value instanceof WP_Error; }
function add_settings_error(...$args) { $GLOBALS['errors'][] = $args; }
function wp_get_nav_menu_object($id) { return $GLOBALS['menus'][$id] ?? false; }
function wp_create_nav_menu($name, ...$args) { $id = count($GLOBALS['menus']) + 10; $GLOBALS['menus'][$name] = (object) ['term_id' => $id]; $GLOBALS['menus'][$id] = $GLOBALS['menus'][$name]; return $id; }
function wp_get_nav_menu_items($id) { return $GLOBALS['items'][$id] ?? []; }
function wp_update_nav_menu_item($id, $unused, $data) { $GLOBALS['items'][$id][] = (object) ['object_id' => $data['menu-item-object-id'], 'object' => 'page']; return 1; }
function reset_fixture($selected) {
    $GLOBALS['allowed'] = true; $GLOBALS['fail_page'] = false;
    $GLOBALS['options'] = ['grit_theme_activation_options' => $selected];
    $GLOBALS['mods'] = $GLOBALS['pages'] = $GLOBALS['menus'] = $GLOBALS['items'] = $GLOBALS['errors'] = [];
}
function expect($ok, $label) { if (!$ok) throw new Exception($label); echo 'PASS ' . $label . PHP_EOL; }
try {
    require dirname(__DIR__) . '/core/activation.php';
    reset_fixture(['create_front_page' => 'true']); grit_theme_activation_action();
    expect(count($GLOBALS['pages']) === 1 && isset($GLOBALS['pages']['home']), 'Home independently creates one page');
    expect(get_option('page_on_front') === 1, 'Home assigned');
    grit_theme_activation_action(); expect(count($GLOBALS['pages']) === 1, 'Completed setup does not repeat');
    reset_fixture(['create_additional_page' => 'true']); grit_theme_activation_action();
    expect(count($GLOBALS['pages']) === 9 && !get_option('page_on_front'), 'Additional pages independent from homepage assignment');
    reset_fixture(['create_front_page' => 'true']); $GLOBALS['fail_page'] = true; grit_theme_activation_action();
    expect(get_option('grit_theme_activation_options')['create_front_page'] === 'true', 'Failed page remains retryable');
    reset_fixture(['create_navigation_menus' => 'true']); $GLOBALS['mods']['nav_menu_locations'] = ['primary_navigation' => 99, 'custom_location' => 99]; $GLOBALS['menus'][99] = (object) ['term_id' => 99]; grit_theme_activation_action();
    expect(get_theme_mod('nav_menu_locations')['primary_navigation'] === 99 && get_theme_mod('nav_menu_locations')['custom_location'] === 99, 'Existing menu assignments preserved');
    reset_fixture(['create_front_page' => 'true']); $GLOBALS['allowed'] = false; grit_theme_activation_action();
    expect(!$GLOBALS['pages'], 'Unauthorized setup does not write');
    reset_fixture(['create_cf7_template' => 'true', 'import_acf_fields' => 'true']); grit_theme_activation_action();
    expect(count($GLOBALS['errors']) === 2 && get_option('grit_theme_activation_options')['import_acf_fields'] === 'true', 'Missing plugins reported without consuming setup options');
} finally {
    unlink($fixture . '/wp-admin/includes/plugin.php'); rmdir($fixture . '/wp-admin/includes'); rmdir($fixture . '/wp-admin'); rmdir($fixture);
}
