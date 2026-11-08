<?php
// * GRIT_SET 404 | Render the not-found page with the shared site context.
$context = Timber::context();
Timber::render('404.twig', $context);
