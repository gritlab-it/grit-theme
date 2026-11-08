<?php

// * GRIT_SET Legend | Write
// Apache rules generated when WordPress permalinks are saved.
// Rules are applied through WordPress rewrite filters; reading this file does not save permalinks.
// 01 | Protect wp-config through Apache rules
// 02 | Generate missing-image rewrite rules
// 03 | Generate browser cache expiry rules

/**
 * GRIT-Framework htaccess custom rules
 *
 * These functions add some lines of code to the Wordpress's 
 * Htaccess. Please note that will be activated only when
 * we press "Save" on "Permalink options" page.
 *
 */

// * GRIT_SET 01 | Protect wp-config through Apache rules
function wpconfig_protect( $rules )
{
$my_content = <<<EOD
\n
<files wp-config.php>
order allow,deny
deny from all
</files>
\n
EOD;
    return $my_content . $rules;
}

// * GRIT_SET 02 | Generate missing-image rewrite rules
function rewrite( $rules )
{
$my_content = <<<EOD
\n
<IfModule mod_rewrite.c>
RewriteEngine On

RewriteCond %{REQUEST_URI} \.(jpg|jpeg|gif|png|ico)$ [NC]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule .*$ logo.png [L]

</IfModule>\n
EOD;
    return $my_content . $rules;
}

// function disable_dir_browsing( $rules )
// {
// $my_content = <<<EOD
// \n
// Options All -Indexes
// \n
// Options -Indexes
// \n
// EOD;
//     return $my_content . $rules;
// }

// * GRIT_SET 03 | Generate browser cache expiry rules
function expirecache( $rules )
{
$my_content = <<<EOD
\n
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType image/jpg "access plus 1 year"
ExpiresByType image/jpeg "access plus 1 year"
ExpiresByType image/gif "access plus 1 year"
ExpiresByType image/png "access plus 1 year"
ExpiresByType text/css "access plus 1 month"
ExpiresByType application/pdf "access plus 1 month"
ExpiresByType text/x-javascript "access plus 1 month"
ExpiresByType application/javascript "access plus 1 month"  
ExpiresByType application/x-javascript "access plus 1 month"
ExpiresByType application/x-shockwave-flash "access plus 1 month"
ExpiresByType image/x-icon "access plus 1 year"
ExpiresDefault "access plus 2 days"
</IfModule>
\n
EOD;
    return $my_content . $rules;
}

// Sicurezza
add_filter('mod_rewrite_rules', 'wpconfig_protect');
// add_filter('mod_rewrite_rules', 'disable_dir_browsing');
add_filter('mod_rewrite_rules', 'rewrite');
// Ottimizzazione
add_filter('mod_rewrite_rules', 'expirecache');
