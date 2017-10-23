<?php

/**
 * The theme's block API
 * Class Tagdiv_API_Block static block api
 *
 * @since MeisterMag 1.0
 */

class Tagdiv_API_Block extends Tagdiv_API_Base {

	/**
	 * This method to register a new block
	 *
	 * @param $block_id           string - The block id. It must be unique
	 * @param $params_array 	  array - The block_parameter array
	 *
	 *      $params_array = array(
	 *          'file' => '',                   - [string] the path to the block class
	 *          'name' => '',                   - [string] block name
	 *          'class' => '',                  - [string] CSS class which will be added to the block
	 *          'category' => '',               - [string] category to describe this block functionality. Ex categories: Content, Social, Structure.
	 * 												You can add your own category, simply enter new category title here
	 *      )
	 *
	 * @throws ErrorException new exception, fatal error if the $block_id already exists
	 */
	static function add( $block_id, $params_array = array() ) {
		parent::add_component( __CLASS__, $block_id, $params_array );
	}


	static function update( $block_id, $params_array = '' ) {
		parent::update_component( __CLASS__, $block_id, $params_array );
	}


	/**
	 * This method gets the value for the ('Tagdiv_API_Block') key in the main settings array of the theme.
	 *
	 * @return mixed array The value set for the 'Tagdiv_API_Block' in the main settings array of the theme
	 */
	static function get_all() {
		return parent::get_all_components_metadata( __CLASS__ );
	}
}

