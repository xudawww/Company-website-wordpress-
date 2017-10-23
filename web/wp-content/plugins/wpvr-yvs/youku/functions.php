<?php
	require_once( 'functions.api.php' );
	
	/* Inject Service Styles */
	$vs['get_styles'] = function () use ( $vs, $pid_suffix ) {
		$vs_id    = $vs['id'];
		$vs_color = $vs['color'];
		$styles
		          = "
			.wpvr_service_icon.$vs_id{ background-color:$vs_color;}\n
			.wpvr_video_author.$vs_id{ background-color:$vs_color;}\n
            .wpvr_source_icon_right.$vs_id{ background-color:$vs_color;}\n
            .wpvrArgs[service=$vs_id] , .wpvr_source_icon[service=$vs_id]{ border-color:$vs_color;}\n
		";
		
		return $styles;
	};
	
	/* Embed Video */
	$vs['video_embed'] = function ( $videoID, $post_id = '', $autoPlay = true, $add_styles = false, $player_args = array(), $player_attributes = array() ) use ( $vs, $pid_suffix ) {
		global $wpvr_options, $wpvr_dynamics;
		
		$player_width  = '100%';
		$player_height = '459';
		$player_styles = '';
		
		if ( $add_styles === true ) {
			$player_styles = ' position:absolute !important;top:0 !important;left:0 !important;width:100% !important;height:100% !important; ';
		}
		
		
		if ( $wpvr_dynamics['player_tags']['force_autoplay_disable'] === true ) {
			$autoPlay = false;
		}
		
		$player_classes = implode( ' ', $wpvr_dynamics['player_classes'] );
		
		$player_base_args = array(
			'title'    => '0',
			'byline'   => '0',
			'portrait' => '0',
			'color'    => 'ffffff',
			'autoplay' => ( $autoPlay === true ? 1 : 0 ),
		);
		
		$player_args = wpvr_extend( $player_args, $player_base_args );
		if (
			isset( $wpvr_dynamics['player_options'][ $vs['id'] ] )
			&& is_array( $wpvr_dynamics['player_options'][ $vs['id'] ] )
		) {
			$player_args = wpvr_extend( $player_args, $wpvr_dynamics['player_options'][ $vs['id'] ] );
		}
		
		$player_args_string = http_build_query( $player_args, '&amp;' );
		$player_args_string = '';
		$player_src         = 'http://player.youku.com/embed/' . $videoID . '?' . $player_args_string;
		
		$player_base_attributes = array(
			'video_id'              => $videoID,
			'style'                 => $player_styles,
			'class'                 => ' wpvr_iframe youku ' . $player_classes,
			'id'                    => 'wpvr_iframe_' . $videoID,
			'width'                 => $player_width,
			'height'                => $player_height,
			'src'                   => $player_src,
			'frameborder'           => "0",
			'webkitallowfullscreen' => "",
			'mozallowfullscreen'    => "",
			'allowfullscreen'       => "",
		);
		$player_attributes      = wpvr_extend( $player_attributes, $player_base_attributes );
		
		//_d( $player_attributes );
		
		$player_attributes_string = wpvr_render_html_attributes( $player_attributes );
		
		$player = '<iframe ' . $player_attributes_string . ' ></iframe>';
		
		return $player;
	};
	
	/* GET DATA */
	$vs['get_trends_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		return false;
	};
	
	/* GET YOUTUBE CHANNEL DATA */
	$vs['get_channel_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		return false;
	};
	
	/* GET YOUTUBE PLAYLIST DATA */
	$vs['get_playlist_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			return false;
		}
		
		$api_endpoint                      = $vs['api_base'] . 'playlists/show.json';
		$api_args                          = array();
		$api_args[ $api_handle['method'] ] = $api_handle['value'];
		$api_args['playlist_id']           = $param;
		
		$api_response = wpvr_make_curl_request( $api_endpoint, $api_args );
		if ( $api_response['status'] != 200 ) {
			return false;
		}
		
		return array(
			'name'    => $api_response['json']['name'],
			'thumb'   => $api_response['json']['thumbnail'],
			'thumbHQ' => $api_response['json']['thumbnail'],
		);
	};
	
	
	/* GET YOUTUBE PLAYLIST DATA */
	$vs['get_user_data'] = function ( $param = null, $type = 'username' ) use ( $vs, $pid_suffix ) {
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			return false;
		}
		
		$api_endpoint                      = $vs['api_base'] . 'users/show.json';
		$api_args                          = array();
		$api_args[ $api_handle['method'] ] = $api_handle['value'];
		
		if ( $type == 'username' ) {
			$api_args['user_name'] = $param;
		} elseif ( $type == 'user_id' ) {
			$api_args['user_id'] = $param;
		} elseif ( $type == 'userid' ) {
			return false;
		}
		$api_response = wpvr_make_curl_request( $api_endpoint, $api_args );
		$api_response = wpvr_object_to_array( $api_response );
		//d( $api_response );
		
		if ( $api_response['status'] != 200 ) {
			return false;
		}
		
		return array(
			'id'          => $api_response['json']['id'],
			'name'        => $api_response['json']['name'],
			'thumb'       => $api_response['json']['avatar'],
			'thumbHQ'     => $api_response['json']['avatar_large'],
			'description' => $api_response['json']['avatar_large'],
		);
	};
	
	
	/* Render Subheader */
	$vs['render_subheader'] = function ( $source = null ) use ( $vs, $pid_suffix ) {
		$source_type = $source->type;
		$vs_type     = $vs['types'][ $source_type ];
		if ( $vs_type['subheader'] === false ) {
			return '';
		}
		if ( $vs_type['subdata_function'] === false ) {
			return '';
		}
		
		$sub_data = $vs[ $vs_type['subdata_function'] ]( $source->$vs_type['param'], $source->userType_yk );
		
		$output = '';
		
		if ( $vs_type['global_id'] == 'trends' ) {
			if ( $source->$vs_type['param'] == '' ) {
				$worldwide       = '<i class="wpvr_worldwide fa fa-globe"></i>';
				$subheader_title = __( 'Trends Worldwide', WPVR_LANG );
			} else {
				$worldwide       = '';
				$subheader_title = __( 'Trends in', WPVR_LANG ) . ' ' . wpvr_get_country_name( $source->$vs_type['param'] );
			}
			
			$output
				= '
				<div class="wpvr_subsource">
					<div class="wpvr_subsource_thumb wpvr_flags f32 ' . $vs_type['global_id'] . '">
						<span class="flag ' . strtolower( $source->$vs_type['param'] ) . ' "></span>
						' . $worldwide . '
					</div>
					<div class="wpvr_subsource_name ' . $vs_type['global_id'] . '">
						' . $subheader_title . '
					</div>
					<div class="wpvr_clearfix"></div>
				</div>
			';
			
		} elseif ( $sub_data != false ) {
			$output
				= '
				<div class="wpvr_subsource">
					<div class="wpvr_subsource_thumb ' . $vs_type['global_id'] . '">
						<img src="' . $sub_data['thumb'] . '" alt="' . $sub_data['name'] . '" />
					</div>
					<div class="wpvr_subsource_name ' . $vs_type['global_id'] . '">
						' . $sub_data['name'] . '
					</div>
					<div class="wpvr_clearfix"></div>
				</div>
			';
		}
		
		return $output;
	};
	
	/* Get Video Tags */
	$vs['get_video_tags'] = function ( $videoId ) use ( $vs, $pid_suffix ) {
		return array();
	};
	
	/* GEt Video Stats */
	$vs['get_video_stats'] = function ( $videosFound, $options ) use ( $vs, $pid_suffix ) {
		return $videosFound;
	};
	
	/* Get Single Video Data */
	$vs['get_single_video_data'] = function ( $video_id ) use ( $vs, $pid_suffix ) {
		
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			wpvr_add_notice( array(
				'title'     => 'WP Video Robot ERROR :',
				'class'     => 'error', //updated or warning or error
				'content'   => $vs['msgs']['authentication_error'],
				'hidable'   => false,
				'is_dialog' => false,
				'show_once' => true,
			) );
			
			return false;
		}
		
		$api_endpoint                      = $vs['api_base'] . 'videos/show.json';
		$api_args['video_id']              = $video_id;
		$api_args[ $api_handle['method'] ] = $api_handle['value'];
		
		$api_response = wpvr_make_curl_request( $api_endpoint, $api_args, null, false );
		
		if ( $api_response['status'] != '200' ) {
			wpvr_add_notice( array(
				'title'     => 'WP Video Robot ERROR :',
				'class'     => 'error', //updated or warning or error
				'content'   => $vs['msgs']['video_not_found'],
				'hidable'   => false,
				'is_dialog' => false,
				'show_once' => true,
			) );
			
			return false;
		}
		
		
		$item = (array) json_decode( $api_response['data'] );
		$item = wpvr_object_to_array( $item );
		
		//d( $item );
		if ( isset( $item['bigThumbnail'] ) ) {
			$bigThumb = $item['bigThumbnail'];
		} elseif ( isset( $item['thumbnail_v2'] ) ) {
			$bigThumb = $item['thumbnail_v2'];
		} else {
			$bigThumb = false;
		}
		
		$nDate            = new DateTime( $item['published'] );
		$originalPostDate = $nDate->format( 'Y-m-d H:i:s' );
		$metas            = array(
			
			'id'               => $video_id,
			'viewIcon'         => '<img style="" width="150" height="115" src="' . $item['thumbnail'] . '">',
			'title'            => $item['title'],
			'desc'             => '',
			'thumb'            => $item['thumbnail'],
			'hqthumb'          => $bigThumb,
			'service'          => $vs['id'],
			'icon'             => $item['thumbnail'],
			'url'              => $item['link'],
			'originalPostDate' => $originalPostDate,
			'likes'            => $item['up_count'],
			'dislikes'         => $item['down_count'],
			'views'            => $item['view_count'],
			'duration'         => 'PT' . ceil( $item['duration'] ) . 'S',
			'source_tags'      => array(),
			'tags'             => explode( ',', $item['tags'] ),
		);
		
		
		$metas['author'] = array(
			'id'        => $item['user']['id'],
			'title'     => $item['user']['name'],
			'title_cut' => $item['user']['name'],
			'thumbnail' => null,
			'link'      => $item['user']['link'],
		);
		
		//d( $metas );
		
		
		return $metas;
	};
	
	/* Fetch Videos */
	$vs_yk                 = $vs;
	$vs_yk['fetch_videos'] = function ( $videosFound, $options, $oldVideos ) use ( &$vs_yk, $pid_suffix ) {
		global $preDuplicates;
		global $default_videosFound, $default_fetching_options;
		
		//d( $videosFound );
		
		$default_videosFound['nextPageToken'] = '1';
		
		//Default variables
		$default_fetching_options = wpvr_prepare_sOptions_fields( $default_fetching_options, null, $default = true );
		$videosFound              = wpvr_extend( $videosFound, $default_videosFound );
		$options                  = wpvr_extend( $options, $default_fetching_options );
		
		$api_handle = $vs_yk['api_auth']();
		
		//_d( $options );
		
		if ( $api_handle === false ) {
			return $videosFound;
		}
		
		if ( $options['how']['onlyNewVideos'] == 'on' ) {
			$options['how']['onlyNewVideos'] = true;
		} else {
			$options['how']['onlyNewVideos'] = false;
		}
		
		if ( ! isset( $videosFound['ch'] ) || $videosFound['ch'] == '' ) {
			$videosFound['ch'] = curl_init();
		}
		if ( $videosFound['execTime'] == '' ) {
			$videosFound['execTime'] = microtime( true );
		}
		
		$vs_type = $vs_yk['types'][ $options['what']['mode'] ];
		
		$api_args = array(
			'page'        => $videosFound['nextPageToken'],
			'count'       => 20,
			'public_type' => 'all',
			'orderby'     => 'relevance',
		);
		//d( $api_handle );
		$api_args[ $api_handle['method'] ] = $api_handle['value'];
		
		
		$direction = "desc";
		if ( $options['what']['order'] == 'title' ) {
			$sort = "published";
		} elseif ( $options['what']['order'] == 'rating' ) {
			$sort = "favorite-count";
		} elseif ( $options['what']['order'] == 'viewCount' ) {
			$sort = "view-count";
		} elseif ( $options['what']['order'] == 'date' ) {
			$sort = "published";
		} elseif ( $options['what']['order'] == 'relevance' ) {
			$sort = "relevance";
		} else {
			$sort = 'date';
		}
		
		if ( $options['what']['mode'] == 'search' . $pid_suffix ) {
			
			$api_endpoint          = $vs_yk['api_base'] . 'searches/video/by_keyword.json';
			$api_args['keyword']   = $options['what'][ $vs_type['param'] ];
			$api_args['orderby']   = $sort;
			$api_args['direction'] = $direction;
			
			
		} elseif ( $options['what']['mode'] == 'playlist' . $pid_suffix ) {
			
			$api_endpoint            = $vs_yk['api_base'] . 'playlists/videos.json';
			$api_args['playlist_id'] = $options['what'][ $vs_type['param'] ];
			$api_args['orderby']     = $sort;
			$api_args['direction']   = $direction;
			
		} elseif ( $options['what']['mode'] == 'user' . $pid_suffix ) {
			$api_endpoint = $vs_yk['api_base'] . 'videos/by_user.json';
			
			if ( $options['what']['userType_yk'] == 'username' ) {
				$api_args['user_name'] = $options['what'][ $vs_type['param'] ];
				$param                 = $options['what'][ $vs_type['param'] ];
				$type                  = 'username';
				$username              = $param;
				$userid                = '';
			} else {
				$api_args['user_id'] = $options['what'][ $vs_type['param'] ];
				$param               = $options['what'][ $vs_type['param'] ];
				$type                = 'user_id';
				$userid              = $param;
				$username            = '';
			}
			
			$api_args['orderby']   = $sort;
			$api_args['direction'] = $direction;
			
			$user_data = $vs_yk['get_user_data']( $param, $type );
			if ( $user_data != false ) {
				$user_data_arr = array(
					'id'    => $user_data['id'],
					'name'  => $user_data['name'],
					'thumb' => $user_data['thumb'],
					'link'  => '',
				);
			} else {
				$user_data_arr = array(
					'id'    => $userid,
					'name'  => $username,
					'thumb' => '',
					'link'  => '',
				);
			}
			
			
		} elseif ( $options['what']['mode'] == 'videos' . $pid_suffix ) {
			
			$api_endpoint          = $vs_yk['api_base'] . 'videos/show_batch.json';
			$api_args['video_ids'] = $options['what'][ $vs_type['param'] ];
			$api_args['orderby']   = $sort;
			
		} else {
			echo "UNKOWN MODE. EXIT !";
			
			return $videosFound;
		}
		
		
		if ( ! isset( $videosFound['recalls'] ) ) {
			$videosFound['recalls'] = 0;
		}
		$api_response = wpvr_make_curl_request( $api_endpoint, $api_args, $videosFound['ch'] );
		//d( $api_response );
		$api_response = wpvr_object_to_array( $api_response );
		
		
		if ( WPVR_API_RESPONSE_DEBUG ) {
			d( $api_response );
		}
		
		
		if (
			$api_response['status'] != '200'
			|| ! isset( $api_response['json']['videos'] )
		) {
			if ( isset( $api_response['json']['error'] ) ) {
				wpvr_render_error_notice(
					'API Error : <br/> ' .
					$api_response['json']['error']->description
				);
			} else {
				wpvr_render_error_notice( $vs_yk['msgs']['api_error'] );
			}
			
			return $videosFound;
		}
		
		$response_items = $api_response['json']['videos'];
		
		
		if ( isset( $api_response['json']['total'] ) ) {
			$videosFound['totalResults'] = $api_response['json']['total'];
		} else {
			$videosFound['totalResults'] = 0;
		}
		
		$videosIds                = "";
		$videosFound['videosIds'] = "";
		
		
		foreach ( (array) $response_items as $item ) {
			$videosFound['absCount'] ++;
			$item = (array) $item;
			
			
			$videoId = $item['id'];
			
			
			if ( $videosFound['real_count'] >= $options['how']['wantedResults'] ) {
				$videosFound['execTime'] = round( microtime( true ) - $videosFound['execTime'], 2 );
				break;
			}
			
			
			if ( array_key_exists( $videoId, $oldVideos ) ) {
				if ( isset( $oldVideos[ $videoId ] ) && $oldVideos[ $videoId ] == 'unwanted' ) {
					$videosFound['unwantedCount'] ++;
				} else {
					$videosFound['dupCount'] ++;
				}
				//continue;
			}
			
			
			if ( $options['how']['onlyNewVideos'] === false || ! ( array_key_exists( $videoId, $oldVideos ) ) ) {
				
				if ( $options['how']['onlyNewVideos'] && array_key_exists( $videoId, $oldVideos ) ) {
					$isDuplicate = true;
				} else {
					$isDuplicate = false;
				}
				
				
				//new dBug ($preDuplicates);
				
				if ( ! ( array_key_exists( $videoId, $preDuplicates ) ) ) {
					$preDuplicates[ $videoId ] = 1;
					
					$videosIds                .= $videoId . ",";
					$videosFound['videosIds'] .= $videoId . ",";
					
					// Getting Tags
					if ( ! isset( $item['tags'] ) ) {
						$item['tags'] = array();
					} else {
						$item['tags'] = explode( ',', $item['tags'] );
					}
					
					$nDate            = new DateTime( $item['published'] );
					$originalPostDate = $nDate->format( 'Y-m-d H:i:s' );
					
					
					if ( isset( $item['bigThumbnail'] ) ) {
						$bigThumb = $item['bigThumbnail'];
					} elseif ( isset( $item['thumbnail_v2'] ) ) {
						$bigThumb = $item['thumbnail_v2'];
						//$bigThumb = false ;
					} else {
						$bigThumb = false;
					}
					
					if ( $item['thumbnail'] == '' ) {
						$item['thumbnail'] = WPVR_NO_THUMB;
						$bigThumb          = false;
					}
					
					if ( ! isset( $item['user'] ) ) {
						$item['user'] = $user_data_arr;
					}
					
					$videoItem = array(
						'id'               => $videoId,
						'viewIcon'         => '<img style="" width="150" height="115" src="' . $item['thumbnail'] . '">',
						'title'            => $item['title'],
						'description'      => '',
						'thumb'            => $item['thumbnail'],
						'hqthumb'          => $bigThumb,
						'service'          => $vs_yk['id'],
						'icon'             => $item['thumbnail'],
						'url'              => $item['link'],
						'originalPostDate' => $originalPostDate,
						'likes'            => $item['up_count'],
						'dislikes'         => $item['down_count'],
						'views'            => $item['view_count'],
						'duration'         => 'PT' . ceil( $item['duration'] ) . 'S',
						'source_tags'      => $options['how']['postTags'],
						'tags'             => $item['tags'],
						'duplicate'        => $isDuplicate,
						'postDate'         => $options['how']['postDate'],
						'postCats'         => $options['how']['postCats'],
						'postAuthor'       => $options['how']['postAuthor'],
						'postContent'      => $options['how']['postContent'],
						'autoPublish'      => $options['how']['autoPublish'],
						'postStatus'       => $options['how']['postStatus'],
						'sourceName'       => $options['how']['sourceName'],
						'sourceId'         => $options['how']['sourceId'],
						'sourceType'       => $options['how']['sourceType'],
						'postAppend'       => $options['how']['postAppend'],
						'appendCustomText' => $options['how']['appendCustomText'],
						'appendSourceName' => $options['how']['appendSourceName'],
					);
					
					//d( $item[ 'user' ] );
					$videoItem = apply_filters(
						'wpvr_extend_found_item_author_data',
						$videoItem, //videoItem
						$item['user']['name'], //Author Name
						$item['user']['id'], // Author ID
						null, // Author Image
						$item['user']['link'] // Author Link
					);
					
					$videoItem = apply_filters(
						'wpvr_extend_found_item',
						$videoItem,
						$item
					);
					
					//d( $videoItem );
					$videosFound['items'][ $videoId ] = $videoItem;
					$oldVideos[ $videoId ]            = "tmp";
					$videosFound['count'] ++;
				}
			}
			$videosFound['real_count'] = count( $videosFound['items'] );
		}
		
		
		if (
			20 * ( $videosFound['nextPageToken'] + 1 ) >= $videosFound['totalResults']
			|| $videosFound['real_count'] >= $options['how']['wantedResults']
		) {
			$videosFound['nextPageToken'] = "end";
		} else {
			$videosFound['nextPageToken'] = $videosFound['nextPageToken'] + 1;
		}
		
		
		/* Apply Filtering on Videos Found */
		$videosFound = apply_filters( 'wpvr_filter_videos_found', $videosFound, $options );
		
		
		if (
			$videosFound['totalResults'] != 0
			&& $videosFound['real_count'] < $options['how']['wantedResults']
			&& $videosFound['real_count'] < $videosFound['totalResults']
		) {
			if ( $videosFound['nextPageToken'] == 'end' ) {
				if ( $options['how']['debugMode'] ) {
					echo( '<br/> Found : ' . $videosFound['count'] . ' .... END SEARCH' );
				}
			} else {
				if ( $options['how']['debugMode'] ) {
					echo( '<br/> Found : ' . $videosFound['count'] . ' .... need to recall' );
				}
				$videosFound['recalls'] = $videosFound['recalls'] + 1;
				
				$videosFound = $vs_yk['fetch_videos']( $videosFound, $options, $oldVideos );
			}
		} else {
			if ( $options['how']['debugMode'] ) {
				echo( '<br/> Found : ' . $videosFound['count'] . ' .... DONE !' );
			}
			$videosFound['execTime'] = round( microtime( true ) - $videosFound['execTime'], 2 );
		}
		
		return $videosFound;
	};
	$vs['fetch_videos']    = $vs_yk['fetch_videos'];
	/* Fetch Videos */
	
	/* Get Comments of a video */
	$vs_ykcm                 = $vs;
	$vs_ykcm['get_comments'] = function ( $video_id, $post_id, $cData ) use ( &$vs_ykcm, $pid_suffix ) {
		
		$cData = wpvr_extend( $cData, array(
			'ch'        => curl_init(),
			'pageToken' => null,
			'wanted'    => 20,
			'count'     => 0,
			'recalls'   => 0,
			'do_import' => false,
			'comments'  => array(),
		) );
		
		//if( ! isset( $vs_ykcm ) ) return $cData;
		
		$youku = $vs_ykcm['api_auth']();
		if ( $youku === false ) {
			$cData['msg'] = 'Youku API not authorized.';
			
			return $cData;
		}
		
		$youku_api_url                        = 'https://openapi.youku.com/v2/comments/by_video.json';
		$youku_api_params                     = array();
		$youku_api_params[ $youku['method'] ] = $youku['value'];
		//$youku_api_params[ 'part' ]             = "snippet,id,replies";
		$youku_api_params['video_id'] = $video_id;
		//$youku_api_params[ 'maxResults' ]       = 200;
		if ( $cData['pageToken'] != null ) {
			$youku_api_params['page'] = $cData['pageToken'];
		}
		
		$api_response = wpvr_make_curl_request( $youku_api_url, $youku_api_params, $cData['ch'] );
		
		//d( $api_response );return false ;
		
		$data = wpvr_object_to_array( json_decode( $api_response['data'] ) );
		
		//d( $data );
		//return false;
		
		if (
			! isset( $data['comments'] )
			||
			! is_array( $data['comments'] )
			|| count( $data['comments'] ) == 0
		) {
			return $cData;
		}
		//_d( $cData );
		//return $cData ;
		foreach ( $data['comments'] as $item ) {
			if ( $cData['count'] >= $cData['wanted'] ) {
				return $cData;
			}
			
			$comment      = $item;
			$comment_date = date( 'Y-m-d H:i:s', strtotime( $comment['published'] ) );
			$cData['count'] ++;
			$comment = array(
				'comment_post_ID'      => $post_id,
				'comment_author'       => $comment['user']['name'],
				'comment_author_email' => '',
				'comment_author_url'   => $comment['user']['link'],
				'comment_content'      => $comment['content'],
				'comment_type'         => '',
				'comment_parent'       => 0,
				'comment_author_IP'    => '127.0.0.1',
				'comment_agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				'comment_date'         => $comment_date,
				'comment_approved'     => 1,
			);
			if ( $cData['do_import'] === true ) {
				$comment_id            = wp_insert_comment( $comment );
				$comment['comment_id'] = $comment_id;
				//_d( $comment_id );
			}
			$cData['comments'][] = $comment;
		}
		
		
		if (
			( $data['page'] * $data['count'] ) < $data['total']
			&& $cData['count'] <= $cData['wanted']
		) {
			$cData['recalls'] ++;
			$cData['pageToken'] = $data['page'] + 1;
			
			//d( $cData );
			return $vs_ykcm['get_comments']( $video_id, $post_id, $cData );
		}
		
		return $cData;
		
	};
	$vs['get_comments']      = $vs_ykcm['get_comments'];
	
	
	/* Getg Channel Id from Username */
	//return FALSE;
	$vs['get_user_id'] = function ( $q ) use ( $vs, $pid_suffix ) {
		
		global $wpvr_options, $wpvr_tokens;
		
		// Init API Connection
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			return array(
				'status' => false,
				'data'   => null,
				'msg'    => __( 'Youtube API is not authorized.', WPVR_LANG ),
			);
		}
		//_d( $api_handle );
		
		// DEfine API URL Endpoint
		$api_url = $vs['api_base'] . 'users/show_batch.json';
		
		// Define API ARGUMENTS
		$api_args = array(
			'user_names'          => $q,
			$api_handle['method'] => $api_handle['value'],
		);
		
		// GET API RESPONSE AND DECODE DATA
		$api_response = wpvr_make_curl_request( $api_url, $api_args );
		//$data         = json_decode( $api_response[ 'data' ] );
		
		//_d( $api_response );
		
		return false;
		
		//EXIT IF ERRORS FOUND
		if ( $api_response['status'] != 200 ) {
			return array(
				'status' => false,
				'data'   => null,
				'msg'    => __( 'Youku API is not reachable.', WPVR_LANG ),
			);
		}
		
		// EXIT IF NO DATA RETURNED
		if (
			! is_array( $json )
			|| ! isset( $json['total'] )
			|| $json['total'] == 0
		) {
			return array(
				'status' => false,
				'data'   => null,
				'msg'    => __( 'Could not find any user corresponding to the given username.', WPVR_LANG ),
			);
		}
		
		$results = array();
		foreach ( (array) $json['total'] as $item ) {
			$name      = preg_replace( '/(' . $q . ')/i', '<span class="wpvr_helper_highlight">' . "$1" . '</span>', $item->name );
			$results[] = array(
				'id'           => $item->id,
				'name'         => $name,
				'thumb'        => $item->avatar,
				'videos_count' => ( isset( $item->videos_count ) ? $item->video_count : 0 ),
			);
		}
		
		return array(
			'status' => true,
			'data'   => $results,
			'msg'    => '',
		);
		//return $data->items[ 0 ]->id;
	};

