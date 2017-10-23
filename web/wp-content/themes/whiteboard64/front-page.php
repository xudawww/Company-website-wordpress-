<?php
/**
 * Template Name: Front Page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Whiteboard64
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">

				<div class="news-tab">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation"  class="active"><a href="#category1" aria-controls="category1" role="tab" data-toggle="tab"><?php echo ''.esc_attr( get_cat_name( get_theme_mod('news1_category_display') ) ).''?></a></li>

						<li role="presentation"><a href="#category2" aria-controls="category2" role="tab" data-toggle="tab"><?php echo ''.esc_attr( get_cat_name( get_theme_mod('news2_category_display') ) ).''?></a></li>

						<li role="presentation"><a href="#category3" aria-controls="category3" role="tab" data-toggle="tab"><?php echo ''.esc_attr( get_cat_name( get_theme_mod('news3_category_display') ) ).''?></a></li>

						<li role="presentation"><a href="#category4" aria-controls="category4" role="tab" data-toggle="tab"><?php echo ''.esc_attr( get_cat_name( get_theme_mod('news4_category_display') ) ).''?></a></li>

						<li role="presentation"><a href="#category5" aria-controls="category5" role="tab" data-toggle="tab"><?php echo ''.esc_attr( get_cat_name( get_theme_mod('news5_category_display') ) ).''?></a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="category1">
							<?php
								$cid = get_theme_mod('news1_category_display');
								$nid = get_theme_mod('category1_no');
								$category_link = get_category_link($cid);
								$whiteboard64_cat = get_category($cid);
								if ($whiteboard64_cat) {
				        	?>

				        	<?php
					            $args = array(
					              'posts_per_page' => $nid,
					              'paged' => 1,
					              'cat' => $cid
					            );
					            $loop = new WP_Query($args);					            
					            $cn = 0;
					            if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();$cn++;
					        ?>
					        <div class="col-xs-12 col-sm-4">
				            	<div class="blog-details wow fadeInUp" data-wow-duration=".5s">
				              		<figure>
				                		<?php if (has_post_thumbnail()) : ?>
				                			<?php the_post_thumbnail('full'); ?>
				                		<?php else : ?>
				                  			<div class="no-img"><i class="fa fa-camera-retro fa-5x"></i></div>
				                		<?php endif; ?> 
				                		<div class="detail-date">
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
				          	<?php                 
				      			endwhile;
				      				wp_reset_postdata();  
				      			endif;                             
				    			}
			    			?> 

			    			<!-- Add Banner -->
							<?php if ( is_active_sidebar( 'homepage-ad1-block' ) ) : ?>
								<?php dynamic_sidebar( 'homepage-ad1-block' ); ?>
							<?php endif; ?>
						</div> <!-- tabpanel-category1 -->


						<div role="tabpanel" class="tab-pane" id="category2">	
							<?php
								$cid = get_theme_mod('news2_category_display');
								$nid = get_theme_mod('category2_no');
								$category_link = get_category_link($cid);
								$whiteboard64_cat = get_category($cid);
								if ($whiteboard64_cat) {
				        	?>

				        	<?php
					            $args = array(
					              'posts_per_page' => $nid,
					              'paged' => 1,
					              'cat' => $cid
					            );
					            $loop = new WP_Query($args);					            
					            $cn = 0;
					            if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();$cn++;
					        ?>
					        <div class="col-xs-12 col-sm-4">
				            	<div class="blog-details wow fadeInUp" data-wow-duration=".5s">
				              		<figure>
				                		<?php if (has_post_thumbnail()) : ?>
				                  			<?php the_post_thumbnail('full'); ?>
				                		<?php else : ?>
				                  			<div class="no-img"><i class="fa fa-camera-retro fa-5x"></i></div>
				                		<?php endif; ?> 
				                		<div class="detail-date">
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
				          	<?php                 
				      			endwhile;
				      				wp_reset_postdata();  
				      			endif;                             
				    			}
			    			?>

			    			<!-- Add Banner -->
							<?php if ( is_active_sidebar( 'homepage-ad2-block' ) ) : ?>
								<?php dynamic_sidebar( 'homepage-ad2-block' ); ?>
							<?php endif; ?>
						</div><!-- tabpanel-category2 -->


						<div role="tabpanel" class="tab-pane" id="category3">	
							<?php
								$cid = get_theme_mod('news3_category_display');
								$nid = get_theme_mod('category3_no');
								$category_link = get_category_link($cid);
								$whiteboard64_cat = get_category($cid);
								if ($whiteboard64_cat) {
				        	?>

				        	<?php
					            $args = array(
					              'posts_per_page' => $nid,
					              'paged' => 1,
					              'cat' => $cid
					            );
					            $loop = new WP_Query($args);					            
					            $cn = 0;
					            if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();$cn++;
					        ?>
					        <div class="col-xs-12 col-sm-4">
				            	<div class="blog-details wow fadeInUp" data-wow-duration=".5s">
				              		<figure>
				                		<?php if (has_post_thumbnail()) : ?>
				                  			<?php the_post_thumbnail('full'); ?>
				                		<?php else : ?>
				                  			<div class="no-img"><i class="fa fa-camera-retro fa-5x"></i></div>
				                		<?php endif; ?> 
				                		<div class="detail-date">
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
				          	<?php                 
				      			endwhile;
				      				wp_reset_postdata();  
				      			endif;                             
				    			}
			    			?>

			    			<!-- Add Banner -->
							<?php if ( is_active_sidebar( 'homepage-ad3-block' ) ) : ?>
								<?php dynamic_sidebar( 'homepage-ad3-block' ); ?>
							<?php endif; ?>
						</div><!-- tabpanel-category3 -->



						<div role="tabpanel" class="tab-pane" id="category4">	
							<?php
								$cid = get_theme_mod('news4_category_display');
								$nid = get_theme_mod('category4_no');
								$category_link = get_category_link($cid);
								$whiteboard64_cat = get_category($cid);
								if ($whiteboard64_cat) {
				        	?>

				        	<?php
					            $args = array(
					              'posts_per_page' => $nid,
					              'paged' => 1,
					              'cat' => $cid
					            );
					            $loop = new WP_Query($args);					            
					            $cn = 0;
					            if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();$cn++;
					        ?>
					        <div class="col-xs-12 col-sm-4">
				            	<div class="blog-details wow fadeInUp" data-wow-duration=".5s">
				              		<figure>
				                		<?php if (has_post_thumbnail()) : ?>
				                  			<?php the_post_thumbnail('full'); ?>
				                		<?php else : ?>
				                  			<div class="no-img"><i class="fa fa-camera-retro fa-5x"></i></div>
				                		<?php endif; ?> 
				                		<div class="detail-date">
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
				          	<?php                 
				      			endwhile;
				      				wp_reset_postdata();  
				      			endif;                             
				    			}
			    			?>

			    			<!-- Add Banner -->
							<?php if ( is_active_sidebar( 'homepage-ad4-block' ) ) : ?>
								<?php dynamic_sidebar( 'homepage-ad4-block' ); ?>
							<?php endif; ?>
						</div><!-- tabpanel-category4 -->



						<div role="tabpanel" class="tab-pane" id="category5">	
							<?php
								$cid = get_theme_mod('news5_category_display');
								$nid = get_theme_mod('category5_no');
								$category_link = get_category_link($cid);
								$whiteboard64_cat = get_category($cid);
								if ($whiteboard64_cat) {
				        	?>

				        	<?php
					            $args = array(
					              'posts_per_page' => $nid,
					              'paged' => 1,
					              'cat' => $cid
					            );
					            $loop = new WP_Query($args);					            
					            $cn = 0;
					            if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();$cn++;
					        ?>
					        <div class="col-xs-12 col-sm-4">
				            	<div class="blog-details wow fadeInUp" data-wow-duration=".5s">
				              		<figure>
				                		<?php if (has_post_thumbnail()) : ?>
				                  			<?php the_post_thumbnail('full'); ?>
				                		<?php else : ?>
				                  			<div class="no-img"><i class="fa fa-camera-retro fa-5x"></i></div>
				                		<?php endif; ?> 
				                		<div class="detail-date">
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
				          	<?php                 
				      			endwhile;
				      				wp_reset_postdata();  
				      			endif;                             
				    			}
			    			?>

			    			<!-- Add Banner -->
							<?php if ( is_active_sidebar( 'homepage-ad5-block' ) ) : ?>
								<?php dynamic_sidebar( 'homepage-ad5-block' ); ?>
							<?php endif; ?>
						</div><!-- tabpanel-category5 -->

					</div><!-- tab-content -->
				</div><!-- news-tab -->

			</div><!-- .container -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();