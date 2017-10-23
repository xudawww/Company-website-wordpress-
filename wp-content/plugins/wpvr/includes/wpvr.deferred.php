<?php
	global $wpvr_deferred , $wpvr_deferred_ids , $wpvr_vs;

	global $wpvr_pages;
	$wpvr_pages = TRUE;


	// Paging Prepare
	if( isset( $_GET[ 'p' ] ) ) {
		if( null !== ( $p_get = filter_input( INPUT_GET , 'p' , FILTER_VALIDATE_INT , FILTER_NULL_ON_FAILURE ) ) ) {
			$current_page = $p_get;
		} else $current_page = 1;
	} else $current_page = 1;
	
	
	//d( $wpvr_deferred );



	$perpage = ( WPVR_DEFERRED_PERPAGE == 0 ) ? 1 : WPVR_DEFERRED_PERPAGE;
	$start   = $perpage * ( $current_page - 1 );
	$end     = $start + $perpage - 1;
	$total   = count( $wpvr_deferred );

	$paging = array(
		'total'  => $total ,
		'pages'  => ceil( $total / $perpage ) ,
		'page'   => $current_page ,
		'start'  => $start ,
		'end'    => min( $end , $total - 1 ) ,
		'suffix' => __( 'video(s) waiting to be added.' , WPVR_LANG ) ,
	);

	//d( $paging );

	$url = admin_url('admin.php?page=wpvr-deferred');

?>
<div class = "wrap wpvr_wrap" style = "display:none;">
	<?php wpvr_show_logo(); ?>
	<h2 class = "wpvr_title">
		<i class = "wpvr_title_icon fa fa-inbox"></i>
		<?php echo __( 'Deferred Videos' , WPVR_LANG ); ?>
	</h2>

	<div>
		<?php if( $paging[ 'total' ] == 0 ) { ?>
			<div class = "wpvr_nothing">
				<i class = "fa fa-frown-o"></i><br/>
				<?php _e( 'There is no deferred video.' , WPVR_LANG ); ?>
			</div>
		<?php } else { ?>
			<div id = "message" class = "updated ">
				<div class = "wpvr_log_resume ">
					<div class = "wpvr_paging_text pull-left">
						<?php if( $paging['total'] == 0 ) { ?>
							<?php _e( 'There is no deferred video.' , WPVR_LANG ); ?>
						<?php }else{ ?>
							<strong><?php echo( $paging[ 'start' ] + 1 ); ?></strong> -
							<strong><?php echo( $paging[ 'end' ] + 1 ); ?></strong> on
							<strong><?php echo $paging[ 'total' ]; ?></strong> <?php echo $paging['suffix'] ; ?>
						<?php } ?>
					</div>

					<div class = "wpvr_paging_select pull-right">
						<span> Page : </span>
						<select url = "<?php echo $url; ?>" class="wpvr_select_page">
							<?php for( $i = 1; $i <= $paging[ 'pages' ]; $i++ ) { ?>
								<?php $sel = ( $paging[ 'page' ] == $i ) ? ' selected = "selected" ' : ''; ?>
								<option value = "<?php echo $i; ?>" <?php echo $sel; ?>>
									<?php echo $i; ?> on <?php echo $paging['pages'] ; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class = "wpvr_clearfix"></div>

				</div>
			</div>
			<div class = "wpvr_nothing" style = "display:none;">
				<?php _e( 'There is no deferred video.' , WPVR_LANG ); ?>
			</div>
			<form id = "wpvr_test_form" class="wpvr_test_screen_wrap" url = "<?php echo WPVR_ACTIONS_URL; ?>" action="test_remove_deferred_videos">
				<div class = "wpvr_test_form_buttons top">
					<div class = "wpvr_button pull-left wpvr_test_form_toggleAll" state = "off">
						<i class = "wpvr_button_icon fa fa-check-square-o"></i>
						<?php _e( 'CHECK ALL VIDEOS' , WPVR_LANG ); ?>
					</div>
					<button class = "wpvr_button  pull-left" id = "wpvr_test_form_refresh">
						<i class = "wpvr_button_icon fa fa-refresh"></i>
						<?php _e( 'REFRESH' , WPVR_LANG ); ?>
					</button>

					<?php if( WPVR_BATCH_ADDING_ENABLED === TRUE ) { ?>
						<div class = "wpvr_button pull-right wpvr_test_form_add" is_deferred = "1">
							<i class = "wpvr_button_icon fa fa-download"></i>
							<?php _e( 'BATCH ADD SELECTED' , WPVR_LANG ); ?>
						</div>
					<?php } ?>
					<button
						class = "wpvr_button wpvr_red_button pull-right wpvr_test_form_remove deferred"
						id = "remove_deferred"
						is_deferred = "1"
					>
						<i class = "wpvr_button_icon fa fa-remove"></i>
						<?php _e( 'REMOVE FROM DEFERRED' , WPVR_LANG ); ?>
					</button>
					<button
						id = "add_deferred"
						class = "wpvr_button wpvr_green_button pull-right wpvr_test_form_add_each"
						is_deferred = "1"
					>
						<i class = "wpvr_button_icon fa fa-cloud-download"></i>
						<?php echo __( 'ADD' , WPVR_LANG ) . '<span class="wpvr_count_checked"> </span>' . __( 'ITEMS' , WPVR_LANG ); ?>
					</button>
				</div>
				<div class = "wpvr_clearfix"></div>
				<br/>

				<div class = "wpvr_deferred_videos wpvr_videos">
					<div class = "wpvr_source_items" id = "">
						<?php //$wpvr_deferred = wpvr_json_decode($wpvr_deferred); ?>

						<?php if( $paging[ 'total' ] == 0 ) { ?>
							<div class = "wpvr_source_noitems">
								<?php _e( 'There is no deferred videos.' , WPVR_LANG ); ?>
							</div>
						<?php } ?>

						<?php $i = 0; ?>

						<?php foreach( (array) $wpvr_deferred as $video ) { ?>
							<?php
							//d( $i );
							if( $i < $paging[ 'start' ] ) {
								$i++;
								continue;
							}
							if( $i > $paging[ 'end' ] ) break;

							$video_views    = $video[ 'views' ];
							$video_duration = wpvr_get_duration_string( $video[ 'duration' ] );
							$i++;

							if( !isset( $wpvr_vs[ $video[ 'service' ] ] ) ) $vs_label = $video['service'];
							else $vs_label = $wpvr_vs[ $video[ 'service' ] ]['label'] ;
							?>
							<div class = "wpvr_video pull-left" id = "video_<?php echo $i; ?>">
								<input type = "checkbox" class = "wpvr_video_cb" name = "<?php echo $video[ 'id' ]; ?>" div_id = "<?php echo $i; ?>"/>

								<div class = "wpvr_video_head">
									<div class = "wpvr_video_adding">
										<i class = "fa fa-refresh fa-spin"></i>
									</div>
									<div class = "wpvr_video_checked">
										<i class = "fa fa-check"></i>
									</div>
									<div class = "wpvr_video_added">
										<i class = "fa fa-thumbs-up"></i>
									</div>
									<div class = "wpvr_service_icon sharp <?php echo $video[ 'service' ]; ?> wpvr_video_service ">
										<?php echo strtoupper( $vs_label ); ?>
									</div>
									<div class = "wpvr_video_views">
										<?php echo wpvr_numberK( $video_views , FALSE ); ?>
									</div>
									<div class = "wpvr_video_duration">
										<?php echo $video_duration; ?>
									</div>
									<div class = "wpvr_video_thumb <?php echo $video[ 'service' ]; ?>">
										<img class = "wpvr_video_thumb_img" src = "<?php echo $video[ 'thumb' ]; ?>"/>
									</div>
								</div>
								<div class = "wpvr_video_title"><?php echo $video[ 'title' ]; ?></div>
							</div>
						<?php } ?>
						<div class = "wpvr_clearfix"></div>
					</div>
				</div>
				<div class = "wpvr_test_form_buttons bottom">
					<div class = "wpvr_button pull-left wpvr_test_form_toggleAll" state = "off">
						<i class = "wpvr_button_icon fa fa-check-square-o"></i>
						<?php _e( 'CHECK ALL VIDEOS' , WPVR_LANG ); ?>
					</div>
					<div class = "wpvr_button pull-left" id = "wpvr_test_form_refresh">
						<i class = "wpvr_button_icon fa fa-refresh"></i>
						<?php _e( 'REFRESH' , WPVR_LANG ); ?>
					</div>
					<div class = "wpvr_button  pull-left wpvr_goToTop">
						<i class = "wpvr_button_icon fa fa-arrow-up"></i>
						<?php echo __( 'To Top' , WPVR_LANG ); ?>
					</div>
					<?php if( WPVR_BATCH_ADDING_ENABLED === TRUE ) { ?>
						<div class = "wpvr_button pull-right wpvr_test_form_add" is_deferred = "1">
							<i class = "wpvr_button_icon fa fa-download"></i>
							<?php _e( 'BATCH ADD SELECTED' , WPVR_LANG ); ?>
						</div>
					<?php } ?>
					<button
						id = "remove_deferred_bis"
						class = "wpvr_button wpvr_red_button pull-right wpvr_test_form_remove deferred"
						is_deferred = "1"
					>
						<i class = "wpvr_button_icon fa fa-remove"></i>
						<?php _e( 'REMOVE FROM DEFERRED' , WPVR_LANG ); ?>
					</button>
					<button
						class = "wpvr_button wpvr_green_button pull-right wpvr_test_form_add_each"
						is_deferred = "1"
						id = "add_deferred_bis"
					>
						<i class = "wpvr_button_icon fa fa-cloud-download"></i>
						<?php echo __( 'ADD' , WPVR_LANG ) . '<span class="wpvr_count_checked"> </span>' . __( 'ITEMS' , WPVR_LANG ); ?>
					</button>
				</div>
				<div class = "wpvr_clearfix"></div>
			</form>
		<?php } ?>
	</div>
	<div class = "wpvr_clearfix"></div>
</div>