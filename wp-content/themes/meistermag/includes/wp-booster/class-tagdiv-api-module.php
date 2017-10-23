<?php

/**
 * The theme's module API
 * Class Tagdiv_API_Module static module api
 *
 * @since MeisterMag 1.0
 */
class Tagdiv_API_Module extends Tagdiv_API_Base {

	/**
	 * The method to register a new module
	 *
	 * @param $module_id           string - The module id. It must be unique
	 * @param $params_array 		array - The module_parameter array
	 *
	 *      $params_array = array (
	 *          'file' 			 => '',                     - [string] the path to the module class
	 *          'text' 			 => '',                     - [string] module name
	 *          'used_on_blocks' => array(),                - [array of strings] block names where this module is used or leave blank if it's used internally (ex. it's not used on any category)
	 * 			'class' 		 => '',						- [string] CSS class which will be added to the module
	 * 		)
	 *
	 * @throws ErrorException new exception, fatal error if the $module_id already exists
	 */
	static function add( $module_id, $params_array = array() ) {
		parent::add_component( __CLASS__, $module_id, $params_array );
	}

	static function update( $module_id, $params_array = '' ) {
		parent::update_component( __CLASS__, $module_id, $params_array );
	}


	/**
	 * This method gets the value for the ('Tagdiv_API_Module') key in the main settings array of the theme.
	 *
	 * @return mixed array The value set for the 'Tagdiv_API_Module' in the main settings array of the theme
	 */
	static function get_all() {
		return parent::get_all_components_metadata( __CLASS__ );
	}
}


