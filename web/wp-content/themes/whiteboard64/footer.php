<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Whiteboard64
 */

?>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">
				<?php if ( is_active_sidebar( 'footer-block' ) ) : ?>
					<div class="footer wow fadeInUp" data-wow-duration="2s">
						<?php dynamic_sidebar( 'footer-block' ); ?>
					</div><!-- .footer -->
				<?php endif; ?>	
			</div><!-- .container -->
		</footer><!-- #colophon -->

		<div class="site-info  wow fadeInUp" data-wow-duration="2s">
			<?php printf( esc_html__( 'Copyright &copy;', 'whiteboard64' ));  echo date("Y"); ?>
			<span class="sep"> | </span>

			<a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
			<span class="sep"> | </span>

			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'whiteboard64' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'whiteboard64' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'whiteboard64' ), 'whiteboard64', '<a href="'.esc_url( __( 'http://sumanshresthaa.com.np', 'whiteboard64' ) ).'" rel="designer">Suman Shrestha</a>' ); ?>		
		</div><!-- .site-info -->

		<div class="scroll-top-wrapper">
			<span class="scroll-top-inner"><i class="fa fa-angle-double-up"></i></span>
		</div>
		
	<?php wp_footer(); ?>
	</body>
</html>