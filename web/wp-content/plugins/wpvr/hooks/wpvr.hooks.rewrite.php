<?php
	
	/* Function to redirect download request to permalink structure */
	add_action( 'template_include' , 'wpvr_download_export_file' );
	function wpvr_download_export_file( $template ) {
		$ext = 'json';
		$tab = explode( '/wpvr_export/' , $_SERVER[ 'REQUEST_URI' ] );
		
		
		if( $tab[ 0 ] == '' ) {
			$xtab = explode( '_@_' , $tab[ 1 ] );
			//d( $xtab );return false;
			if( ! isset( $xtab[ 1 ] ) || $xtab[ 1 ] == '' ) {
				
				$a = explode( '*' , $xtab[ 0 ] );
				
				if( isset( $a[ 1 ] ) ) {
					$type            = '';
					$file_name       = $tab[ 1 ];
					$export_filename = $a[ 0 ] . '.' . $a[ 1 ];
				} elseif( strpos( $tab[ 1 ] , 'sysinfo' ) != - 1 ) {
					$type            = "";
					$file_name       = $tab[ 1 ];
					$export_filename = "wpvr_system_info.txt";
				} else {
					//All types
					$type            = "";
					$file_name       = $tab[ 1 ];
					$export_filename = "wpvr_export." . $ext;
				}
			} else {
				if( $xtab[ 1 ] == 'options' ) {
					//options
					$type = "options";
				} elseif( $xtab[ 1 ] == 'sources' ) {
					//sources
					$type = "sources";
				} elseif( $xtab[ 1 ] == 'videos' ) {
					//Videos
					$type = "videos";
				} elseif( $xtab[ 1 ] == 'sysinfo' ) {
					//Videos
					$type = "system_info";
					$ext  = "txt";
				}
				$file_name       = $xtab[ 0 ];
				$export_filename = "wpvr_export_" . $type . "." . $ext;
			}
			
			
			$file = WPVR_TMP_PATH . '' . $tab[ 1 ];
			header( "Content-type: application/x-msdownload" , TRUE , 200 );
			header( "Content-Disposition: attachment; filename=" . $export_filename );
			header( "Pragma: no-cache" );
			header( "Expires: 0" );
			readfile( $file );
			exit();
		} else {
			return $template;
		}
	}
	
	/* Remove Video Post Type slug from permalink */
	add_filter( 'post_type_link' , 'wpvr_remove_video_slug' , 10 , 3 );
	function wpvr_remove_video_slug( $post_link , $post , $leavename ) {
		global $wpvr_options;
		
		if( WPVR_VIDEO_TYPE != $post->post_type || 'publish' != $post->post_status ) {
			return $post_link;
		}
		
		global $wp , $wp_query ;
		
		
		if( $wpvr_options[ 'enableRewriteRule' ] === TRUE ) {
			$post_link = wpvr_render_video_permalink( $post , "/%postname%/" );
			// d( $post_link );
			if( $wpvr_options[ 'permalinkBase' ] === 'none' ) {
				
				$base = '';
				
			} elseif( $wpvr_options[ 'permalinkBase' ] === 'category' ) {
				
				$terms = wp_get_object_terms( $post->ID , 'category' );
				if( ! is_wp_error( $terms ) && ! empty( $terms ) && is_object( $terms[ 0 ] ) ) {
					$taxonomy_slug = $terms[ 0 ]->slug;
				} else {
					$taxonomy_slug = WPVR_UNCATEGORIZED;
				}
				
				if( $taxonomy_slug == '' ) {
					$base = '';
				} else {
					$base = '/' . $taxonomy_slug . '';
				}
				
			} elseif( $wpvr_options[ 'permalinkBase' ] === 'custom' ) {
				
				if( $wpvr_options[ 'customPermalinkBase' ] == '' ) {
					$base = '';
				} else {
					$base = '/' . $wpvr_options[ 'customPermalinkBase' ] . '';
				}
				
			}
			
			$permalink = str_replace( WPVR_SITE_URL , WPVR_SITE_URL . $base , $post_link );
			// d( $permalink );
			return $permalink;
		} else {
			
			return wpvr_render_video_permalink( $post );
		}
	}

	add_action( 'init' , 'wpvr_add_cron_endpoint' );
	function wpvr_add_cron_endpoint() {
		add_rewrite_tag( '%wpvr_cron%' , '([^&]+)' );
		add_rewrite_rule( WPVR_CRON_ENDPOINT . '/([^&]+)/?' , 'index.php?wpvr_cron=$matches[1]' , 'top' );
		flush_rewrite_rules();
	}


	add_action( 'template_redirect' , 'wpvr_process_cron_call' , 1000 );
	function wpvr_process_cron_call() {
		global $wp_query , $cron_data_file;
		$token = $wp_query->get( 'wpvr_cron' );
		if( ! $token ) return;
		//$_GET['debug'] = true ;
		$_GET[ 'token' ] = $token;
		//d( $_GET );
		
		if( ! is_multisite() ) {
			$cron_data_file = WPVR_PATH . "assets/php/cron.txt";
		} else {
			$site_id        = get_current_blog_id();
			$cron_data_file = WPVR_PATH  . "assets/php/cron_" . $site_id . ".txt";
		}
		include( WPVR_PATH . 'wpvr.cron.php' );
		exit;
	}
	