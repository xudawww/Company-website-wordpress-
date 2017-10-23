<?php
	
	//@deprecated
    
    return false;
    /*******************************************/
    /*******************************************/
    /*******************************************/
    /*******************************************/
	global $wpdb , $wpvr_options;
	global $wpvr_pages;
	$wpvr_pages = TRUE;
	
	if( isset( $wpvr_options[ 'timeZone' ][1] ) ){
		$timeZone = $wpvr_options[ 'timeZone' ][1] ;
	}else{
		$timeZone = $wpvr_options[ 'timeZone'];
	}
	
	
	if( isset( $_GET[ 'deferred_screen' ] ) ) {
		return FALSE;
	}

	if( isset( $_GET[ 'clear_log' ] ) ) {
		$log_table = $wpdb->prefix . "wpvr_log";
		$clear_log = $wpdb->get_results( "
				delete from $log_table
			" );
	}
	$count_deferred = count( get_option( 'wpvr_deferred' ) );
	$logs_per_page  = $wpvr_options[ 'logsPerPage' ];
	if( isset( $_GET[ 'period' ] ) ) $period = $_GET[ 'period' ];
	else $period = "today";

	$cst_period = "";

	if( $period == 'today' ) {

		$dateA      = $dateB = date( 'Y-m-d' );
		$cst_period = " AND ( STR_TO_DATE(time, '%Y-%m-%d') = '" . $dateA . "' ) ";

	} elseif( $period == 'yesterday' ) {

		$dateA      = $dateB = date( 'Y-m-d' , strtotime( "-1 days" ) );
		$cst_period = " AND ( STR_TO_DATE(time, '%Y-%m-%d') = '" . $dateA . "' ) ";

	} elseif( $period == 'lastWeek' ) {

		$dateB      = date( 'Y-m-d' , strtotime( "-1 days" ) );
		$dateA      = date( 'Y-m-d' , strtotime( "-1 weeks" ) );
		$cst_period = " AND STR_TO_DATE(time, '%Y-%m-%d') BETWEEN '" . $dateA . "' AND '" . $dateB . "' ";

	} elseif( $period == 'lastMonth' ) {

		$dateB      = date( 'Y-m-d' , strtotime( "-1 days" ) );
		$dateA      = date( 'Y-m-d' , strtotime( "-1 months" ) );
		$cst_period = " AND STR_TO_DATE(time, '%Y-%m-%d') BETWEEN '" . $dateA . "' AND '" . $dateB . "' ";

	} elseif( $period == 'all' ) {
		$cst_period = "";
	}


	if( isset( $_GET[ 'page_num' ] ) && ( $_GET[ 'page_num' ] >= 1 || $_GET[ 'page_num' ] == 'all' ) )
		$page_num = $_GET[ 'page_num' ];
	else
		$page_num = 1;
	$start_index = ( $page_num - 1 ) * $logs_per_page;
	$reset_url   = admin_url( 'admin.php?page=wpvr-log&clear_log' );
	$page_url    = admin_url( 'admin.php?page=wpvr-log' );

	$log_table = $wpdb->prefix . "wpvr_log";
	$logs      = array();
	$sql
	           = "
			SELECT 
				* 
			FROM 
				$log_table 
			WHERE 
				1
				$cst_period
			ORDER BY time DESC,type DESC
		";
	if( $page_num != 'all' ) {
		$sql_limit = $sql . " LIMIT $start_index,$logs_per_page ";
	} else {
		$sql_limit = $sql;
	}


	$db_all     = $wpdb->get_results( $sql );
	$total_logs = $wpdb->num_rows;


	$db_logs      = $wpdb->get_results( $sql_limit );
	$count_pages  = ceil( $total_logs / $logs_per_page );
	$deferredLink = get_bloginfo( 'url' ) . '/wp-admin/admin.php?page=wpvr-deferred';
	$start        = $start_index + 1;
	if( $page_num != 'all' ) {
		$start = $start_index + 1;
		$end   = min( $total_logs , $page_num * $logs_per_page );
	} else {
		$start = 0;
		$end   = $total_logs;
	}
?>
<div class = "wrap wpvr_wrap" style = "display:none;">
	<?php wpvr_show_logo(); ?>
	<h2 class = "wpvr_title">
		<i class = "wpvr_title_icon fa fa-list"></i>
		<?php echo __( 'Activity Logs' , WPVR_LANG ); ?>
	</h2>

	<div class = "wpvr_log_buttons">

		<div id = "message" class = "updated ">
			<div class = "wpvr_log_resume">
				<div class = "pull-left">
					<b><a href = "<?php echo $deferredLink; ?>">
							<?php echo __( 'Total Deferred' , WPVR_LANG ); ?>
						</a></b> : <?php echo wpvr_numberK( $count_deferred ) . '  |  '; ?></div>
				<div class = "pull-left"><b><?php echo __( 'Server Time' , WPVR_LANG ); ?></b> : <?php echo date( 'H:i:s' ) . '  |  '; ?></div>
				<div class = "pull-left"><b><?php echo __( 'Server TimeZone' , WPVR_LANG ); ?></b> : <?php echo $timeZone; ?></div>
				<div class = "pull-right">
					<b><?php echo __( 'Showing' , WPVR_LANG ); ?></b> :
					<?php echo $start . ' - ' . $end . ' ' . __( 'on' , WPVR_LANG ) . ' ' . $total_logs; ?>
				</div>
				<div class = "wpvr_clearfix"></div>
			</div>
			<div class = "wpvr_clearfix"></div>
		</div>
	</div>

	<div class = "wpvr_log_buttons">
		<div class = "wpvr_log_page pull-right">
			<select class = "wpvr_log_period_select" page_url = "<?php echo $page_url; ?>">
				<option value = "today" <?php if( $period == 'today' ) echo 'selected="selected" '; ?>>
					<?php echo __( 'Today' , WPVR_LANG ); ?>
				</option>
				<option value = "yesterday" <?php if( $period == 'yesterday' ) echo 'selected="selected" '; ?>>
					<?php echo __( 'Yesterday' , WPVR_LANG ); ?>
				</option>
				<option value = "lastWeek" <?php if( $period == 'lastWeek' ) echo 'selected="selected" '; ?>>
					<?php echo __( 'Last Week' , WPVR_LANG ); ?>
				</option>
				<option value = "lastMonth" <?php if( $period == 'lastMonth' ) echo 'selected="selected" '; ?>>
					<?php echo __( 'Last Month' , WPVR_LANG ); ?>
				</option>
				<option value = "all" <?php if( $period == 'all' ) echo 'selected="selected" '; ?>>
					--- <?php echo __( 'Show All' , WPVR_LANG ); ?> ---
				</option>
			</select>
			<select class = "wpvr_log_page_select" page_url = "<?php echo $page_url; ?>" period = "<?php echo $period; ?>">
				<?php for ( $k = 1; $k <= $count_pages; $k ++ ) { ?>

					<option value = "<?php echo $k; ?>" <?php if( $page_num == $k ) echo 'selected="selected" '; ?>>
						Page <?php echo "$k on $count_pages"; ?>
					</option>
				<?php } ?>
				<option value = "all" <?php if( $page_num == 'all' ) echo 'selected="selected" '; ?>>
					--- <?php echo __( 'Show All' , WPVR_LANG ); ?> ---
				</option>
			</select>
		</div>

		<div class = "wpvr_button  pull-left wpvr_clear_log" id = "wpvr_clear_log" reset_url = "<?php echo $reset_url; ?>">
			<i class = "wpvr_button_icon fa fa-remove"></i>
			<?php echo __( 'Clear Log' , WPVR_LANG ); ?>
		</div>
		<div class = "wpvr_button  pull-left wpvr_refresh_log" id = "wpvr_refresh_log">
			<i class = "wpvr_button_icon fa fa-refresh"></i>
			<?php echo __( 'Refresh Log' , WPVR_LANG ); ?>
		</div>
		<div class = "wpvr_clearfix"></br></div>
	</div>

	<?php
		if( count( $db_logs ) == 0 ) {
			
			?>
			
			<div class = "wpvr_nothing">
				<i class = "fa fa-frown-o"></i><br/>
				<?php _e( 'Nothing happened during the selected period.' , WPVR_LANG ); ?>
			</div>
			
			<?php
			return FALSE;

		}
		
		foreach ( (array) $db_logs as $log ) {
			//new dBug($log);

			$log_msgs      = wpvr_json_decode( $log->log_msgs );
			$log->log_msgs = $log_msgs;
			$logs[]        = $log;
		}
		
		$lines     = "";
		$linesHTML = "";
		$linesHTML .= "<div class='wpvr_log_items'>";
		$i = 0;
		
		foreach ( (array) $logs as $log ) {
			
			if( property_exists( $log , 'status' ) ) $log_status = $log->status;
			else $log_status = "";
			
			$line = "\n\n";
			$line .= "[" . $log->time . "] ";
			$line .= "[<b>" . $log->action . "</b>] : ";
			$line .= "" . $log->object . "";
			
			$lineHTML = "<div class='wpvr_log_item " . $log_status . "'>";
			$lineHTML .= "<div class='wpvr_log_col " . $log->type . "'></div>";
			$lineHTML .= "<div class='wpvr_log_title'>";
			$lineHTML .= "<span class='wpvr_log_time'>" . $log->time . "</span> | ";
			$lineHTML .= "<span class='wpvr_log_action'>" . $log->action . " </span> | ";
			$lineHTML .= "<span class='wpvr_log_object'>" . $log->object . "</span>";
			$lineHTML .= "</div>";
			if( property_exists( $log , 'icon' ) && $log->icon != '' ) {
				$lineHTML .= "<div class='wpvr_log_icon pull-left'><img src='" . $log->icon . "' alt=''/></div>";
			}
			foreach ( (array) $log->log_msgs as $msg ) {
				
				$line .= "\n \t\t " . $msg;
				$lineHTML .= "<div class='wpvr_log_msgs'>" . $msg . "</div>";
			}
			$lineHTML .= "<div class='wpvr_clearfix'></div>";
			$lineHTML .= "</div>";
			$lines .= $line;
			$linesHTML .= $lineHTML;
		}
		$linesHTML .= "</div>";
	?>

	<?php
		
		echo $linesHTML;
	?>
	<div class = "wpvr_log_buttons">
		<div class = "wpvr_log_page pull-right">
			<select class = "wpvr_log_page_select" page_url = "<?php echo $page_url; ?>" period = "<?php echo $period; ?>">
				<?php for ( $k = 1; $k <= $count_pages; $k ++ ) { ?>

					<option value = "<?php echo $k; ?>" <?php if( $page_num == $k ) echo 'selected="selected" '; ?>>
						Page <?php echo "$k on $count_pages"; ?>
					</option>
				<?php } ?>
				<option value = "all" <?php if( $page_num == 'all' ) echo 'selected="selected" '; ?>> --- Show All ---</option>
			</select>
		</div>
		<div class = "wpvr_button  pull-left wpvr_clear_log" id = "wpvr_clear_log" reset_url = "<?php echo $reset_url; ?>">
			<i class = "wpvr_button_icon fa fa-remove"></i>
			<?php echo __( 'Clear Log' , WPVR_LANG ); ?>
		</div>
		<div class = "wpvr_button  pull-left wpvr_refresh_log" id = "wpvr_refresh_log">
			<i class = "wpvr_button_icon fa fa-refresh"></i>
			<?php echo __( 'Refresh Log' , WPVR_LANG ); ?>
		</div>
		<div class = "wpvr_button  pull-left wpvr_goToTop">
			<i class = "wpvr_button_icon fa fa-arrow-up"></i>
			<?php echo __( 'To Top' , WPVR_LANG ); ?>
		</div>

		<div class = "wpvr_clearfix"></div>
	</div>

</div>