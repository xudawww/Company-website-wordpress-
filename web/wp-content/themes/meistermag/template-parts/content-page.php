<?php
/**
 * The template used for displaying page content
 *
 * @since MeisterMag 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="tagdiv-page-header">
		<?php the_title( '<h1 class="tagdiv-entry-title tagdiv-page-title">', '</h1>' ); ?>
	</header><!-- /.tagdiv-page-header -->

	<div class="tagdiv-page-content">
		<?php the_content(); ?>
	</div><!-- /.tagdiv-page-content -->

	<footer class="tagdiv-page-footer">
		<?php
		wp_link_pages( array(
			'before'      => '<div class="page-nav">',
			'after'       => '</div>',
			'link_before' => '<div>',
			'link_after'  => '</div>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'meistermag' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>
	</footer><!-- /.tagdiv-page-footer -->

</article><!-- #post-## -->
