<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @since MeisterMag 1.0
*/

get_header(); ?>

	<div class="tagdiv-main-content-wrap">
		<div class="tagdiv-container">
			<div class="tagdiv-span12">
				<div class="tagdiv-404-head">
					<div class="tagdiv-404-title"><?php esc_html_e( '404', 'meistermag' ); ?></div>
					<div class="tagdiv-404-sub-title"><?php esc_html_e( 'Oops!', 'meistermag' ); ?></div>
					<div class="tagdiv-404-sub-sub-title"><?php esc_html_e( 'Sorry, but the page you are looking for doesn&rsquo;t exist. Please use search for help', 'meistermag' ); ?></div>

					<div class="tagdiv-search-page-wrap">
						<?php get_search_form(); ?>
					</div>
				</div>

				<?php

				$args = array(
					'post_type'=> 'post',
					'showposts' => 3,
					'ignore_sticky_posts' => 1
				);

				$tagdiv_404_query = new WP_Query( $args );

				if ( $tagdiv_404_query->have_posts() ) {

					$tagdiv_current_column = 1;
					$tagdiv_row_is_open = false;

					while ( $tagdiv_404_query->have_posts() ) {
						$tagdiv_404_query->the_post();

						if ( false === $tagdiv_row_is_open ) {
							$tagdiv_row_is_open = true;
							echo '<div class="tagdiv-row">'; // open a grid row
						} ?>

						<div class="tagdiv-span4">
							<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
						</div>

						<?php if ( 3 == $tagdiv_current_column and true === $tagdiv_row_is_open ) {
							$tagdiv_row_is_open = false;
							echo '</div>'; // close the grid row
						}

						if ( 3 == $tagdiv_current_column ) {
							$tagdiv_current_column = 1;
						} else {
							$tagdiv_current_column++;
						}
					} //end of the loop

					if ( true === $tagdiv_row_is_open ) {
						$tagdiv_row_is_open = false;
						echo '</div>'; // close the grid row
					}

					wp_reset_postdata();

				} else {

					get_template_part( 'template-parts/content', 'none' );

				}

				?>
			</div>
		</div> <!-- /.tagdiv-container -->
	</div> <!-- /.tagdiv-main-content-wrap -->

<?php get_footer(); ?>
