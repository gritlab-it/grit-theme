<?php
// * GRIT_SET Comments | Respect password protection and the theme's disable-comments setting.
if (!defined('ABSPATH') || post_password_required() || get_theme_mod('grit_setting_comments', false)) {
    return;
}
?>
<section class="section_page contained py-5" id="comments">
    <div class="container-fluid">
        <?php if (have_comments()) : ?>
            <h2><?php esc_html_e('Commenti', 'grit'); ?></h2>
            <ol class="comment-list">
                <?php wp_list_comments(['style' => 'ol', 'short_ping' => true]); ?>
            </ol>
            <?php the_comments_pagination(); ?>
        <?php endif; ?>

        <?php comment_form(['class_form' => 'comment-form contact-form-style-1']); ?>
    </div>
</section>
