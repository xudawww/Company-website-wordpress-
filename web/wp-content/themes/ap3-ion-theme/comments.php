<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to appp_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Ion
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'ap3-ion-theme' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="comment-list list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use appp_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define appp_comment() and that will be used instead.
				 * See appp_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'appp_comment' ) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation-comment" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'ap3-ion-theme' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'ap3-ion-theme' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ap3-ion-theme' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'ap3-ion-theme' ); ?></p>
	<?php endif; ?>

	<?php 
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$comment_args = array(
		'class_submit' => 'button button-block button-primary',
		'class_form' => 'comment-form list list-inset',
		'comment_field' =>  '<label class="item item-input" for="comment">' . _x( 'Comment', 'noun', 'ap3-ion-theme' ) .
	    '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
	    '</textarea></label>',
		'fields' =>  array(

		  'author' =>
		    '<label class="item item-input" for="author">' . __( 'Name', 'ap3-ion-theme' ) .
		    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		    '" size="30" /></label>',

		  'email' =>
		    '<label class="item item-input" for="email">' . __( 'Email', 'ap3-ion-theme' ) .
		    ( $req ? '<span class="required">*</span>' : '' ) .
		    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		    '" size="30"' . $aria_req . ' /></label>',

		  'url' =>
		    '<label class="item item-input" for="url">' . __( 'Website', 'ap3-ion-theme' ) .
		    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		    '" size="30" /></label>',
		)
	);
	comment_form( $comment_args ); ?>

</div><!-- #comments -->
