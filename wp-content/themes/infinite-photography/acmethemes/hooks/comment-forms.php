<?php
/**
 * Comment Form
 *
 * @since infinite-photography 1.0.0
 *
 * @param array $form
 * @return array $form
 *
 */
if ( !function_exists('infinite_photography_alter_comment_form') ) :

    function infinite_photography_alter_comment_form($form) {

        $required = get_option('require_name_email');
        $req = $required ? 'aria-required="true"' : '';
        $form['fields']['author'] = '<p class="comment-form-author"><label for="author"></label><input id="author" name="author" type="text" placeholder="'.esc_attr__( 'Name', 'infinite-photography' ).'" value="" size="30" ' . $req . '/></p>';
        $form['fields']['email'] = '<p class="comment-form-email"><label for="email"></label> <input id="email" name="email" type="email" value="" placeholder="'.esc_attr__( 'Email', 'infinite-photography' ).'" size="30" ' . $req . '/></p>';
        $form['fields']['url'] = '<p class="comment-form-url"><label for="url"></label> <input id="url" name="url" placeholder="'.esc_attr__( 'Website URL', 'infinite-photography' ).'" type="url" value="" size="30" /></p>';
        $form['comment_field'] = '<p class="comment-form-comment"><label for="comment"></label> <textarea id="comment" name="comment" placeholder="'.esc_attr__( 'Comment', 'infinite-photography' ).'" cols="45" rows="8" aria-required="true"></textarea></p>';
        $form['comment_notes_before'] = '';
        $form['label_submit'] = __( 'Add Comment', 'infinite-photography' );
        $form['title_reply'] = sprintf( __( '%s Leave a Comment', 'infinite-photography' ), '<span></span>' );

        return $form;
    }

endif;

add_filter('comment_form_defaults', 'infinite_photography_alter_comment_form');