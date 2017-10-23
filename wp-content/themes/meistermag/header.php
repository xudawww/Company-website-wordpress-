<?php
/**
 * The header of the theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @since MeisterMag 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- mobile navigation -->
<div class="tagdiv-menu-background"></div>
<div id="tagdiv-mobile-nav">
	<div class="tagdiv-mobile-container">
		<!-- close button -->
		<div class="tagdiv-mobile-close">
			<a href="#"><i class="tagdiv-icon-close-mobile"></i></a>
		</div>
		<!-- menu section -->
		<div class="tagdiv-mobile-content">
			<?php
			if ( has_nav_menu( 'header-menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'header-menu',
					'menu_class'	 => 'tagdiv-mobile-main-menu',
					'link_after' 	 => '<i class="tagdiv-icon-menu-right tagdiv-element-after"></i>',
					'walker'  		 => new Tagdiv_Walker_Mobile_Menu()
				) );
			} else {
				wp_nav_menu( array(
					'theme_location' => 'header-menu',
					'fallback_cb'    => wp_page_menu(
						array(
							'menu_class' => 'tagdiv-main-menu-page-list'
						)
					)
				) );
			}
			?>
		</div>
	</div>
</div>

<!-- mobile search -->
<div class="tagdiv-search-background"></div>
<div class="tagdiv-search-wrap-mob">
	<div class="tagdiv-drop-down-search">
		<div class="tagdiv-search-close">
			<a href="#"><i class="tagdiv-icon-close-mobile"></i></a>
		</div>
		<div role="search" class="tagdiv-search-input">
			<span><?php esc_html_e( 'Search', 'meistermag' )?></span>
			<?php get_search_form(); ?>
		</div>
	</div>
</div>

<div id="tagdiv-page-wrap" class="tagdiv-site">
	<!--site header-->
	<div class="tagdiv-header-wrap tagdiv-header-style">
		<div class="tagdiv-container">
			<a class="skip-link screen-reader-text" href="#tagdiv-site-content"><?php esc_html_e( 'Skip to content', 'meistermag' ); ?></a>

			<div class="tagdiv-header-logo-wrap">
				<!--header logo-->
				<div class="tagdiv-header-logo">
					<?php tagdiv_custom_logo(); ?>
				</div>
			</div>
		</div>

		<!--header menu-->
		<div class="tagdiv-header-menu-wrap">
			<div class="tagdiv-container tagdiv-header-main-menu">
				<div id="tagdiv-header-menu" role="navigation">
					<!--mobile menu toggle button-->
					<div id="tagdiv-top-mobile-toggle"><a href="#"><i class="tagdiv-icon-font tagdiv-icon-mobile"></i></a></div>

					<nav class="tagdiv-main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Header Menu (main)', 'meistermag' ); ?>">
						<?php
						if ( has_nav_menu( 'header-menu' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'header-menu',
								'menu_class'	 => 'tagdiv-sf-menu'
							) );
						} else {
							wp_nav_menu( array(
								'theme_location' => 'header-menu',
								'fallback_cb'    => wp_page_menu(
									array(
										'menu_class' => 'tagdiv-main-menu-page-list'
									)
								)
							) );
						}
						?>
					</nav>
				</div>
				<!--header menu search-->
				<div class="tagdiv-header-menu-search">
					<div class="tagdiv-search-btns-wrap">
						<a id="tagdiv-header-search-button" href="#" role="button"><i class="tagdiv-icon-search"></i></a>
						<a id="tagdiv-header-search-button-mob" href="#" role="button"><i class="tagdiv-icon-search"></i></a>
					</div>
					<div class="tagdiv-search-box-wrap">
						<div class="tagdiv-drop-down-search">
							<?php get_search_form(); ?>
						</div>
					</div>
				</div> <!-- /.tagdiv-header-menu-search -->
			</div> <!-- /.tagdiv-header-main-menu -->
		</div> <!-- /.tagdiv-header-menu-wrap -->
	</div> <!-- /.tagdiv-header-wrap -->
	<!--site content-->
	<div id="tagdiv-site-content" class="tagdiv-site-content" tabindex="-1">
