<?php digital_post_meta_data(); ?>
<span class="postcateg"><?php the_category(', '); ?></span>
<?php if ( comments_open() ) : ?><span class="comp"><?php comments_popup_link( __( 'No Comment', 'digital' ), __( '1 Comment', 'digital' ), __( '% Comments', 'digital' ) ); ?></span><?php endif; ?>
		