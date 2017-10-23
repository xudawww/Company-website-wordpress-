<?php
	
	
	/* Validate Token  */
	$vs['validate_token'] = function () use ( $vs, $pid_suffix ) {
		global $wpvr_tokens;
		if ( ! isset( $wpvr_tokens[ $vs['id'] ]['access_token'] ) ) {
			return false;
		}
		if ( $wpvr_tokens[ $vs['id'] ]['access_token'] == '' ) {
			return false;
		} else {
			return true;
		}
	};
	
	/* REnew Token  */
	$vs['renew_token'] = function () use ( $vs, $pid_suffix ) {
		global $wpvr_tokens;
		$service = $vs['id'];
		
		$api_url  = WPVR_AUTH_URL;
		$api_args = array(
			'get_fresh_token' => 1,
			'service'         => $service,
			'access_token'    => $wpvr_tokens[ $service ]['access_token'],
			'refresh_token'   => $wpvr_tokens[ $service ]['refresh_token'],
		);
		
		$api_response = wpvr_make_curl_request( $api_url, $api_args );
		//d( $api_response );
		
		//return false;
		
		if ( $api_response['status'] != 200 ) {
			return false;
		}
		$data      = (array) wpvr_json_decode( $api_response['data'] );
		$new_token = $data['token'];
		
		//d( $data );return false;
		if ( $new_token === false ) {
			//echo "<br/>NEW TOKEN INVALID";
			return false;
		} else {
			//new dBug( $wpvr_tokens[ $service ] );
			
			$wpvr_tokens[ $service ]['access_token'] = $new_token;
			//$wpvr_tokens[ $service ]['refresh_token'] = $data['rToken'] ;
			//new dBug( $wpvr_tokens[ $service ] );
			update_option( 'wpvr_tokens', $wpvr_tokens );
			
			return $new_token;
		}
	};
	
	/* Auth Access to API service  */
	$vs['api_connect'] = function () use ( $vs, $pid_suffix ) {
		global $wpvr_tokens, $wpvr_options;
		$service    = $vs['id'];
		$api_access = array(
			'service' => $service,
			'type'    => '',
			'value'   => '',
		);
		
		if ( WPVR_FORCE_CREDENTIALS_API_CONNECT === true ) {
			$conn_type = 'advanced';
		} elseif ( $wpvr_options['apiConnect'] == 'wizzard' ) {
			$conn_type = 'wizard';
		} elseif ( $wpvr_options['apiConnect'] == 'advanced' ) {
			$conn_type = 'advanced';
		} else {
			$conn_type = 'none';
		}
		
		//d( $vs ); return false;
		
		if ( $conn_type == 'wizard' ) {
			
			//d(  $vs['validate_token']() );return $api_access;
			
			// Using the api wizzard to connect to the service API
			if ( $wpvr_tokens[ $service ]['access_token'] == '' || $wpvr_tokens[ $service ]['access_token'] === false ) {
				// There is no acces token for this service : Ask for one !
				$api_access['type']  = 'manual_access_grant';
				$api_access['value'] = false;
				
				//}elseif( wpvr_validate_token( $service ) === false ){
			} elseif ( $vs['validate_token']() === false ) {
				//}elseif( true ){
				// The API Service Token is no longer Valid
				//echo "ASKING FOR A NEW SERVICE TOKEN";
				//$new_token = $vs['renew_token']();
				//if( $new_token === false ){
				if ( false ) {
					// Cannot renew the access token : need to manual grant access
					$api_access['type']  = 'manual_access_refresh';
					$api_access['value'] = false;
					
				} else {
					// access token renewed
					$api_access['type']  = 'access_token';
					$api_access['value'] = $vs['renew_token']();
				}
			} else {
				// The API Service token is still valid
				//echo "SERVICE TOKEN IS VALID";
				$api_access['type']  = 'access_token';
				$api_access['value'] = $wpvr_tokens[ $service ]['access_token'];
			}
		} elseif ( $conn_type == 'advanced' ) {
			
			if ( $vs['client_id_name'] == '' || $vs['client_secret_name'] == '' ) {
				/* No API Key DEfined */
				if ( WPVR_ALLOW_DEFAULT_API_CREDENTIALS ) {
					/* Using DEfault API KEY */
					$api_access['type']   = 'credentials';
					$api_access['value']  = WPVR_VIMEO_CLIENT_ID;
					$api_access['secret'] = WPVR_VIMEO_CLIENT_SECRET;
				} else {
					/* REfusing access since no api credentials is used */
					$api_access['type']  = 'no_credentials';
					$api_access['value'] = false;
				}
			} else {
				/* Using User defined Vimeo API Key */
				$api_access['type']   = 'credentials';
				$api_access['value']  = $vs['client_id_name'];
				$api_access['secret'] = $vs['client_secret_name'];
			}
		}
		
		//d( $api_access );
		return $api_access;
	};
	
	/* Auth Access to API service  */
	$vs['api_auth_'] = function () use ( $vs, $pid_suffix ) {
		return false;
	};
	
	/* api auth FUNCTION of youtbe */
	$vs['api_auth'] = function ( $show_messages = true ) use ( $vs, $pid_suffix ) {
		global $wpvr_tokens;
		
		$api_access = $vs['api_connect']();
		
		if ( $api_access['type'] == 'manual_access_grant' ) {
			
			// There is no acces token for this service : Ask for one !
			if ( $show_messages === true ) {
				wpvr_render_error_notice( $vs['msgs']['authentication_error'], 'authentication_error' );
			}
			
			return false;
			
		} elseif ( $api_access['type'] == 'manual_access_refresh' ) {
			
			// Refresh Token Access
			if ( $show_messages === true ) {
				wpvr_render_error_notice( $vs['msgs']['obsolete_access'], 'authentication_error' );
			}
			
			return false;
			
		} elseif ( $api_access['type'] == 'no_credentials' ) {
			
			// REfuse access since no api credentials is used
			if ( $show_messages === true ) {
				wpvr_render_error_notice( $vs['msgs']['authentication_error'], 'authentication_error' );
			}
			
			return false;
			
		} elseif ( $api_access['type'] == 'credentials' ) {
			// Connecting to Vimeo using CREDENTIALS
			require_once( WPVR_PATH . 'assets/php/vimeo.php' );
			$api       = new Vimeo( $api_access['value'], $api_access['secret'] );
			$api_token = $api->clientCredentials();
			$api_token = wpvr_object_to_array( $api_token );
			//d( $api_token );
			
			if ( $api_token['status'] == '429' ) {
				wpvr_render_error_notice( 'Vimeo ERROR: ' . $api_token['body']['error'], 'limit_error' );
				
				return false;
			}
			
			if ( $api_token['status'] != '200' ) {
				wpvr_render_error_notice( $vs['msgs']['authentication_error'], 'authentication_error' );
				
				return false;
			} else {
				$api->setToken( $api_token['body']['access_token'] );
				
				return $api;
			}
		} elseif ( $api_access['type'] == 'access_token' ) {
			// Connecting to Vimeo Using Access Token
			require_once( WPVR_PATH . 'assets/php/vimeo.php' );
			$api = new Vimeo( '', '' );
			$api->setToken( $wpvr_tokens['vimeo']['access_token'] );
			
			return $api;
		}
		
		return false;
	};
