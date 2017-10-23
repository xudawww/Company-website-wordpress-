<?php
	
	// CAPI REMOTE GET REQUEST
	if ( ! function_exists( 'wpvr_capi_remote_get' ) ) {
		function wpvr_capi_remote_get( $url , $json = FALSE ) {
			
			$oUrl = parse_url( $url );
			if ( isset( $oUrl[ 'query' ] ) ) {
				parse_str( $oUrl[ 'query' ] , $args );
			} else {
				$args = array();
			}
			
			$curl_object = curl_init();
			curl_setopt( $curl_object , CURLOPT_URL , $url );
			curl_setopt( $curl_object , CURLOPT_SSL_VERIFYPEER , FALSE );
			curl_setopt( $curl_object , CURLOPT_RETURNTRANSFER , TRUE );
			curl_setopt( $curl_object , CURLOPT_HEADER , FALSE );
			curl_setopt( $curl_object , CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );
			$data = curl_exec( $curl_object );
			
			return array(
				'url'    => $url ,
				'args'   => $args ,
				'status' => curl_getinfo( $curl_object , CURLINFO_HTTP_CODE ) ,
				'data'   => $json ? (array) wpvr_json_decode( $data ) : $data ,
			);
		}
	}
	
	// CAPI BUILD QUERY FROM URL AND ARGS ARRAY
	if ( ! function_exists( 'wpvr_capi_build_query' ) ) {
		function wpvr_capi_build_query( $url = null , $args ) {
			if ( $url == null ) {
				$url      = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$protocol = stripos( $_SERVER[ 'SERVER_PROTOCOL' ] , 'https' ) === TRUE ? 'https://' : 'http://';
			} else {
				$protocol = '';
			}
			
			$oUrl = parse_url( $url );
			
			if ( isset( $oUrl[ 'query' ] ) ) {
				parse_str( $oUrl[ 'query' ] , $new_args );
			} else {
				$new_args = array();
			}
			if ( $args != array() && count( $args ) > 0 ) {
				foreach ( (array) $args as $key => $val ) {
					if ( $val === FALSE ) {
						unset( $new_args[ $key ] );
					} else {
						$new_args[ $key ] = $val;
					}
				}
			}
			
			if ( $protocol == '' && isset( $oUrl[ 'path' ] ) ) {
				return $oUrl[ 'scheme' ] . '://' . $oUrl[ 'host' ] . $oUrl[ 'path' ] . '?' . http_build_query( $new_args );
			}
			if ( ! isset( $oUrl[ 'path' ] ) ) {
				return $oUrl[ 'scheme' ] . '://' . $oUrl[ 'host' ] . '?' . http_build_query( $new_args );
			}
			
			if ( $url == 0 ) {
				return '?' . http_build_query( $new_args );
			}
			
			return $protocol . $oUrl[ 'path' ] . '?' . http_build_query( $new_args );
		}
	}
	
	// GET FULL RELEASE INFOS
	if ( ! function_exists( 'wpvr_capi_release_get_full_version' ) ) {
		function wpvr_capi_release_get_full_version( $products_slugs ) {
			$url      = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'         => WPVR_API_REQ_KEY ,
				'action'          => 'get_version' ,
				'products_slugs'  => $products_slugs ,
				'encrypt_results' => 1 ,
				//'only_version'    => 1 ,
				//'only_results'     => 1 ,
				//'get_first_result' => 1 ,
			) );
			$response = wpvr_capi_remote_get( $url , FALSE );
			//d( $response );
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			
			$data = (array) wpvr_json_decode( $response[ 'data' ] );
			
			if ( $data == array() ) {
				return FALSE;
			}
			
			//$data['msg'] = 'Render WP Update Object.';
			$data[ 'data' ] = (array) wpvr_json_decode( base64_decode( $data[ 'data' ] ) );
			
			return (array ) $data;
			
		}
	}
	
	// GET VERSION FROM comma separated products slugs
	if ( ! function_exists( 'wpvr_capi_release_get_version' ) ) {
		function wpvr_capi_release_get_version( $products_slugs ) {
			$url      = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'         => WPVR_API_REQ_KEY ,
				'action'          => 'get_version' ,
				'products_slugs'  => $products_slugs ,
				'encrypt_results' => 1 ,
				'only_version'    => 1 ,
				//'only_results'     => 1 ,
				//'get_first_result' => 1 ,
			) );
			$response = wpvr_capi_remote_get( $url , FALSE );
			//d( $response );
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			$data = (array) wpvr_json_decode( $response[ 'data' ] );
			//$data['msg'] = 'Render WP Update Object.';
			$data[ 'data' ] = (array) wpvr_json_decode( base64_decode( $data[ 'data' ] ) );
			
			return (array ) $data;
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_activate' ) ) {
		function wpvr_capi_activate( $product_slug , $purchase_code , $code_type , $new_email = '' , $new_domain = '' , $new_url = '' , $new_ip = '' , $new_cinfos = '' , $new_version = '' ) {
			global $WPVR_SERVER;
			$url = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'        => WPVR_API_REQ_KEY ,
				'action'         => 'activate' ,
				'products_slugs' => $product_slug ,
				'new_domain'     => $new_domain ,
				//'encrypt_results' => 1 ,
				'purchase_code'  => $purchase_code ,
				'new_email'      => $new_email ,
				
				'new_url'      => $new_url ,
				'new_ip'       => $new_ip ,
				'new_cinfos'   => $new_cinfos ,
				'new_version'  => $new_version ,
				'code_type'    => $code_type ,
				'only_results' => 1 ,
				
				'origin' => $WPVR_SERVER[ 'HTTP_HOST' ] ,
			) );
			//_d( $url ); return false;
			
			$response = wpvr_capi_remote_get( $url , FALSE );
			//_d( $response );
			//_d( $response['data'] );
			//return false;
			
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			$dresp = (array) wpvr_json_decode( base64_decode( $response[ 'data' ] ) );
			if ( $dresp == array() ) {
				$dresp = (array) wpvr_json_decode( $response[ 'data' ] );
			}
			
			//_d( $response[ 'data' ] );
			if ( ! isset( $dresp[ 'status' ] ) ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI error or unreachable.' ,
					'data'   => null ,
				);
			}
			
			if ( is_bool( $dresp[ 'status' ] ) ) {
				$status = ( $dresp[ 'status' ] === TRUE ) ? 1 : 0;
			} else {
				$status = $dresp[ 'status' ];
			}
			
			
			return array(
				'status' => $status ,
				'msg'    => $dresp[ 'msg' ] ,
				//'data'   => ( $dresp[ 'valid' ] === true ) ? $dresp[ 'data' ] : null ,
				'data'   => $dresp[ 'data' ] ,
			);
			
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_get_download' ) ) {
		function wpvr_capi_get_download( $product_slugs , $purchase_code , $download_version = '' ) {
			global $WPVR_SERVER;
			$url = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'          => WPVR_API_REQ_KEY ,
				'action'           => 'get_download' ,
				'products_slugs'   => $product_slugs ,
				'encrypt_results'  => 1 ,
				'purchase_code'    => $purchase_code ,
				'download_version' => $download_version ,
				'origin'           => $WPVR_SERVER[ 'HTTP_HOST' ] ,
				'only_results'     => 1 ,
			) );
			
			$response = wpvr_capi_remote_get( $url , FALSE );
			//d( $url );
			//d( $response );return FALSE;
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			$dresp = (array) wpvr_json_decode( base64_decode( $response[ 'data' ] ) );
			if ( $dresp == array() ) {
				$dresp = (array) wpvr_json_decode( $response[ 'data' ] );
			}
			
			//d( $dresp );
			
			return array(
				'status' => ( $dresp[ 'status' ] === TRUE ) ? 1 : 0 ,
				'msg'    => $dresp[ 'msg' ] ,
				//'data'   => ( $dresp[ 'valid' ] === true ) ? $dresp[ 'data' ] : null ,
				'data'   => $dresp[ 'data' ] ,
			);
			
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_verify_code' ) ) {
		function wpvr_capi_verify_code( $product_slug , $purchase_code , $code_type , $new_domain = '' , $get_details = FALSE ) {
			$args = array(
				'api_key'         => WPVR_API_REQ_KEY ,
				'action'          => 'verify' ,
				'encrypt_results' => 1 ,
				'only_results'    => 1 ,
				'products_slugs'  => $product_slug ,
				'purchase_code'   => $purchase_code ,
				'code_type'       => $code_type ,
				'new_domain'      => $new_domain ,
			);
			if ( $get_details != FALSE ) {
				$args[ 'get_licence_details' ] = 1;
			}
			
			$url = wpvr_capi_build_query( WPVR_API_REQ_URL , $args );
			
			$response = wpvr_capi_remote_get( $url , FALSE );
			//d( $url );d( $response );
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			$dresp = (array) wpvr_json_decode( base64_decode( $response[ 'data' ] ) );
			
			return array(
				'status' => ( $dresp[ 'valid' ] === TRUE ) ? 1 : 0 ,
				'msg'    => $dresp[ 'msg' ] ,
				//'data'   => ( $dresp[ 'valid' ] === true ) ? $dresp[ 'data' ] : null ,
				'data'   => $dresp[ 'data' ] ,
			);
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_get_addons' ) ) {
		function wpvr_capi_get_addons( $parent_slug ) {
			global $WPVR_SERVER;
			$url = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'         => WPVR_API_REQ_KEY ,
				'action'          => 'get' ,
				'encrypt_results' => 1 ,
				'get_addons'      => 1 ,
				'addon_of'        => $parent_slug ,
				'origin'          => $WPVR_SERVER[ 'HTTP_HOST' ] ,
			) );
			
			//d( $url );
			$response = wpvr_capi_remote_get( $url , FALSE );
			//d( $response );
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			$data = (array) wpvr_json_decode( $response[ 'data' ] );
			//$data['msg'] = 'Render WP Update Object.';
			$data[ 'data' ] = (array) wpvr_json_decode( base64_decode( $data[ 'data' ] ) );
			
			return (array ) $data;
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_release_get_info' ) ) {
		function wpvr_capi_release_get_info( $products_slugs ) {
			$url      = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'         => WPVR_API_REQ_KEY ,
				'action'          => 'get_version' ,
				'products_slugs'  => $products_slugs ,
				'encrypt_results' => 1 ,
				'render_wp_info'  => 1 ,
				//'only_version' => 1 ,
				//'only_results'     => 1 ,
				//'get_first_result' => 1 ,
			
			) );
			$response = wpvr_capi_remote_get( $url , FALSE );
			//d( $response );
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			$data = (array) wpvr_json_decode( $response[ 'data' ] );
			//$data['msg'] = 'Render WP Update Object.';
			$data[ 'data' ] = (array) wpvr_json_decode( base64_decode( $data[ 'data' ] ) );
			
			return (array ) $data;
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_alert' ) ) {
		function wpvr_capi_alert( $product_slug , $domain , $url , $ip , $version , $code = '' ) {
			global $WPVR_SERVER;
			$url      = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'        => WPVR_API_REQ_KEY ,
				'action'         => 'alert' ,
				'products_slugs' => $product_slug ,
				'alert_domain'   => $domain ,
				'alert_code'     => $code ,
				'alert_url'      => $url ,
				'alert_ip'       => $ip ,
				'alert_version'  => $version ,
				'origin'         => $WPVR_SERVER[ 'HTTP_HOST' ] ,
				
				//'encrypt_results' => 1 ,
				'only_results'   => 1 ,
			) );
			$response = wpvr_capi_remote_get( $url , FALSE );
			
			//d( $response );
			
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			$dresp = (array) wpvr_json_decode( base64_decode( $response[ 'data' ] ) );
			if ( $dresp == array() ) {
				$dresp = (array) wpvr_json_decode( $response[ 'data' ] );
			}
			
			//d( $dresp );
			
			return array(
				'status' => ( $dresp[ 'status' ] === TRUE ) ? 1 : 0 ,
				'msg'    => $dresp[ 'msg' ] ,
				//'data'   => ( $dresp[ 'valid' ] === true ) ? $dresp[ 'data' ] : null ,
				'data'   => $dresp[ 'data' ] ,
			);
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_show_update_message' ) ) {
		function wpvr_capi_show_update_message( $p = array() ) {
			
			//d( $p );
			$slug = '_wpvr_update_' . $p[ 'slug' ] . '_' . $p[ 'version' ];
			$link = WPVR_SITE_URL . '/wp-admin/plugin-install.php?tab=plugin-information&TB_iframe=true&plugin=' . $p[ 'slug' ] . '';
			$msg
			      = 'There is a new update available for <strong>' . $p[ 'name' ] . '</strong>. <br/> ' .
			        'Your version : <strong>' . $p[ 'local_version' ] . '</strong>' .
			        ' / Latest version :<strong>' . $p[ 'version' ] . '</strong> ( ' . $p[ 'date' ] . ' ). ';
			if ( $p[ 'act' ] == 1 ) {
				$msg
					.= '
	                <p class="wpvr_notice_button_wrap">
	                    <a class="thickbox open-plugin-details-modal wpvr_notice_button " href="' . $link . '" title="Click to update">
	                        ' . __( 'View this new version details' , WPVR_LANG ) . '
	                    </a>
	                </p>
                  ';
			} else {
				$activation_link = admin_url( 'admin.php?page=wpvr-licences' );
				$msg
					.= '
					<p class="wpvr_notice_button_wrap">
						<a class="wpvr_notice_button" href="' . $activation_link . '">
							<strong style="color:#FFF">Please activate your license to update.</strong>
						</a>
					</p>
				';
			}
			//d( $slug );
			wpvr_add_notice( array(
				'slug'      => $slug ,
				'title'     => 'WPVR : Update Available' ,
				'class'     => 'warning' , //updated or warning or error
				'content'   => $msg ,
				'hidable'   => TRUE ,
				'is_dialog' => FALSE ,
				'color'     => '#45B6AF' ,
				'icon'      => 'fa-refresh' ,
			) , TRUE , is_multisite() );
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_show_expiration_message' ) ) {
		function wpvr_capi_show_expiration_message( $args = array() ) {
			global $wpvr_addons;
			$args = wpvr_extend( $args , array(
				'slug'    => '' ,
				'license' => '' ,
				'since'   => '' ,
			) );
			
			if ( $args[ 'slug' ] == '' || $args[ 'slug' ] == 'wpvr' ) {
				return FALSE;
			}
			
			$addon = $wpvr_addons[ $args[ 'slug' ] ];
			
			$slug = '_wpvr_expiration_' . $args[ 'slug' ] . '_' . $args[ 'license' ];
			$link = $addon[ 'infos' ][ 'addon_url' ];
			$msg
			      = 'Your license of <strong>' . $addon[ 'infos' ][ 'title' ] . '</strong> has expired
			        <strong>' . $args[ 'since' ] . '</strong> ago.<br/>
			        <a class="wpvr_notice_button" href="' . $addon[ 'infos' ][ 'addon_url' ] . '">
			            Renew your yearly license with a 40% discount.
			        </a> 
			        ';
			//d( $slug );
			wpvr_add_notice( array(
				'slug'      => $slug ,
				'title'     => 'WP Video Robot : License Expiration' ,
				'class'     => 'warning' , //updated or warning or error
				'content'   => $msg ,
				'hidable'   => TRUE ,
				'is_dialog' => FALSE ,
				'color'     => '#45B6AF' ,
				'icon'      => 'fa-hand-peace-o' ,
			) );
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_cancel_activation' ) ) {
		function wpvr_capi_cancel_activation( $code ) {
			global $WPVR_SERVER;
			$url = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'        => WPVR_API_REQ_KEY ,
				'action'         => 'cancel_licence' ,
				'products_slugs' => 'wpvr' ,
				'purchase_code'  => $code ,
				'only_results'   => 1 ,
				'origin'         => $WPVR_SERVER[ 'HTTP_HOST' ] ,
			) );
			//_d( $url );
			
			$response = wpvr_capi_remote_get( $url , FALSE );
			
			//_d( $response['data'] );
			//return false;
			
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => nul//l ,
				);
			}
			$dresp = (array) wpvr_json_decode( base64_decode( $response[ 'data' ] ) );
			if ( $dresp == array() ) {
				$dresp = (array) wpvr_json_decode( $response[ 'data' ] );
			}
			
			//_d( $response[ 'data' ] );
			if ( ! isset( $dresp[ 'status' ] ) ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI error or unreachable.' ,
					'data'   => null ,
				);
			}
			
			if ( is_bool( $dresp[ 'status' ] ) ) {
				$status = ( $dresp[ 'status' ] === TRUE ) ? 1 : 0;
			} else {
				$status = $dresp[ 'status' ];
			}
			
			
			return array(
				'status' => $status ,
				'msg'    => $dresp[ 'msg' ] ,
				'data'   => $dresp[ 'data' ] ,
			);
			
			
		}
	}
	
	if ( ! function_exists( 'wpvr_capi_check_expiration' ) ) {
		function wpvr_capi_check_expiration( $slug , $act_id = null ) {
			if ( $act_id == null ) {
				$act = wpvr_get_activation( $slug );
				if ( ! isset( $act[ 'act_id' ] ) ) {
					return FALSE;
				}
				$act_id = $act[ 'act_id' ];
			}
			if ( $act_id == '' ) {
				return FALSE;
			}
			$url      = wpvr_capi_build_query( WPVR_API_REQ_URL , array(
				'api_key'         => WPVR_API_REQ_KEY ,
				'action'          => 'check_license' ,
				'products_slugs'  => $slug ,
				'encrypt_results' => 1 ,
				'act_id'          => $act_id ,
			) );
			$response = wpvr_capi_remote_get( $url , FALSE );
			//d( $response );
			if ( $response[ 'status' ] != 200 ) {
				return array(
					'status' => FALSE ,
					'msg'    => 'CAPI unreachable.' ,
					'data'   => null ,
				);
			}
			$data = (array) wpvr_json_decode( $response[ 'data' ] );
			//$data['msg'] = 'Render WP Update Object.';
			$data[ 'data' ] = (array) wpvr_json_decode( base64_decode( $data[ 'data' ] ) );
			
			return (array ) $data;
			
		}
	}

	
