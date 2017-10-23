<?php
	
	/* Function to declare PHP is too old ! */
	add_action( 'admin_notices' , 'wpvr_show_php_too_old' );
	function wpvr_show_php_too_old() {
		if( version_compare( PHP_VERSION , WPVR_REQUIRED_PHP_VERSION , '<' ) ) {
			$php_version = explode( '+' , PHP_VERSION );
			?>
			<div class = "error">
				<p>
					<strong>WP Video Robot ERROR</strong><br/>
					<?php echo __( 'You are using PHP version ' , WPVR_LANG ) . $php_version[ 0 ]; ?>.<br/>
					<?php printf( __( 'WP Video Robot needs version %s at least to work properly.' , WPVR_LANG ) , WPVR_REQUIRED_PHP_VERSION ); ?><br/>
					<?php echo __( 'Please upgrade PHP.' , WPVR_LANG ); ?>
				</p>
			</div>
			<?php
		}
	}
	
	/* Function to show error message if cron not writable */
	add_action( 'admin_notices' , 'wpvr_cron_file_permission_issue' );
	function wpvr_cron_file_permission_issue() {
		$f = WPVR_PATH . 'assets/php/cron.txt';
		if( is_writable( $f ) === FALSE ) {
			?>
			<div class = "error">
				<p>
					<strong>WP Video Robot ERROR</strong><br/>
					<?php echo __( 'The plugin cannot work automatically.' , WPVR_LANG ); ?>
					<?php echo __( 'Please, make sure this file is writable :' , WPVR_LANG ); ?>
					<strong><?php echo $f; ?></strong><br/>
					<?php echo __( 'If you cannot do that, contact your host.' , WPVR_LANG ); ?>
				
				</p>
			</div>
			<?php
		}
	}
	
	/* Function to show WPVR NOtices */
	add_action( 'admin_notices' , 'wpvr_show_notices' );
	function wpvr_show_notices() {
		$wpvr_notices = get_option( 'wpvr_notices' );
		if( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'do-plugin-upgrade' ) {
			return FALSE;
		}
		if( $wpvr_notices == '' ) {
			return FALSE;
		}
		//d( $wpvr_notices );
		foreach ( (array) $wpvr_notices as $notice ) {
			if( ! isset( $notice[ 'is_manual' ] ) || $notice[ 'is_manual' ] === FALSE ) {
				wpvr_render_notice( $notice );
			}
		}
	}

	/* Function to show WPVR NOtices */
	add_action( 'admin_notices' , 'wpvr_show_multisite_notices' );
	function wpvr_show_multisite_notices() {
		if( !is_multisite() ) return FALSE;
		$wpvr_notices = get_site_option( 'wpvr_notices' );
		if( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'do-plugin-upgrade' ) {
			return FALSE;
		}
		if( $wpvr_notices == '' ) {
			return FALSE;
		}
		//d( $wpvr_notices );
		foreach ( (array) $wpvr_notices as $notice ) {
			if( ! isset( $notice[ 'is_manual' ] ) || $notice[ 'is_manual' ] === FALSE ) {
				wpvr_render_notice( $notice );
			}
		}
	}

	
	/* Function to show demo message */
	add_action( 'admin_notices' , 'wpvr_show_demo_message' );
	function wpvr_show_demo_message() {
		if( WPVR_IS_DEMO ) {
			global $current_user;
			$user_id = $current_user->ID;
			/* Check that the user hasn't already clicked to ignore the message */
			if( ! get_user_meta( $user_id , 'wpvr_show_demo_notice' ) ) {
				global $wpvr_options;
				$hideLink = "?wpvr_show_demo_notice=0";
				foreach ( (array) $_GET as $key => $value ) {
					$hideLink .= "&$key=$value";
				}
				?>
				<div class = "updated">
					<div class = "wpvr_demo_notice">
						<a class = "pull-right" href = "<?php echo $hideLink; ?>"><?php _e( 'Hide this notice' , WPVR_LANG ); ?></a>
						
						<strong>WELCOME TO THE LIVE DEMO OF WP VIDEO ROBOT v<?php echo WPVR_VERSION; ?></strong><br/><br/>
						
						<div class = "wpvr_demo_notice_left">
							<i class = "fa fa-smile-o"></i>
						</div>
						<div class = "wpvr_demo_notice_right">
							Feel free to play around with the options, add sources, test them and even schedule them to get a feel for how the plugin works. <br/>Don't forget to check this demo
							<a class = "wpvr_notice_button" href = "<?php echo WPVR_SITE_URL; ?>">FrontEnd</a> to see how do your imported videos render.
							<br/><b>You can also check out our several frontend demo sites <a class = "wpvr_notice_button" href = "<?php echo WPVR_DEMOS_URL; ?>" title = "FRONT END DEMOS">here</a></b>.
							<br/>The contents of the demo site is reset once a week.
						</div>
					</div>
					
					<div class = "wpvr_clearfix"></div>
				</div>
				<?php
			}
		}
	}
	
	/* Display message to adapt old data */
	add_action( 'admin_notices' , 'wpvr_adapt_check_imported' );
	function wpvr_adapt_check_imported() {
		global $wpvr_imported;
		$wpvr_actions_url = admin_url( 'admin.php?page=wpvr&update_imported' , 'http' );
		//new dBug( $wpvr_imported );
		if( isset( $_GET[ 'update_imported' ] ) ) {
			return FALSE;
		}
		if( $wpvr_imported === FALSE ) {
			return FALSE;
		}
		if( $wpvr_imported == '' || ! is_array( $wpvr_imported ) ) {
			
			$notice = array();
			//d( $wpvr_imported );
			
			?>
			<div class = "error warning wpvr_wp_notice" style = "display:none;">
				<div>
					<b><?php _e( 'WP Video Robot WARNING' , WPVR_LANG ); ?></b> : <br/>
					<?php _e( 'Looks like the anti duplicates filter is OFF.' , WPVR_LANG ); ?>
					<br/>
					<a href = "<?php echo $wpvr_actions_url; ?>">
						<?php echo __( 'Click here to turn it ON' , WPVR_LANG ); ?>.
					</a>
				</div>
			
			</div>
			
			<?php
		}
	}
	
	/* Display message to adapt old data */
	add_action( 'admin_notices' , 'wpvr_adapt_old_data_reminder' );
	function wpvr_adapt_old_data_reminder() {
		if( isset( $_GET[ 'adapt_old_data' ] ) ) {
			return FALSE;
		}
		$wpvr_actions_url = admin_url( 'admin.php?page=wpvr&adapt_old_data' , 'http' );
		$wpvr_is_adapted  = get_option( 'wpvr_is_adapted' );
		
		//new dBug( $wpvr_is_adapted );
		
		if( $wpvr_is_adapted != WPVR_VERSION ) {
			global $wpdb;
			
			$sql_videos
				= "
                    SELECT
                        count(*)
                    FROM
                        $wpdb->posts P
                    WHERE P.ID IN(
                        SELECT
                            P.ID
                        FROM
                            $wpdb->posts P
                            INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
                        WHERE
                            P.post_type = '" . WPVR_VIDEO_TYPE . "'
                            AND post_status != 'auto-draft'
                            AND M.meta_key = 'wpvr_video_plugin_version'
                            AND M.meta_value < '" . WPVR_VERSION . "'
                    )
                ";
			$sql_sources
				= "
                    SELECT
                        count(*)
                    FROM
                        $wpdb->posts P
                    WHERE P.ID IN(
                        SELECT
                            P.ID
                        FROM
                            $wpdb->posts P
                            INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
                        WHERE
                            P.post_type = '" . WPVR_SOURCE_TYPE . "'
                            AND post_status != 'auto-draft'
                            AND M.meta_key = 'wpvr_source_plugin_version'
                            AND M.meta_value < '" . WPVR_VERSION . "'
                    )
                ";
			
			//$items = $wpdb->get_results( $sql_sources , OBJECT);
			//new dBug( $items );
			$count_sources = $wpdb->get_var( $sql_sources );
			$count_videos  = $wpdb->get_var( $sql_videos );
			
			if( $count_videos != 0 || $count_sources != 0 ) {
				$info_notice = array(
					'title'   => __( 'WP Video Robot WARNING' , WPVR_LANG ) ,
					'class'   => 'warning' , //updated or warning or error
					'content' => '' .
					             __( 'Looks like you have some sources and videos from an older version of the plugin.' , WPVR_LANG ) .
					             '<br/>' .
					             '<a href = "' . $wpvr_actions_url . '">' .
					             __( 'Click here to adapt them to this new version' , WPVR_LANG ) . ' ( ' . WPVR_VERSION . ' )' .
					             '</a>'
					,
					'hidable' => FALSE ,
					'color'   => '#999' ,
					'icon'    => 'fa-info-circle' ,
				);
				wpvr_render_notice( $info_notice );
			} else {
				update_option( 'wpvr_is_adapted' , WPVR_VERSION );
			}
		}
	}