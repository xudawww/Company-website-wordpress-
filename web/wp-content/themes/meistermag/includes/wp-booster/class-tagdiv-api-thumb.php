<?php

/**
 * The theme's thumbs API
 * Class Tagdiv_API_Thumb static thumbs api
 *
 * @since MeisterMag 1.0
 */
class Tagdiv_API_Thumb extends Tagdiv_API_Base {

	/**
	 * This method is to register a new thumb
	 *
	 * @param $thumb_id           string - The thumb id. It must be unique
	 * @param $params_array 	  array - The thumb parameter array
	 *
	 *      $params_array = array (
	 *          'name' => 'tagdiv_300x220',                 - [string] the thumb name
	 *          'width' => ,                                - [int] the thumb width
	 *          'height' => ,                               - [int] the thumb height
	 *          'crop' => array('center', 'top'),           - [array of string] what crop to use (center, top, etc)
	 *          'used_on' => array('')                      - [array of string] description where the thumb is used
	 *      )
	 *
	 * @throws ErrorException new exception, fatal error if the $thumb_id already exists
	 */

	static function add( $thumb_id, $params_array = array() ) {
		parent::add_component( __CLASS__, $thumb_id, $params_array );
	}

	static function update( $thumb_id, $params_array = array() ) {

		$thumbs = self::get_all();

		// When thumbs are used in multiple modules registered by the theme and others plugins, all these modules' ids must be shown all together
		if ( ! empty( $params_array ) && array_key_exists( $thumb_id, $thumbs ) && array_key_exists( 'used_on', $params_array ) ) {
			$params_array['used_on'] = array_merge( $thumbs[ $thumb_id ]['used_on'], $params_array['used_on'] );
		}
		parent::update_component( __CLASS__, $thumb_id, $params_array );
	}

	static function get_all() {
		return parent::get_all_components_metadata( __CLASS__ );
	}
}



