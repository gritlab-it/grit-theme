<?php
// * GRIT_SET Page legend
// 01 | Current page and password protection
// 02 | ACF fields and page content
// 03 | Bio links and contact data
// 04 | Twig template priority
if (!defined('ABSPATH')) {
    exit;
}

// * GRIT_SET 01 | Load the requested page; protected pages stop here.
$context = Timber::context();
$timber_post = Timber::get_post(get_queried_object_id());
$post_id = $timber_post ? $timber_post->ID : 0;
$context['post'] = $timber_post;

if ($timber_post && post_password_required($post_id)) {
    $context['password_form'] = get_the_password_form($post_id);
    $context['sections'] = [];
    Timber::render('single-password.twig', $context);
    return;
}

// * GRIT_SET 02 | Helpers load ACF and run content filters with the correct page ID.
$context = grit_template_fields($context, $post_id);
$context['post'] = $timber_post;
$context['title'] = $timber_post ? $timber_post->title : '';
$context['content'] = $timber_post ? grit_template_content($post_id) : '';

// * GRIT_SET 03 | Bio uses existing Theme Fields and an optional WordPress menu.
$assigned_template = get_page_template_slug($post_id);
if ($assigned_template === 'grit-bio.php' || ($timber_post && $timber_post->post_name === 'bio' && !is_front_page())) {
    $context['bio_menu'] = has_nav_menu('bio_navigation') ? new Timber\Menu('bio_navigation') : null;
    $context['bio_contacts'] = [];
    $email = sanitize_email($context['setting_mail_2'] ?: $context['setting_mail_1']);
    if (is_email($email)) {
        $context['bio_contacts'][] = ['title' => __('Scrivici', 'grit'), 'detail' => $email, 'url' => 'mailto:' . $email, 'icon' => 'far fa-envelope'];
    }
    $phone = trim((string) ($context['setting_tel_2'] ?: $context['setting_tel_1']));
    $digits = preg_replace('/\D+/', '', $phone);
    if (strlen($digits) >= 7) {
        $context['bio_contacts'][] = ['title' => __('Chiamaci', 'grit'), 'detail' => $phone, 'url' => 'tel:' . (strpos($phone, '+') === 0 ? '+' : '') . $digits, 'icon' => 'fas fa-phone'];
    }
    $whatsapp = preg_replace('/\D+/', '', (string) $context['setting_tel_3']);
    if (strpos($whatsapp, '00') === 0) { $whatsapp = substr($whatsapp, 2); }
    if (strlen($whatsapp) >= 7 && strlen($whatsapp) <= 15) {
        $context['bio_contacts'][] = ['title' => 'WhatsApp', 'detail' => __('Iniziamo una conversazione', 'grit'), 'url' => 'https://wa.me/' . $whatsapp, 'icon' => 'fab fa-whatsapp', 'external' => true];
    }
    $address = trim((string) ($context['setting_indirizzo_2'] ?: $context['setting_indirizzo_1']));
    if ($address !== '') {
        $context['bio_contacts'][] = ['title' => __('Dove siamo', 'grit'), 'detail' => $address, 'url' => 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($address), 'icon' => 'fas fa-map-marker-alt', 'external' => true];
    }
    $context['bio_socials'] = [];
    foreach (['instagram' => ['Instagram', 'fab fa-instagram'], 'linkedin' => ['LinkedIn', 'fab fa-linkedin-in'], 'facebook' => ['Facebook', 'fab fa-facebook-f'], 'tiktok' => ['TikTok', 'fab fa-tiktok']] as $key => $social) {
        $value = trim((string) ($context['setting_' . $key] ?? ''));
        if (!preg_match('~^https?://~i', $value)) { continue; }
        $url = esc_url_raw($value, ['http', 'https']);
        if ($url) { $context['bio_socials'][] = ['title' => $social[0], 'icon' => $social[1], 'url' => $url]; }
    }
}

// * GRIT_SET 04 | Assigned templates survive slug changes; other pages keep the usual hierarchy.
$templates = [];
$page_templates = [
    'grit-privacy-policy.php' => 'page-privacy-policy.twig',
    'grit-cookie-policy.php' => 'page-cookie-policy.twig',
    'grit-bio.php' => 'page-bio.twig',
];
if (isset($page_templates[$assigned_template])) {
    $templates[] = $page_templates[$assigned_template];
} elseif (is_front_page()) {
    $templates[] = 'home.twig';
} elseif ($timber_post) {
    $templates[] = 'page-' . $timber_post->post_name . '.twig';
}
$templates[] = 'page.twig';
$templates[] = 'index.twig';

Timber::render($templates, $context);
