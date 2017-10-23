<?php

/**
 * theme module support
 *
 * @since MeisterMag 1.0
 */

abstract class Tagdiv_Module {
	var $post;
	var $title_attribute;
	var $title;
	var $href;

	/**
	 * @var int|null Contains the id of the current $post thumbnail. If no thumbnail is found, the value is NULL
	 */
	protected $post_thumb_id = null;

	/**
	 * @param $post WP_Post
	 * @throws ErrorException
	 */
	function __construct( $post ) {
		if ( gettype( $post ) != 'object' || get_class( $post ) != 'WP_Post' ) {
			Tagdiv_Util::tagdiv_wp_booster_error( __FILE__, sprintf( __( '<b>tagdiv_module: </b> <em>%s</em> invalid data ( not WP_Post data )', 'meistermag' ), get_Class( $this ) ) );
		}

		$this->post = $post;

		// by default the WordPress title is not escaped on twenty fifteen
		$this->title           = get_the_title( $post->ID );
		$this->title_attribute = esc_attr( strip_tags( $this->title ) );
		$this->href            = esc_url( get_permalink( $post->ID ) );

		if ( has_post_thumbnail( $this->post->ID ) ) {
			$tmp_get_post_thumbnail_id = get_post_thumbnail_id( $this->post->ID );
			if ( ! empty( $tmp_get_post_thumbnail_id ) ) {
				// if we have a wrong id, leave the post_thumb_id NULL
				$this->post_thumb_id = $tmp_get_post_thumbnail_id;
			}
		}
	}

	/**
	 * This function returns the module classes
	 * @param string $additional_classes_array
	 * @return string
	 */
	function get_module_classes( $additional_classes_array = '' ) {
		//add the wrap and module id class
		$buffy = 'tagdiv-module-wrap';

		//show no thumb only if no thumb is detected
		if ( is_null( $this->post_thumb_id ) ) {
			$buffy .= ' tagdiv-module-no-thumb';
		}

		if ( $additional_classes_array != '' && is_array( $additional_classes_array ) ) {
			$buffy .= ' ' . implode( ' ', $additional_classes_array );
		}

		if ( is_sticky( $this->post->ID ) ) {
			$buffy .= ' sticky';
		}

		return $buffy;
	}

	/**
	 * This function returns the module post author
	 * @return string
	 */
	function get_author() {

		$buffy = '';
		$buffy .= '<span class="tagdiv-post-author-name">';
		$buffy .= '<a href="' . esc_url( get_author_posts_url( $this->post->post_author ) ) . '">' . get_the_author_meta( 'display_name', $this->post->post_author ) . '</a>';
		$buffy .= '</span>';

		return $buffy;
	}

	/**
	 * This function returns the module post date
	 * @return string
	 */
	function get_date() {

		$buffy = '';
		$tagdiv_article_date_unix = get_the_time( 'U', $this->post->ID );

		$buffy .= '<span class="tagdiv-post-date">';
		$buffy .= '<time class="entry-date updated" datetime="' . date( DATE_W3C, $tagdiv_article_date_unix ) . '" >' . get_the_time( get_option( 'date_format' ), $this->post->ID ) . '</time>';
		$buffy .= '</span>';

		return $buffy;
	}

	/**
	 * This function returns the post comments
	 * @return string
	 */
	function get_comments() {
		$buffy = '';

		$buffy .= '<div class="tagdiv-module-comments">';
		$buffy .= '<a href="' . esc_url( get_comments_link( $this->post->ID ) ) . '">';
		$buffy .= get_comments_number( $this->post->ID );
		$buffy .= '</a>';
		$buffy .= '</div>';

		return $buffy;
	}

	/**
	 * This function returns the module thumb image or a placeholder
	 * @param $thumbType
	 *
	 * @return string
	 */
	function get_image( $thumbType ) {
		$buffy        = ''; //the output buffer
		$srcset_sizes = ''; //retina image

			// if available show the post thumb
			if ( ! is_null( $this->post_thumb_id ) ) {

				// the thumb is enabled from the panel, it's time to show the real thumb
				$tagdiv_temp_image_url = wp_get_attachment_image_src( $this->post_thumb_id, $thumbType );
				$attachment_alt        = get_post_meta( $this->post_thumb_id, '_wp_attachment_image_alt', true );
				$attachment_alt        = 'alt="' . esc_attr( strip_tags( $attachment_alt ) ) . '"';
				$attachment_title      = ' title="' . esc_attr( strip_tags( $this->title ) ) . '"';

				if ( empty( $tagdiv_temp_image_url[0] ) ) {
					$tagdiv_temp_image_url[0] = '';
				}

				if ( empty( $tagdiv_temp_image_url[1] ) ) {
					$tagdiv_temp_image_url[1] = '';
				}

				if ( empty( $tagdiv_temp_image_url[2] ) ) {
					$tagdiv_temp_image_url[2] = '';
				}

				$thumb_srcset = wp_get_attachment_image_srcset( $this->post_thumb_id, $thumbType );
				$thumb_sizes  = wp_get_attachment_image_sizes( $this->post_thumb_id, $thumbType );

				if ( $thumb_srcset !== false && $thumb_sizes !== false ) {
					$srcset_sizes = ' srcset="' . $thumb_srcset . '" sizes="' . $thumb_sizes . '"';
				}

			} else {
				//we have no thumb show the placeholder
				global $_wp_additional_image_sizes;

				if ( empty( $_wp_additional_image_sizes[ $thumbType ]['width'] ) ) {
					$tagdiv_temp_image_url[1] = '';
				} else {
					$tagdiv_temp_image_url[1] = $_wp_additional_image_sizes[ $thumbType ]['width'];
				}

				if ( empty( $_wp_additional_image_sizes[ $thumbType ]['height'] ) ) {
					$tagdiv_temp_image_url[2] = '';
				} else {
					$tagdiv_temp_image_url[2] = $_wp_additional_image_sizes[ $thumbType ]['height'];
				}

				/**
				 * get thumb height and width via api
				 * first we check the global in case a custom thumb is used
				 *
				 * The api thumb is checked only for additional sizes registered and if at least one of the settings (width or height) is empty.
				 * This should be enough to avoid getting a non existing id using api thumb.
				 */
				if ( ! empty( $_wp_additional_image_sizes ) && array_key_exists( $thumbType, $_wp_additional_image_sizes ) && ( $tagdiv_temp_image_url[1] == '' || $tagdiv_temp_image_url[2] == '' ) ) {
					$tagdiv_thumb_parameters  = Tagdiv_API_Thumb::get_by_id( $thumbType );
					$tagdiv_temp_image_url[1] = $tagdiv_thumb_parameters['width'];
					$tagdiv_temp_image_url[2] = $tagdiv_thumb_parameters['height'];
				}


				$tagdiv_temp_image_url[0] = get_template_directory_uri() . '/images/no-thumb/' . $thumbType . '.png';
				$attachment_alt           = 'alt=""';
				$attachment_title         = ' title=""';
			} //end    if ( $this->post_has_thumb ) {


			$buffy .= '<div class="tagdiv-module-thumb">';
				if ( current_user_can( 'edit_posts' ) ) {
					$buffy .= '<a class="tagdiv-admin-edit" href="' . esc_url( get_edit_post_link( $this->post->ID ) ) . '">' . __( 'edit', 'meistermag' ) . '</a>';
				}
				$buffy .= '<a href="' . esc_url( $this->href ) . '" rel="bookmark" title="' . esc_attr( $this->title_attribute ) . '">';
				$buffy .= '<img width="' . $tagdiv_temp_image_url[1] . '" height="' . $tagdiv_temp_image_url[2] . '" class="tagdiv-entry-thumb" src="' . $tagdiv_temp_image_url[0] . '"' . $srcset_sizes . ' ' . $attachment_alt . $attachment_title . '/>';
				$buffy .= '</a>';
			$buffy .= '</div>'; //end wrapper

		return $buffy;
	}

	/**
	 * This function returns the module post title
	 * @return string
	 */
	function get_title() {
		$buffy = '';
		$buffy .= '<h3 class="tagdiv-entry-title">';
		$buffy .= '<a href="' . esc_url( $this->href ) . '" rel="bookmark" title="' . esc_attr( $this->title_attribute ) . '">';
		$buffy .= $this->title;
		$buffy .= '</a>';
		$buffy .= '</h3>';

		return $buffy;
	}

	/**
	 * This method is used by modules to get content that has to be excerpted (cut)
	 * IT RETURNS THE EXCERPT FROM THE POST IF IT'S ENTERED IN THE EXCERPT CUSTOM POST FIELD BY THE USER
	 *
	 * @param string $cut_at - if provided the method will just cat at that point
	 * @param string $type
	 * @return string - the post excerpt
	 */
	function get_excerpt( $cut_at = '', $type = '' ) {

		//If the user supplied the excerpt in the post excerpt custom field, we just return that
		if ( '' != $this->post->post_excerpt ) {
			return $this->post->post_excerpt;
		}

		$buffy = '';
		if ( '' != $cut_at ) {
			// simple, $cut_at and return
			$buffy .= Tagdiv_Util::tagdiv_excerpt( $this->post->post_content, $cut_at, $type, $this->post->ID );
		} else {
			//no $cut_at provided -> return the full $this->post->post_content
			$buffy .= $this->post->post_content;
		}

		return $buffy;
	}

	/**
	 * This function returns the module post category
	 * @return string
	 */
	function get_category() {

		$buffy                      = '';
		$selected_category_obj      = '';
		$selected_category_obj_id   = '';
		$selected_category_obj_name = '';


			//get one auto
			$categories = get_the_category( $this->post->ID );

			if ( is_category() ) {
				foreach ( $categories as $category ) {
					if ( $category->term_id == get_query_var( 'cat' ) ) {
						$selected_category_obj = $category;
						break;
					}
				}
			}

			if ( empty( $selected_category_obj ) && ! empty( $categories[0] ) ) {
					$selected_category_obj = $categories[0];
			}


			if ( ! empty( $selected_category_obj ) ) {
				$selected_category_obj_id   = $selected_category_obj->cat_ID;
				$selected_category_obj_name = $selected_category_obj->name;
			}


		if ( ! empty( $selected_category_obj_id ) && ! empty( $selected_category_obj_name ) ) {
			$buffy .= '<a href="' . esc_url( get_category_link( $selected_category_obj_id ) ) . '" class="tagdiv-post-category">' . $selected_category_obj_name . '</a>';
		}

		return $buffy;
	}

}