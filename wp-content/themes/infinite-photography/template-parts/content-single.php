<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */
global $infinite_photography_customizer_all_values;
$infinite_photography_single_image_size = $infinite_photography_customizer_all_values['infinite-photography-single-image-size']

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php infinite_photography_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<!--post thumbnal options-->
    <?php
    if( has_post_thumbnail() ):
        ?>
        <div class="single-feat clearfix">
            <figure class="single-thumb single-thumb-full">
			    <?php
			    the_post_thumbnail( $infinite_photography_single_image_size );
			    ?>
            </figure>
        </div><!-- .single-feat-->
    <?php
    endif;
    ?>
	<div class="entry-content">
		<?php
        the_content();
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'infinite-photography' ),
            'after'  => '</div>',
        ) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php infinite_photography_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

