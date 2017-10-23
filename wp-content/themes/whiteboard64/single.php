<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Whiteboard64
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">

				<div class="col-sm-12 col-md-9">	
					<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', 'single' );

						the_post_navigation();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

					<div class="related-posts wow fadeInUp" data-wow-duration="2s">
						<h3><?php esc_html_e( 'Related Posts', 'whiteboard64' ); ?></h3>
						<?php
			                $related = get_posts( array( 
			                    'category__in' => wp_get_post_categories($post->ID), 
			                    'numberposts' => 6, 
			                    'post__not_in' => array($post->ID) 
			                    ) );
			                if( $related ) foreach( $related as $post ) {
			                setup_postdata($post); ?>

			                    <div class="col-xs-12 col-sm-4">
					            	<div class="row blog-details wow fadeInUp" data-wow-duration="2s">
					              		<figure>
					                		<?php if (has_post_thumbnail()) : ?>
					                			<?php the_post_thumbnail('full'); ?>
					                		<?php else : ?>
					                  			<div class="no-img"><i class="fa fa-camera-retro fa-5x"></i></div>
					                		<?php endif; ?> 
					                		<div class="detail-date wow fadeInLeft" data-wow-duration="4s">
									        	<div class="month-day"><?php echo get_the_date('d M');?></div>
									        	<div class="year"><?php echo get_the_date('Y');?></div>
									    	</div>	                       
					                  
					                		<figcaption>
					                  			<div>    
								                    <?php the_excerpt(); ?>
					                  			</div>
					                		</figcaption>
					              		</figure> <!--figure end--> 

					              		<div class="blog-info">
					                		<h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
					              		</div>
					            	</div> <!--blog-details end--> 
					          	</div>  <!--col-sm-4 end-->  

			                <?php }
			                wp_reset_postdata(); 
			            ?>
					</div>
				</div>

				<div class="col-sm-12 col-md-3">
					<?php get_sidebar(); ?>
				</div>

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();