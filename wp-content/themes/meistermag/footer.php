<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #tagdiv-site-content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @since MeisterMag 1.0
 */

?>

	</div><!-- #tagdiv-site-content -->
	<!--site footer-->
	<div class="tagdiv-footer-wrapper">
		<div class="tagdiv-footer-container">
			<div class="tagdiv-container">
				<div class="tagdiv-row">
					<div class="tagdiv-span4">
						<?php dynamic_sidebar( 'tagdiv-footer-1' ); ?>
					</div>

					<div class="tagdiv-span4">
						<?php dynamic_sidebar( 'tagdiv-footer-2' ); ?>
					</div>

					<div class="tagdiv-span4">
						<?php dynamic_sidebar( 'tagdiv-footer-3' ); ?>
					</div>
				</div>

				<div class="tagdiv-row">
					<!--logo-->
					<div class="tagdiv-span12">
						<aside class="footer-logo-wrap">
                            <?php if ( Tagdiv_Util::tagdiv_get_theme_options( 'tagdiv_footer_logo' ) == '' ) { ?>
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tagdiv-custom-logo-text-link" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                    <?php echo get_bloginfo( 'name', 'display' ) ?>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tagdiv-custom-logo-link" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                    <img src="<?php echo esc_url( Tagdiv_Util::tagdiv_get_theme_options( 'tagdiv_footer_logo' ) ) ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                                </a>
                            <?php } ?>
						</aside>
					</div>
				</div>
			</div>
		</div>

		<!-- site sub footer -->
        <?php
        $tagdiv_footer_copy_symbol = Tagdiv_Util::tagdiv_get_theme_options( 'tagdiv_subfooter_copyright_symbol' );
        $tagdiv_footer_copyright   = Tagdiv_Util::tagdiv_get_theme_options( 'tagdiv_subfooter_copyright' );

        if ( has_nav_menu( 'footer-menu' ) || ! empty( $tagdiv_footer_copyright ) ) { ?>
		<div class="tagdiv-sub-footer-container">
			<div class="tagdiv-container">
				<div class="tagdiv-row">
					<!--footer menu-->
					<div class="tagdiv-span12 tagdiv-sub-footer-menu">
						<nav class="tagdiv-footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'meistermag' ); ?>">
							<?php
							if ( has_nav_menu( 'footer-menu' ) ) {
								wp_nav_menu( array(
									'theme_location' => 'footer-menu',
									'menu_class'	 => 'tagdiv-subfooter-menu',
									'fallback_cb' 	 => false,
								) );
							} else {
								echo '<!-- no menu set -->';
							}
							?>
						</nav>
					</div>

					<div class="tagdiv-span12 tagdiv-sub-footer-copy">
						<?php
						//show copyright symbol
						if ( !empty( $tagdiv_footer_copy_symbol ) ) {
							echo '&copy; ';
						}
						echo wp_kses_post( $tagdiv_footer_copyright );
						?>
					</div>
				</div>
			</div> <!-- /.tagdiv-container -->
		</div> <!-- /.tagdiv-sub-footer-container -->
        <?php } ?>

	</div> <!-- /.tagdiv-footer-wrapper -->
</div><!-- #tagdiv-page-wrap -->

<?php wp_footer(); ?>

</body>
</html>
