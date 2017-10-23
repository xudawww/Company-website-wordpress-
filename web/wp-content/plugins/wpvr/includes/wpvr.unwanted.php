<?php
	global $wpvr_unwanted, $wpvr_unwanted_ids, $wpvr_vs;
	//$wpvr_unwanted = $wpvr_deferred ;
	global $wpvr_pages;
	$wpvr_pages = true;
	
	
	if ( isset( $_GET['scope'] ) && $_GET['scope'] == 'source' ) {
		if ( isset( $_GET['source'] ) ) {
			$source_ids = json_decode( urldecode( stripslashes( $_GET['source'] ) ), true );
		} else {
			$source_ids = 'all';
		}
		$unwanted_videos = wpvr_get_unwanted_videos( $source_ids, false );
		// d( $unwanted_videos );
	} else {
		$unwanted_videos = wpvr_get_unwanted_videos( false, false );
	}
	
	// Paging Prepare
	if ( isset( $_GET['p'] ) ) {
		if ( null !== ( $p_get = filter_input( INPUT_GET, 'p', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE ) ) ) {
			$current_page = $p_get;
		} else {
			$current_page = 1;
		}
	} else {
		$current_page = 1;
	}
	
	if ( isset( $_GET['service'] ) ) {
		$service = $_GET['service'];
	} else {
		$service = 'all';
	}
	
	if ( isset( $_GET['searchterm'] ) ) {
		$searchterm = $_GET['searchterm'];
	} else {
		$searchterm = '';
	}
	
	
	$perpage = ( WPVR_UNWANTED_PERPAGE == 0 ) ? 1 : WPVR_UNWANTED_PERPAGE;
	$start   = $perpage * ( $current_page - 1 );
	$end     = $start + $perpage - 1;
	$total   = count( $unwanted_videos );
	
	$paging = array(
		'service'    => $service,
		'searchterm' => $searchterm,
		'total'      => $total,
		'pages'      => ceil( $total / $perpage ),
		'page'       => $current_page,
		'start'      => $start,
		'end'        => min( $end, $total - 1 ),
		'suffix'     => __( 'videos', WPVR_LANG ),
	);
	
	//d( $paging );
	
	$url = admin_url( 'admin.php?page=wpvr-unwanted' );

?>
<div class="wrap wpvr_wrap" style="display:none;">
	<?php wpvr_show_logo(); ?>
    <h2 class="wpvr_title">
        <i class="wpvr_title_icon fa fa-ban"></i>
		<?php echo __( 'Unwanted Videos', WPVR_LANG ); ?>
    </h2>

    <div>
		<?php if ( true ) { ?>
            <div id="message" class="updated ">
                <div class="wpvr_log_resume ">
                    <div class="wpvr_paging_text pull-left">
						<?php if ( $paging['total'] == 0 ) { ?>
							<?php _e( 'No unwanted video found.', WPVR_LANG ); ?>
						<?php } else { ?>
                            <strong><?php echo( $paging['start'] + 1 ); ?></strong> -
                            <strong><?php echo( $paging['end'] + 1 ); ?></strong> on
                            <strong><?php echo $paging['total']; ?></strong> <?php echo $paging['suffix']; ?>
						<?php } ?>
                    </div>

                    <div class="wpvr_paging_select pull-right">
                        <span> Page : </span>
                        <select url="<?php echo $url; ?>" class="wpvr_unwanted_select_page">
							<?php for ( $i = 1; $i <= $paging['pages']; $i ++ ) { ?>
								<?php $sel = ( $paging['page'] == $i ) ? ' selected = "selected" ' : ''; ?>
                                <option value="<?php echo $i; ?>" <?php echo $sel; ?>>
									<?php echo $i; ?> on <?php echo $paging['pages']; ?>
                                </option>
							<?php } ?>
                        </select>
                    </div>
					<?php //d( $wpvr_vs ); ?>

                    <div class="wpvr_clearfix"></div>

                </div>
            </div>
			
			<?php $scope = isset( $_GET['scope'] ) && $_GET['scope'] != '' ? $_GET['scope'] : 'global'; ?>

            <div class="wpvr_unwanted_filters <?php echo $scope; ?>">
                <div class="wpvr_unwanted_filter">
                    <label><?php echo ___( 'Scope' ); ?></label>
                    <select name="scope" class="wpvr_unwanted_scope">
                        <option value="global" <?php echo $scope == 'global' ? ' selected="selected" ' : ''; ?>>
							<?php echo ___( 'Global Unwanted' ); ?>
                        </option>

                        <option value="source" <?php echo $scope == 'source' ? ' selected="selected" ' : ''; ?>>
							<?php echo ___( 'Source Unwanted' ); ?>
                        </option>

                    </select>
                </div>

                <div class="wpvr_unwanted_filter">
                    <label><?php echo ___( 'Search' ); ?></label>
                    <input
                            class="search wpvr_unwanted_search"
                            type="text"
                            placeholder="<?php echo __( 'Search term ...' ); ?>"
                            value="<?php echo isset( $_GET['search'] ) ? $_GET['search'] : ''; ?>"
                    />
                </div>

                <div class="wpvr_unwanted_filter source">
					<?php $value = isset( $_GET['source'] ) ? json_decode( urldecode( stripslashes( $_GET['source'] ) ), true ) : array(); ?>
                    <div class="wpvr_filter_dropdown <?php echo count( $value ) == 0 ? '' : 'active'; ?>">
                        <label><?php echo ___( 'Sources' ); ?></label>
						<?php echo wpvr_render_dropdown( array(
							'name'        => "source",
							'placeholder' => ___( 'All Sources', true ) . ' ...',
							'options'     => wpvr_get_sources_options(),
							'maxItems'    => 25,
							'wrap_class'  => 'wpvr_filter_dropdown_wrap ',
							'value'       => $value,
						) ); ?>

                    </div>
                </div>

                <div class="wpvr_unwanted_filter global">
					<?php
						global $wpvr_vs;
						$services_options = array();
						foreach ( (array) $wpvr_vs as $value => $vs ) {
							// d( $vs );
							if ( isset( $vs['skipThis'] ) ) {
								continue;
							}
							$services_options[ $vs['id'] ] = $vs['label'];
						}
						
						$services = isset( $_GET['service'] ) ? json_decode( urldecode( stripslashes( $_GET['service'] ) ), true ) : array();
					
					?>
                    <div class="wpvr_filter_dropdown <?php echo count( $value ) == 0 ? '' : 'active'; ?>">
                        <label><?php echo ___( 'Services' ); ?></label>
						<?php echo wpvr_render_dropdown( array(
							'name'        => "service",
							'placeholder' => ___( 'All services', true ) . ' ...',
							'options'     => $services_options,
							'maxItems'    => 25,
							'wrap_class'  => 'wpvr_filter_dropdown_wrap ',
							'value'       => $services,
						) ); ?>

                    </div>
                </div>

                <div class="wpvr_unwanted_filter">
                    <button class="wpvr_button wpvr_unwanted_refine">
                        <i class="fa fa-search"></i>
						<?php echo ___( 'Refine' ); ?>
                    </button>

                </div>

            </div>

            <div class="wpvr_clearfix"></div>

            <div class="wpvr_nothing" style="display:none;">
				<?php _e( 'No unwanted video found.', WPVR_LANG ); ?>
            </div>
            <form id="wpvr_test_form" class="wpvr_test_screen_wrap" url="<?php echo WPVR_ACTIONS_URL; ?>"
                  action="test_remove_unwanted_videos">
                <div class="wpvr_test_form_buttons top">
                    <div class="wpvr_button pull-left wpvr_test_form_toggleAll" state="off">
                        <i class="wpvr_button_icon fa fa-check-square-o"></i>
						<?php _e( 'CHECK ALL VIDEOS', WPVR_LANG ); ?>
                    </div>
                    <div class="wpvr_button pull-left" id="wpvr_test_form_refresh">
                        <i class="wpvr_button_icon fa fa-refresh"></i>
						<?php _e( 'REFRESH', WPVR_LANG ); ?>
                    </div>

                    <button
                            class="wpvr_button wpvr_red_button pull-right wpvr_test_form_remove unwanted"
                            id="remove_unwanted"
                            is_unwanted="1"
                    >
                        <i class="wpvr_button_icon fa fa-remove"></i>
						<?php _e( 'Remove from unwanted', WPVR_LANG ); ?>
                    </button>

                </div>
                <div class="wpvr_clearfix"></div>
                <br/>

                <div class="wpvr_unwanted_videos wpvr_videos">
                    <div class="wpvr_source_items" id="">
						<?php //$wpvr_unwanted = wpvr_json_decode($wpvr_unwanted); ?>
						
						<?php $i = 0; ?>
						<?php if ( $paging['total'] == 0 ) { ?>
                            <div class="wpvr_nothing">
                                <i class="fa fa-frown-o"></i><br/>
								<?php _e( 'No unwanted video found.', WPVR_LANG ); ?>
                            </div><br/><br/><br/>
						<?php } else { ?>
							<?php foreach ( (array) $unwanted_videos as $video ) { ?>
								<?php
								//d( $i );
								if ( $i < $paging['start'] ) {
									$i ++;
									continue;
								}
								
								if (
									isset( $_GET['search'] )
									&& $_GET['search'] != ''
									&& strpos( strtolower( $video['title'] ), strtolower( $_GET['search'] ) ) === false
								) {
									$i ++;
									continue;
								}
								// d( $services );
								if (
									count( $services ) != 0
									&& !in_array( $video['service'], $services )
								) {
									$i ++;
									continue;
								}
								
								if ( $i > $paging['end'] ) {
									break;
								}
								
								
								$i ++;
								
								if ( ! isset( $wpvr_vs[ $video['service'] ] ) ) {
									$vs_label = $video['service'];
								} else {
									$vs_label = $wpvr_vs[ $video['service'] ]['label'];
								}
								
								
								?>
                                <div class="wpvr_video pull-left" id="video_<?php echo $i; ?>">
                                    <input
                                            type="checkbox"
                                            class="wpvr_video_cb"
                                            name="<?php echo $video['id']; ?>"
                                            source_id="<?php echo isset( $video['sourceId'] ) ? $video['sourceId'] : ''; ?>"
                                            scope="<?php echo $scope; ?>"
                                            div_id="<?php echo $i; ?>"
                                    />

                                    <div class="wpvr_video_head">
                                        <div class="wpvr_video_adding">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                        <div class="wpvr_video_checked">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div class="wpvr_video_added">
                                            <i class="fa fa-thumbs-up"></i>
                                        </div>

                                        <div
                                                class="wpvr_service_icon sharp <?php echo $video['service']; ?> wpvr_video_service ">
											<?php echo strtoupper( $vs_label ); ?>
                                        </div>

                                        <div class="wpvr_video_duration wpvr_video_unwanted">
                                            <i class="fa fa-ban"></i>
											<?php echo __( 'UNWANTED', WPVR_LANG ); ?>
                                        </div>
                                        <div class="wpvr_video_thumb <?php echo $video['service']; ?>">
                                            <img class="wpvr_video_thumb" src="<?php echo $video['thumb']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="wpvr_video_title"><?php echo $video['title']; ?></div>
                                </div>
							<?php } ?>
						<?php } ?>
                        <div class="wpvr_clearfix"></div>
                    </div>
                </div>
                <div class="wpvr_test_form_buttons bottom">
                    <div class="wpvr_button pull-left wpvr_test_form_toggleAll" state="off">
                        <i class="wpvr_button_icon fa fa-check-square-o"></i>
						<?php _e( 'CHECK ALL VIDEOS', WPVR_LANG ); ?>
                    </div>
                    <div class="wpvr_button pull-left" id="wpvr_test_form_refresh">
                        <i class="wpvr_button_icon fa fa-refresh"></i>
						<?php _e( 'REFRESH', WPVR_LANG ); ?>
                    </div>
                    <div class="wpvr_button  pull-left wpvr_goToTop">
                        <i class="wpvr_button_icon fa fa-arrow-up"></i>
						<?php echo __( 'To Top', WPVR_LANG ); ?>
                    </div>


                    <button
                            class="wpvr_button wpvr_red_button pull-right wpvr_test_form_remove unwanted"
                            id="remove_unwanted"
                            is_unwanted="1"
                    >
                        <i class="wpvr_button_icon fa fa-remove"></i>
						<?php _e( 'Remove from Unwanted', WPVR_LANG ); ?>
                    </button>

                </div>
                <div class="wpvr_clearfix"></div>
            </form>
		<?php } ?>
    </div>
    <div class="wpvr_clearfix"></div>
</div>