<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @since MeisterMag 1.0
 */

get_header(); ?>

	<div class="tagdiv-main-content-wrap">
		<div class="tagdiv-search-header">
			<div class="tagdiv-container">
				<div class="tagdiv-span12">

					<h1 class="tagdiv-entry-title tagdiv-page-title">
						<span class="tagdiv-search-query"><?php echo get_search_query(); ?></span> - <span> <?php esc_html_e( 'search results', 'meistermag' );?></span>
					</h1>

				</div>
			</div>
		</div> <!-- /.tagdiv-search-header -->

		<div class="tagdiv-container">
			<div class="tagdiv-row">
				<div class="tagdiv-span8" role="main">
						<?php if ( have_posts() ) {

							$tagdiv_current_column = 1;
							$row_is_open = false;

							while (have_posts()) : the_post(); // Start the loop.

								if ( false === $row_is_open ) {
									$row_is_open = true;
									echo '<div class="tagdiv-row">'; // open a grid row
								} ?>

								<div class="tagdiv-span6">
									<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
								</div>

								<?php if ( 2 == $tagdiv_current_column and true === $row_is_open ) {
									$row_is_open = false;
									echo '</div>'; // close the grid row
								}

								if ( 2 == $tagdiv_current_column ) {
									$tagdiv_current_column = 1;
								} else {
									$tagdiv_current_column++;
								}

							endwhile; //End of the Loop

							if ( true === $row_is_open ) {
								$row_is_open = false;
								echo '</div>'; // close the grid row
							} ?>

							<div class="page-nav">
								<?php
								// Previous/next page navigation.
								the_posts_pagination( array(
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'meistermag' ) . ' </span>',
								) );
								?>
							</div>

						<?php
						// If no content, include the "No posts found" template.
						} else {
							get_template_part( 'template-parts/content', 'none' );
						}
						?>
				</div>

				<div class="tagdiv-span4 tagdiv-sidebar" role="complementary">
					<?php get_sidebar(); ?>
				</div>
			</div> <!-- /.tagdiv-row -->
		</div> <!-- /.tagdiv-container -->
	</div> <!-- /.tagdiv-main-content-wrap -->

<?php get_footer(); ?>
