<?php
	
	
	global $wpvr_is_cli;
	$wpvr_is_cli = false;
	
	global $wpvr_is_json;
	$wpvr_is_cli = false;
	
	global $cron_lines;
	$cron_lines = '';
	
	global $cron_data_file;
	
	
	define( 'WPVR_CRON_ROOT', dirname( __FILE__ ) );
	define( 'WPVR_CRON_FILE', $cron_data_file );
	define( 'WPVR_CRON_DEBUG', WPVR_CRON_ROOT . "/assets/php/dBug.php" );
	define( 'WPVR_CRON_JSON_DELIMITER', "##_@wpvr@_##" );
	
	if ( ! function_exists( 'wpvr_chrono_time' ) ) {
		function wpvr_chrono_time( $start = false ) {
			$time = explode( ' ', microtime() );
			if ( $start === false ) {
				return $time[0] + $time[1];
			} else {
				return round( wpvr_chrono_time() - $start, 6 );
			}
		}
	}
	
	$timer = wpvr_chrono_time();
	require_once( WPVR_CRON_DEBUG );
	
	if ( ! file_exists( WPVR_CRON_FILE ) ) {
		file_put_contents( WPVR_CRON_FILE, ' ' );
	}
	
	
	if ( ! is_writable( WPVR_CRON_FILE ) ) {
		$error_notice_slug = wpvr_add_notice( array(
			'title'     => 'WP Video Robot : ',
			'class'     => 'error', //updated or warning or error
			'content'   => __( 'WPVR CRON could not work properly, since the plugin folder is not writable.', WPVR_LANG ),
			'hidable'   => false,
			'is_dialog' => false,
			'show_once' => true,
			'color'     => '#e4503c',
			'icon'      => 'fa-exclamation-circle',
		) );
		wpvr_render_notice( $error_notice_slug );
		wpvr_remove_notice( $error_notice_slug );
		
		return false;
	}
	
	if ( isset( $argv ) ) {
		global $CLI_SERVER;
		
		//print_r( $argv );
		
		if ( isset( $argv[1] ) ) {
			$_GET['token'] = $argv[1];
		}
		if ( isset( $argv[2] ) && $argv[2] == 'debug' ) {
			$_GET['debug'] = 1;
		}
		if ( isset( $argv[3] ) && $argv[3] == 'json' ) {
			$_GET['json'] = 1;
		}
		
		$wpvr_is_cli = true;
		
		$CLI_SERVER['HTTP_HOST']       = '';
		$CLI_SERVER['SERVER_PROTOCOL'] = '';
		$CLI_SERVER['REQUEST_METHOD']  = '';
		$CLI_SERVER['PHP_SELF']        = '';
		$CLI_SERVER['REQUEST_URI']     = '';
		
		$WPVR_SERVER = $CLI_SERVER;
		
		
		$_SERVER['SERVER_PROTOCOL'] = '';
		$_SERVER['REQUEST_METHOD']  = '';
		
	} else {
		$WPVR_SERVER = $_SERVER;
	}
	
	
	//new dbug( $WPVR_SERVER );
	
	//echo "DO TEST \n";
	//return false;
	
	
	if ( ! isset( $_GET['debug'] ) ) {
		define( 'WPVR_CRON_SILENT', true );
	} else {
		define( 'WPVR_CRON_SILENT', false );
	}
	
	if ( ! isset( $_GET['json'] ) ) {
		define( 'WPVR_CRON_JSON', false );
	} else {
		define( 'WPVR_CRON_JSON', true );
		$wpvr_is_json = true;
		$cron_lines   = array();
	}
	
	
	function cron_say( $message, $echo = false ) {
		global $cron_lines, $wpvr_is_cli, $wpvr_is_json;
		if ( $wpvr_is_json === true ) {
			$cron_lines[] = $message;
			
			return true;
		}
		
		if ( $wpvr_is_cli === false ) {
			$line = '';
			$line .= '<div class="cron_line">';
			$line .= '<strong> CRON : </strong> ' . $message;
			$line .= '</div>';
		} else {
			$line = "--- " . $message . " \n";
		}
		$cron_lines .= $line;
		
		if ( $echo === true ) {
			echo $line;
		}
		
	}
	
	
	function wpvr_cron_init() {
		global $cron_lines;
		
		cron_say( 'Cron started.' );
		
		
		$cron_data = wpvr_object_to_array( @wpvr_json_decode( @file_get_contents( WPVR_CRON_FILE ) ) );
		if ( ! isset( $cron_data ) ) {
			date_default_timezone_set( 'UTC' );
		}
		
		// YOU SOULD GET AND USE TIMEZONE !!!!!!!
		$cron_timezone = wpvr_get_timezone();
		$now           = new DateTime( 'now', new DateTimeZone( $cron_timezone ) );
		
		$cronStep    = 10;
		$maxCronStep = 50;
		$runStep     = 50;
		$deferStep   = 10;
		
		
		if ( isset( $_GET['show'] ) ) {
			new dBug( $cron_data );
			//return false;
		}
		
		if ( $cron_data == null ) {
			//FIRST EXEC 			
			//$t = explode( 'wp-content' , dirname( __FILE__ ) );
			//@require_once( $t[ 0 ] . '/wp-blog-header.php' );
			global $wpvr_options, $wpvr_cron_token;
			
			
			$cron_data = array(
				//'purchase_code' => $now->format("Y-m-d H:i:s"),
				'first_exec'      => $now->format( "Y-m-d H:i:s" ),
				'last_exec'       => $now->format( "Y-m-d H:i:s" ),
				'last_exec_run'   => '',
				'last_exec_defer' => '',
				'total_exec'      => 0,
				'counter'         => 0,
				'token'           => '',
				'timezone'        => $cron_timezone,
			);
		} else {
			$cron_data['last_exec'] = $now->format( "Y-m-d H:i:s" );
		}
		
		$cron_data['total_exec'] = $cron_data['total_exec'] + 1;
		
		if ( ! isset( $_GET['token'] ) ) {
			cron_say( 'token $_GET variable not defined. RETURN ! ' );
			
			if ( WPVR_CRON_JSON ) {
				return array(
					'status'   => 0,
					'timeZone' => $cron_data['timezone'],
					'time'     => $now->format( "Y-m-d H:i:s" ),
					'step'     => $cronStep,
					'lines'    => $cron_lines,
				);
			}
			
			return false;
		} else {
			cron_say( 'token defined, continue ...' );
			$token = $_GET['token'];
		}
		
		if ( isset( $_GET['doExec'] ) ) {
			$cron_data['counter'] = 40;
		}
		
		if ( isset( $_GET['doCount'] ) ) {
			$new_count            = $_GET['doCount'] == 0 ? 0 : $_GET['doCount'] - $cronStep;
			$cron_data['counter'] = $new_count;
		}
		
		if ( $cron_data['counter'] >= $maxCronStep ) {
			$cron_data['counter'] = 0;
		} else {
			$cron_data['counter'] = $cron_data['counter'] + $cronStep;
		}
		
		cron_say( 'cron_count = ' . $cron_data['counter'] );
		
		if ( $cron_data['counter'] != 0 && ( $cron_data['counter'] % $runStep == 0 ) ) {
			$cron_step = 'run';
			//$t         = explode( 'wp-content' , dirname( __FILE__ ) );
			//@require_once( $t[ 0 ] . '/wp-blog-header.php' );
			global $wpvr_options, $wpvr_cron_token;
			$token = $_GET['token'];
			
			
			cron_say( 'Running Step ... ' );
			do_action( 'wpvr_event_cron_run_before', $cron_data['counter'] );
			
			if ( $cron_data['token'] != $wpvr_cron_token ) {
				$cron_data['token'] = $wpvr_cron_token;
			}
			
			
			if ( ! function_exists( 'wpvr_add_video' ) ) {
				cron_say( "WP Video Robot is not Active. RETURN !" );
				file_put_contents( WPVR_CRON_FILE, wpvr_json_encode( $cron_data ) );
				
				if ( WPVR_CRON_JSON ) {
					return array(
						'status'   => 0,
						'timeZone' => $cron_data['timezone'],
						'time'     => $now->format( "Y-m-d H:i:s" ),
						'step'     => $cron_step,
						'count'    => $cron_data['counter'],
						'lines'    => $cron_lines,
					);
				}
				
				return false;
			}
			
			
			if ( $token != $wpvr_cron_token ) {
				//$t = "token=$token and wpvr_cron_token=$wpvr_cron_token"; 
				cron_say( "Token Not Valid. RETURN !" );
				file_put_contents( WPVR_CRON_FILE, wpvr_json_encode( $cron_data ) );
				
				if ( WPVR_CRON_JSON ) {
					return array(
						'status'   => 0,
						'timeZone' => $cron_data['timezone'],
						'time'     => $now->format( "Y-m-d H:i:s" ),
						'step'     => $cron_step,
						'count'    => $cron_data['counter'],
						'lines'    => $cron_lines,
					);
				}
				
				return false;
			} else {
				cron_say( 'Token Valid, continue ... ' );
			}
			$doWork = wpvr_doWork();
			if ( ! $doWork ) {
				cron_say( 'CRON not allowed to work. EXIT ! ' );
				file_put_contents( WPVR_CRON_FILE, wpvr_json_encode( $cron_data ) );
				
				if ( WPVR_CRON_JSON ) {
					return array(
						'status'   => 0,
						'timeZone' => $cron_data['timezone'],
						'time'     => $now->format( "Y-m-d H:i:s" ),
						'step'     => $cron_step,
						'count'    => $cron_data['counter'],
						'lines'    => $cron_lines,
					);
				}
				
				return false;
			} else {
				cron_say( 'Cron is allowed to work, continue ... ' );
			}
			
			$nowTime = wpvr_get_time( 'now', false, true, false );
			$sources = wpvr_get_sources( array(
				'status'      => 'on',
				'type'        => '',
				'scheduled'   => 'now', // now | inNextHour
				'post_status' => array( 'publish' ), // now | inNextHour
			) );
			// d( $sources );
			
			
			//return false;
			
			
			$sources        = apply_filters( 'wpvr_extend_sources_autorun', $sources, $now );
			$source_titling = apply_filters( 'wpvr_extend_sources_autorun_done', 'WPVR Native Agenda' );
			
			
			if ( $sources !== false ) {
				if ( count( $sources ) == 0 ) {
					cron_say( 'Using '. $source_titling );
					cron_say( __( 'No active sources scheduled at', WPVR_LANG ) . ' ' . $nowTime . ' (' . wpvr_get_timezone_name( wpvr_get_timezone() ) . ')' );
					cron_say( __( 'Nothing to do. Cron terminated.', WPVR_LANG ) );
					
					return false;
				} else {
					cron_say( 'Using '. $source_titling );
					cron_say( count( $sources ) . ' ' . __( 'sources scheduled at', WPVR_LANG ) . ' ' . $nowTime . ' (' . wpvr_get_timezone_name( wpvr_get_timezone() ) . ')' );
				}
			}
			
			if ( $sources !== false && count( $sources ) != 0 ) {
				cron_say( wpvr_render_source_list_names( $sources ) );
				if ( $wpvr_options['enableAsync'] ) {
					cron_say( 'Running sources asynchronously... ' );
					$async = wpvr_async_run_sources( $sources, true, false );
					// d( $async );
					
					$return = array(
						'status'         => true,
						'msg'            => '',
						'exec_time'      => $async['fetching']['exec_time'] + $async['adding']['exec_time'],
						'count_added'    => $async['adding']['added'],
						'count_deferred' => $async['adding']['deferred'],
						'count_sources'  => $async['adding']['sources'],
						'count_skipped'  => $async['fetching']['count_duplicates'] + $async['fetching']['count_unwanted'],
					);
					
				} else {
					cron_say( 'Running sources... ' );
					$return = wpvr_run_sources( $sources, true, false );
					//$return['exec_time'] = 0;
					
				}
				
				//cron_say( $return['count_sources'] . ' active source(s) found... ' );
				cron_say( $return['count_added'] + $return['count_deferred'] . ' videos found ... ' );
				//d( $return );
				if ( $return['status'] === true ) {
					$msg = "<strong> " . $return['count_added'] . " </strong> " . wpvr_get_plural( $return['count_added'], ___( 'video' ), ___( 'videos' ) ) . " added, " .
					       "<strong>" . $return['count_deferred'] . "</strong> " . wpvr_get_plural( $return['count_deferred'], ___( 'video' ), ___( 'videos' ) ) . " deferred and " .
					       "<strong>" . $return['count_skipped'] . "</strong> " . wpvr_get_plural( $return['count_skipped'], ___( 'video' ), ___( 'videos' ) ) . " skipped.";
				} else {
					$msg = $return['msg'];
				}
				
				cron_say( $msg );
				
				// d( $return );
				if ( isset( $return['exec_time'] ) ) {
					cron_say( 'Executed in ' . round( $return['exec_time'], 2 ) . ' sec.' );
				}
				do_action( 'wpvr_event_cron_run_after', $cron_data['counter'], $sources, $return );
			}
			
			if ( $wpvr_options['timeZone'] != $cron_data['timezone'] ) {
				$cron_data['timezone'] = $wpvr_options['timeZone'];
			}
			
			$cron_data['last_exec_run'] = $now->format( "Y-m-d H:i:s" );
			
			
		} elseif ( ( $cron_data['counter'] % $deferStep == 0 ) ) {
			$cron_step = 'defer';
			//$t         = explode( 'wp-content' , dirname( __FILE__ ) );
			//@require_once( $t[ 0 ] . '/wp-blog-header.php' );
			global $wpvr_options, $wpvr_cron_token, $wpvr_deferred, $wpvr_deferred_ids, $wpvr_imported;
			$token = $_GET['token'];
			cron_say( 'Defer Step ... ' );
			$timer      = wpvr_chrono_time();
			do_action( 'wpvr_event_cron_defer_before', $cron_data['counter'] );
			
			
			if ( $token != $wpvr_cron_token ) {
				//$t = "token=$token and wpvr_cron_token=$wpvr_cron_token"; 
				cron_say( "Token Not Valid. RETURN !" );
				file_put_contents( WPVR_CRON_FILE, wpvr_json_encode( $cron_data ) );
				
				if ( WPVR_CRON_JSON ) {
					return array(
						'status'   => 0,
						'timeZone' => $cron_data['timezone'],
						'time'     => $now->format( "Y-m-d H:i:s" ),
						'step'     => $cron_step,
						'count'    => $cron_data['counter'],
						'lines'    => $cron_lines,
					);
				}
				
				return false;
			} else {
				cron_say( 'Token Valid, continue ... ' );
			}
			
			
			//else echo "IS OK";
			$doWork = wpvr_doWork();
			if ( ! $doWork ) {
				cron_say( 'CRON not allowed to work. EXIT !' );
				file_put_contents( WPVR_CRON_FILE, wpvr_json_encode( $cron_data ) );
				
				if ( WPVR_CRON_JSON ) {
					return array(
						'status'   => 0,
						'timeZone' => $cron_data['timezone'],
						'time'     => $now->format( "Y-m-d H:i:s" ),
						'step'     => $cron_step,
						'count'    => $cron_data['counter'],
						'lines'    => $cron_lines,
					);
				}
				
				return false;
			} else {
				cron_say( 'Cron is allowed to work, continue ... ' );
			}
			
			$k              = 0;
			$added_deferred = array();
			$count_deferred = count( $wpvr_deferred );
			cron_say( $count_deferred . ' deferred video(s) to be added. ' );
			
			//new dBug( $wpvr_deferred );
			
			$wpvr_imported = wpvr_update_imported_videos();
			
			if ( $count_deferred > 0 ) {
				for ( $i = 0; ( $i < $count_deferred && $i < $wpvr_options['deferBuffer'] ); $i ++ ) {
					$video  = array_shift( $wpvr_deferred );
					$is_dup = isset( $wpvr_imported[ $video['service'] ][ $video['id'] ] );
					unset( $wpvr_deferred_ids[ $video['service'] ][ $video['id'] ] );
					
					if ( ! $is_dup ) {
						$k ++;
						$video['origin']      = 'by DEFERRED AUTO RUN';
						$video['owner']       = 0;
						$video['is_deferred'] = true;
						wpvr_add_video( $video, $wpvr_imported );
						$added_deferred[] = $video;
					}
					
				}
				cron_say( $k . ' added deferred video(s) ' );
				
				update_option( 'wpvr_deferred', $wpvr_deferred );
				update_option( 'wpvr_deferred_ids', $wpvr_deferred_ids );
			}
			
			do_action( 'wpvr_event_cron_defer_after', $cron_data['counter'], $added_deferred );
			
			if ( $wpvr_options['timeZone'] != $cron_data['timezone'] ) {
				$cron_data['timezone'] = $wpvr_options['timeZone'];
			}
			
			cron_say( 'Executed in ' . round( wpvr_chrono_time( $timer ), 2 ) . ' sec.' );
			
			$cron_data['last_exec_defer'] = $now->format( "Y-m-d H:i:s" );
			
		} else {
			cron_say( 'No Step, walk your way ! ' );
		}
		
		cron_say( 'Execution terminated.' );
		
		file_put_contents( WPVR_CRON_FILE, wpvr_json_encode( $cron_data ) );
		
		if ( WPVR_CRON_JSON ) {
			return array(
				'status'   => 1,
				'timeZone' => $cron_data['timezone'],
				'time'     => $now->format( "Y-m-d H:i:s" ),
				'step'     => $cron_step,
				'lines'    => $cron_lines,
			);
		} else {
			return true;
		}
		
		
	}
	
	
	$json  = wpvr_cron_init();
	$timer = wpvr_chrono_time( $timer );
	if ( WPVR_CRON_JSON === true ) {
		
		$json['exec_time'] = round( $timer, 3 );
		echo WPVR_CRON_JSON_DELIMITER . wpvr_json_encode( $json ) . WPVR_CRON_JSON_DELIMITER;
		
	} elseif ( WPVR_CRON_SILENT === true ) {
		echo apply_filters( 'wpvr_show_silence_is_golden', "SILENCE IS GOLDEN." ) . "\n";
		
	} elseif ( $wpvr_is_cli === true ) {
		echo "\n----------------------------";
		echo "\n- CRON EXECUTION CLI ... ";
		echo "\n----------------------------\n";
		echo $cron_lines;
		echo "----------------------------\n";
		echo "Executed in " . round( $timer, 3 ) . " sec. \n";
		echo "---------------------------- \n\n";
		
	} else {
		$cron_output
			= '
			<head>
			<style>
				.cron_body{
					background:#F5F5F5;
					font-family:arial;
					font-size:12px;			
				}
				.cron_title{
					text-align:center;
					margin:2em 0;
				}
				.cron_wrap{
					width:50%;
					max-width:600px;
					min-width:350px;
					margin:0 auto;
					background:#FFF;
					border:1px solid #DDD;
				}
				
				.cron_line{
					padding: 10px;
					padding-bottom: 5px;
					border-bottom: 1px dotted #DDD;
					font-size: 15px;
					color: #999;
				}
				
				.cron_line strong{
					color:#777;
				}
			</style>
			</head>
			<body class="cron_body">
				<h2 class="cron_title">
					WP VIDEO ROBOT Cron Machine
				</h2>
				<p style="text-align:center;">
					<a href="http://' . $WPVR_SERVER['HTTP_HOST'] . $WPVR_SERVER['REQUEST_URI'] . '">
						RELOAD CRON MACHINE
					</a>
				</p>
				<div class="cron_wrap">
					' . $cron_lines . '
				</div>
			</body>
		';
		echo $cron_output;
		//d( $cron_output );
	}