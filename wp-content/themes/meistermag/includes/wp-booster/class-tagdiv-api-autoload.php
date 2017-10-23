<?php

/**
 * The theme's autoload API
 * Class Tagdiv_API_Autoload - here we keep files for auto loading @see Tagdiv_Autoload_Classes
 *
 * @since MeisterMag 1.0
 */
class Tagdiv_API_Autoload extends Tagdiv_API_Base {
	static function add( $class_id, $file ) {
		$params_array['file'] = $file;
		parent::add_component( __CLASS__, $class_id, $params_array );
	}

	static function get_all() {
		return parent::get_all_components_metadata( __CLASS__ );
	}
}