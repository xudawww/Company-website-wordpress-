<?php if ( get_theme_mod('hanne_featposts_enable') && is_front_page() ) : ?>

<div class="featposts container-fluid">
	
	<?php if ( have_posts() ) : ?>
	
				<?php /* Start the Loop */  ?>
				<?php
	    		$args = array( 'posts_per_page' =>  3, 'category' => esc_html(get_theme_mod('hanne_featposts_cat')) );
				$lastposts = get_posts( $args );
				foreach ( $lastposts as $post ) :
				  setup_postdata( $post ); ?> 	
						
				<article id="post-<?php the_ID(); ?>" <?php post_class('item col-md-4 col-xs-12 col-sm-4'); ?>>
					<div class="item-container">
							<?php if (has_post_thumbnail()) : ?>	
								<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('hanne-thumb'); ?></a>
							<?php else : ?>
								<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/placeholder.png"; ?>"></a>
	
							<?php endif; ?>
					
					</div>		
					
					<div class="post-title-parent">
						<a class="post-title" href="<?php the_permalink() ?>"><?php echo the_title(); ?></a>
					</div>
						
				</article><!-- #post-## -->
					
				<?php endforeach;
					wp_reset_postdata(); ?>
	
			<?php endif; ?>

</div>

<?php endif; ?>