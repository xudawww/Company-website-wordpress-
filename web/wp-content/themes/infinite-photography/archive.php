<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */

get_header();
global $infinite_photography_customizer_all_values;
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/**
			 * infinite_photography_action_masonry_start hook
			 * @since infinite-photography 1.0.0
			 *
			 * @hooked infinite_photography_masonry_start -  0
			 */
			do_action( 'infinite_photography_action_masonry_start' );

			while ( have_posts() ) : the_post();

				/*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
				if ( $infinite_photography_customizer_all_values['infinite-photography-blog-archive-layout'] == 'photography') {
					get_template_part( 'template-parts/content', 'photography' );


				}
				else{
					get_template_part( 'template-parts/content', get_post_format() );
				}

			endwhile;
			/**
			 * infinite_photography_action_masonry_end hook
			 * @since infinite-photography 1.0.0
			 *
			 * @hooked infinite_photography_masonry_end -  0
			 */
			do_action( 'infinite_photography_action_masonry_end' );
			echo "<div class='clearfix'></div>";
			the_posts_navigation();
			else :
                get_template_part( 'template-parts/content', 'none' );
			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar( 'left' );
get_sidebar();
get_footer();
