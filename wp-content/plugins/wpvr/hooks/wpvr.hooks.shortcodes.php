<?php
	
	/* Add WP Video Robot shortcode for embeding videos on post */
	add_shortcode( 'wpvr', 'wpvr_embed_shortcode' );
	function wpvr_embed_shortcode( $atts ) {
		$wpvr_video_id      = get_post_meta( $atts['id'], 'wpvr_video_id', true );
		$wpvr_video_service = get_post_meta( $atts['id'], 'wpvr_video_service', true );
		$player             = wpvr_video_embed(
			$wpvr_video_id,
			$atts['id'],
			false,
			$wpvr_video_service
		);
		$embedCode          = '<div class="wpvr_embed">' . $player . '</div>';
		//new dBug( $wpvr_video_id);
		$views = get_post_meta( $atts['id'], 'wpvr_video_views', true );
		update_post_meta( $atts['id'], 'wpvr_video_views', $views + 1 );
		wpvr_update_dynamic_video_views( $atts['id'], $views + 1 );
		$embedCode = apply_filters( 'wpvr_replace_player_code', $embedCode, $atts['id'] );
		
		return $embedCode;
	}
	
	/* Add WP Video Robot shortcode for embeding videos on post */
	add_shortcode( 'wpvr_views', 'wpvr_views_shortcode' );
	function wpvr_views_shortcode( $atts ) {
		$wpvr_video_views = get_post_meta( $atts['id'], 'wpvr_video_views', true );
		
		return $wpvr_video_views;
	}
	
	add_filter( 'wpvr_generate_count_string', 'wpvr_define_counter_shortcodes_string_generation', 100, 3 );
	function wpvr_define_counter_shortcodes_string_generation( $count = 0, $label = null, $count_only = false ) {
		
		if ( $count_only ) {
			return $count;
		}
		
		if ( $label == null ) {
			return __( 'Total videos' ) . ' : ' . $count;
		}
		
		if ( $count == 0 ) {
			$output = $label . ' : ' . __( 'No video', WPVR_LANG ) . '.';
		} elseif ( $count == 1 ) {
			$output = $label . ' : ' . __( 'One video', WPVR_LANG ) . '.';
		} else {
			$output = $label . ' : ' . $count . ' ' . __( 'videos', WPVR_LANG ) . '.';
		}
		
		//d( $output );
		
		return $output;
	}
	
	add_shortcode( 'wpvr_count', 'wpvr_define_count_shortcode_definition' );
	function wpvr_define_count_shortcode_definition( $atts ) {
		global $wpvr_vs, $wpvr_status;
		
		$atts = shortcode_atts( array(
			'nolabel'  => false,
			'service'  => 'all',
			'status'   => 'all',
			'category' => 'all',
		), $atts, 'wpvr_count' );
		
		
		$count_only = isset( $atts['nolabel'] ) && $atts['nolabel'] == 1 ? true : false ;
		
		$stats = wpvr_videos_stats();
		
		//d( $stats );
		// Filtering by service
		if ( isset( $atts['service'] ) && isset( $wpvr_vs[ $atts['service'] ] ) ) {
			return apply_filters(
				'wpvr_generate_count_string',
				$stats['byService']['items'][ $atts['service'] ],
				$wpvr_vs[ $atts['service'] ]['label'],
				$count_only
			);
		}
		
		// Filtering by status
		if ( isset( $atts['status'] ) && isset( $wpvr_status[ $atts['status'] ] ) ) {
			return apply_filters(
				'wpvr_generate_count_string',
				$stats['byStatus']['items'][ $atts['status'] ],
				$wpvr_status[ $atts['status'] ]['label'],
				$count_only
			);
		}
		
		// Filtering by category
		if ( isset( $atts['category'] ) && isset( $stats['byCat']['items'][ $atts['category'] ] ) ) {
			$category = get_category_by_slug( $atts['category'] );
			
			return apply_filters(
				'wpvr_generate_count_string',
				$stats['byCat']['items'][ $atts['category'] ],
				$category->name,
				$count_only
			);
		}
		
		if ( $stats != false && isset( $stats['byStatus']['total'] ) ) {
			return apply_filters(
				'wpvr_generate_count_string',
				$stats['byStatus']['total'],
				null,
				$count_only
			);
		}
	}