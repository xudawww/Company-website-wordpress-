<?php

/**
 * theme block support - base class for blocks
 *
 * @since MeisterMag 1.0
 */

class Tagdiv_Block {
	
	var $tagdiv_query; //the query used to rendering the current block
	public $tagdiv_query_atts = array(); //the block attributes used for rendering the current block

	/**
	 * the base render function. This is called by all the child classes of this class
	 * @param $tagdiv_block_query_attributes
	 * @return string ''
	 */
	function render( $tagdiv_block_query_attributes ) {

		// All block attributes must be defined here!
		// It's easier to maintain and we always have a list of them all
		$this->tagdiv_query_atts = shortcode_atts( //add defaults (if an att is not in this list, it will be removed!)
			array(
				// posts number limit
				'tagdiv_block_posts_limit' 			=> 5,
				// posts sorting
				'tagdiv_block_sort'        			=> '',
				// post id's filter (separated by commas)
				'tagdiv_block_post_ids'             => '',
				// tag slug filter (separated by commas)
				'tagdiv_block_tag_slug'             => '',
				// filter by post authors ID
				'tagdiv_block_autors_id'            => '',
				// filter by custom post types
				'tagdiv_block_installed_post_types' => '',
				// filter by multiple category ids (multiple category filter)
				'tagdiv_block_category_id'          => '',
				// filter by category id (a single category filter)
				'tagdiv_block_category_ids'         => '',
				// custom title for the block
				'tagdiv_custom_title'  				=> '',
				// custom url for the block title
				'tagdiv_block_custom_url'          	=> '',
				// block columns number
				'tagdiv_column_number' 				=> '',
				// block posts offset
				'tagdiv_block_offset'               => '',
			),
			$tagdiv_block_query_attributes
		);

		//by ref do the query
		$this->tagdiv_query = &Tagdiv_Data_Source::tagdiv_get_wp_query( $this->tagdiv_query_atts );

		return '';
	}


	/**
	 * Used by blocks to generate titles
	 * @return string
	 */
	function get_block_title() {
		$tagdiv_block_custom_title = $this->tagdiv_query_atts['tagdiv_custom_title'];
		$tagdiv_block_custom_url   = $this->tagdiv_query_atts['tagdiv_block_custom_url'];

		if ( empty( $tagdiv_block_custom_title ) ) {
			return '';
		}

		// there is a custom title
		$tagdiv_buffer = '';
		$tagdiv_buffer .= '<h4 class="tagdiv-block-title">';
		if ( ! empty( $tagdiv_block_custom_url ) ) {
			$tagdiv_buffer .= '<a href="' . esc_url( $tagdiv_block_custom_url ) . '">' . esc_html( $tagdiv_block_custom_title ) . '</a>';
		} else {
			$tagdiv_buffer .= '<span>' . esc_html( $tagdiv_block_custom_title ) . '</span>';
		}
		$tagdiv_buffer .= '</h4>';

		return $tagdiv_buffer;
	}

	/**
	 * @param $tagdiv_additional_classes_array array - of classes to add to the block
	 * @return string
	 */
	protected function get_block_classes( $tagdiv_additional_classes_array = array() ) {

		//add the block wrap class
		$tagdiv_block_classes = array(
			'tagdiv-block-wrap'
		);

		//marge the additional classes received from blocks code
		if ( ! empty( $tagdiv_additional_classes_array ) ) {
			$tagdiv_block_classes = array_merge(
				$tagdiv_block_classes,
				$tagdiv_additional_classes_array
			);
		}

		//remove duplicates
		$tagdiv_block_classes = array_unique( $tagdiv_block_classes );

		return implode( ' ', $tagdiv_block_classes );
	}
}

