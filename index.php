<?php
// * GRIT_SET Index | Blog requests use archive.php; other requests use the generic post list.
if (!defined('ABSPATH')) {
    exit;
}

if (is_home()) {
    locate_template('archive.php', true);
    return;
}

$context = Timber::context();
$context['posts'] = new Timber\PostQuery();
Timber::render('index.twig', $context);
