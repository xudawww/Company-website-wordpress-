<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */
global $infinite_photography_customizer_all_values;
$infinite_photography_blog_archive_image_size = $infinite_photography_customizer_all_values['infinite-photography-blog-archive-image-size']

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php infinite_photography_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<!--post thumbnal options-->

    <?php
    if( has_post_thumbnail() ):?>
    <div class="post-thumb">
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( $infinite_photography_blog_archive_image_size )?>
        </a>
    </div><!-- .post-thumb-->
        <?php
    endif;
    ?>

	<div class="entry-content">
        <?php
		the_excerpt();
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php infinite_photography_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
