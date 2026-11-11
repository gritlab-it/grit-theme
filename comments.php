<?php
// * GRIT_SET Comments | Respect password protection and the theme's disable-comments setting.
if (!defined('ABSPATH') || post_password_required() || get_theme_mod('grit_setting_comments', false)) {
    return;
}
?>
<section class="section_page contained py-5" id="comments">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                <?php if (have_comments()) : ?>
                    <h2 class="h3 mb-4"><?php esc_html_e('Comments', 'grit'); ?></h2>
                    <ol class="comment-list list-unstyled mb-5">
                        <?php
                        // Keep WordPress markup and reply behavior; add existing theme utilities.
                        $comment_styles = [
                            'comment-body'       => 'bg-light rounded p-3 p-md-4 mb-4',
                            'comment-author'     => 'mb-2',
                            'avatar'             => 'rounded-circle mr-2',
                            'comment-metadata'   => 'small mb-3',
                            'comment-content'    => 'mt-3',
                            'reply'              => 'mt-3',
                            'comment-reply-link' => 'btn btn-secondary btn-sm',
                            'comment-reply-login' => 'btn btn-secondary btn-sm',
                            'children'           => 'list-unstyled pl-3 pl-md-4',
                        ];
                        $comment_list = new WP_HTML_Tag_Processor(wp_list_comments([
                            'style'       => 'ol',
                            'format'      => 'html5',
                            'short_ping'  => true,
                            'avatar_size' => 40,
                            'echo'        => false,
                        ]));
                        while ($comment_list->next_tag()) {
                            foreach ($comment_styles as $class => $utilities) {
                                if ($comment_list->has_class($class)) {
                                    $comment_list->add_class($utilities);
                                }
                            }
                        }
                        echo $comment_list->get_updated_html();
                        ?>
                    </ol>
                    <?php the_comments_pagination(); ?>
                <?php endif; ?>

                <?php
                // Preserve WordPress visibility and cancellation behavior on the styled link.
                $cancel_reply_button = static function ($link) {
                    $html = new WP_HTML_Tag_Processor($link);
                    if ($html->next_tag('a')) {
                        $html->add_class('btn btn-secondary btn-sm mt-3');
                    }
                    return $html->get_updated_html();
                };
                add_filter('cancel_comment_reply_link', $cancel_reply_button);

                // Public fields: name and email follow the WordPress discussion setting.
                $commenter = wp_get_current_commenter();
                $required = get_option('require_name_email') ? ' required' : '';
                $required_label = $required ? ' *' : '';
                $privacy_url = grit_policy_url('privacy');
                $privacy_label = $privacy_url
                    ? sprintf(__('I have read and accept the %s.', 'grit'), '<a href="' . esc_url($privacy_url) . '" target="_blank" rel="noopener noreferrer">' . esc_html__('Privacy Policy', 'grit') . '</a>')
                    : esc_html__('I have read and accept the privacy policy.', 'grit');
                $comment_fields = [
                    'author' => '<p class="comment-form-author"><label for="author">' . esc_html__('Name', 'grit') . $required_label . '</label><input id="author" name="author" type="text" maxlength="245" autocomplete="name"' . $required . ' value="' . esc_attr($commenter['comment_author']) . '"></p>',
                    'email' => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'grit') . $required_label . '</label><input id="email" name="email" type="email" maxlength="100" autocomplete="email" aria-describedby="email-notes"' . $required . ' value="' . esc_attr($commenter['comment_author_email']) . '"></p>',
                    'cookies' => '',
                    'privacy' => '<p class="comment-form-privacy d-flex align-items-start"><input id="grit-comment-privacy" name="grit_comment_privacy" type="checkbox" value="1" required class="mt-1 mr-2 flex-shrink-0"><label for="grit-comment-privacy" class="small mb-0">' . $privacy_label . ' *</label></p>',
                ];
                if (has_action('set_comment_cookies', 'wp_set_comment_cookies') && get_option('show_comments_cookies_opt_in')) {
                    $comment_fields['cookies'] = '<p class="comment-form-cookies-consent d-flex align-items-start"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="mt-1 mr-2 flex-shrink-0"><label for="wp-comment-cookies-consent" class="small mb-0">' . esc_html__('Save my name and email in this browser for the next time I comment.', 'grit') . '</label></p>';
                }

                // Fields inherit the global form style; the submit uses the shared theme button.
                comment_form([
                    'fields'             => $comment_fields,
                    'comment_notes_before' => '<p class="comment-notes small"><span id="email-notes">' . esc_html__('Your email address will not be published.', 'grit') . '</span> ' . esc_html__('Fields marked with * are required.', 'grit') . '</p>',
                    'class_form'         => 'comment-form',
                    'class_container'    => 'comment-respond mt-4',
                    'class_submit'       => 'submit btn btn-primary',
                    'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title h3 mb-4">',
                    'title_reply_after'  => '</h2>',
                    'cancel_reply_before' => '<small class="d-block">',
                    'cancel_reply_after'  => '</small>',
                ]);
                remove_filter('cancel_comment_reply_link', $cancel_reply_button);
                ?>
            </div>
        </div>
    </div>
</section>
