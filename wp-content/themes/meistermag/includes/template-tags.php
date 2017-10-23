<?php
/**
 * Custom MeisterMag template tags
 *
 * @since MeisterMag 1.0
 */

if ( ! function_exists( 'tagdiv_post_thumbnail' ) ) {
	/**
	 * Display an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @since MeisterMag 1.0
	 */
	function tagdiv_post_thumbnail() {
		global $post;

		if ( !has_post_thumbnail() ) {
			if ( is_singular() ) {
				return;
			} else { ?>

				<div class="tagdiv-module-image">
					<?php tagdiv_get_no_thumb( 'tagdiv_300x220' ); ?>

					<div class="tagdiv-post-category-wrap">
						<?php echo tagdiv_post_category(); ?>
					</div> <!-- /.tagdiv-post-category-wrap-->
				</div> <!-- /.tagdiv-module-image-->

			<?php
			}// End is_singular()
		} else {

			if ( post_password_required() || is_attachment() ) {
				return;
			}

			if ( is_singular() ) {
				?>

				<div class="tagdiv-post-featured-image">
					<?php
					the_post_thumbnail( 'tagdiv_640x0', array( 'alt' => esc_attr( strip_tags( get_the_title() ) ), 'class' => 'tagdiv-entry-thumb' ) );
					?>
				</div><!-- /.tagdiv-post-featured-image -->

			<?php } else { ?>

				<div class="tagdiv-module-image">
					<div class="tagdiv-module-thumb">

						<?php if ( current_user_can( 'edit_posts' ) ) { ?>
							<a class="tagdiv-admin-edit" href="<?php echo esc_url( get_edit_post_link( $post->ID ) ); ?>"><?php esc_html_e( 'edit', 'meistermag' ); ?></a>
						<?php } ?>

						<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" rel="bookmark" title="<?php echo esc_attr( strip_tags( get_the_title( $post->ID ) ) ); ?>">
							<?php the_post_thumbnail( 'tagdiv_300x220', array( 'alt' => esc_attr( strip_tags( get_the_title() ) ), 'class' => 'tagdiv-entry-thumb' ) ); ?>
						</a>

					</div><!-- /.tagdiv-module-thumb-->

					<div class="tagdiv-post-category-wrap">
						<?php echo tagdiv_post_category(); ?>
					</div> <!-- /.tagdiv-post-category-wrap-->
				</div> <!-- /.tagdiv-module-image-->

			<?php
			}// End is_singular()
		}
	}
}

if ( ! function_exists( 'tagdiv_post_category' ) ) {
	/**
	 * Display the post categories.
	 * 
	 * If multiple, this returns the first category on tagdiv module
	 * and a list of posts categories when on single views.
	 * @since MeisterMag 1.0
	 */
	function tagdiv_post_category() {
		global $post;
		$tagdiv_categories_array = array();
		$tagdiv_post_categories  = '';

		if ( is_singular() ) {
			$categories = get_the_category( $post->ID );

			if ( ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					$tagdiv_categories_array[$category->name] = array(
						'link' => get_category_link( $category->cat_ID )
					);
				}
			}

			$tagdiv_post_categories .= '<ul class="tagdiv-category">';
			foreach ( $tagdiv_categories_array as $category_name => $category_params ) {
				$tagdiv_post_categories .= '<li><a href="' . esc_url( $category_params['link'] ) . '">' . $category_name . '</a></li>';
			}
			$tagdiv_post_categories .= '</ul>';

			return $tagdiv_post_categories;

		} else {
			$tagdiv_selected_category_obj      = '';
			$tagdiv_selected_category_obj_id   = '';
			$tagdiv_selected_category_obj_name = '';

			// default post type
			$categories = get_the_category( $post->ID );

			if ( is_category() ) {
				foreach ( $categories as $category ) {
					if ( $category->term_id == get_query_var( 'cat' ) ) {
						$tagdiv_selected_category_obj = $category;
						break;
					}
				}
			}

			if ( empty( $tagdiv_selected_category_obj ) && ! empty( $categories[0] ) ) {
				if ( ! empty( $categories[0] ) ) {
					$tagdiv_selected_category_obj = $categories[0];
				}
			}

			if ( ! empty( $tagdiv_selected_category_obj ) ) {
				$tagdiv_selected_category_obj_id   = $tagdiv_selected_category_obj->cat_ID;
				$tagdiv_selected_category_obj_name = $tagdiv_selected_category_obj->name;
			}

			if ( ! empty( $tagdiv_selected_category_obj_id ) && ! empty( $tagdiv_selected_category_obj_name ) ) {
				$tagdiv_post_categories .= '<a href="' . esc_url ( get_category_link( $tagdiv_selected_category_obj_id ) ) . '" class="tagdiv-post-category">' . $tagdiv_selected_category_obj_name . '</a>';
			}

			return $tagdiv_post_categories;

		}
	}
}

if ( ! function_exists( 'tagdiv_post_header' ) ) {
	/**
	 * Display the post or module header.
	 *
	 * @since MeisterMag 1.0
	 */
	function tagdiv_post_header() {

		if ( is_singular() ) { ?>

			<div class="tagdiv-post-header">

				<?php echo tagdiv_post_category(); ?>

				<header>
					<?php the_title( '<h1 class="tagdiv-entry-title">', '</h1>' ); ?>

					<div class="tagdiv-module-meta-info">

						<div class="tagdiv-post-author-name">
							<span class="tagdiv-author-by"><?php esc_html_e( 'By ', 'meistermag' ) ?></span><a href="<?php echo esc_url( get_author_posts_url( absint( get_the_author_meta( 'ID' ) ) ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></a>
						</div>

						<div class="tagdiv-post-date">
							<time class="entry-date updated" datetime="<?php echo date( DATE_W3C, get_the_time( 'U', get_the_ID() ) ); ?>"><?php echo get_the_time( get_option( 'date_format' ), get_the_ID() ); ?></time>
						</div>

						<div class="tagdiv-post-comments">
							<a href="<?php echo esc_url(  get_comments_link( get_the_ID() ) ); ?>"><i class="tagdiv-icon-comments"></i><?php echo get_comments_number( get_the_ID() ); ?></a>
						</div>

					</div><!-- /.tagdiv-module-meta-info-->
				</header><!-- post header -->

			</div> <!-- /.tagdiv-post-header -->

		<?php } else { ?>

			<header>
				<?php the_title( sprintf( '<h3 class="tagdiv-entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

				<?php if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) { ?>

				<div class="tagdiv-module-meta-info">

					<div class="tagdiv-post-author-name">
						<span class="tagdiv-author-by"><?php esc_html_e( 'By ', 'meistermag' ) ?></span><a href="<?php echo esc_url( get_author_posts_url( absint( get_the_author_meta( 'ID' ) ) ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></a>
					</div>

					<div class="tagdiv-post-date">
						<time class="entry-date updated" datetime="<?php echo date( DATE_W3C, get_the_time( 'U', get_the_ID() ) ); ?>"><?php echo get_the_time( get_option( 'date_format' ), get_the_ID() ); ?></time>
					</div>

					<div class="tagdiv-module-comments">
						<a href="<?php echo esc_url( get_comments_link( get_the_ID() ) ); ?>"><?php echo get_comments_number( get_the_ID() ); ?></a>
					</div>

				</div>

				<?php } ?>
			</header><!-- module entry header -->

		<?php }
	}
}

if ( ! function_exists( 'tagdiv_post_tags' ) ) {
	/**
	 * Display the post tags.
	 *
	 * @since MeisterMag 1.0
	 * @return string - the the post tags html
	 */
	function tagdiv_post_tags() {

		$tagdiv_tags_array = array();
		$tagdiv_post_tags  = '';

		if ( is_singular() ) {

			$tags = get_the_tags();
			if ( ! empty( $tags ) ) {
				foreach ( $tags as $tag ) {
					$tagdiv_tags_array[ $tag->name ] = array(
						'url' => get_tag_link( $tag->term_id )
					);
				}
			}

			if ( ! empty( $tagdiv_tags_array ) ) {
				$tagdiv_post_tags .= '<ul class="tagdiv-tags tagdiv-clearfix">';
				$tagdiv_post_tags .= '<li><span>' . __( 'TAGS', 'meistermag' ) . '</span></li>';
				foreach ( $tagdiv_tags_array as $tag_name => $tag_params ) {
					$tagdiv_post_tags .= '<li><a href="' . esc_url( $tag_params['url'] ) . '">' . $tag_name . '</a></li>';
				}
				$tagdiv_post_tags .= '</ul>';
			}

			return $tagdiv_post_tags;

		}
		return '';
	}
}

if ( ! function_exists( 'tagdiv_next_prev_posts' ) ) {
	/**
	 * Display the next/prev posts.
	 *
	 * @since MeisterMag 1.0
	 * @return string - the next/prev html
	 */
	function tagdiv_next_prev_posts() {

		$tagdiv_next_prev_posts  = '';
		$tagdiv_next_post 		 = get_next_post();
		$tagdiv_prev_post 		 = get_previous_post();

		if ( is_singular() ) {

			if ( ! empty( $tagdiv_next_post ) or ! empty( $tagdiv_prev_post ) ) {

				$tagdiv_next_prev_posts .= '<div class="tagdiv-row tagdiv-post-next-prev">';
				if ( ! empty( $tagdiv_prev_post ) ) {
					$tagdiv_next_prev_posts .= '<div class="tagdiv-span6 tagdiv-post-prev-post">';
					$tagdiv_next_prev_posts .= '<div class="tagdiv-post-next-prev-content"><span class="tagdiv-prev-art">' . __( 'Previous article', 'meistermag' ) . '</span>';
					$tagdiv_next_prev_posts .= '<a href="' . esc_url( get_permalink( $tagdiv_prev_post->ID ) ) . '">' . get_the_title( $tagdiv_prev_post->ID ) . '</a>';
					$tagdiv_next_prev_posts .= '</div>';
					$tagdiv_next_prev_posts .= '</div>';
				} else {
					$tagdiv_next_prev_posts .= '<div class="tagdiv-span6 tagdiv-post-prev-post">';
					$tagdiv_next_prev_posts .= '</div>';
				}
				if ( ! empty( $tagdiv_next_post ) ) {
					$tagdiv_next_prev_posts .= '<div class="tagdiv-span6 tagdiv-post-next-post">';
					$tagdiv_next_prev_posts .= '<div class="tagdiv-post-next-prev-content"><span class="tagdiv-next-art">' . __( 'Next article', 'meistermag' ) . '</span>';
					$tagdiv_next_prev_posts .= '<a href="' . esc_url( get_permalink( $tagdiv_next_post->ID ) ) . '">' . get_the_title( $tagdiv_next_post->ID ) . '</a>';
					$tagdiv_next_prev_posts .= '</div>';
					$tagdiv_next_prev_posts .= '</div>';
				}
				$tagdiv_next_prev_posts .= '</div>';
			}

			return $tagdiv_next_prev_posts;

		}
		return '';
	}
}

if ( ! function_exists( 'tagdiv_author_box' ) ) {
	/**
	 * Display the post author box.
	 *
	 * @since MeisterMag 1.0
	 * @return string - the post author box html
	 */
	function tagdiv_author_box() {
		global $post;
		$tagdiv_author_box = '';

		if ( is_singular() ) {

			$tagdiv_author_box .= '<div class="tagdiv-author-box-wrap">';

			$tagdiv_author_box .= '<a href="' . esc_url( get_author_posts_url( $post->post_author ) ) . '">';
			$tagdiv_author_box .= get_avatar( get_the_author_meta( 'email', $post->post_author ), '96' );
			$tagdiv_author_box .= '</a>';

			$tagdiv_author_box .= '<div class="tagdiv-author-meta">';
			$tagdiv_author_box .= '<div class="tagdiv-author-name vcard author">';
			$tagdiv_author_box .= '<span class="tagdiv-post-author-url fn">';
			$tagdiv_author_box .= '<a href="' . esc_url( get_author_posts_url( $post->post_author ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $post->post_author ) ) . '</a>';
			$tagdiv_author_box .= '</span>';
			$tagdiv_author_box .= '</div>';

			if ( '' !== get_the_author_meta( 'user_url', $post->post_author ) ) {
				$tagdiv_author_box .= '<div class="tagdiv-author-url">';
				$tagdiv_author_box .= '<a href="' . esc_url( get_the_author_meta( 'user_url', $post->post_author ) ) . '">' . esc_url( get_the_author_meta( 'user_url', $post->post_author ) ) . '</a>';
				$tagdiv_author_box .= '</div>';
			}

			$tagdiv_author_box .= '<div class="tagdiv-author-description">';
			$tagdiv_author_box .= esc_html( get_the_author_meta( 'description', $post->post_author ) );
			$tagdiv_author_box .= '</div>';

			$tagdiv_author_box .= '<div class="tagdiv-clearfix"></div>';

			$tagdiv_author_box .= '</div><!-- /.tagdiv-author-meta-->';
			$tagdiv_author_box .= '</div><!-- /.tagdiv-author-box-wrap-->';

			return $tagdiv_author_box;

		}

		return '';
	}
}

if ( ! function_exists( 'tagdiv_custom_logo' ) ) {
	/**
	 * Displays the optional custom logo.
	 *
	 * Displays the site title if the custom logo is not available.
	 *
	 * @since MeisterMag 1.0
	 */
	function tagdiv_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			if( has_custom_logo() ) {
				the_custom_logo();
			} else {
			    ?>
                <h1 class="tagdiv-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<p class="tagdiv-site-description"><?php echo get_bloginfo( 'description', 'display' ); ?></p>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'tagdiv_excerpt' ) ) {
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * @since MeisterMag 1.0
	 *
	 * @param string $tagdiv_custom_class Optional. Class string of the div element. Defaults to 'tagdiv-excerpt'.
	 */
	function tagdiv_excerpt( $tagdiv_custom_class = 'tagdiv-excerpt' ) {
		$tagdiv_custom_class = esc_attr( $tagdiv_custom_class );
		?>
			<div class="<?php echo $tagdiv_custom_class; ?>">
				<?php the_excerpt(); ?>
			</div><!-- /.<?php echo $tagdiv_custom_class; ?> -->
		<?php
	}
}

if ( ! function_exists( 'tagdiv_get_no_thumb' ) ) {
	/**
	 * Displays the no_thumb placeholder or a sample image placeholder
	 *
	 * @since MeisterMag 1.0
	 *
	 * @param string $tagdiv_thumb_type - The thumb type
	 */
	function tagdiv_get_no_thumb( $tagdiv_thumb_type ) {
		global $post;

		$tagdiv_temp_image_url = get_template_directory_uri() . '/images/no-thumb/' . $tagdiv_thumb_type . '.png';

		if ( Tagdiv_Global::$tagdiv_is_demo_preview ) {
			$tagdiv_temp_image_url = tagdiv_get_sample_image();
		}

		?>
			<div class="tagdiv-module-thumb">
				<?php	if ( current_user_can( 'edit_posts' ) ) { ?>
					<a class="tagdiv-admin-edit" href="<?php echo esc_url( get_edit_post_link( $post->ID ) ); ?>"><?php esc_html_e( 'edit', 'meistermag' ); ?></a>
				<?php } ?>
				<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" rel="bookmark" title="<?php echo esc_attr( strip_tags( get_the_title( $post->ID ) ) ); ?>">
					<img class="tagdiv-entry-thumb" src="<?php echo esc_url( $tagdiv_temp_image_url ); ?>" alt="no-thumb-placeholder" title="no-thumb" />
				</a>
			</div> <!-- /.tagdiv-module-thumb-->
		<?php
	}
}