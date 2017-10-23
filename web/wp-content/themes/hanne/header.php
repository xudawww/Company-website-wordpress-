<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package hanne
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'hanne' ); ?></a>
	<div id="jumbosearch">
		<span class="fa fa-remove closeicon"></span>
		<div class="form">
			<?php get_search_form(); ?>
		</div>
	</div>	
	
	<div id="slickmenu"></div>
	<nav id="site-navigation" class="main-navigation title-font" role="navigation">
		<div class="container">
			<?php
				// Get the Appropriate Walker First.
				$walker = has_nav_menu('primary') ? new Hanne_Menu_With_Icon : '';
				    //Display the Menu.							
			    wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => $walker ) ); ?>
		</div>	    
	</nav><!-- #site-navigation -->
	
	<header id="masthead" class="site-header" role="banner">
			<div class="container">
				<div class="site-branding">
					<?php if ( has_custom_logo() ) : ?>
					<div id="site-logo">
						<?php the_custom_logo(); ?>
					</div>
					<?php endif; ?>
					<div id="text-title-desc">
					<h1 class="site-title title-font"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</div>
				</div>
				
				<div id="social-icons">
					<?php get_template_part('social', 'fa'); ?>
				</div>
			</div>	
			
	</header><!-- #masthead -->
	
	<?php if( class_exists('rt_slider') ) {
			 rt_slider::render('slider', 'nivo' ); 
		} ?>
	
	
	<?php get_template_part('featured', 'posts' ); ?>
	
	<div class="mega-container">
	
		<div id="content" class="site-content container">