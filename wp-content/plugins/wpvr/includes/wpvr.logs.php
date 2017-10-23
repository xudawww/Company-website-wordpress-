<?php
	
	
	global $wpdb, $wpvr_options, $wpvr_pages;
	
	$wpvr_pages = true;
	
	$logs_url = admin_url('admin.php?page=wpvr-logs');
	
	$time = new DateTime( 'now' );
	$time->setTimezone( new DateTimeZone( wpvr_get_timezone() ) );
	$now_time = $time->format( 'Y-m-d H:i:s' );
	
	$now_timezone   = '<strong>NOW</strong> ( ' . wpvr_get_timezone_name( wpvr_get_timezone() ) . ' ).';
	$now_local_time = wpvr_get_time( 'now', false, true, 'output', true );
	// $now_local_time = $now_local->format('Y-m-d H:i');
	
	// d( $now_time );
	// d( $now_local_time );
	// d( wpvr_get_timezone() );
	
	$period = isset( $_GET['period'] ) ? $_GET['period'] : 'all';
	$type   = isset( $_GET['type'] ) ? $_GET['type'] : 'all';
	
	
	$period_selected = array(
		'today'     => '',
		'yesterday' => '',
		'lastWeek'  => '',
		'lastMonth' => '',
		'all'       => '',
	);
	
	$type_selected = array(
		'all'     => '',
		'video'  => '',
		'source' => '',
	);
	
	$period_selected[ $period ] = ' selected="selected" ';
	$type_selected[ $type ] = ' selected="selected" ';
	
?>
<div class="wrap wpvr_wrap" style="display:none;">
	<?php wpvr_show_logo(); ?>
    <h2 class="wpvr_title">
        <i class="wpvr_title_icon fa fa-list"></i>
		<?php echo __( 'Activity Logs', WPVR_LANG ); ?>
    </h2>

    <div class="wpvr_log_buttons">

        <div id="message" class="notice">
            <div class="wpvr_log_resume">

                <div class="pull-left">
                    <select class="wpvr_log_period_select wpvr_logs_select" >
                        <option value="all" <?php echo $period_selected['all']; ?> >
		                    - <?php echo __( 'Show All Logs', WPVR_LANG ); ?>
                        </option>
                        <option value="today" <?php echo $period_selected['today']; ?> >
                            <?php echo __( 'Today Logs', WPVR_LANG ); ?>
                        </option>
                        <option value="yesterday" <?php echo $period_selected['yesterday']; ?> >
							<?php echo __( 'Yesterday Logs', WPVR_LANG ); ?>
                        </option>
                        <option value="lastWeek" <?php echo $period_selected['lastWeek']; ?>>
							<?php echo __( 'Last Week Logs', WPVR_LANG ); ?>
                        </option>
                        <option value="lastMonth" <?php echo $period_selected['lastMonth']; ?> >
							<?php echo __( 'Last Month Logs', WPVR_LANG ); ?>
                        </option>
                        
                    </select>

                    <select class="wpvr_log_type_select wpvr_logs_select">
                        <option value="all" <?php echo $type_selected['all']; ?> >
			                - <?php echo __( 'Show All Logs Types', WPVR_LANG ); ?>
                        </option>
                        <option value="source" <?php echo $type_selected['source']; ?> >
			                <?php echo __( 'Source Logs Only', WPVR_LANG ); ?>
                        </option>
                        <option value="video" <?php echo $type_selected['video']; ?> >
		                    <?php echo __( 'Videos Logs Only', WPVR_LANG ); ?>
                        </option>
                    </select>
                    <button class="wpvr_button  wpvr_logs_refine" data-url="<?php echo $logs_url; ?>">
                        <i class="wpvr_button_icon fa fa-search"></i>
	                    <?php echo ___('Refine'); ?>
                    </button>

                </div>
                
                <div class="pull-right">
                    <button class="wpvr_button  wpvr_black_button wpvr_clear_logs">
                        <i class="wpvr_button_icon fa fa-remove"></i>
						<?php echo __( 'Clear Logs', WPVR_LANG ); ?>
                    </button>
                </div>
                <div class="wpvr_clearfix"></div>
            </div>
            <div class="wpvr_clearfix"></div>
        </div>
    </div>

    <div class="wpvr_log_wrap">
        <div class="wpvr_log_canvas" data-localnow="<?php echo $now_local_time; ?>" data-now="<?php echo $now_time; ?>"
             data-timezone="<?php echo $now_timezone; ?>">
            <div class="wpvr_log_canvas_timeline" id="wpvr_log_timeline"
                 style="width:80%;max-width:800px;margin:auto;"></div>
            <div class="wpvr_log_canvas_more" style="text-align:center;">
                <button
                        class="wpvr_button  wpvr_log_load_more"
                        data-page="1"
                        data-period="<?php echo $period; ?>"
                        data-type="<?php echo $type; ?>"
                >
                    <i class="wpvr_button_icon fa fa-caret-down"></i>
					<?php echo __( 'Load  Older Logs', WPVR_LANG ); ?>
                </button>
                <div class="wpvr_log_canvas_statement"></div>
            </div>
            <div class="wpvr_log_canvas_buttons" style=""></div>
        </div>


    </div>
    <div class="wpvr_clearfix"></div>


</div>