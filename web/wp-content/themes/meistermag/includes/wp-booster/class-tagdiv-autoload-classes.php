<?php

/**
 * Class Tagdiv_Autoload_Classes
 *
 * @since MeisterMag 1.0
 */
class Tagdiv_Autoload_Classes {


	/**
	 * register the spl hook
	 */
	public function __construct() {
		spl_autoload_register( array( $this, 'loading_classes' ) );
	}

	/**
	 * The callback function used by spl_autoload_register
	 *
	 * @param $class_name string - The class name
	 */
	private function loading_classes( $class_name ) {
		$path_regex = 'Tagdiv';

		// foreach regex path, the class name is verified for a start matching
		if ( ( strpos( $class_name, $path_regex ) !== false ) && ( strpos( $class_name, $path_regex ) === 0 ) ) {

			$class_settings = Tagdiv_API_Autoload::get_by_id( $class_name );

			if ( ! empty( $class_settings ) ) {
				if ( array_key_exists( 'file', $class_settings ) ) {
					$class_file_path = $class_settings['file'];

					if ( isset( $class_file_path ) && ! empty( $class_file_path ) ) {
						// set the autoloaded key for that component
						Tagdiv_API_Autoload::_debug_set_class_is_autoloaded( $class_name );

						// require_once( $class_file_path ); - we need to use load_template to make our single_templates work like wordpress
						// with load_template we prepare the globals ( $post etc for the files )
						// we should not use the global $post or any other globals in our classes without explicit declaration
						load_template( $class_file_path, true );
					}
				} else {
					Tagdiv_Util::tagdiv_wp_booster_error( __FILE__, __( 'Missing parameter: "file"', 'meistermag' ) );
				}
			}
		}
	}
}

new Tagdiv_Autoload_Classes();
