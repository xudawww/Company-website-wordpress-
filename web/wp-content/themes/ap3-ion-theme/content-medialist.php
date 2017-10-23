<?php
/**
 * @package Ion
 */
?>

<li id="post-<?php the_ID(); ?>" class="post-list-item">

		<a class="item item-thumbnail-left item-text-wrap <?php if( class_exists( 'AppTransitions' ) ) {
			echo apply_filters('appp_transition_left', $classname );
			} ?>" href="<?php the_permalink(); ?>">
			
			  <?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'thumbnail' );
				} else { ?>
					<img src="<?php echo get_stylesheet_directory_uri() . '/images/thumbnail.jpg'; ?>">
				<?php } ?>
				
			
			  <div class="item-title"><?php the_title(); ?></div>
			
			  <div class="item-text"><?php the_excerpt(); ?></div>
		  
		</a>
	
</li><!-- #post-## -->