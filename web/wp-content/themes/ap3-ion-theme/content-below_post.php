<?php
/**
 * @package Ion
 */
?>

<section class="appp-below-post">

	<div class="button-bar" role="group" aria-label="Justified button group">
		<?php

		// Display next/previous links
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( $previous ) {
			previous_post_link( '<div class="button button-secondary icon-left previous-link">%link</div>', '<i class="icon ion-chevron-left"></i><span class="button-text"> Previous</span>' );
		} 

		// Display comment modal button if comments are open
		if ( comments_open() ) {
			echo '<a href="#commentModal" class="button button-secondary icon-left io-modal-open appp-comment-btn"><i class="icon ion-ios-chatbubble"></i> <span class="button-text">Comment</span></a>';
		}
 
		// If AppShare installed and preferred (see admin settings), display sharing link
		if( apply_filters( 'appshare_btn', false, 'post' ) ) {
			?>
			<div class="button button-secondary icon-left appshare" 
				data-msg="<?php echo get_the_title(); ?>" 
				data-link="<?php echo get_permalink(); ?>"><i class="icon ion-share"></i> <span class="button-text">Share</span></a></div>
		<?php } ?>

		<?php 

		if ( $next ) {
			next_post_link( '<div class="button button-secondary icon-right next-link">%link</div>', '<span class="button-text">Next </span><i class="icon ion-chevron-right"></i>' ); 
		} ?>

    </div>

</section>

<?php
	// If comments are open or we have at least one comment, load up the comment template
	if ( comments_open() || '0' != get_comments_number() ) {
		comments_template();
	}
?>