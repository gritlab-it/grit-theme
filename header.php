<?php
// * GRIT_SET Plugin header | Support plugins using WordPress get_header()/get_footer().
// Save the site context and capture their page output; footer.php renders the final Twig layout.
$GLOBALS['timberContext'] = Timber::context();
ob_start();
