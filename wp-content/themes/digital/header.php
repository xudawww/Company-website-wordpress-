<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">
<div class="wrapper">
<div id="pronav"> <?php if (of_get_option('digital_sharebut' ) =='1' ) {load_template(get_template_directory() . '/includes/social.php'); } ?>
    <div id="pronav-inner" class="clearfix secondary">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</div>  </div>
	<div id="header">
		<div id="logo">
<?php if (of_get_option( 'digital_logo' )): ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo of_get_option( 'digital_logo' ); ?>" max-height="100px" max-width="450px" alt="<?php bloginfo( 'name' ); ?>"/></a>
      			<?php else : ?>        
           	<?php digital_site_title(); ?>
					<?php digital_site_description(); ?>
          <?php endif; ?>		
		</div>		
		<div id="banner-top"><?php echo of_get_option( 'banner_top'); ?>
		<?php if (!dynamic_sidebar('headerwid') ) : endif; ?></div>		
	</div> <!-- end div #header -->

	<!-- END HEADER -->

	<!-- BEGIN TOP NAVIGATION -->		
<div id="navigation" class="nav"> 
    <div id="navigation-inner" class="clearfix secondary">
		<?php	wp_nav_menu(array('container' => '', 'theme_location' => 'digital-navigation', 'fallback_cb' => 'digital_hdmenu'));?>
		<div id="search"><?php get_search_form(); ?></div></div>   </div>
	
	
	<?php if ( (function_exists( 'of_get_option' )) && (of_get_option('slidetitle4',true) !=1) ) {
	if ( ( of_get_option('slider_enabled') != 0 ) && ( (is_home() == true) || (is_front_page() == true) ) )  
		{ ?>  <div class="slider-wrapper theme-dark"> 
       <div id="slider" class="nivoSlider">
          <?php
		  		$slider_flag = false;
		  		for ($i=1;$i<5;$i++)
					if ( of_get_option('slide'.$i, true) != "" ) {
						echo "<a href='".esc_url(of_get_option('slideurl'.$i, true))."'><img src='".of_get_option('slide'.$i, true)."' title='".of_get_option('slidetitle'.$i, true)."'></a>";    
						$slider_flag = true; }  ?>
        </div>     
    </div>
    <?php
		if ($slider_flag == false)
		{	
			echo "<style>.slider-wrapper { display: none }</style>";
			echo "<h2>Please Add Some Images to Your slider, in order to enable it.</h2>";
		}
	 } //endif
 }//endif
 ?>
 
 <?php if (!dynamic_sidebar('belownavi') ) : endif; ?>