<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Whiteboard64
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div class="top-header">
			<div class="container">
				<div class="col-sm-12 col-md-6 text-left top-date">
					<?php echo date_i18n("l jS \of F Y"); ?>
				</div>

				<div class="col-sm-12 col-md-6 socialicons">
					<ul class="socials text-right"> 
						<?php 	               	
		               	$facebook =  esc_url(get_theme_mod('facebook_link'));
		                $twitter = esc_url(get_theme_mod('twitter_link'));
		                $googleplus = esc_url(get_theme_mod('googleplus_link'));
		                $linkedin = esc_url(get_theme_mod('linkedin_link'));
		                $youtube = esc_url(get_theme_mod('youtube_link')); 
		                
		                if($facebook){?>
		                <li><a target="_blank" href="<?php echo esc_url($facebook); ?>"><i class="fa fa-facebook"></i></a></li>
		                <?php }
		                if($twitter){?>
		                <li><a target="_blank" href="<?php echo esc_url($twitter); ?>"><i class="fa fa-twitter"></i></a></li>
		                <?php }
		                if($googleplus){?>
		                <li><a target="_blank" href="<?php echo esc_url($googleplus); ?>"><i class="fa fa-google-plus"></i></a></li>
		                <?php }
		                if($linkedin){?>
		                <li><a target="_blank" href="<?php echo esc_url($linkedin); ?>"><i class="fa fa-linkedin"></i></a></li>
		                <?php }
		                if($youtube){?>
		                <li><a target="_blank" href="<?php echo esc_url($youtube); ?>"><i class="fa fa-youtube"></i></a></li>
		                <?php }
		            	?> 
					</ul>
				</div>
			</div><!-- .container -->
		</div><!-- .top-header -->

		<div class="header">
			<div class="container">
				<div class="col-sm-12 col-md-4 site-branding">
					<?php if (function_exists('whiteboard64_the_custom_logo')) : ?>	                            
		                <?php echo '<div class="site-logo">'; ?>
		    				<?php whiteboard64_the_custom_logo(); ?>
		    			<?php echo '</div>'; ?>    
		            <?php endif; ?>
		            
		            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div><!-- .site-branding -->

				<?php if ( is_active_sidebar( 'header-ad-block' ) ) : ?>
					<div class="col-sm-12 col-md-8 top-ads text-right">
						<div class="img-responsive center-block">
						<?php dynamic_sidebar( 'header-ad-block' ); ?>
						</div>
					</div>
				<?php endif; ?>

			</div><!-- .container -->
		</div><!-- .header -->

		<div class="topmenu">
			<nav class="navbar navbar-default">
				<div class="container">				

					<div class="col-sm-11 col-md-11">	
						<nav id="site-navigation" class="main-navigation" role="navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i><?php esc_html_e( 'Menu', 'whiteboard64' ); ?></button>
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'primarymenu' ) ); ?>
						</nav><!-- #site-navigation -->	
		            </div><!-- .col-md-11 -->

		            <div class="col-sm-1 col-md-1 header-search text-right">
		            	<span class="top-search header-search">
	                        <button type="button" class="btn navbar-search-theme" data-toggle="modal" data-target="#myModal">
	                            <i class="fa fa-search"></i>
	                        </button>
	                        <!-- Modal -->
	                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	                            <div class="modal-dialog">
	                                <div class="modal-content">
	                                    <div class="modal-body">
	                                        <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	                                            <input type="text" class="form-control" placeholder="Type Something to search and hit enter key" value="<?php echo get_search_query(); ?>" name="s">
	                                        </form>
	                                    </div> <!-- end of modal-body -->
	                                </div> <!-- end of modal-content -->
	                            </div> <!-- end of modal-dialog -->
	                        </div> <!-- end of modal-fade -->
	                    </span>
		            </div>

				</div><!-- .container -->
			</nav><!-- .nav fixed-top -->
		</div>
		


		<?php if( is_front_page() != '') : ?>
			<div id="carousel-whiteboard" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner" role="listbox">
					<?php
						$cid = get_theme_mod('slider_category_display');
						$category_link = get_category_link($cid);
						$whiteboard64_cat = get_category($cid);
						if ($whiteboard64_cat) {
		        	?>

		        	<?php
			            $args = array(
			              'posts_per_page' => 5,
			              'paged' => 1,
			              'cat' => $cid
			            );
			            $loop = new WP_Query($args);
			            
			            $cn = 0;
			            if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();$cn++;
			        ?>

				    <div class="item">
				    	<div class="feaImg wow fadeIn" data-wow-duration="2s">
					    	<?php the_post_thumbnail('full', 'center-block');?>
					    </div>
					    <div class="carousel-caption wow slideInLeft" data-wow-duration="2s">
					    	<div class="container">
					      		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h2>
					      		<?php the_excerpt(); ?>
					      	</div>
					    </div>
				    </div><!-- .item -->

				    <?php                 
		      			endwhile;
		      				wp_reset_postdata();  
		      			endif;                             
		    				}
		    		?>
				</div>
				<a class="left carousel-control" href="#carousel-whiteboard" data-slide="prev">
					<span class="icon-prev"></span>
				</a>
				<a class="right carousel-control" href="#carousel-whiteboard" data-slide="next">
					<span class="icon-next"></span>
				</a>
			</div> <!-- carousel slider -->
		       
		 <?php elseif ( get_header_image() ) : ?>
		    <img src="<?php header_image(); ?>" class="header-image feaImg img-responsive center-block" />
		<?php endif; ?>