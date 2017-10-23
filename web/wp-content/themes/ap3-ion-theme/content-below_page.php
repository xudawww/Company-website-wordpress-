<?php
/**
 * @package Ion
 */
?>

<section class="appp-below-post">

	<div class="button-bar" role="group" aria-label="Justified button group">
		<?php

		// Display comment modal button if comments are open
		if ( comments_open() ) {
			echo '<a href="#commentModal" class="button button-secondary icon-left io-modal-open appp-comment-btn"><i class="icon ion-ios-chatbubble"></i> <span class="button-text">Comment</span></a>';
		}
 
		// If AppShare installed and preferred (see admin settings), display sharing link
		if( apply_filters( 'appshare_btn', false, 'page' ) ) {
			?>
			<div class="button button-secondary icon-left appshare" 
				data-msg="<?php echo get_the_title(); ?>" 
				data-link="<?php echo get_permalink(); ?>"><i class="icon ion-share"></i> <span class="button-text">Share</span></a></div>
		<?php } ?>

    </div>

</section>

<?php
	// If comments are open or we have at least one comment, load up the comment template
	if ( comments_open() || '0' != get_comments_number() ) {
		comments_template();
	}
?>