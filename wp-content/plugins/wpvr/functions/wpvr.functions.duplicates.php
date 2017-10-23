<?php

	if( ! function_exists( 'wpvr_create_n_video_duplicates' ) ) {
		function wpvr_create_n_video_duplicates( $post_ids , $number = 3 ) {
			$dups_ids = array();
			foreach ( (array) $post_ids as $post_id ) {
				$dups_ids[ $post_id ] = array();
				for ( $i = 1; $i <= $number; $i ++ ) {
					$dups_ids[ $post_id ][] = wpvr_duplicate_video( $post_id , ' copy-' . $i );
					//echo "<br/> Duplicate $post_id , $i ";
				}
			}

			return $dups_ids;
		}
	}

	if( ! function_exists( 'wpvr_duplicate_video' ) ) {
		function wpvr_duplicate_video( $post_id , $suffix = '' ) {
			global $wpdb;
			$post            = get_post( $post_id );
			$current_user    = wp_get_current_user();
			$new_post_author = $current_user->ID;
			if( get_post_meta( $post_id , 'wpvr_video_views' , TRUE ) == '' ) {
				update_post_meta( $post_id , 'wpvr_video_views' , 0 );
			}
			if( ! isset( $post ) || $post == null ) {
				wp_die( 'Post creation failed, could not find original post: ' . $post_id );
			}
			$new_post_id = wp_insert_post( array(
				'comment_status' => $post->comment_status ,
				'ping_status'    => $post->ping_status ,
				'post_author'    => $new_post_author ,
				'post_content'   => $post->post_content ,
				'post_excerpt'   => $post->post_excerpt ,
				'post_name'      => $post->post_name ,
				'post_parent'    => $post->post_parent ,
				'post_password'  => $post->post_password ,
				'post_status'    => 'publish' ,
				'post_title'     => $post->post_title . $suffix ,
				'post_type'      => $post->post_type ,
				'to_ping'        => $post->to_ping ,
				'menu_order'     => $post->menu_order ,
			) );
			$taxonomies  = get_object_taxonomies( $post->post_type ); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ( (array) $taxonomies as $taxonomy ) {
				$post_terms = wp_get_object_terms( $post_id , $taxonomy , array( 'fields' => 'slugs' ) );
				wp_set_object_terms( $new_post_id , $post_terms , $taxonomy , FALSE );
			}
			$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
			if( count( $post_meta_infos ) != 0 ) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ( (array) $post_meta_infos as $meta_info ) {
					$meta_key   = $meta_info->meta_key;
					$meta_value = addslashes( $meta_info->meta_value );
					if( $meta_key == 'wpvr_video_views' ) {
						$meta_value = mt_rand( 100 , 60000 );
					}

					$sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query .= implode( " UNION ALL " , $sql_query_sel );
				$wpdb->query( $sql_query );
			}

			//update_post_meta( $new_post_id , 'wpvr_source_count_run' , 0 );
			//update_post_meta( $new_post_id , 'wpvr_source_count_test' , 0 );
			//update_post_meta( $new_post_id , 'wpvr_source_count_imported' , 0 );
			return $new_post_id;
		}
	}


	// Retreive an attachment files paths from thumb_id
	if( ! function_exists( 'wpvr_get_thumbnail_file_paths' ) ) {
		function wpvr_get_thumbnail_file_paths( $thumb_id ) {
			$files      = array();
			$upload_dir = wp_upload_dir();
			$thumb_meta = wp_get_attachment_metadata( $thumb_id );
			if( ! $thumb_meta ) return $files;
			$sizes = get_intermediate_image_sizes();

			$files[ 'full' ] = $upload_dir[ 'basedir' ] . "/" . $thumb_meta[ 'file' ];
			foreach ( (array) $sizes as $size ) {
				if( ! isset( $thumb_meta[ 'sizes' ][ $size ] ) ) {
					$files[ $size ] = FALSE;
				} else {
					$files[ $size ] = $upload_dir[ 'basedir' ] . '/' . $thumb_meta[ 'sizes' ][ $size ][ 'file' ];
				}
			}

			return $files;
		}
	}

	// Get Duplicates
	if( ! function_exists( 'wpvr_get_duplicate_videos' ) ) {
		function wpvr_get_duplicate_videos( $post_ids = array() , $limit = FALSE , $debug = FALSE, $only_sql = FALSE ) {
			global $wpdb;
			//_d( $post_ids );
			$post_ids_conditions = array();
			if( count( $post_ids ) != 0 ) {
				foreach ( (array) $post_ids as $post_id ) {
					$post_ids_conditions[] = " FIND_IN_SET( '$post_id' , post_ids ) != 0 ";
				}
				$post_ids_condition = " AND ( " . implode( ' OR ' , $post_ids_conditions ) . " )";
			} else {
				$post_ids_condition = "";
			}


			$sql
				= "
			SELECT 
				GROUP_CONCAT( DISTINCT P.ID SEPARATOR ',' ) as post_ids,
				GROUP_CONCAT( DISTINCT P.ID SEPARATOR ',' ) as post_ids,
				MIN( DISTINCT P.ID ) as master_id,
				GROUP_CONCAT(DISTINCT if(PMM.meta_key = '_thumbnail_id' , CONCAT( PMM.meta_value, '-' , PM.post_id ), NULL ) SEPARATOR ',') as thumb_ids,
				PM.meta_value as video_id,
				SUM(DISTINCT if(PMM.meta_key = 'wpvr_video_views' , PMM.meta_value , 0 )) as total_views,
				COUNT(DISTINCT P.ID)-1 as count,
				
				
				
				
				SUBSTRING_INDEX( GROUP_CONCAT( P.post_title order by P.ID asc ) , ',', 1) as post_title,
				SUBSTRING_INDEX( GROUP_CONCAT( P.post_title order by P.ID asc ) , ',', 1) as title , 
				SUBSTRING_INDEX( GROUP_CONCAT( P.post_date order by P.ID asc ) , ',', 1) as post_date ,
				 
				GROUP_CONCAT( DISTINCT if(PMM.meta_key = 'wpvr_video_service' , PMM.meta_value , NULL ) SEPARATOR '') as service,
				GROUP_CONCAT(DISTINCT if(PMM.meta_key = 'wpvr_video_id' , PMM.meta_value , NULL ) SEPARATOR '') as id,
				COUNT(DISTINCT P.ID) as cc,		
				COUNT(DISTINCT P.ID) as dupCount,
				SUM(DISTINCT if(PMM.meta_key = 'wpvr_video_views' , PMM.meta_value , 0 )) as views,
				GROUP_CONCAT( DISTINCT P.ID SEPARATOR ',' ) as ids,
				'' as duration,
				'publish' as status,
				'' as description,
				'' as post_id
				
				
			FROM 
				$wpdb->postmeta PM
				LEFT JOIN $wpdb->posts P on PM.post_id = P.ID
				LEFT JOIN $wpdb->postmeta PMM on PMM.post_id = P.ID
			WHERE 
				PM.meta_key = 'wpvr_video_id' 
				
			GROUP BY 
				PM.meta_value
			HAVING 
				dupCount > 1
				$post_ids_condition
			";

			if( $only_sql ) return $sql ;


			//d($sql );

			if( $limit != FALSE ) {
				$sql .= "LIMIT 0, $limit";
			}

			$entries = $wpdb->get_results( $sql , OBJECT );
			//_d( $entries );
			if( $debug ) d( $wpdb->last_error );

			return ( $entries );
		}
	}

	// Prepare Duplicates Cleaner
	if( ! function_exists( 'wpvr_prepare_duplicate_videos' ) ) {
		function wpvr_prepare_duplicate_videos( $dups , $get_files = FALSE ) {
			global $wpdb;
			$queries = array(
				'count' => array(
					'videos'     => 0 ,
					'duplicates' => 0 ,
				) ,
				'views' => array() ,
				'files' => array() ,
				'ids'   => array(
					'thumbs' => array() ,
					'posts'  => array() ,
				) ,
			);
			
			foreach ( (array) $dups as $dup ) {
				$queries[ 'count' ][ 'videos' ] ++;
				$queries[ 'count' ][ 'duplicates' ] = $queries[ 'count' ][ 'duplicates' ] + $dup->count;
				$post_ids                           = explode( ',' , $dup->post_ids );
				$thumb_ids                          = explode( ',' , $dup->thumb_ids );
				//$master_id       = min( $post_ids );
				$master_id       = $dup->master_id;
				$master_thumb_id = get_post_meta( $master_id , '_thumbnail_id' , TRUE );

				foreach ( (array) $post_ids as $id ) {
					if( $id != $master_id ) {
						$queries[ 'ids' ][ 'posts' ][] = $id;
					}
				}

				foreach ( (array) $thumb_ids as $id ) {
					$x = explode( '-' , $id );
					if( ! isset( $x[ 1 ] ) ) continue;
					$dup_thumb_id = $x[ 0 ];
					$dup_post_id  = $x[ 1 ];
					if( $master_thumb_id == $dup_thumb_id ) continue;
					//d( $dup_post_id . ' : ' . $master_id );
					if( $get_files ) {

						if( $dup_post_id != $master_id && ! in_array( $dup_thumb_id , $queries[ 'ids' ][ 'thumbs' ] ) ) {
							$queries[ 'ids' ][ 'thumbs' ][] = $dup_thumb_id;

							$queries[ 'files' ][] = wpvr_get_thumbnail_file_paths( $dup_thumb_id );
						}
					}
				}
				
				//" . implode( "','" , $posts_to_delete ) . "

				$queries[ 'views' ][] = "UPDATE $wpdb->postmeta SET meta_value = $dup->total_views WHERE meta_key = 'wpvr_video_views' AND post_id = '$master_id' ";

			}
			if( count( $queries[ 'ids' ][ 'posts' ] ) != 0 ) {
				$post_ids = implode( "','" , $queries[ 'ids' ][ 'posts' ] );

				$queries[ 'sql' ][ 'meta' ]  = str_replace( '%s' , $post_ids ,
					"DELETE FROM $wpdb->postmeta WHERE post_id IN ('%s')"
				);
				$queries[ 'sql' ][ 'terms' ] = str_replace( '%s' , $post_ids ,
					"DELETE FROM $wpdb->term_relationships WHERE object_id IN ('%s')"
				);
				$queries[ 'sql' ][ 'posts' ] = str_replace( '%s' , $post_ids ,
					"DELETE FROM $wpdb->posts WHERE post_type = '" . WPVR_VIDEO_TYPE . "' AND ID IN ('%s')"
				);
			}

			if( count( $queries[ 'ids' ][ 'thumbs' ] ) != 0 ) {
				$queries[ 'sql' ][ 'thumbs' ] = str_replace(
					'%s' ,
					implode( "','" , $queries[ 'ids' ][ 'thumbs' ] ) ,
					"DELETE FROM $wpdb->posts WHERE post_type = 'attachment' AND ID IN ('%s')"
				);
			}

			return $queries;
		}
	}
	
	// Process Duplicates Cleaner
	if( ! function_exists( 'wpvr_process_duplicate_videos' ) ) {
		function wpvr_process_duplicate_videos( $cleaner , $delete_files = FALSE ) {
			global $wpdb;
			$done  = array(
				'sql'       => array() ,
				'files'     => array() ,
				'count'     => $cleaner[ 'count' ] ,
				'exec_time' => 0 ,
			);
			$timer = wpvr_chrono_time();

			foreach ( (array) $cleaner[ 'views' ] as $query ) {
				$done[ 'views' ][] = $wpdb->query( $query );
			}

			foreach ( (array) $cleaner[ 'sql' ] as $query ) {
				$done[ 'sql' ][] = $wpdb->query( $query );
			}
			
			if( $delete_files ) {
				foreach ( (array) $cleaner[ 'files' ] as $files ) {
					foreach ( (array) $files as $file ) {
						if( $file != FALSE ) {
							$done[ 'files' ][] = @unlink( $file );
						}
					}
				}
			}
			$done[ 'exec_time' ] = wpvr_chrono_time( $timer , 3 );
			
			return $done;
		}
	}