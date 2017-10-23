<?php
/**
 * @package Ion
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

	if ( has_post_thumbnail() ) {
		echo '<div class="featured-image">';
		the_post_thumbnail( 'large' );
		echo '</div>';
	}
	?>

	<div class="entry-content padding">

		<h1 class="entry-title"><?php echo $title = apply_filters( 'appp_single_post_title', the_title(null,null,false) ); ?></h1>

		<?php

		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'ap3-ion-theme' ),
			'after'  => '</div>',
		) );
		?>

		<footer class="entry-meta">
			<?php 

				// Post on meta
				echo '<span class="appp-posted-on">';
				appp_posted_on();
				echo '</span>';
				
			?>

			<?php edit_post_link( __( 'Edit', 'ap3-ion-theme' ), '<span class="sep"> | </span><span class="edit-link no-ajax">', '</span>' ); ?>
		</footer><!-- .entry-meta -->

	</div><!-- .entry-content -->
</article><!-- #post-## -->
