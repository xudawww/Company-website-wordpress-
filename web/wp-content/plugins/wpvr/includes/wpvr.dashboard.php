<?php
	
	global $wpvr_colors, $wpvr_status, $wpvr_services, $wpvr_vs;
	global $wpvr_using_cpt;
	//d( $wpvr_using_cpt );

?>
<div class="wrap wpvr_wrap" style="visibility:hidden;">
	<?php wpvr_show_logo(); ?>
    <h2 class="wpvr_title">
        <i class="wpvr_title_icon fa fa-dashboard"></i>
		<?php echo __( 'Dashboard', WPVR_LANG ); ?>
    </h2>
	<?php
		
		global $wpvr_pages;
		$wpvr_pages = true;
		
		
		$active = array(
			'content'     => '',
			'automation'  => '',
			'duplicates'  => '',
			'datafillers' => '',
			'setters'     => '',
		);
		
		if ( ! isset( $_GET['section'] ) || ! isset( $active[ $_GET['section'] ] ) ) {
			$active['content'] = 'active';
		} else {
			
			$active[ $_GET['section'] ] = 'active';
		}
		//echo $_GET['tab'] ;
	?>

    <div class="wpvr_nav_tabs pull-left">


        <div title="<?php _e( 'Sources & Videos', WPVR_LANG ); ?>"
             class="wpvr_nav_tab pull-left noMargin <?php echo $active['content']; ?>" id="a">
            <i class="wpvr_tab_icon fa fa-bar-chart"></i><br/>
            <span><?php _e( 'Sources & Videos', WPVR_LANG ); ?> </span>
        </div>

        <div title="<?php _e( 'Automation Stats', WPVR_LANG ); ?>"
             class="wpvr_nav_tab pull-left noMargin <?php echo $active['automation']; ?>" id="b">
            <i class="wpvr_tab_icon fa fa-calendar"></i><br/>
            <span><?php _e( 'Automation Stats', WPVR_LANG ); ?></span>
        </div>


        <div title="<?php _e( 'Track Duplicates', WPVR_LANG ); ?>"
             class="wpvr_nav_tab pull-left noMargin <?php echo $active['duplicates']; ?>" id="c">
            <i class="wpvr_tab_icon fa fa-copy"></i><br/>
            <span><?php _e( 'Track Duplicates', WPVR_LANG ); ?></span>
        </div>
		
		<?php if ( WPVR_ENABLE_DATA_FILLERS === true ) { ?>
            <div title="<?php _e( 'Data Fillers', WPVR_LANG ); ?>"
                 class="wpvr_nav_tab pull-left noMargin <?php echo $active['datafillers']; ?>" id="d">
                <i class="wpvr_tab_icon fa fa-tags"></i><br/>
                <span><?php _e( 'Data Fillers', WPVR_LANG ); ?></span>
            </div>
		<?php } ?>
		
		<?php if ( WPVR_ENABLE_SETTERS === true ) { ?>
            <div title="<?php _e( 'Admin Actions', WPVR_LANG ); ?>"
                 class="wpvr_nav_tab pull-left noMargin <?php echo $active['setters']; ?>" id="e">
                <i class="wpvr_tab_icon fa fa-hand-o-up"></i><br/>
                <span><?php _e( 'Admin Actions', WPVR_LANG ); ?></span>
            </div>
		<?php } ?>


        <span class="wpvr_version_helper pull-right">
			<?php echo "v" . WPVR_VERSION; ?>
		</span>

        <div class="wpvr_clearfix"></div>
    </div>
    <div class="wpvr_clearfix"></div>
    <div class="wpvr_dashboard">
		
		
		<?php if ( WPVR_ENABLE_DATA_FILLERS === true ) { ?>
            <!-- DUPLICATES DASHBOARD -->
            <div id="" class="wpvr_nav_tab_content tab_d">
				
				<?php
					include( 'wpvr.datafillers.php' );
				?>

            </div>
		<?php } ?>
		
		<?php if ( WPVR_ENABLE_SETTERS === true ) { ?>
            <!-- DUPLICATES DASHBOARD -->
            <div id="" class="wpvr_nav_tab_content tab_e">
				
				<?php
					include( 'wpvr.setters.php' );
				?>

            </div>
		<?php } ?>


        <!-- DUPLICATES DASHBOARD -->
        <div id="" class="wpvr_nav_tab_content tab_c">
			
			<?php
				global $is_DT;
				$is_DT = true;
				include( 'wpvr.manage.php' );
			?>

        </div>
		
		<?php $sources_stats = wpvr_sources_stats( $group = true ); ?>
		<?php $video_stats = wpvr_videos_stats(); ?>


        <!-- SOURCE & VIDEOS DASHBOARD -->
        <div id="" class="wpvr_nav_tab_content tab_a">
            <div id="dashboard-widgets" class="metabox-holder">
				
				<?php
					$new_video_link  = WPVR_SITE_URL . '/wp-admin/post-new.php?post_type=' . WPVR_VIDEO_TYPE;
					$new_source_link = WPVR_SITE_URL . '/wp-admin/post-new.php?post_type=' . WPVR_SOURCE_TYPE;
					
					//d( $post_types );
				?>

                <!-- LEFT DASHBOARD WIDGETS -->
                <div class="postbox-container">

                    <!-- VIDEOS WIDGET -->
                    <div id="" class="postbox ">
                        <h3 class="hndle">
                            <span> <?php echo __( 'YOUR VIDEOS', WPVR_LANG ) ?> </span>

                        </h3>

                        <div class="inside">
                            <div>
                                <div class="wpvr_graph_wrapper" style="width:100% !important; height:400px !important;">
									<?php echo $wpvr_using_cpt; ?>
                                    <div class="wpvr_graph_fact">
										<?php if ( $video_stats != false ) { ?>
                                            <span><?php echo wpvr_numberK( $video_stats['byStatus']['total'] ); ?></span>
                                            <br/>
											<?php _e( 'videos', WPVR_LANG ); ?>
										<?php } else { ?>
                                            <div class="wpvr_message">
                                                <i class="fa fa-frown-o"></i><br/>
												<?php _e( 'There is no video.', WPVR_LANG ); ?>
                                            </div>
                                            <p>
                                                <a href="<?php echo $new_video_link; ?>"
                                                   class="wpvr_black_button wpvr_submit_button wpvr_graph_button">
                                                    <i class="fa fa-plus"></i>
													<?php _e( 'Import your first video.', WPVR_LANG ); ?>
                                                </a>
                                            </p>
										<?php } ?>
                                    </div>
                                    <canvas id="wpvr_chart_videos_by_status" width="900" height="400"></canvas>
                                </div>
								<?php if ( count( $video_stats['byStatus']['items'] ) != 0 ) { ?>
                                    <script>
                                        var data_videos_by_status = [
											<?php foreach( (array) $video_stats['byStatus']['items'] as $label=>$count){ ?>
											<?php if ( $label == 'total' ) {
											continue;
										} ?>

                                            {
                                                value: parseInt(<?php echo $count; ?>),
                                                color: '<?php echo $wpvr_status[ $label ]['color']; ?>',
                                                label: '<?php echo strtoupper( $wpvr_status[ $label ]['label'] ); ?>',
                                            },
											<?php } ?>
                                        ];
                                        jQuery(document).ready(function ($) {
                                            wpvr_draw_chart(
                                                $('#wpvr_chart_videos_by_status'),
                                                $('#wpvr_chart_videos_by_status_legend'),
                                                data_videos_by_status,
                                                'donut'
                                            );
                                        });
                                    </script>
								<?php } ?>
                            </div>
							<?php if ( $sources_stats['total'] != 0 ) { ?>
                                <div class="wpvr_widget_legend">
                                    <div id="wpvr_chart_videos_by_status_legend"></div>
                                </div>
							<?php } ?>
                            <div class="wpvr_clearfix"></div>
                        </div>
                    </div>
                    <!-- VIDEOS WIDGET -->

                    <!-- VIDEOS WIDGET 2+ -->
					<?php //new dBug($video_stats); ?>
					<?php if ( $video_stats != false ) { ?>
                        <div id="" class="postbox ">
                            <h3 class="hndle"><span> <?php _e( 'YOUR VIDEOS - By Service', WPVR_LANG ); ?> </span></h3>

                            <div class="inside">
                                <div class="wpvr_widget_pie pull-left">
                                    <div class="wpvr_graph_wrapper" style="width:100% !important;">
                                        <canvas id="wpvr_chart_videos_by_service" width="250" height="250"></canvas>
                                    </div>

                                    <script>
                                        var data_videos_by_service = [
											<?php $i = 0; ?>
											<?php foreach( (array) $video_stats['byService']['items'] as $label=>$count){ ?>

                                            {
                                                value: parseInt(<?php echo $count; ?>),
                                                color: '<?php echo $wpvr_services[ $label ]['color']; ?>',
                                                label: '<?php echo strtoupper( $wpvr_services[ $label ]['label'] ); ?>',
                                            },
											<?php $i ++; ?>
											<?php } ?>
                                        ];
                                        jQuery(document).ready(function ($) {
                                            wpvr_draw_chart(
                                                $('#wpvr_chart_videos_by_service'),
                                                $('#wpvr_chart_videos_by_service_legend'),
                                                data_videos_by_service,
                                                'donut'
                                            );
                                        });
                                    </script>
                                </div>
                                <div class="wpvr_widget_legend pull-left">
                                    <div id="wpvr_chart_videos_by_service_legend"></div>
                                </div>
                                <div class="wpvr_clearfix"></div>
                            </div>
                        </div>
					<?php } ?>
                    <!-- VIDEOS WIDGET 2+ -->


                    <!-- VIDEOS WIDGET 2 -->
					<?php if ( $video_stats != false ) { ?>
                        <div id="" class="postbox ">
                            <h3 class="hndle"><span> <?php _e( 'YOUR VIDEOS - By Category', WPVR_LANG ); ?> </span></h3>

                            <div class="inside">
                                <div class="wpvr_widget_pie pull-left">
                                    <div class="wpvr_graph_wrapper" style="width:100% !important;">
                                        <canvas id="wpvr_chart_videos_by_cat" width="250" height="250"></canvas>
                                    </div>

                                    <script>
                                        var data_videos_by_cat = [
											<?php $i = 0; ?>
											<?php $pColors = wpvr_generate_colors( count( $video_stats['byCat']['items'] ) ); ?>
											
											<?php foreach( (array) $video_stats['byCat']['items'] as $label=>$count){ ?>

                                            {
                                                value: parseInt(<?php echo $count; ?>),
                                                color: '<?php echo $pColors[ $i ]; ?>',
                                                label: '<?php echo addslashes( strtoupper( $label ) ); ?>',
                                            },
											<?php $i ++; ?>
											<?php } ?>
                                        ];
                                        jQuery(document).ready(function ($) {
                                            wpvr_draw_chart(
                                                $('#wpvr_chart_videos_by_cat'),
                                                $('#wpvr_chart_videos_by_cat_legend'),
                                                data_videos_by_cat,
                                                'donut'
                                            );
                                        });
                                    </script>
                                </div>
                                <div class="wpvr_widget_legend pull-left">
                                    <div id="wpvr_chart_videos_by_cat_legend"></div>
                                </div>
                                <div class="wpvr_clearfix"></div>
                            </div>
                        </div>
					<?php } ?>
                    <!-- VIDEOS WIDGET 2 -->

                    <!-- VIDEOS WIDGET 3 -->
					<?php if ( $video_stats != false ) { ?>
                        <div id="" class="postbox ">
                            <h3 class="hndle"><span> <?php _e( 'YOUR VIDEOS - By Author', WPVR_LANG ); ?> </span></h3>

                            <div class="inside">
                                <div class="wpvr_widget_pie pull-left">
                                    <div class="wpvr_graph_wrapper" style="width:100% !important;">
                                        <canvas id="wpvr_chart_videos_by_author" width="250" height="250"></canvas>
                                    </div>
									<?php $pColors = wpvr_generate_colors( count( $video_stats['byAuthor']['items'] ) ); ?>
                                    <script>
                                        var data_videos_by_author = [
											<?php $i = 0; ?>
											<?php foreach( (array) $video_stats['byAuthor']['items'] as $label=>$count){ ?>

                                            {
                                                value: parseInt(<?php echo $count; ?>),
                                                color: '<?php echo isset( $pColors[ $i ] ) ? $pColors[ $i ] : $pColors[ rand( 0, count( $pColors ) - 1 ) ]; ?>',
                                                label: '<?php echo strtoupper( $label ); ?>',
                                            },
											<?php $i ++; } ?>
                                        ];
                                        jQuery(document).ready(function ($) {
                                            wpvr_draw_chart(
                                                $('#wpvr_chart_videos_by_author'),
                                                $('#wpvr_chart_videos_by_author_legend'),
                                                data_videos_by_author,
                                                'donut'
                                            );
                                        });
                                    </script>
                                </div>
                                <div class="wpvr_widget_legend pull-left">
                                    <div id="wpvr_chart_videos_by_author_legend"></div>
                                </div>
                                <div class="wpvr_clearfix"></div>
                            </div>
                        </div>
					<?php } ?>
                    <!-- VIDEOS WIDGET 3 -->

                </div>
                <!-- LEFT DASHBOARD WIDGETS -->

                <!-- RIGHT DASHBOARD WIDGETS -->
                <div id="postbox-container-2" class="postbox-container">
                    <div id="" class="meta-box-sortables">


                        <!-- SOURCES WIDGET 1-->
                        <div id="" class="postbox ">
                            <h3 class="hndle"><span> <?php _e( 'YOUR SOURCES', WPVR_LANG ); ?> </span></h3>

                            <div class="inside">
                                <div class="wpvr_widget_pie">
									<?php //$sources_stats = wpvr_sources_stats( $group = true ); ?>
                                    <div class="wpvr_graph_wrapper"
                                         style="width:100% !important; height:400px !important;">
                                        <div class="wpvr_graph_fact">
											<?php if ( $sources_stats['total'] != 0 ) { ?>
                                                <span><?php echo wpvr_numberK( $sources_stats['total'] ); ?></span><br/>
												<?php _e( 'sources', WPVR_LANG ); ?>
											<?php } else { ?>
                                                <div class="wpvr_message">
                                                    <i class="fa fa-frown-o"></i><br/>
													<?php _e( 'There is no source.', WPVR_LANG ); ?>
                                                </div>

                                                <p>
                                                    <a href="<?php echo $new_source_link; ?>"
                                                       class="wpvr_black_button wpvr_submit_button wpvr_graph_button">
                                                        <i class="fa fa-plus"></i>
														<?php _e( 'Create your first source.', WPVR_LANG ); ?>
                                                    </a>
                                                </p>
											<?php } ?>
                                        </div>
                                        <canvas id="wpvr_chart_sources_by_types" width="900" height="400"></canvas>
                                    </div>
									
									<?php //new dBug( $sources_stats['byType'] ); ?>
									<?php
										if ( ! isset( $label ) ) {
											$label = 'none';
										}
										if ( isset( $wpvr_colors['sourceTypes'][ $label ] ) ) {
											$source_color = $wpvr_colors['sourceTypes'][ $label ];
										} else {
											$source_color = $wpvr_colors['sourceTypes']['none'];
										}
										$i       = 0;
										$pColors = wpvr_generate_colors( count( $sources_stats['byType'] ) );
									?>
                                    <script>
                                        var data_sources_by_type = [
											<?php foreach( (array) $sources_stats['byType'] as $label=>$count){ ?>
											<?php $i ++; ?>
											<?php if ( $label == 'groupType' ) {
											$label = 'group_dm';
										} ?>
                                            {
                                                value: parseInt(<?php echo $count; ?>),
                                                color: '<?php echo $pColors[ $i ]; ?>',
                                                label: '<?php echo strtoupper( $label ); ?> SOURCE',
                                            },
											<?php } ?>
                                        ];
                                        jQuery(document).ready(function ($) {
                                            wpvr_draw_chart(
                                                $('#wpvr_chart_sources_by_types'),
                                                $('#wpvr_chart_sources_by_types_legend'),
                                                data_sources_by_type,
                                                'donut'
                                            );
                                        });
                                    </script>
                                </div>
								<?php if ( $sources_stats['total'] != 0 ) { ?>
                                    <div class="wpvr_widget_legend">
                                        <div id="wpvr_chart_sources_by_types_legend"></div>
                                    </div>
								<?php } ?>
                                <div class="wpvr_clearfix"></div>
                            </div>
                        </div>
                        <!-- SOURCES WIDGET 1 -->


                        <!-- SOURCES WIDGET 1+ -->
						<?php if ( $sources_stats['total'] != 0 ) { ?>
                            <div id="" class="postbox ">
                                <h3 class="hndle"><span> <?php _e( 'YOUR SOURCES - By Service', WPVR_LANG ); ?> </span>
                                </h3>

                                <div class="inside">
                                    <div class="wpvr_widget_pie pull-left">
                                        <div class="wpvr_graph_wrapper" style="width:100% !important;">
                                            <canvas id="wpvr_chart_sources_by_services" width="250"
                                                    height="250"></canvas>
                                        </div>
										<?php //$sources_stats = wpvr_sources_stats( $group = true ); ?>
                                        <script>
                                            var data_sources_by_services = [
												<?php foreach( (array) $sources_stats['byService'] as $label=>$count){ ?>
                                                {
                                                    value: parseInt(<?php echo $count; ?>),
                                                    color: '<?php echo $wpvr_vs[ $label ]['color']; ?>',
                                                    label: '<?php echo strtoupper( $wpvr_vs[ $label ]['label'] ); ?>',
                                                },
												<?php } ?>
                                            ];
                                            jQuery(document).ready(function ($) {
                                                wpvr_draw_chart(
                                                    $('#wpvr_chart_sources_by_services'),
                                                    $('#wpvr_chart_sources_by_services_legend'),
                                                    data_sources_by_services,
                                                    'donut'
                                                );
                                            });
                                        </script>
                                    </div>
                                    <div class="wpvr_widget_legend pull-left">
                                        <div id="wpvr_chart_sources_by_services_legend"></div>
                                    </div>
                                    <div class="wpvr_clearfix"></div>
                                </div>
                            </div>
						<?php } ?>
                        <!-- SOURCES WIDGET 1+ -->


                        <!-- SOURCES WIDGET 2 -->
						<?php if ( $sources_stats['total'] != 0 ) { ?>
                            <div id="" class="postbox ">
                                <h3 class="hndle"><span> <?php _e( 'YOUR SOURCES - By State', WPVR_LANG ); ?> </span>
                                </h3>

                                <div class="inside">
                                    <div class="wpvr_widget_pie pull-left">
                                        <div class="wpvr_graph_wrapper" style="width:100% !important;">
                                            <canvas id="wpvr_chart_sources_by_states" width="250" height="250"></canvas>
                                        </div>
										<?php //$sources_stats = wpvr_sources_stats( $group = true ); ?>
                                        <script>
                                            var data_sources_by_states = [
												<?php foreach( (array) $sources_stats['byState'] as $label=>$count){ ?>
                                                {
                                                    value: parseInt(<?php echo $count; ?>),
                                                    color: '<?php echo $wpvr_colors['sourceStates'][ $label ]; ?>',
                                                    label: '<?php echo strtoupper( $label ); ?>',
                                                },
												<?php } ?>
                                            ];
                                            jQuery(document).ready(function ($) {
                                                wpvr_draw_chart(
                                                    $('#wpvr_chart_sources_by_states'),
                                                    $('#wpvr_chart_sources_by_states_legend'),
                                                    data_sources_by_states,
                                                    'donut'
                                                );
                                            });
                                        </script>
                                    </div>
                                    <div class="wpvr_widget_legend pull-left">
                                        <div id="wpvr_chart_sources_by_states_legend"></div>
                                    </div>
                                    <div class="wpvr_clearfix"></div>
                                </div>
                            </div>
						<?php } ?>
                        <!-- SOURCES WIDGET 2 -->

                        <!-- SOURCES WIDGET 3 -->
						<?php if ( $sources_stats['total'] != 0 ) { ?>
                            <div id="" class="postbox ">
                                <h3 class="hndle"><span> <?php _e( 'YOUR SOURCES - By Status', WPVR_LANG ); ?> </span>
                                </h3>

                                <div class="inside">
                                    <div class="wpvr_widget_pie pull-left">
                                        <div class="wpvr_graph_wrapper" style="width:100% !important;">
                                            <canvas id="wpvr_chart_sources_by_status" width="250" height="250"></canvas>
                                        </div>
										<?php //$sources_stats = wpvr_sources_stats( $group = true ); ?>
                                        <script>
                                            var data_sources_by_status = [
												<?php foreach( (array) $sources_stats['byStatus'] as $label=>$count){ ?>
                                                {
                                                    value: parseInt(<?php echo $count; ?>),
                                                    color: '<?php echo $wpvr_colors['status'][ $label ]; ?>',
                                                    label: '<?php echo strtoupper( $label ); ?>',
                                                },
												<?php } ?>
                                            ];
                                            jQuery(document).ready(function ($) {
                                                wpvr_draw_chart(
                                                    $('#wpvr_chart_sources_by_status'),
                                                    $('#wpvr_chart_sources_by_status_legend'),
                                                    data_sources_by_status,
                                                    'donut'
                                                );
                                            });
                                        </script>
                                    </div>
                                    <div class="wpvr_widget_legend pull-left">
                                        <div id="wpvr_chart_sources_by_status_legend"></div>
                                    </div>
                                    <div class="wpvr_clearfix"></div>
                                </div>
                            </div>
						<?php } ?>
                        <!-- SOURCES WIDGET 3 -->
						<?php if ( false ) { ?>
                            <!-- BOX -->
                            <div id="" class="postbox ">
                                <h3 class="hndle"><span> <?php _e( 'BOX TITLE', WPVR_LANG ); ?> </span></h3>

                                <div class="inside">

                                    BOX 0


                                </div>
                            </div>
                            <!-- BOX -->
						<?php } ?>

                    </div>
                </div>
                <!-- RIGHT DASHBOARD WIDGETS -->


            </div>
        </div>
        <!-- SOURCE & VIDEOS DASHBOARD -->

        <!-- AUTOMATION DASHBOARD -->
        <div id="" class="wpvr_nav_tab_content tab_b">
            <div id="dashboard-widgets" class="metabox-holder">
				<?php
					//echo "#***";
					$security_data       = wpvr_max_fetched_videos_per_run();
					$security_warning    = false;
					$problematic_sources = "";
					foreach ( (array) $security_data as $id => $data ) {
						if ( $data['warning'] === true ) {
							$editLink         = get_edit_post_link( $id );
							$security_warning = true;
							$problematic_sources
								.= "
								<li> 
									<strong>" . $data["source_name"] . " </strong> :
									" . $data["wanted_videos"] . " wanted videos with " . $data["sub_sources"] . " subsource(s).
									
									--- <a target ='_blank' href='" . $editLink . "'> Edit this source </a>
								</li>
							";
						}
					}
				
				?>
				
				<?php if ( $security_warning === true ) { ?>
                    <!-- WIDE DASHBOARD WIDGET -->
                    <div id="" class="postbox wide">
                        <h3 class="hndle"><span> <?php _e( 'Important Notice', WPVR_LANG ); ?> </span></h3>

                        <div class="inside">
                            <div class="wpvr_wide_notice_icon pull-left">
                                <i class="fa fa-warning"></i>
                            </div>
                            <div class="pull-left">
                                You have configured the plugin with too many wanted videos for each run.<br/>
                                That will probably decrease your site performances on each run.<br/>
                                Here is a list of the problematic sources :
                                <br/><br/>
								
								<?php echo $problematic_sources; ?>
                            </div>
                            <div class="wpvr_clearfix"></div>

                        </div>
                    </div>
                    <!-- WIDE DASHBOARD WIDGET -->
				<?php } ?>


                <!-- LEFT DASHBOARD WIDGETS -->
                <div class="postbox-container">
                    <div id="" class="">


                        <!-- BOX -->
                        <div id="" class="postbox ">
                            <h3 class="hndle"><span>  <?php _e( 'Automation Status', WPVR_LANG ); ?> </span></h3>

                            <div class="inside">
								
								<?php
									global $wpvr_options, $wpvr_cron_token;
									
									if ( $wpvr_options['autoRunMode'] === true ) {
										$autoRunMode = '<span class="ok">' . __( 'ON', WPVR_LANG ) . '</span>';
									} else {
										$autoRunMode = '<span class="ko">' . __( 'OFF', WPVR_LANG ) . '</span>';
									}
									
									$workHours = wpvr_get_working_hours_formatted();
									
									$cronUsed = '<span class="ok">' . __( 'Real Cron Service', WPVR_LANG ) . '</span>';
									
									if ( ! is_multisite() ) {
										$cron_data_file = WPVR_PATH . "assets/php/cron.txt";
									} else {
										$site_id        = get_current_blog_id();
										$cron_data_file = WPVR_PATH . "assets/php/cron_" . $site_id . ".txt";
									}
									
									$cron_data = wpvr_object_to_array( @wpvr_json_decode( @file_get_contents( $cron_data_file ) ) );
									
									if ( ! isset( $cron_data['last_exec'] ) ) {
										$cron_data['last_exec'] = '';
									}
									if ( ! isset( $cron_data['first_exec'] ) ) {
										$cron_data['first_exec'] = '';
									}
									if ( ! isset( $cron_data['total_exec'] ) ) {
										$cron_data['total_exec'] = '';
									}
									
									$date_a = new Datetime( $cron_data['last_exec'] );
									$date_b = new Datetime( 'now' );
									
									$human_delay = human_time_diff( $date_b->format('U') , $date_a->format('U') );
									$in    = $date_b->diff( $date_a );
									$delay =   $in->days * 86400 + $in->h * 3600 +  $in->i * 60 +  $in->s;
                                    
									if ( $cron_data['last_exec'] == '' ) {
										$delay_msg = '<span class="ko">' . __( 'CRON never worked!', WPVR_LANG ) . '</span>';
									} elseif ( $delay <= 600 ) {
										$delay_msg = '<span class="ok">' . __( 'CRON is working!', WPVR_LANG ) . '</span>';
									} else {
										$delay_msg = '
                                                <span class="ko">' . __( 'CRON stopped', WPVR_LANG ) . ' 
                                                    ' . $human_delay . ' 
                                                    ' . __( 'ago.', WPVR_LANG ) . '
                                                </span>
                                        ';
									}
								
								?>
                                <div class="wpvr_automation_status">


                                    <li>
										<?php _e( 'Cron status', WPVR_LANG ); ?> : <?php echo $delay_msg; ?>
                                    </li>

                                    <li>
										<?php _e( 'AutoRun mode is', WPVR_LANG ); ?> : <?php echo $autoRunMode; ?>
                                    </li>
                                    <li>
										<?php _e( 'WP Video Robot is allowed to work', WPVR_LANG ); ?> :
                                        <span> <?php echo $workHours; ?></span>
                                    </li>
                                    <li>
										<?php _e( 'First Execution', WPVR_LANG ); ?> :
                                        <span>
                                            <?php echo $cron_data['first_exec'] != '' ? $cron_data['first_exec'] : ___( 'Never executed'); ?>
                                        </span>
                                    </li>
                                    <li>
										<?php _e( 'Last Execution', WPVR_LANG ); ?> :
                                        <span>
                                            <?php echo $cron_data['last_exec'] != '' ? $cron_data['last_exec'] : ___( 'Never executed'); ?>
                                        </span>
                                    </li>
									<?php if ( $cron_data['total_exec'] != '' && $cron_data['total_exec'] != 0 ) { ?>
                                        <li>
											<?php _e( 'Cron executed', WPVR_LANG ); ?>
                                            <span> <?php echo wpvr_numberK( $cron_data['total_exec'] ); ?></span>
											<?php _e( 'times', WPVR_LANG ); ?>.
                                        </li>
									<?php } ?>


                                    <a
                                            href="<?php echo admin_url( 'admin.php?page=wpvr-options&section=automation' ); ?>"
                                            id="wpvr_trigger_cron"
                                            class="pull-left wpvr_button wpvr_small"
                                    >
                                        <i class="wpvr_button_icon fa fa-gears"></i>
										<?php echo __( 'CONFIGURE AUTOMATION', WPVR_LANG ); ?>
                                    </a>

                                    <a
                                            href="<?php echo wpvr_get_cron_url( '?debug' ); ?>"
                                            target="_blank"
                                            id="wpvr_trigger_cron"
                                            class="pull-right wpvr_button wpvr_small wpvr_trigger_cron wpvr_black_button"
                                    >
                                        <i class="wpvr_button_icon fa fa-paw"></i>
										<?php echo __( 'MANUALLY TRIGGER CRON', WPVR_LANG ); ?>

                                    </a>

                                    <div class="wpvr_clearfix"></div>
                                </div>


                            </div>
                        </div>
                        <!-- BOX -->
						
						<?php
							$today = new DateTime();
							$today->modify( '+1 day' );
							wpvr_async_draw_stress_graph_by_day( $today, wpvr_generate_colors( false ) );
							$today->modify( '+2 day' );
							wpvr_async_draw_stress_graph_by_day( $today, wpvr_generate_colors( false ) );
							$today->modify( '+2 day' );
							wpvr_async_draw_stress_graph_by_day( $today, wpvr_generate_colors( false ) );
							$today->modify( '+2 day' );
							wpvr_async_draw_stress_graph_by_day( $today, wpvr_generate_colors( false ) );
						?>

                    </div>
                </div>
                <!-- LEFT DASHBOARD WIDGETS -->

                <!-- RIGHT DASHBOARD WIDGETS -->
                <div id="postbox-container-2" class="postbox-container">
                    <div id="" class="meta-box-sortables">
						
						<?php if ( false ) { ?>
                            <!-- BOX -->
                            <div id="" class="postbox ">
                                <h3 class="hndle"><span>
										<?php _e( 'AUTOPILOT', WPVR_LANG ); ?>
									</span></h3>

                                <div class="inside">

                                    AUTOPILOT CODE ...


                                </div>
                            </div>
                            <!-- BOX -->
						<?php } ?>
						
						<?php
							$today = new DateTime();
							$today->modify( '+2 day' );
							wpvr_async_draw_stress_graph_by_day( $today, wpvr_generate_colors( false ) );
							$today->modify( '+2 day' );
							wpvr_async_draw_stress_graph_by_day( $today, wpvr_generate_colors( false ) );
							$today->modify( '+2 day' );
							wpvr_async_draw_stress_graph_by_day( $today, wpvr_generate_colors( false ) );
							$today->modify( '+2 day' );
							wpvr_async_draw_stress_graph_by_day( $today, wpvr_generate_colors( false ) );
						?>


                    </div>
                </div>
                <!-- RIGHT DASHBOARD WIDGETS -->


            </div>
        </div>
        <!-- AUTOMATION DASHBOARD -->


    </div>