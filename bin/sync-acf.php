<?php
/** Run: wp eval-file bin/sync-acf.php [apply]. Default: compare only. */
if (PHP_SAPI !== 'cli' || !defined('ABSPATH')) { exit('Load WordPress through WP-CLI.'); }
if (!function_exists('acf_import_field_group')) { throw new RuntimeException('ACF PRO must be active.'); }
$source = json_decode(file_get_contents(dirname(__DIR__) . '/core/acf-fields.json'), true, 512, JSON_THROW_ON_ERROR);
acf_disable_filter('clone');
acf_get_store('fields')->reset();
foreach (['post_type','tease','taxonomy'] as $name) remove_filter('acf/load_field/name='.$name, 'grit_archive_admin_field');
$backup = [];
$index = static function ($value) use (&$index) {
    $out = [];
    if (!is_array($value)) return $out;
    if (isset($value['key'])) $out[$value['key']] = ['name' => $value['name'] ?? '', 'type' => $value['type'] ?? ''];
    foreach ($value as $child) if (is_array($child)) $out += $index($child);
    return $out;
};
foreach ($source as $group) {
    $live = acf_get_field_group($group['key']);
    if ($live) {
        $live['fields'] = acf_get_fields($live);
        $live = acf_prepare_field_group_for_export($live);
        $backup[] = $live;
        $before = $index($live); $after = $index($group);
        foreach ($before as $key => $identity) {
            if (!isset($after[$key]) || $after[$key] !== $identity) throw new RuntimeException('Unmapped or renamed field: ' . $key);
        }
    }
    echo $group['key'] . ': ' . ($live ? 'compare/update' : 'new group') . PHP_EOL;
}
if (($args[0] ?? '') !== 'apply') { echo "Read-only. Use apply after reviewing core/acf-fields.json.\n"; return; }
$path = tempnam(sys_get_temp_dir(), 'grit-acf-backup-');
if (!$path || file_put_contents($path, wp_json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) throw new RuntimeException('Backup failed.');
echo 'Backup: ' . $path . PHP_EOL;
foreach ($source as $group) {
    $result = acf_import_field_group($group);
    if (!$result || is_wp_error($result)) throw new RuntimeException('Import failed: ' . $group['key']);
}
echo "Imported field definitions only; content values were not changed.\n";
