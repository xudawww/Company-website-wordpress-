<?php


	/* Validate Token  */
	$vs[ 'validate_token' ] = function () use ( $vs , $pid_suffix ) {
		global $wpvr_tokens;
		if ( ! isset( $wpvr_tokens[ $vs[ 'id' ] ][ 'access_token' ] ) ) {
			return FALSE;
		}
		$access_token = $wpvr_tokens[ $vs[ 'id' ] ][ 'access_token' ];
		if ( $access_token == '' ) {
			return FALSE;
		}
		$api_url  = 'https://www.googleapis.com/oauth2/v1/tokeninfo';
		$api_args = array(
			'access_token' => $access_token ,
		);

		$api_response = wpvr_make_curl_request( $api_url , $api_args );

		if ( $api_response[ 'status' ] != 200 ) {
			return FALSE;
		}
		if ( isset( $api_response[ 'json' ][ 'error' ] ) && $api_response[ 'json' ][ 'error' ] == 'invalid_token' ) {
			return FALSE;
		} else {
			return TRUE;
		}
	};

	/* REnew Token  */
	$vs[ 'renew_token' ] = function () use ( $vs , $pid_suffix ) {
		global $wpvr_tokens;
		$service = $vs[ 'id' ];
		if( !isset( $wpvr_tokens[ $service ][ 'access_token' ]) || !isset($wpvr_tokens[ $service ][ 'refresh_token' ]) ){
			return FALSE;
		}
		$api_url  = WPVR_AUTH_URL;
		$api_args = array(
			'get_fresh_token' => 1 ,
			'service'         => $service ,
			'access_token'    => $wpvr_tokens[ $service ][ 'access_token' ] ,
			'refresh_token'   => $wpvr_tokens[ $service ][ 'refresh_token' ] ,
		);

		$api_response = wpvr_make_curl_request( $api_url , $api_args );
		//d( $api_response );

		//return false;

		if ( $api_response[ 'status' ] != 200 ) {
			return FALSE;
		}
		$data = (array) wpvr_json_decode( $api_response[ 'data' ] );
		if ( ! isset( $data[ 'token' ] ) ) {
			return FALSE;
		}
		$new_token = $data[ 'token' ];

		//d( $data );return false;
		if ( $new_token === FALSE ) {
			//echo "<br/>NEW TOKEN INVALID";
			return FALSE;
		} else {
			//new dBug( $wpvr_tokens[ $service ] );

			$wpvr_tokens[ $service ][ 'access_token' ] = $new_token;
			//$wpvr_tokens[ $service ]['refresh_token'] = $data['rToken'] ;
			//new dBug( $wpvr_tokens[ $service ] );
			update_option( 'wpvr_tokens' , $wpvr_tokens );

			return $new_token;
		}
	};

	/* Auth Access to API service  */
	$vs[ 'api_connect' ] = function () use ( $vs , $pid_suffix ) {
		global $wpvr_tokens , $wpvr_options;
		$service    = $vs[ 'id' ];
		$api_access = array(
			'service' => $service ,
			'type'    => '' ,
			'value'   => '' ,
		);

		if ( WPVR_FORCE_CREDENTIALS_API_CONNECT === TRUE ) {
			$conn_type = 'advanced';
		} elseif ( $wpvr_options[ 'apiConnect' ] == 'wizzard' ) {
			$conn_type = 'wizard';
		} elseif ( $wpvr_options[ 'apiConnect' ] == 'advanced' ) {
			$conn_type = 'advanced';
		} else {
			$conn_type = 'none';
		}
		

		if ( $conn_type == 'wizard' ) {

			// Using the api wizzard to connect to the service API
			if (
				isset( $wpvr_tokens[ $service ][ 'access_token' ] )
				&& ( $wpvr_tokens[ $service ][ 'access_token' ] == '' || $wpvr_tokens[ $service ][ 'access_token' ] === FALSE
				)
			) {
				// There is no acces token for this service : Ask for one ! 
				$api_access[ 'type' ]  = 'manual_access_grant';
				$api_access[ 'value' ] = FALSE;

				//}elseif( wpvr_validate_token( $service ) === false ){
			} elseif ( $vs[ 'validate_token' ]() === FALSE ) {
				//}elseif( true ){
				// The API Service Token is no longer Valid
				//echo "ASKING FOR A NEW SERVICE TOKEN";
				//$new_token = $vs['renew_token']();
				//if( $new_token === false ){
				if ( FALSE ) {
					// Cannot renew the access token : need to manual grant access
					$api_access[ 'type' ]  = 'manual_access_refresh';
					$api_access[ 'value' ] = FALSE;
					
				} else {
					// access token renewed 
					$api_access[ 'type' ]  = 'access_token';
					$api_access[ 'value' ] = $vs[ 'renew_token' ]();
				}
			} else {
				// The API Service token is still valid 
				//echo "SERVICE TOKEN IS VALID";
				$api_access[ 'type' ]  = 'access_token';
				$api_access[ 'value' ] = $wpvr_tokens[ $service ][ 'access_token' ];
			}
		} elseif ( $conn_type == 'advanced' ) {
			if ( $vs[ 'api_key_name' ] == '' ) {
				// No API Key DEfined 
				if ( WPVR_ALLOW_DEFAULT_API_CREDENTIALS ) {
					// Using DEfault API KEY 
					$api_access[ 'type' ]  = 'credentials';
					$api_access[ 'value' ] = WPVR_DEFAULT_YOUTUBE_API_KEY;
				} else {
					// REfusing access since no api credentials is used 
					$api_access[ 'type' ]  = 'no_credentials';
					$api_access[ 'value' ] = FALSE;
				}
			} else {
				// Using User defined Youtube API Key 
				$api_access[ 'type' ]  = 'credentials';
				$api_access[ 'value' ] = $vs[ 'api_key_name' ];
			}
		}

		return $api_access;
	};

	/* Auth Access to API service  */
	$vs[ 'api_auth_' ] = function () use ( $vs , $pid_suffix ) {
		return FALSE;
	};

	/* api auth FUNCTION of youtbe */
	$vs[ 'api_auth' ] = function ( $show_messages = TRUE ) use ( $vs , $pid_suffix ) {

		$api_access = $vs[ 'api_connect' ]();

		if ( $api_access[ 'type' ] == 'manual_access_grant' ) {

			// There is no acces token for this service : Ask for one !
			if ( $show_messages === TRUE ) {
				wpvr_render_error_notice( $vs[ 'msgs' ][ 'authentication_error' ] );
			}

			return FALSE;

		} elseif ( $api_access[ 'type' ] == 'manual_access_refresh' ) {

			// Refresh Token Access
			if ( $show_messages === TRUE ) {
				wpvr_render_error_notice( $vs[ 'msgs' ][ 'obsolete_access' ] );
			}

			return FALSE;

		} elseif ( $api_access[ 'type' ] == 'no_credentials' ) {

			// REfuse access since no api credentials is used
			if ( $show_messages === TRUE ) {
				wpvr_render_error_notice( $vs[ 'msgs' ][ 'authentication_error' ] );
			}

			return FALSE;

		} elseif ( $api_access[ 'type' ] == 'credentials' ) {
			// Connecting to Youtube using CREDENTIALS
			return array(
				'method' => 'key' ,
				'value'  => $api_access[ 'value' ] ,
			);
		} elseif ( $api_access[ 'type' ] == 'access_token' ) {
			// Connecting to Youtube Using Access Token
			return array(
				'method' => 'access_token' ,
				'value'  => $api_access[ 'value' ] ,
			);
		}

		return FALSE;
	};