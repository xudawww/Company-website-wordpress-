<?php
/**
 * @package Ion
 */
?>

<li id="post-<?php the_ID(); ?>" class="post-list-item">

 	<div class="item item-text-wrap">

		<a class="<?php if( class_exists( 'AppTransitions' ) ) { 
			echo apply_filters('appp_transition_left', $classname );
			} 
			?>" href="<?php the_permalink(); ?>">
		

			<div class="item-inner">
			
			  <h2 class="title"><?php the_title(); ?></h2>
			
			  <div class="item-text"><?php the_excerpt(); ?></div>
			  
			</div>
		  
		</a>
	
 	</div>
	
</li><!-- #post-## -->
