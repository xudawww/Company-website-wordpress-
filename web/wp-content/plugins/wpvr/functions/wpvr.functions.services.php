<?php

	/* Prepare wpvr_imported and wpvr_deferred ids */
	if( ! function_exists( 'wpvr_prepare_tables_for_video_services' ) ) {
		function wpvr_prepare_tables_for_video_services( $wpvr_imported , $wpvr_deferred_ids , $wpvr_unwanted_ids ) {
			global $wpvr_vs;
			$tables = array();
			foreach ( (array) $wpvr_vs as $vs ) {
				if( ! isset( $wpvr_imported[ $vs[ 'id' ] ] ) ) $wpvr_imported[ $vs[ 'id' ] ] = array();
				if( ! isset( $wpvr_deferred_ids[ $vs[ 'id' ] ] ) ) $wpvr_deferred_ids[ $vs[ 'id' ] ] = array();
				if( ! isset( $wpvr_unwanted_ids[ $vs[ 'id' ] ] ) ) $wpvr_unwanted_ids[ $vs[ 'id' ] ] = array();
				//if( ! isset( $async_deuplicates[ $vs[ 'id' ] ] ) ) $async_deuplicates[ $vs[ 'id' ] ] = array();
				$tables[ $vs[ 'id' ] ] = array(
					'wpvr_imported'     => $wpvr_imported[ $vs[ 'id' ] ] ,
					'wpvr_deferred_ids' => $wpvr_deferred_ids[ $vs[ 'id' ] ] ,
					'wpvr_unwanted_ids' => $wpvr_unwanted_ids[ $vs[ 'id' ] ] ,
					//'async_deuplicates' => $async_deuplicates[ $vs[ 'id' ] ] ,
					'merged'            => $wpvr_imported[ $vs[ 'id' ] ] +
					                       $wpvr_deferred_ids[ $vs[ 'id' ] ] +
					                       $wpvr_unwanted_ids[ $vs[ 'id' ] ]
					,
				);
			}
			// d( $tables );
			return $tables;
		}
	}

	/* Prepare sOptions to be fetched */
	if( ! function_exists( 'wpvr_prepare_sOptions_fields' ) ) {
		function wpvr_prepare_sOptions_fields( $sOptions , $source , $default = FALSE ) {
			global $wpvr_vs;
			$output = '';
			foreach ( (array) $wpvr_vs as $vs ) {
				if( count( $vs[ 'types' ] ) > 0 ) {
					foreach ( (array) $vs[ 'types' ] as $vs_type ) {
						if( isset( $vs_type[ 'fields' ] ) && count( $vs_type[ 'fields' ] ) > 0 ) {
							foreach ( (array) $vs_type[ 'fields' ] as $vs_type_field ) {
								//$output .= "GROUP_CONCAT( if(M.meta_key = 'wpvr_source_".$vs_type_field['id']."' , M.meta_value , NULL ) SEPARATOR '' ) as ".$vs_type_field['id'].", \n";
								$field_id = $vs_type_field[ 'id' ];
								if( $default === TRUE ) $sOptions[ 'what' ][ $field_id ] = '';
								else $sOptions[ 'what' ][ $field_id ] = $source->$field_id;

							}
						}
					}
				}
			}

			return $sOptions;
		}
	}

	/* Prepare SQL Join Statements to include video services fields */
	if( ! function_exists( 'wpvr_render_video_services_sql_join_string' ) ) {
		function wpvr_render_video_services_sql_join_string() {
			global $wpvr_vs;
			$output = '';
			foreach ( (array) $wpvr_vs as $vs ) {
				if( count( $vs[ 'types' ] ) > 0 ) {
					foreach ( (array) $vs[ 'types' ] as $vs_type ) {
						if( isset( $vs_type[ 'fields' ] ) && count( $vs_type[ 'fields' ] ) > 0 ) {
							foreach ( (array) $vs_type[ 'fields' ] as $vs_type_field ) {
								$output .= "GROUP_CONCAT( if(M.meta_key = 'wpvr_source_" . $vs_type_field[ 'id' ] . "' , M.meta_value , NULL ) SEPARATOR '' ) as " . $vs_type_field[ 'id' ] . ", \n";
							}
						}
					}
				}
			}

			//echo nl2br( $output );
			return $output;
		}
	}

	/* Prepare SQL Join Statements to include video services fields */
	if( ! function_exists( 'wpvr_prepare_source_stats_sql' ) ) {
		function wpvr_prepare_source_stats_sql() {
			global $wpvr_vs;
			$types_group = array();
			$lines       = array();
			$output      = '';
			foreach ( (array) $wpvr_vs as $vs ) {

				$lines[]
					= "
				COUNT( distinct if(
					M.meta_key = 'wpvr_source_service' AND M.meta_value = '" . $vs[ 'id' ] . "' , P.ID , NULL
				)) as " . $vs[ 'id' ] . " ";

				if( count( $vs[ 'types' ] ) > 0 ) {
					foreach ( (array) $vs[ 'types' ] as $vs_type ) {
						if( ! isset( $types_group[ $vs_type[ 'global_id' ] ] ) ) $types_group[ $vs_type[ 'global_id' ] ] = array();
						$types_group[ $vs_type[ 'global_id' ] ][] = " M.meta_value = '" . $vs_type[ 'id' ] . "' ";
					}
				}
			}
			foreach ( (array) $types_group as $gid => $types ) {
				$lines[]
					= "
				COUNT( distinct if(
					M.meta_key = 'wpvr_source_type' AND (

						" . implode( " \n OR " , $types ) . "
					), P.ID , NULL
				)) as " . $gid . "
			";
			}
			
			if( count( $lines ) != 0 ) return implode( ' , ' , $lines ) . ',';
			else return '';
		}
	}
