<?php
	
	add_action( 'wpvr_event_add_video_done', 'wpvr_add_notice_trigger_function', 10, 1 );
	function wpvr_add_notice_trigger_function( $count_videos ) {
		if ( WPVR_ASK_TO_RATE_TRIGGER === false ) {
			return false;
		}
		global $current_user;
		$user_id = $current_user->ID;
		
		//update_option('koko' , $count_videos );
		
		if ( get_user_meta( $user_id, 'wpvr_user_has_voted', true ) == 1 ) {
			return false;
		}
		$level_reached = wpvr_is_reaching_level( $count_videos );
		if ( $level_reached != false ) {
			$message = "<p class='wpvr_dialog_icon'><i class='fa fa-trophy'></i></p>" .
			           "<div class='wpvr_dialog_msg'>" .
			           "<p>Hey, you just have crossed <strong>$count_videos</strong> videos imported with WPVR. That's Awesome !</p>" .
			           "<p>Could you please do us a big favor and give WP Video Robot a 5-star rating on Codecanyon ?" .
			           "<br/>That will help us spread the word and boost our motivation.</p>" .
			           "<strong>~pressaholic</strong>" .
			           "</div>";
			
			//$token = bin2hex( openssl_random_pseudo_bytes( 16 ) );
			
			
			wpvr_add_notice( array(
				'slug'               => "rating_notice_" . $level_reached,
				'title'              => 'Congratulations !',
				'class'              => 'updated', //updated or warning or error
				'content'            => $message,
				'hidable'            => true,
				'is_dialog'          => true,
				'dialog_modal'       => false,
				'dialog_delay'       => 1500,
				//'dialog_ok_button' => '',
				'dialog_ok_button'   => ' <i class="fa fa-heart"></i> RATE WPVR NOW',
				'dialog_hide_button' => '<i class="fa fa-close"></i> DISMISS ',
				'dialog_class'       => ' askToRate ',
				'dialog_ok_url'      => 'http://codecanyon.net/downloads#item-8619739',
			) );
			
		}
		
	}
	
	add_action( 'wp_trash_post', 'wpvr_add_unwanted_on_trash' );
	function wpvr_add_unwanted_on_trash( $post_id ) {
		global $wpvr_options;
		if ( get_post_type( $post_id ) == WPVR_VIDEO_TYPE && $wpvr_options['unwantOnTrash'] === true ) {
			wpvr_unwant_videos( array( $post_id ) );
		}
	}
	
	add_action( 'before_delete_post', 'wpvr_add_unwanted_on_delete' );
	function wpvr_add_unwanted_on_delete( $post_id ) {
		global $wpvr_options;
		if ( get_post_type( $post_id ) == WPVR_VIDEO_TYPE && $wpvr_options['unwantOnDelete'] === true ) {
			wpvr_unwant_videos( array( $post_id ) );
		}
	}
	
	add_action( 'admin_init', 'wpvr_demo_message_ignore' );
	function wpvr_demo_message_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['wpvr_show_demo_notice'] ) && '0' == $_GET['wpvr_show_demo_notice'] ) {
			add_user_meta( $user_id, 'wpvr_show_demo_notice', 'true', true );
		}
		
		if ( isset( $_GET['wpvr_hide_notice'] ) && $_GET['wpvr_hide_notice'] != '' ) {
			add_user_meta( $user_id, $_GET['wpvr_hide_notice'], 'true', true );
		}
		
	}
	
	/* Define Custom Dashboard Widgets */
	add_action( 'wp_dashboard_setup', 'wpvr_custom_dashboard_widget' );
	function wpvr_custom_dashboard_widget() {
		global $wp_meta_boxes;
		wp_add_dashboard_widget(
			'home_dashboard_widget', //ID of the dashboard Widgets
			'WP Video Robot - Global Activity', //Title of the dashboard Widgets
			'wpvr_custom_dashboard_function',
			'side',
			'high'
		);
	}
	
	
	/* Function to prevent from showing content on loops */
	add_action( 'the_content', 'wpvr_remove_flow_content' );
	function wpvr_remove_flow_content( $html ) {
		global $post;
		if ( ! isset( $post->ID ) || ! wpvr_is_imported_video( $post->ID ) ) {
			return $html;
		}
		
		if (
			is_admin()
			|| ! defined( 'WPVR_REMOVE_FLOW_CONTENT' )
			|| WPVR_REMOVE_FLOW_CONTENT === false
			|| get_post_type() != WPVR_VIDEO_TYPE
		) {
			return $html;
		} else {
			if ( ! is_singular() ) {
				return '';
			} else {
				return $html;
			}
		}
	}
	
	/* Function to prevent from showing tags on loops */
	add_action( 'term_links-post_tag', 'wpvr_remove_flow_tags' );
	function wpvr_remove_flow_tags( $tags ) {
		if (
			is_admin()
			|| ! defined( 'WPVR_REMOVE_FLOW_TAGS' )
			|| WPVR_REMOVE_FLOW_TAGS === false
			|| get_post_type() != WPVR_VIDEO_TYPE
		) {
			return $tags;
		} else {
			if ( ! is_singular() ) {
				return array();
			} else {
				return $tags;
			}
		}
	}
	
	/* Function for whether to show thumbnail on single */
	add_action( 'post_thumbnail_html', 'wpvr_remove_thumb_single_function', 10, 2 );
	function wpvr_remove_thumb_single_function( $html, $post_id ) {
		
		if (
			is_admin()
			|| ! is_singular()
			|| ! defined( 'WPVR_REMOVE_THUMB_SINGLE' )
			|| WPVR_REMOVE_THUMB_SINGLE === false
			|| get_post_type() != WPVR_VIDEO_TYPE
		) {
			return $html;
		} else {
			return '';
		}
	}
	
	add_filter( 'get_post_metadata', 'wpvr_force_define_external_thumb_as_feature_image', 9999999999, 4 );
	function wpvr_force_define_external_thumb_as_feature_image( $metadata, $object_id, $meta_key, $single ) {
		global $wpvr_options;
		
		if ( $wpvr_options['forceExternalThumb'] === false ) {
			return $metadata;
		}
		
		if ( $meta_key == '_thumbnail_id' && isset( $meta_key ) ) {
			
			if ( ! $single ) {
				// d( $single );
				return $metadata;
			}
			
			$use_external_thumb = get_post_meta( $object_id, 'wpvr_video_using_external_thumbnail', true );
			if ( $use_external_thumb != '' ) {
				// d( $use_external_thumb );
				return $object_id;
			}
			
			return $metadata;
		}
		
		return $metadata;
	}
	
	
	add_action( 'post_thumbnail_html', 'wpvr_user_external_thumb', 10000, 2 );
	function wpvr_user_external_thumb( $html, $post_id ) {
		global $wpvr_options;
		
		if ( $wpvr_options['forceExternalThumb'] === false ) {
			return $html;
		}
		if ( is_admin() || get_post_type() != WPVR_VIDEO_TYPE ) {
			return $html;
		}
		$use_external_thumb = get_post_meta( $post_id, 'wpvr_video_using_external_thumbnail', true );
		
		if ( WPVR_ENABLE_THUMB_DEFAULT_SIZES && strpos( $use_external_thumb, 'maxresdefault' ) !== false ) {
			$use_external_thumb = str_replace( 'maxresdefault', '0', $use_external_thumb );
		}
		
		
		if ( $use_external_thumb == '' ) {
			return $html;
		}
		
		if ( defined( 'WPVR_FORCE_EXTERNAL_THUMB_HARD_CROP' ) && WPVR_FORCE_EXTERNAL_THUMB_HARD_CROP === true ) {
			$is_small = 'is_small';
		} else {
			$is_small   = '';
			$image_info = get_post_meta( $post_id, 'wpvr_video_using_external_thumbnail_info', true );
			if ( WPVR_ENABLE_THUMB_CORRECTION === true && $image_info != '' && is_array( $image_info ) ) {
				$is_small = ( $image_info[0] == 640 || $image_info[0] == 480 ) ? 'is_small' : '';
			}
		}
		$html = '<div class="wpvr_external_thumbnail_wrapper">
                    <img class=" ' . $is_small . ' wpvr_external_thumbnail" src="' . $use_external_thumb . '" />
                 </div>';
		
		//wpvr_ooo( $user_external_thumb );
		
		return $html;
	}
	
	/* Function for replacing post thumbnail by embeded video player */
	add_action( 'post_thumbnail_html', 'wpvr_video_thumbnail_embed', 20, 2 );
	function wpvr_video_thumbnail_embed( $html, $post_id ) {
		global $wpvr_options, $wpvr_is_admin;
		if ( get_post_type() != WPVR_VIDEO_TYPE ) {
			return $html;
		}
		if ( $wpvr_is_admin === true || is_admin() || $wpvr_options['videoThumb'] === false ) {
			return $html;
		} else {
			if ( is_singular() ) {
				return $html;
			} else {
				$wpvr_video_id = get_post_meta( $post_id, 'wpvr_video_id', true );
				$wpvr_service  = get_post_meta( $post_id, 'wpvr_video_service', true );
				$player        = wpvr_video_embed(
					$wpvr_video_id,
					$post_id,
					$autoPlay = false,
					$wpvr_service
				);
				$embedCode     = '<div class="wpvr_embed">' . $player . '</div>';
				
				return $embedCode;
			}
		}
	}
	
	/* Function for replacing post thumbnail by embeded video player */
	add_filter( 'post_thumbnail_html', 'wpvr_video_thumbnail_use_service_thumb', 20, 2 );
	function wpvr_video_thumbnail_use_service_thumb( $html, $post_id ) {
		global $wpvr_options, $wpvr_is_admin;
		if ( get_post_type() != WPVR_VIDEO_TYPE ) {
			return $html;
		}
		if ( $wpvr_options['downloadThumb'] === false ) {
			return $html;
		}
		
		if ( get_post_meta( $post_id, '_thumbnail_id', true ) == '' ) {
			$service_image_url = get_post_meta( $post_id, 'wpvr_video_service_thumb', true );
			
			return '<img src="' . $service_image_url . '" />';
		} else {
			return $html;
			//return get_post_meta( $post_id , '_thumbnail_id' );
		}
	}
	
	/* Add EG FIX content trick */
	add_action( 'the_content', 'wpvr_eg_content_hook_fix' );
	function wpvr_eg_content_hook_fix( $content ) {
		global $post;
		if ( ! isset( $post->ID ) || ! wpvr_is_imported_video( $post->ID ) ) {
			return $content;
		}
		
		if ( get_post_type() == WPVR_VIDEO_TYPE && WPVR_EG_FIX === true ) {
			$content = preg_replace_callback( "/<iframe (.+?)<\/iframe>/", function ( $matches ) {
				return str_replace( $matches[1], '>', $matches[0] );
			}, $content );
		}
		
		return $content;
	}
	
	add_filter( 'the_content', 'wpvr_video_autoembed_function', 100 );
	function wpvr_video_autoembed_function( $content ) {
		global $post, $wpvr_options, $wpvr_dynamics;
		
		
		if ( ! isset( $post->ID ) || $post->ID == null ) {
			return $content;
		}
		
		$post_id = $post->ID;
		//d( 'WPVR HOOKS');
		
		//AVoid Duplicate hook call
		if ( isset( $wpvr_dynamics['autoembed_done'] ) && $wpvr_dynamics['autoembed_done'] == 1 ) {
			return $content;
		}
		
		//d( wpvr_is_imported_video( $post_id ) );
		//Avoid messing with not video content
		if ( ! wpvr_is_imported_video( $post_id ) ) {
			return $content;
		}
		
		if ( isset( $wpvr_dynamics['cu_autoembed_done'] ) && $wpvr_dynamics['cu_autoembed_done'] == 1 ) {
			return $content;
		}
		
		//Avoid doing anytihng on loops or other content
		if ( ! is_singular() || get_post_type() != WPVR_VIDEO_TYPE ) {
			return $content;
		}
		
		$disableAutoEmbed = get_post_meta( $post_id, 'wpvr_video_disableAutoEmbed', true );
		if ( $disableAutoEmbed == 'default' || $disableAutoEmbed == '' ) {
			$disableAutoEmbed = $wpvr_options['autoEmbed'] ? 'off' : 'on';
		}
		
		// Update Video Views Count
		$views = get_post_meta( $post_id, 'wpvr_video_views', true );
		update_post_meta( $post_id, 'wpvr_video_views', $views + 1 );
		wpvr_update_dynamic_video_views( $post_id, $views + 1 );
		
		//Getting Video Player
		$video_player = wpvr_render_modified_player( $post_id );
		
		//Getting Video Text Content
		$video_content = '';
		$video_content .= stripslashes( do_shortcode( apply_filters( 'wpvr_extend_around_video_content', '', 'before', $post_id ) ) );
		$video_content .= stripslashes( do_shortcode( apply_filters( 'wpvr_extend_video_content', $content, $post_id ) ) );
		$video_content .= stripslashes( do_shortcode( apply_filters( 'wpvr_extend_around_video_content', '', 'after', $post_id ) ) );
		
		
		if ( $disableAutoEmbed == 'on' ) {
			return $content;
		}
		
		if ( $wpvr_options['autoEmbed'] === false ) {
			return $video_content;
		}
		
		if ( $wpvr_options['removeVideoContent'] === true ) {
			return $video_player;
		}
		$wpvr_dynamics['wpvr_autoembed_done'] = 1;
		
		//d( $video_content );
		return $video_player . ' <br/> ' . $video_content;
	}
	
	add_filter( 'wpvr_extend_video_player_arguments', 'wpvr_define_rendered_player_arguments', 100, 2 );
	function wpvr_define_rendered_player_arguments( $args, $post_id ) {
		global $wpvr_options;
		
		$post_meta = get_post_meta( $post_id );
		
		// wpvr_ooo( $post_meta );
		
		$hideRelated     = isset( $post_meta['wpvr_video_hidePlayerRelated'] ) ? $post_meta['wpvr_video_hidePlayerRelated'][0] : '';
		$hideTitle       = isset( $post_meta['wpvr_video_hidePlayerTitle'] ) ? $post_meta['wpvr_video_hidePlayerTitle'][0] : '';
		$hideAnnotations = isset( $post_meta['wpvr_video_hidePlayerAnnotations'] ) ? $post_meta['wpvr_video_hidePlayerAnnotations'][0] : '';
		
		
		// d( $hideAnnotations );
		if ( $hideRelated == 'default' || $hideRelated == '' ) {
			$hideRelated = $wpvr_options['hidePlayerRelated'] ? 'on' : 'off';
		}
		if ( $hideTitle == 'default' || $hideTitle == '' ) {
			$hideTitle = $wpvr_options['hidePlayerTitle'] ? 'on' : 'off';
		}
		
		if ( $hideAnnotations == 'default' || $hideAnnotations == '' ) {
			$hideAnnotations = $wpvr_options['hidePlayerAnnotations'] ? 'on' : 'off';
		}
		
		$args['rel']            = $hideRelated == 'on' ? '0' : '1';
		$args['showinfo']       = $hideTitle == 'on' ? '0' : '1';
		$args['modestbranding'] = '0';
		
		
		if ( $hideAnnotations == 'on' ) {
			$args['iv_load_policy'] = 3;
		}
		
		// d( $args );
		
		return $args;
	}
	
	
	add_filter( 'wpvr_extend_found_item_author_data', 'wpvr_add_video_author_data', 100, 5 );
	function wpvr_add_video_author_data( $videoItem, $channel_title = null, $channel_id = null, $thumbnail = null, $link = null ) {
		
		
		$title_length        = 18;
		$videoItem['author'] = false;
		if ( $channel_title == '' || $channel_id == '' ) {
			return $videoItem;
		}
		if ( strlen( $channel_title ) > $title_length ) {
			$channel_title_cut = mb_substr( $channel_title, 0, $title_length ) . '...';
		} else {
			$channel_title_cut = $channel_title;
		}
		
		$videoItem['author'] = array(
			'id'        => $channel_id,
			'title'     => $channel_title,
			'title_cut' => $channel_title_cut,
			'thumbnail' => $thumbnail,
			'link'      => $link,
		);
		
		//d( $videoItem );
		return $videoItem;
	}
	
	add_filter( 'wpvr_extend_define_videos_columns', 'wpvr_enable_overriding_videos_columns', 1 );
	function wpvr_enable_overriding_videos_columns() {
		global $wpvr_options;
		if ( $wpvr_options['adminOverride'] === true ) {
			return true;
		} else {
			return false;
		}
		
		
	}
	
	/*************************************/
	
	//add_action( 'add_meta_boxes' , 'wpvr_adapt_cpt_meta_boxes' , 1000 );
	function wpvr_adapt_cpt_meta_boxes() {
		
		global $wp_meta_boxes, $post;
		$wpvr_mb = get_option( 'wpvr_mb' );
		if ( $wpvr_mb == '' || $wpvr_mb == array() ) {
			return false;
		}
		if ( $post->post_type != WPVR_VIDEO_TYPE ) {
			return false;
		}
		
		$theme = wp_get_theme(); // gets the current theme
		if ( $theme->parent_theme == '' ) {
			$theme_name = $theme->name;
		} else {
			$theme_name = $theme->parent_theme;
		}
		if ( ! isset( $wpvr_mb[ $theme_name ] ) ) {
			return false;
		}
		$mbs = $wpvr_mb[ $theme_name ];
		
		foreach ( (array) $mbs['side'] as $id => $mb ) {
			$wp_meta_boxes[ WPVR_VIDEO_TYPE ]['side'][ $mb['level'] ][ $mb['id'] ] = $mb;
		}
		
		foreach ( (array) $mbs['normal'] as $id => $mb ) {
			$wp_meta_boxes[ WPVR_VIDEO_TYPE ]['normal'][ $mb['level'] ][ $mb['id'] ] = $mb;
		}
	}
	
	add_action( 'add_meta_boxes', 'wpvr_update_cpt_meta_boxes', 1000 );
	function wpvr_update_cpt_meta_boxes() {
		global $wp_meta_boxes, $wpvr_getmb_unsupported_themes;
		
		//d( $_GET );
		
		$theme = wp_get_theme(); // gets the current theme
		if ( $theme->parent_theme == '' ) {
			$theme_name = $theme->name;
		} else {
			$theme_name = $theme->parent_theme;
		}
		
		
		if ( in_array( $theme_name, $wpvr_getmb_unsupported_themes ) ) {
			return false;
		}
		//d( $theme_name );
		
		
		//if( isset( $_GET[ 'wpvr_reset_mb' ] ) && $_GET[ 'wpvr_reset_mb' ] == '1' ) $wpvr_mb = array();
		if ( isset( $_GET['wpvr_clear_mb'] ) && $_GET['wpvr_clear_mb'] == 1 ) {
			update_option( 'wpvr_mb', array() );
			
			return false;
		}
		if ( ! isset( $_GET['wpvr_get_mb'] ) || $_GET['wpvr_get_mb'] != 1 ) {
			return false;
		}
		//d( $_GET );
		
		$wpvr_mb = get_option( 'wpvr_mb' );
		if ( $wpvr_mb == '' ) {
			$wpvr_mb = array();
		}
		if ( isset( $_GET['wpvr_reset_mb'] ) && $_GET['wpvr_reset_mb'] == 1 ) {
			$wpvr_mb = array();
		}
		
		//if( isset( $wpvr_mb[ $theme_name ] ) ) return FALSE;
		$wpvr_mb[ $theme_name ] = array(
			'theme'  => $theme,
			'normal' => array(),
			'side'   => array(),
		);
		
		$mb_post_types = apply_filters( 'wpvr_extend_mb_post_types', array( 'post' ) );
		
		
		foreach ( (array) $mb_post_types as $post_type ) {
			
			//d( $post_type );
			if ( ! isset( $wp_meta_boxes[ $post_type ] ) ) {
				continue;
			}
			//Cloning Normal metaboxes
			foreach ( (array) $wp_meta_boxes[ $post_type ]['normal'] as $level => $mbs ) {
				//d( $mbs );
				foreach ( (array) $mbs as $mb ) {
					
					$mb['level'] = $level;
					
					$wpvr_mb[ $theme_name ]['normal'][ $mb['id'] ] = $mb;
				}
			}
			//Cloning Side metaboxes
			foreach ( (array) $wp_meta_boxes[ $post_type ]['side'] as $level => $mbs ) {
				//d( $mbs );
				foreach ( (array) $mbs as $mb ) {
					$mb['level'] = $level;
					
					$wpvr_mb[ $theme_name ]['side'][ $mb['id'] ] = $mb;
				}
			}
		}
		//d( $wpvr_mb );
		update_option( 'wpvr_mb', $wpvr_mb );
		
		$msg  = __( 'New Theme Metaboxes detected and added.', WPVR_LANG ) . '<br/>' .
		        __( 'You can now handle your imported videos as any regular Wordpress post.' ) . '<br/><br/>' .
		        '<a id="wpvr_get_mb_close" href="#">' . __( 'Close', WPVR_LANG ) . '</a>';
		$slug = wpvr_add_notice( array(
			'title'     => 'WP Video Robot : ',
			'class'     => 'updated', //updated or warning or error
			'content'   => $msg,
			'hidable'   => false,
			'is_dialog' => false,
			'show_once' => true,
			'color'     => '#27A1CA',
			'icon'      => 'fa-cube',
		) );
		wpvr_render_notice( $slug );
		wpvr_remove_notice( $slug );
		
		?>
        <style>
            #poststuff {
                display: none;
            }

            .wrap h1 {
                visibility: hidden;
            }
        </style>
		<?php
	}
	
	add_filter( 'wpvr_show_silence_is_golden', 'wpvr_define_silence_message', 100, 1 );
	function wpvr_define_silence_message( $message ) {
		ob_start();
		
		?>
        <style>
            body {
                background: #f0f0f0;
                margin: 1em;
                font-family: Arial;
                color: #222222;
                font-size: 14px;
            }
        </style>
        <div style="background: #FFF;padding: 1em 2em;width: 300px;border-radius: 3px;margin: 50px auto;">
            <strong><?php echo __( 'WP Video Robot is working properly.', WPVR_LANG ); ?></strong>
            <br/>
            <br/>
			<?php echo __( 'Enable CRON Debug Mode to have more details about the automation process.', WPVR_LANG ); ?>
        </div>
		<?php
		
		$output = ob_get_contents();
		ob_get_clean();
		
		return $output;
	}
	
	
	add_action( 'init', 'wpvr_show_loading' );
	function wpvr_show_loading() {
		global $wpvr_global_loading;
		
		if ( WPVR_SMOOTH_SCREEN_ENABLED === false ) {
			return false;
		}
		
		if ( $wpvr_global_loading === true ) {
			return false;
		}
		
		if ( ! isset( $_GET['page'] ) || $_GET['page'] != 'wpvr' ) {
			return false;
		}
		
		if (
			! isset( $_GET['test_sources'] )
			&& ! isset( $_GET['run_sources'] )
		) {
			return false;
		}
		
		$wpvr_global_loading = true;
		
		?>
        <div class="wpvr_global_loading wpvr_hide_when_loaded">
            <div class="wpvr_global_loading_inner">
                <img class="" src="<?php echo WPVR_URL . 'assets/images/spinner.white.gif' ?>">
                <span><?php echo __( 'Please Wait ...', WPVR_LANG ); ?></span>
            </div>
        </div>
        <style>

            .wpvr_global_loading {
                position: fixed;
                background: rgba(0, 0, 0, 0.6);
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                z-index: 1000;
                color: #FFF;
                text-align: center;
                padding-top: 70px;
            }

            .wpvr_global_loading_inner {
                background: rgb(255, 255, 255);
                width: 200px;
                margin: 0 auto;
                padding: 10px;
                border-radius: 3px;
                color: #999;
                text-align: center;

            }

            .wpvr_global_loading img {
                display: block;
                margin: 0 auto 5px auto;
            }
        </style>
		<?php
	}
	
	//add_action( 'wpvr_check_source_fetching_result', 'wpvr_check_source_fetching_result_callback', 100, 2 );
	function wpvr_check_source_fetching_result_callback( $videosFound, $source ) {
		global $wpvr_options;
		
		// d( $videosFound );
		
		if ( $videosFound['nextPageToken'] == 'end' && $videosFound['count'] == 0 ) {
			// No results returned by this source fetching process
			$new_count_fail = $source->count_fail + 1;
			update_post_meta( $source->id, 'wpvr_source_count_fail', $new_count_fail );
			if ( $new_count_fail >= $wpvr_options['sourceDeactivationThreshold'] ) {
				//Deactivate the source
				update_post_meta( $source->id, 'wpvr_source_status', 'off' );
			}
		} else {
			$new_count_success = $source->count_success + 1;
			update_post_meta( $source->id, 'wpvr_source_count_success', $new_count_success );
			update_post_meta( $source->id, 'wpvr_source_count_fail', 0 );
			
		}
		
		
	}
	
	
	add_filter( 'wpvr_extend_import_success_message', 'wpvr_add_allowurlfopen_error_message', 100, 1 );
	function wpvr_add_allowurlfopen_error_message( $message ) {
		
		if ( ini_get( 'allow_url_fopen' ) == '1' ) {
			return $message;
		}
		
		$message .= '<br/><br/>';
		$message .= '<strong>Warning:</strong> :<br/>';
		$message .= ___( 'The video thumbnails could not be downloaded because the PHP AllowUrlFopen extension is disabled on your server.' );
		$message .= ' ' . ___( 'Enable it in order to download the video thumbnails to your site.' );
		
		return $message;
		
		
	}
	
	add_action( 'wpvr_print_before_run_sources', 'wpvr_check_allowurlfopen_extension', 10, 1 );
	add_action( 'wpvr_print_before_test_sources', 'wpvr_check_allowurlfopen_extension', 10, 1 );
	function wpvr_check_allowurlfopen_extension( $sources ) {
		
		if ( ini_get( 'allow_url_fopen' ) == '1' ) {
			return;
		}
		
		$error_notice_slug = wpvr_add_notice( array(
			'title'     => 'WP Video Robot : ',
			'class'     => 'error', //updated or warning or error
			'content'   => __( 'The PHP extension allow_url_fopen is not enabled.', WPVR_LANG ) . ' ' .
			               __( "Therefore, WPVR is unable to download then video thumbnails file on your server.", WPVR_LANG ) . ' <br/>' .
			               __( "Please enable that extension or ask your host to enable it.", WPVR_LANG ),
			'hidable'   => false,
			'is_dialog' => false,
			'show_once' => true,
			'color'     => '#e4503c',
			'icon'      => 'fa-exclamation-circle',
		) );
		wpvr_render_notice( $error_notice_slug );
		wpvr_remove_notice( $error_notice_slug );
	}
	
	
	add_action( 'wpvr_event_cron_defer_after', 'wpvr_hook_autoCleaner_to_defer_step', 100, 2 );
	function wpvr_hook_autoCleaner_to_defer_step( $counter, $deferred_videos ) {
		global $wpvr_options;
		
		if ( $counter != 40 ) {
			return;
		}
		if ( $wpvr_options['autoClean'] === false ) {
			return;
		}
		
		if ( ! wpvr_autoClean_should_work() ) {
			$nowTime = wpvr_get_time( 'now', false, true, false, true );
			cron_say( 'AutoCleaner is not scheduled now (' . $nowTime . ').' );
			
			return;
		}
		
		cron_say( 'AutoCleaner working ...' );
		$merge = wpvr_better_merge_all_duplicates();
		
		if ( $merge['count']['duplicates'] == 0 ) {
			cron_say( "No duplicate found. Your site is clean :)" );
		} else {
			cron_say( "{$merge['count']['duplicates']} duplicate(s) merged. {$merge['count']['videos']} video(s) processed in
		{$merge['exec_time']} seconds." );
		}
		
		//d( $wpvr_options );
		
	}
	
	add_filter( 'wpvr_extend_trashed_message', 'wpvr_notify_autoUnwant_on_trash', 100, 1 );
	function wpvr_notify_autoUnwant_on_trash( $message ) {
		global $wpvr_options;
		
		if ( $wpvr_options['unwantOnTrash'] === false ) {
			return $message;
		}
		
		$message .= '<br/><br/><div class="wpvr_inner_notice">';
		$message .= '<strong>' . ___( 'Notice' ) . ': </strong><br/>';
		$message .= ___( 'The trashed videos have been automatically added to unwanted. That means the plugin will skip them on next executions.' ) . '<br/>';
		$message .= ___( 'You can disable the "Auto Unwant After Trashing Videos" on the WPVR General Options.' );
		$message .= '</div> <br/>';
		
		return $message;
		
	}
	
	add_filter( 'wpvr_extend_deleted_message', 'wpvr_notify_autoUnwant_on_delete', 100, 1 );
	function wpvr_notify_autoUnwant_on_delete( $message ) {
		global $wpvr_options;
		
		if ( $wpvr_options['unwantOnDelete'] === false ) {
			return $message;
		}
		
		$message .= '<br/><br/><div class="wpvr_inner_notice">';
		$message .= '<strong>' . ___( 'Notice' ) . ': </strong><br/>';
		$message .= ___( 'The deleted videos have been automatically added to unwanted. That means the plugin will skip them on next executions.' ) . '<br/>';
		$message .= ___( 'You can disable the "Auto Unwant After Deleting Videos" on the WPVR General Options.' );
		$message .= '</div> <br/>';
		
		return $message;
		
	}
	
	
	add_filter( 'wpvr_extend_found_item', 'wpvr_append_additional_videoItem_parameters', 100, 2 );
	function wpvr_append_additional_videoItem_parameters( $videoItem, $item ) {
		global $wpvr_options;
		if ( ! isset( $videoItem['sourceId'] ) || $videoItem['sourceId'] == 0 || $videoItem['sourceId'] == '' ) {
			return $videoItem;
		}
		$source = wpvr_get_source( $videoItem['sourceId'] );
		// d( $source );
		
		$videoItem['downloadThumb']         = $source->downloadThumb == 'on' ? true : false;
		$videoItem['hidePlayerRelated']     = $source->hidePlayerRelated;
		$videoItem['hidePlayerTitle']       = $source->hidePlayerTitle;
		$videoItem['hidePlayerAnnotations'] = $source->hidePlayerAnnotations;
		$videoItem['startTime']             = $source->startTime;
		$videoItem['endTime']               = $source->endTime;
		$videoItem['postStatus']            = $source->postStatus;
		
		//d( $videoItem );
		
		return $videoItem;
	}
	
	add_filter( 'wp_get_attachment_image_src', 'wpvr_forceUseExternalThumbnail', 100, 2 );
	function wpvr_forceUseExternalThumbnail( $image, $att_id ) {
		global $wpvr_options;
		
		if ( $wpvr_options['forceExternalThumb'] === false ) {
			return $image;
		}
		
		$use_external_thumb = get_post_meta( $att_id, 'wpvr_video_using_external_thumbnail', true );
		
		if ( $use_external_thumb != '' ) {
			return array(
				$use_external_thumb,
				'',
				'',
			);
		}
		
		return $image;
	}
	
	add_filter( 'wpvr_extend_posting_authors_roles', 'wpvr_define_more_roles_for_posting_author', 100, 1 );
	function wpvr_define_more_roles_for_posting_author( $roles ) {
		//$roles = array();
		return $roles;
	}