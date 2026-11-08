<?php
// * GRIT_SET Index | Blog requests use archive.php; other requests use the generic post list.
if (!defined('ABSPATH')) {
    exit;
}

if (is_home()) {
    include get_template_directory() . '/archive.php';
    return;
}

$context = Timber::context();
$context['posts'] = new Timber\PostQuery();
Timber::render('index.twig', $context);
