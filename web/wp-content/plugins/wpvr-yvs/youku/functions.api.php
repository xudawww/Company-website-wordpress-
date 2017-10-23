<?php

	/* Validate Token  */
	$vs[ 'validate_token' ] = function () use ( $vs , $pid_suffix ) {
		global $wpvr_tokens;
		if( isset( $wpvr_tokens[ $vs[ 'id' ] ] ) ){
			$access_token = $wpvr_tokens[ $vs[ 'id' ] ][ 'access_token' ];
			if( $access_token == '' ) return false;
			else return true;
		}else return false;
	};

	/* REnew Token  */
	$vs[ 'renew_token' ] = function () use ( $vs , $pid_suffix ) {
		global $wpvr_tokens;
		$service = $vs[ 'id' ];

		$api_url  = WPVR_AUTH_URL;
		$api_args = array(
			'get_fresh_token' => 1 ,
			'service'         => $service ,
			'access_token'    => $wpvr_tokens[ $service ][ 'access_token' ] ,
			'refresh_token'   => $wpvr_tokens[ $service ][ 'refresh_token' ] ,
		);

		$api_response = wpvr_make_curl_request( $api_url , $api_args );
		d( $api_response );
		return false;

		if( $api_response[ 'status' ] != 200 ) return false;
		$data      = (array)json_decode( $api_response[ 'data' ] );
		$new_token = $data[ 'token' ];

		//d( $data );return false;
		if( $new_token === false ) {
			//echo "<br/>NEW TOKEN INVALID";
			return false;
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
			'value'   => '',
		);

		if( WPVR_FORCE_CREDENTIALS_API_CONNECT === true )
			$connection_type = 'advanced';
		elseif( $wpvr_options[ 'apiConnect' ] == 'wizzard' )
			$connection_type = 'wizard';
		elseif( $wpvr_options[ 'apiConnect' ] == 'advanced' )
			$connection_type = 'advanced';
		else
			$connection_type = 'none';

		if( isset( $vs[ 'force_credentials' ] ) && $vs[ 'force_credentials' ] === true )
			$connection_type = 'advanced';

		//d( WPVR_FORCE_CREDENTIALS_API_CONNECT );
		//d( $wpvr_options[ 'apiConnect' ] );
		//d( $connection_type );

		if( $connection_type == 'wizard' ) {

			// Using the api wizzard to connect to the service API
			if( $wpvr_tokens[ $service ][ 'access_token' ] == '' || $wpvr_tokens[ $service ][ 'access_token' ] === false ) {
				// There is no acces token for this service : Ask for one !
				$api_access[ 'type' ]  = 'manual_access_grant';
				$api_access[ 'value' ] = false;

				//}elseif( wpvr_validate_token( $service ) === false ){
			} elseif( $vs[ 'validate_token' ]() === false ) {
				//}elseif( true ){
				// The API Service Token is no longer Valid
				//echo "ASKING FOR A NEW SERVICE TOKEN";
				//$new_token = $vs['renew_token']();
				//if( $new_token === false ){
				if( false ) {
					// Cannot renew the access token : need to manual grant access
					$api_access[ 'type' ]  = 'manual_access_refresh';
					$api_access[ 'value' ] = false;

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
		} elseif( $connection_type == 'advanced' ) {

			if( $vs[ 'client_id_name' ] == '' || $vs[ 'client_secret_name' ] == '' ) {
				/* No API Key DEfined */
				if( WPVR_ALLOW_DEFAULT_API_CREDENTIALS ) {
					/* Using DEfault API KEY */
					$api_access[ 'type' ]   = 'credentials';
					$api_access[ 'value' ]  = WPVRYVS_DEFAULT_CLIENT_ID;
					$api_access[ 'secret' ] = WPVRYVS_DEFAULT_CLIENT_SECRET;
				} else {
					/* REfusing access since no api credentials is used */
					$api_access[ 'type' ]  = 'no_credentials';
					$api_access[ 'value' ] = false;
				}
			} else {
				/* Using User defined Vimeo API Key */
				$api_access[ 'type' ]   = 'credentials';
				$api_access[ 'value' ]  = $vs[ 'client_id_name' ];
				$api_access[ 'secret' ] = $vs[ 'client_secret_name' ];
			}
		}
		return $api_access;
	};

	/* Auth Access to API service  */
	$vs[ 'api_auth_' ] = function () use ( $vs , $pid_suffix ) {
		return false;
	};

	/* api auth FUNCTION of youtbe */
	$vs[ 'api_auth' ] = function ( $show_messages = true ) use ( $vs , $pid_suffix ) {

		$api_access = $vs[ 'api_connect' ]();
		//d( $api_access );
		if( $api_access[ 'type' ] == 'manual_access_grant' ) {

			// There is no acces token for this service : Ask for one !
			if( $show_messages === true ) {
				wpvr_render_error_notice( $vs[ 'msgs' ][ 'authentication_error' ] );
			}
			return false;

		} elseif( $api_access[ 'type' ] == 'manual_access_refresh' ) {

			// Refresh Token Access
			if( $show_messages === true ) {
				wpvr_render_error_notice( $vs[ 'msgs' ][ 'obsolete_access' ] );
			}
			return false;

		} elseif( $api_access[ 'type' ] == 'no_credentials' ) {

			// REfuse access since no api credentials is used
			if( $show_messages === true ) {
				wpvr_render_error_notice( $vs[ 'msgs' ][ 'authentication_error' ] );
			}
			return false;

		} elseif( $api_access[ 'type' ] == 'credentials' ) {
			// Connecting to YOKOU using CREDENTIALS
			return array(
				'method' => 'client_id' ,
				'value'  => $api_access[ 'value' ] ,
				'secret' => $api_access[ 'secret' ] ,
			);

		} elseif( $api_access[ 'type' ] == 'access_token' ) {
			// Connecting to YOKOU using CREDENTIALS
			return array(
				'method' => 'access_token' ,
				'value'  => $api_access[ 'value' ] ,
				//'secret' => $api_access['secret'],
			);
		}
		return false;
	};
