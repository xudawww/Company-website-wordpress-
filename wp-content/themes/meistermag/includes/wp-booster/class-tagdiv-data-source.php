<?php

/**
 * Class Tagdiv_Data_Source - theme block posts query
 *
 * @since MeisterMag 1.0
 */

class Tagdiv_Data_Source {

	/**
	 * creates the $args array
	 * @param string $tagdiv_block_query_attributes  : the query attributes
	 * @return array
	 */
	static function shortcode_to_args( $tagdiv_block_query_attributes = '' ) {
		extract( shortcode_atts(
				array(
					'tagdiv_block_post_ids'             => '',
					'tagdiv_block_category_ids'         => '',
					'tagdiv_block_category_id'          => '',
					'tagdiv_block_tag_slug'             => '',
					'tagdiv_block_sort'                 => '',
					'tagdiv_block_posts_limit'    		=> '',
					'tagdiv_block_autors_id'            => '',
					'tagdiv_block_installed_post_types' => '',
					'tagdiv_block_offset'               => '',
				),
				$tagdiv_block_query_attributes
			)
		);

		//init the array
		$tagdiv_wp_query_args = array(
			'ignore_sticky_posts' => 1,
			'post_status' 		  => 'publish'
		);

		//the query goes only via $tagdiv_block_category_ids - for both options ( $tagdiv_block_category_ids and $tagdiv_block_category_id ) also $tagdiv_block_category_ids overwrites $tagdiv_block_category_id
		if ( ! empty( $tagdiv_block_category_id ) && empty( $tagdiv_block_category_ids ) ) {
			$tagdiv_block_category_ids = $tagdiv_block_category_id;
		}

		if ( ! empty( $tagdiv_block_category_ids ) ) {
			$tagdiv_wp_query_args['cat'] = $tagdiv_block_category_ids;
		}

		// tag slug filter
		if ( ! empty( $tagdiv_block_tag_slug ) ) {
			$tagdiv_wp_query_args['tag'] = str_replace( ' ', '-', $tagdiv_block_tag_slug );
		}

		switch ( $tagdiv_block_sort ) {

			case 'oldest_posts':
				$tagdiv_wp_query_args['order'] = 'ASC';
				break;

			case 'random_posts':
				$tagdiv_wp_query_args['orderby'] = 'rand';
				break;

			case 'alphabetical_order':
				$tagdiv_wp_query_args['orderby'] = 'title';
				$tagdiv_wp_query_args['order']   = 'ASC';
				break;

			case 'comment_count':
				$tagdiv_wp_query_args['orderby'] = 'comment_count';
				$tagdiv_wp_query_args['order']   = 'DESC';
				break;

			case 'random_today':
				$tagdiv_wp_query_args['orderby']  = 'rand';
				$tagdiv_wp_query_args['year']     = date( 'Y' );
				$tagdiv_wp_query_args['monthnum'] = date( 'n' );
				$tagdiv_wp_query_args['day']      = date( 'j' );
				break;

			case 'random_7_day':
				$tagdiv_wp_query_args['orderby']    = 'rand';
				$tagdiv_wp_query_args['date_query'] = array(
					'column' => 'post_date_gmt',
					'after'  => '1 week ago'
				);
				break;
		}

		if ( ! empty( $tagdiv_block_autors_id ) ) {
			$tagdiv_wp_query_args['author'] = $tagdiv_block_autors_id;
		}

		// add post_type to query
		if ( ! empty( $tagdiv_block_installed_post_types ) ) {
			$tagdiv_array_selected_post_types = array();
			$tagdiv_explode_installed_post_types = explode( ',', $tagdiv_block_installed_post_types );

			foreach ( $tagdiv_explode_installed_post_types as $tagdiv_val_this_post_type ) {
				if ( trim( $tagdiv_val_this_post_type ) != '' ) {
					$tagdiv_array_selected_post_types[] = trim( $tagdiv_val_this_post_type );
				}
			}

			$tagdiv_wp_query_args['post_type'] = $tagdiv_array_selected_post_types; //$tagdiv_block_installed_post_types;
		}

		// post in section
		if ( ! empty( $tagdiv_block_post_ids ) ) {

			// split posts id string
			$tagdiv_post_id_array = explode( ',', $tagdiv_block_post_ids );

			$post_in     = array();
			$post_not_in = array();

			// split ids into post_in and post_not_in
			foreach ( $tagdiv_post_id_array as $post_id ) {
				$post_id = trim( $post_id );

				// check if the ID is actually a number
				if ( is_numeric( $post_id ) ) {
					if ( intval( $post_id ) < 0 ) {
						$post_not_in [] = str_replace( '-', '', $post_id );
					} else {
						$post_in [] = $post_id;
					}
				}
			}

			// don't pass an empty post__in because it will return had_posts()
			if ( ! empty( $post_in ) ) {
				$tagdiv_wp_query_args['post__in'] = $post_in;
				$tagdiv_wp_query_args['orderby']  = 'post__in';
			}

			// check if the post__not_in is already set, if it is merge it with $post_not_in
			if ( ! empty( $post_not_in ) ) {
				if ( ! empty( $tagdiv_wp_query_args['post__not_in'] ) ) {
					$tagdiv_wp_query_args['post__not_in'] = array_merge( $tagdiv_wp_query_args['post__not_in'], $post_not_in );
				} else {
					$tagdiv_wp_query_args['post__not_in'] = $post_not_in;
				}
			}
		}

		//custom pagination tagdiv_block_posts_limit
		if ( empty( $tagdiv_block_posts_limit ) ) {
			$tagdiv_block_posts_limit = get_option( 'posts_per_page' );
		}

		$tagdiv_wp_query_args['posts_per_page'] = $tagdiv_block_posts_limit;

		if ( ! empty( $tagdiv_block_offset ) ) {
			$tagdiv_wp_query_args['offset'] = $tagdiv_block_offset;
		}

		return $tagdiv_wp_query_args;
	}

	/**
	 * used by blocks
	 * @param string $tagdiv_block_query_attributes
	 * @return WP_Query
	 */
	static function &tagdiv_get_wp_query( $tagdiv_block_query_attributes = '' ) { //by ref
		$args = self::shortcode_to_args( $tagdiv_block_query_attributes );

		$tagdiv_query = new WP_Query( $args );

		return $tagdiv_query;
	}

}

