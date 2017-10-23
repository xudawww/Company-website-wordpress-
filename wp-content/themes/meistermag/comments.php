<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @since MeisterMag 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}
?>

<div class="comments" id="comments">
	<?php
	if ( have_comments() ) {
		$tagdiv_comments_number = get_comments_number(); // get_comments_number returns only a numeric value
		if ( $tagdiv_comments_number > 1 ) {
			$tagdiv_comments_no_text = $tagdiv_comments_number . ' ' . __( 'COMMENTS', 'meistermag' );
		} else {
			$tagdiv_comments_no_text = __( '1 COMMENT', 'meistermag' );
		}
	?>

		<div class="tagdiv-comments-title-wrap">
			<h4 class="tagdiv-comments-title"><span><?php esc_html( $tagdiv_comments_no_text ) ?></span></h4>
		</div>

		<ol class="comment-list">
			<?php wp_list_comments( array(
				'callback' => 'tagdiv_comment'
			) ); ?>
		</ol>

		<div class="comment-pagination">
			<?php previous_comments_link(); ?>
			<?php next_comments_link(); ?>
		</div>
	<?php }

	if ( ! comments_open() and ( get_comments_number() > 0 ) ) { ?>
		<p><?php esc_html_e( 'Comments are closed.', 'meistermag' ); ?></p>
	<?php }

	$tagdiv_commenter = wp_get_current_commenter();
	$tagdiv_req = get_option( 'require_name_email' );
	$tagdiv_aria_req = ( $tagdiv_req ? " aria-required='true'" : '' );

	$tagdiv_fields = array(
		'author' => '<p class="comment-form-input-wrap tagdiv-form-author"><input class="" id="author" name="author" placeholder="' . esc_attr__( 'Name: *', 'meistermag' ) . '" type="text" value="' . esc_attr( $tagdiv_commenter['comment_author'] ) . '" size="30" ' . $tagdiv_aria_req . ' /></p>',
		'email'  => '<p class="comment-form-input-wrap tagdiv-form-email"><input class="" id="email" name="email" placeholder="' . esc_attr__( 'Email: *', 'meistermag' ) . '" type="text" value="' . esc_attr(  $tagdiv_commenter['comment_author_email'] ) . '" size="30" ' . $tagdiv_aria_req . ' /></p>',
		'url' 	 => '<p class="comment-form-input-wrap tagdiv-form-url"><input class="" id="url" name="url" placeholder="' . esc_attr__( 'Website:', 'meistermag' ) . '" type="text" value="' . esc_attr( $tagdiv_commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$tagdiv_defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', $tagdiv_fields ) );
	$tagdiv_defaults['comment_field'] 		  = '<div class="tagdiv-clearfix"></div><p class="comment-form-input-wrap tagdiv-form-comment"><textarea placeholder="' . esc_attr__( 'Comment:', 'meistermag' ) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
	$tagdiv_defaults['comment_notes_before']  = '';
	$tagdiv_defaults['comment_notes_after']   = '';
	$tagdiv_defaults['title_reply'] 		  = __( 'LEAVE A REPLY', 'meistermag' );
	$tagdiv_defaults['label_submit'] 		  = __( 'Post Comment', 'meistermag' );
	$tagdiv_defaults['cancel_reply_link'] 	  = __( 'Cancel reply', 'meistermag' );

	global $post;
	$tagdiv_url = wp_login_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) );

	$tagdiv_defaults['must_log_in'] 		  = '<p class="must-log-in"><a href="' . esc_url( $tagdiv_url ) .'">' . __( 'Log in to leave a comment', 'meistermag' ) . ' </a></p>';

	comment_form( $tagdiv_defaults );

	?>
</div> <!-- /.comments -->

<?php
	/**
	 * Custom callback for outputting comments
	 *
	 * @param $tagdiv_comment
	 * @param $tagdiv_comment_args
	 * @param $tagdiv_comment_depth
	 */

	function tagdiv_comment( $tagdiv_comment, $tagdiv_comment_args, $tagdiv_comment_depth ) {

	$tagdiv_is_ping_trackback_class = '';
	if( 'pingback' == $tagdiv_comment->comment_type ) {
		$tagdiv_is_ping_trackback_class = 'pingback';
	}

	if( 'trackback' == $tagdiv_comment->comment_type ) {
		$tagdiv_is_ping_trackback_class = 'trackback';
	}

	$tagdiv_comment_auth_email = '';
	if ( !empty( $tagdiv_comment->comment_author_email ) ) {
		$tagdiv_comment_auth_email = $tagdiv_comment->comment_author_email;
	}

	$tagdiv_article_date_unix = '';
	if ( !empty ( $tagdiv_comment->comment_date_gmt) && false !== strtotime( $tagdiv_comment->comment_date_gmt . " GMT" ) ) {
		$tagdiv_article_date_unix = strtotime( $tagdiv_comment->comment_date_gmt . " GMT" );
	}

	?>

	<li class="comment <?php esc_attr( $tagdiv_is_ping_trackback_class ) ?>" id="comment-<?php comment_ID() ?>">
		<article>
			<footer>
				<?php echo get_avatar( $tagdiv_comment_auth_email, 50 ); ?>
				<cite><?php comment_author_link() ?></cite>

				<a class="comment-link" href="#comment-<?php comment_ID() ?>">
					<time pubdate="<?php esc_attr( $tagdiv_article_date_unix ) ?>"> <?php comment_date() ?> <?php esc_html_e( 'at', 'meistermag' ); ?> <?php comment_time() ?> </time>
				</a>
			</footer>

			<div class="comment-content">
				<?php if ( '0' == $tagdiv_comment->comment_approved ) { ?>
					<em><?php esc_html_e( 'Your comment is awaiting moderation', 'meistermag' ); ?></em>
				<?php }
				comment_text(); ?>
			</div>

			<div class="comment-meta" id="comment-<?php comment_ID() ?>">
				<?php comment_reply_link( array_merge( $tagdiv_comment_args, array(
					'depth' => $tagdiv_comment_depth,
					'max_depth' => $tagdiv_comment_args['max_depth'],
					'reply_text' => __( 'Reply', 'meistermag' ),
					'login_text' =>  __( 'Log in to leave a comment', 'meistermag' )
				) ) )
				?>
			</div>
		</article>
	</li>

<?php

}
?>