<?php

class AppPresser_Query {

	public $default_params;

	/**
	 * Gets or sets up the URL parameters we make available
	 * @return array $default_params
	 */
	public function get_default_params() {
		if( is_null( $this->default_params ) ) {
			
			// Use the filter to add your own parameters to check
			$this->default_params = apply_filters( 'appp_list_params', array(
				'type',             // post_type
				'list_display',     // default or cards
				'num',              // posts_per_page limit
			));
		}

		$query = new WP_Query();
		$keys = array_keys( $query->fill_query_vars( $this->default_params ) );
		foreach ($keys as $key) {
			if( is_string( $key ) )
				$this->default_params[] = $key;
		}
		return $this->default_params;
	}

	/**
	 * Do a WP_Query after getting our URL params
	 * 
	 * @return WP_Query
	 */
	public function get_query() {
		return new WP_Query( $this->get_query_args() );
	}

	/**
	 * Loops through our available params to create an array of arguments to be used in the WP_Query
	 * 
	 * @return array $query_args
	 */
	public function get_query_args() {

		// default values
		$query_args = apply_filters( 'appp_list_query_args', array(
			'post_type'     => 'post',
			'post_per_page' => 10,
		), 'default' );

		foreach ( $this->get_default_params() as $param_key ) {
			$value = $this->get_url_param( $param_key );
			if( $value ) {
				$query_args[ $this->wpize_query_arg_key( $param_key ) ] = $value;
			}
		}

		// A filter in case you need to clean up your custom args
		return apply_filters( 'appp_list_query_args', $query_args, false );
	}

	/**
	 * Converts simple key names to real WP_Query arg keys. 
	 * 
	 * i.e. 'num' converts to 'posts_per_page'
	 * 
	 * @return string $key
	 */
	public function wpize_query_arg_key( $key ) {

		switch ( $key ) {
			case 'num':
				$key = 'posts_per_page';
				break;
			
			case 'type':
				$key = 'post_type';
				break;
		}

		return $key;

	}

	/**
	 * Tests getting a parameter from the _GET
	 * 
	 * @param string $param
	 * @param mixed $default
	 * @return mixed $value
	 */
	public function get_url_param( $param, $default = false ) {

		if( is_string( $param ) && isset( $_GET[ $param ] ) && !empty( $_GET[ $param ] ) ) {
			return $_GET[ $param ];
		} else {
			return $default;
		}
	}

	/**
	 * Checks to see if the URL param for list_type exists. Defaults to 'list'
	 * @return string list|cardlist
	 */
	public function get_list_type() {
		return $this->get_url_param( 'list_type', 'medialist' );
	}
}

/**
 * A helper function to setup a WP_Query and a list type from URL parameters
 * @return array $custom_query
 */
function apppresser_custom_query() {

	$AppPresser_Query = new AppPresser_Query();
	
	$custom_query = array(
		'query' => $AppPresser_Query->get_query(),
		'list_type' => $AppPresser_Query->get_list_type(),
	);

	return $custom_query;
}