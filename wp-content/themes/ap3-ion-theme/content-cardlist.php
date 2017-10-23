<?php
/**
 * @package Ion
 */
?>

<li id="post-<?php the_ID(); ?>" class="post-list-item">

	<a class="<?php if( class_exists( 'AppTransitions' ) ) {
		echo apply_filters('appp_transition_left', $classname ); 
		}?>" href="<?php the_permalink(); ?>">
		<div class="card">
		    <div class="item item-text-wrap"><h2><?php the_title(); ?></h2></div>
		    <div class="item item-body">
			    <div class="card-media">
				
				  <?php if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'full' );
					} ?>
					
				</div>
		        <div class="card-content-inner"><p><?php the_excerpt(); ?></p></div>
		    </div>
		    <?php do_action( 'appp_cardlist_footer'); ?>
		</div> 
	</a>
	
</li><!-- #post-## -->

