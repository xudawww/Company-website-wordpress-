<?php
	
	
	/* Show Home dashboard Stats */
	if ( ! function_exists( 'wpvr_custom_dashboard_function' ) ) {
		function wpvr_custom_dashboard_function() {
			global $wpvr_colors, $wpvr_services, $wpvr_types_, $wpvr_status, $wpvr_using_cpt;
			$sources_stats = wpvr_sources_stats();
			$videos_stats  = wpvr_videos_stats();
			$wpvr_deferred = get_option( 'wpvr_deferred' );
			if ( $wpvr_deferred == '' ) {
				$videos_deferred = 0;
			} else {
				$videos_deferred = count( $wpvr_deferred );
			}
			
			$newVideoLink  = WPVR_SITE_URL . '/wp-admin/post-new.php?post_type=' . WPVR_VIDEO_TYPE;
			$newSourceLink = WPVR_SITE_URL . '/wp-admin/post-new.php?post_type=' . WPVR_SOURCE_TYPE;
			$dashboardLink = WPVR_SITE_URL . '/wp-admin/admin.php?page=wpvr';
			$deferredLink  = WPVR_SITE_URL . '/wp-admin/admin.php?page=wpvr-deferred';
			$unwantedLink  = WPVR_SITE_URL . '/wp-admin/admin.php?page=wpvr-unwanted';
			$reviewLink    = WPVR_SITE_URL . '/wp-admin/edit.php?post_status=pending&post_type=' . WPVR_VIDEO_TYPE;
			$optionsLink   = WPVR_SITE_URL . '/wp-admin/admin.php?page=wpvr-options';
			$manageLink    = WPVR_SITE_URL . '/wp-admin/admin.php?page=wpvr-manage';
			$addonsLink    = WPVR_SITE_URL . '/wp-admin/admin.php?page=wpvr-addons';
			?>
			
			<?php $video_stats = wpvr_videos_stats(); ?>
			<?php $sources_stats = wpvr_sources_stats( $group = true ); ?>
			<?php $post_types = wpvr_get_available_post_types(); ?>

            <div class="wpvr_clearfix"></div>
			
			
            <h4 class="wpvr_dashboard_title">
				<?php echo __( 'YOUR VIDEOS', WPVR_LANG ); ?>
			
            </h4>

            <div class="wpvr_clearfix"></div>


            <!-- VIDEOS BY STATUS -->
            <div>
                <div>
                    <div class="wpvr_graph_wrapper" style="width:100% !important; height:400px !important;">
	                    
                        <div class="wpvr_graph_fact">
							<?php if ( $video_stats != false ) { ?>
                                <span><?php echo wpvr_numberK( $video_stats['byStatus']['total'] ); ?></span><br/>
								<?php _e( 'videos', WPVR_LANG ); ?>
							<?php } else { ?>
                                <i class="fa fa-frown-o"></i><br/>
								<?php _e( 'There is no video.', WPVR_LANG ); ?>
							<?php } ?>
                        </div>
                        <canvas id="wpvr_chart_videos_by_status" width="900" height="400"></canvas>
                    </div>

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
                </div>
                <div class="wpvr_widget_legend">
                    <div id="wpvr_chart_videos_by_status_legend"></div>
                    
                    <div class="wpvr_dashboard_center">
	
	                   <a href="javascript:;">
                           <button class="wpvr_dashboard_button wpvr_dashboard_full">
                               <?php echo sprintf( __( 'Using the %s post type', WPVR_LANG ), '<strong>' . WPVR_VIDEO_TYPE . '</strong>' ) ;?>
                           </button>
                       </a>
                        
                        <a href="<?php echo $newVideoLink; ?>">
                            <button class="wpvr_dashboard_button wpvr_dashboard_half">
                                <i class="wpvr_link_icon fa fa-plus"></i>
								<?php _e( 'Add New Video', WPVR_LANG ); ?>
                            </button>
                        </a>
                        <a href="<?php echo $reviewLink; ?>">
                            <button class="wpvr_dashboard_button wpvr_dashboard_half">
                                <i class="wpvr_link_icon fa fa-flag"></i>
								<?php _e( 'Review Videos', WPVR_LANG ); ?>
                            </button>
                        </a>
                        <a href="<?php echo $deferredLink; ?>">
                            <button class="wpvr_dashboard_button wpvr_dashboard_half">
                                <i class="wpvr_link_icon fa fa-inbox"></i>
								<?php _e( 'Deferred Videos', WPVR_LANG ); ?>
                            </button>
                        </a>
                        <a href="<?php echo $unwantedLink; ?>">
                            <button class="wpvr_dashboard_button wpvr_dashboard_half">
                                <i class="wpvr_link_icon fa fa-ban"></i>
								<?php _e( 'Unwanted Videos', WPVR_LANG ); ?>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="wpvr_clearfix"></div>
            </div>
            <div class="wpvr_clearfix"></div>

            <hr/>
            <h4 class="wpvr_dashboard_title">
				<?php _e( 'Your Sources', WPVR_LANG ); ?>
            </h4>
            <!-- VIDEOS BY STATUS -->
            <div>
                <div>
                    <div class="wpvr_graph_wrapper" style="width:100% !important; height:400px !important;">
                        <div class="wpvr_graph_fact">
							<?php if ( $sources_stats['total'] != 0 ) { ?>
                                <span><?php echo wpvr_numberK( $sources_stats['total'] ); ?></span><br/>
								<?php _e( 'sources', WPVR_LANG ); ?>
							<?php } else { ?>
                                <i class="fa fa-frown-o"></i><br/>
								<?php _e( 'There is no source.', WPVR_LANG ); ?>
							<?php } ?>
                        </div>
                        <canvas id="wpvr_chart_sources_by_status" width="900" height="400"></canvas>
                    </div>

                    <script>
                        var data_sources_by_status = [
							<?php if( count( $sources_stats['byType'] ) != 0 && is_array( $sources_stats['byType'] ) ){ ?>
							<?php foreach( (array) $sources_stats['byType'] as $label=>$count){ ?>
							<?php if ( $label == 'total' ) {
							continue;
						} ?>
							<?php if ( $label == 'groupType' ) {
							$label = 'group_dm';
						} ?>
                            {
                                value: parseInt(<?php echo $count; ?>),
                                color: '<?php echo $wpvr_colors['sourceTypes'][ $label ]; ?>',
                                label: '<?php echo strtoupper( $label ); ?>',
                            },
							<?php } ?>
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
                <div class="wpvr_widget_legend">
                    <div id="wpvr_chart_sources_by_status_legend"></div>
                    <div class="wpvr_dashboard_center">
                        <a href="<?php echo $newSourceLink; ?>">
                            <button class="wpvr_dashboard_button wpvr_dashboard_half">
                                <i class="wpvr_link_icon fa fa-plus"></i>
								<?php _e( 'Add New Source', WPVR_LANG ); ?>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="wpvr_clearfix"></div>
            </div>
            <div class="wpvr_clearfix"></div>

            <div class="wpvr_dashboard_center">
                <a href="<?php echo $dashboardLink; ?>">
                    <button class="wpvr_dashboard_button wpvr_dashboard_half">
                        <i class=" wpvr_link_icon fa fa-dashboard"></i>
						<?php _e( 'View Dashboard', WPVR_LANG ); ?>
                    </button>
                </a>
                <a href="<?php echo $manageLink; ?>">
                    <button class="wpvr_dashboard_button wpvr_dashboard_half">
                        <i class="wpvr_link_icon  fa fa-film"></i>
						<?php _e( 'Manage Videos', WPVR_LANG ); ?>
                    </button>
                </a>
                <a href="<?php echo $optionsLink; ?>">
                    <button class="wpvr_dashboard_button wpvr_dashboard_half">
                        <i class="wpvr_link_icon fa fa-wrench"></i>
						<?php _e( 'Manage Options', WPVR_LANG ); ?>
                    </button>
                </a>

                <a href="<?php echo $addonsLink; ?>">
                    <button class="wpvr_dashboard_button wpvr_dashboard_half">
                        <i class="wpvr_link_icon fa fa-cubes"></i>
						<?php _e( 'Browse Addons', WPVR_LANG ); ?>
                    </button>
                </a>
            </div>
            <br/><br/>
            <div class="wpvr_dashboard_version pull-left">
				<?php echo __( 'You are using', WPVR_LANG ) . '<br/>' . __( 'WP Video Robot', WPVR_LANG ) . '  <b>' . WPVR_VERSION . '</b>'; ?>
            </div>
            <div class="wpvr_dashboard_links pull-right">
                <a
                        href="#"
                        class="wpvr_button small"
                        id="wpvr_system_infos">
                    <i class="wpvr_link_icon fa fa-info"></i> System Info
                </a> |
                <a href="<?php echo WPVR_SUPPORT_URL; ?>"><?php _e( 'Get Support', WPVR_LANG ); ?></a>
                <div id="wpvr_export" style="display:none;"></div>
            </div>
            <div class="wpvr_clearfix"></div>
			<?php
			
			
			return false;
			
		}
	}
	
	/* Get Playlis Data from Channel Id */
	if ( ! function_exists( 'wpvr_get_country_name' ) ) {
		function wpvr_get_country_name( $country_code ) {
			global $wpvr_countries;
			
			return $wpvr_countries[ $country_code ];
		}
	}
	
	/* Render manage_filters */
	if ( ! function_exists( 'wpvr_manage_render_filters' ) ) {
		function wpvr_manage_render_filters( $filter_name, $button = true ) {
			
			global $wpvr_status, $wpvr_services;
			$filter_class = 'wpvr_manage';
			
			if ( $filter_name == 'authors' ) {
				$filter = wpvr_get_authors_count();
				$prefix = 'filter_authors';
			} elseif ( $filter_name == 'dates' ) {
				
				$filter = wpvr_get_dates_count();
				$prefix = 'filter_dates';
				
			} elseif ( $filter_name == 'categories' ) {
				$filter = wpvr_get_categories_count();
				$prefix = 'filter_categories';
			} elseif ( $filter_name == 'services' ) {
				$filter = wpvr_get_services_count();
				$prefix = 'filter_services';
			} elseif ( $filter_name == 'statuses' ) {
				$filter = wpvr_get_status_count();
				$prefix = 'filter_statuses';
				
			}
			//new dBug( $filter);		return false;
			$render = '';
			//$render .= 	//'<input type="hidden" name="'.$prefix.'[]" value="0">'.
			$render .= '<div class="wpvr_manage_box_content_inner">';
			$render .= '<ul id="' . $filter_class . '_' . $prefix . '" class="' . $filter_class . ' wpvr_manage_check_ul">';
			
			if ( count( $filter ) == 0 ) {
				return false;
			}
			foreach ( (array) $filter as $value => $data ) {
				
				
				if ( $filter_name == 'services' ) {
					$label = '<span class="wpvr_service_icon ' . $data['value'] . '"> ' . $data['label'] . ' </span>';
				} elseif ( $filter_name == 'statuses' ) {
					$icon  = '<i class="wpvr_video_status_icon fa ' . $wpvr_status[ $data['value'] ]['icon'] . ' "></i>';
					$label = '<span class="wpvr_video_status ' . $data['value'] . '"> ' . $icon . $data['label'] . ' </span>';
				} else {
					$label = wpvr_substr( $data['label'], 25 );
				}
				
				
				$render .= '<li id="category-289">' .
				           '<label class="selectit">' .
				           '<input type="checkbox" name="' . $prefix . '[]" value="' . $data['value'] . '" />' .
				           '<e>' . $label . '</e>' .
				           '<span class="wpvr_filter_count" >' .
				           wpvr_numberK( $data['count'] ) .
				           '</span>' .
				           '</label>' .
				           '</li>';
				
			}
			
			$render .= '</ul>';
			$render .= '</div>';
			
			if ( $button === true ) {
				$render
					.= '
				<div class="wpvr_button wpvr_manage_refresh">
					<i class="wpvr_button_icon fa fa-refresh"></i>
					' . __( 'REFRESH', WPVR_LANG ) . '
				</div>
			';
			}
			
			return $render;
		}
	}