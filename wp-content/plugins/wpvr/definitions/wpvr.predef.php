<?php


	if( ! function_exists( 'wpvr_get_available_roles' ) ) {
		function wpvr_get_available_roles() {
			global $wp_roles;
			$super_users = array( 'administrator' , 'superadmin' , );

			if( strtoupper( substr( PHP_OS , 0 , 3 ) ) === 'WIN' )
				$capabilities = ABSPATH . 'wp-includes\capabilities.php';
			else
				$capabilities = ABSPATH . 'wp-includes/capabilities.php';


			$wpvr_roles = array( 'available' => array() , 'default' => array() , );
			if( $wp_roles == null ) {
				require_once( $capabilities );
				$wp_roles = new WP_Roles();
			}
			$all_roles = $wp_roles->roles;

			foreach( (array) $all_roles as $role_id => $role ) {
				if( ! in_array( $role_id , $super_users ) ){
					$wpvr_roles[ 'available' ][ $role_id ] = $role[ 'name' ];
					$wpvr_roles[ 'default' ][] = $role_id;
				}
			}

			return $wpvr_roles;
		}
	}
	