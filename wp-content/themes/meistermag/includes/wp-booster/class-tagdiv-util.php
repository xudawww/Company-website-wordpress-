<?php

/**
 * theme utility class/methods
 *
 * @since MeisterMag 1.0
 */
class Tagdiv_Util {

	/**
	 * @var null
	 * keep a local copy of all theme settings
	 */
	static $tagdiv_theme_options = NULL ;

	/**
	 * returns a string containing the numbers of words or chars for the content
	 *
	 * @param        $post_content    - the content that needs to be cut
	 * @param        $limit           - limit to cut
	 * @param string $type            - type of cut
	 * @param string $show_shortcodes - if shortcodes
	 *
	 * @return string
	 */
	static function tagdiv_excerpt( $post_content, $limit, $type = '', $post_id,  $show_shortcodes = '' ) {
		//remove shortcodes and tags
		if ( '' == $show_shortcodes ) {
			//delete all shortcode tags from the content.
			$post_content = strip_shortcodes( $post_content );
		}

		$post_content = stripslashes( wp_filter_nohtml_kses( $post_content ) );

		//excerpt for letters
		if ( 'letters' == $type ) {
			$ret_excerpt = mb_substr( $post_content, 0, $limit );
			if ( mb_strlen( $post_content ) >= $limit ) {
				$ret_excerpt = $ret_excerpt . ' &hellip; ';
			}

		//excerpt for words
		} else {
			$excerpt = explode( ' ', $post_content, $limit );

			if ( count( $excerpt ) >= $limit ) {
				array_pop( $excerpt );
				$excerpt = implode( " ", $excerpt ) . ' &hellip; ';
			} else {
				$excerpt = implode( " ", $excerpt );
			}

			$excerpt = esc_attr( strip_tags( $excerpt ) );

			if ( trim( $excerpt ) == ' &hellip; ' ) {
				return '';
			}

			$ret_excerpt = $excerpt;
			$ret_excerpt .= sprintf( '<a href="%1$s" class="tagdiv-more-link">%2$s</a>',
				esc_url( get_permalink( $post_id ) ),
				/* translators: %s: Name of current post */
				sprintf( __( 'Read More<span class="screen-reader-text"> "%s"</span>', 'meistermag' ), get_the_title( $post_id ) )
			);
		}

		return $ret_excerpt;
	}

	/**
	 * Shows a soft error. The site will run as usual if possible. If the user is logged in and has 'switch_themes'
	 * privileges this will also output the caller file path
	 * @param $file
	 * @param $message
	 * @param string $more_data
	 */
	static function tagdiv_wp_booster_error( $file, $message, $more_data = '' ) {

		$error = '';
		$error .= '<div class="tagdiv-booster-error">';
		$error .= __( 'theme wp booster error: ', 'meistermag' );
		$error .= $message;

		if ( is_user_logged_in() && current_user_can( 'switch_themes' ) ) {
			$error .= '<br>' . $file . '<br><br>';

			if ( ! empty( $more_data ) ) {
				$error .= '<br><br><pre>';
				$error .= __( 'more data: ', 'meistermag' ) . PHP_EOL;
				$error .= print_r( $more_data );
				$error .= '</pre>';
			}
		}

		$error .= '</div>';
		echo $error;
	}

	/**
	 * get one of tagdiv_theme_options
	 * @param $option_key - the key/name of the option to return
	 * @return string - the option value
	 */
	static function tagdiv_get_theme_options( $option_key ) {
		if ( is_null( self::$tagdiv_theme_options ) ) {
			self::$tagdiv_theme_options = wp_parse_args( get_theme_mod( TAGDIV_THEME_OPTIONS_NAME ), self::tagdiv_get_theme_options_defaults() );
		}

		if ( !empty( self::$tagdiv_theme_options[$option_key] ) ) {
			return self::$tagdiv_theme_options[$option_key];
		}
		return '';
	}

	/**
	 * theme's default settings
	 * @return mixed|void
	 */
	static function tagdiv_get_theme_options_defaults() {
		$defaults = array(
			'tagdiv_footer_logo' 				=> '',
			'tagdiv_subfooter_copyright_symbol' => 1,
			'tagdiv_block_1_title' 				=> __( 'MUST READ', 'meistermag' ),
			'tagdiv_block_2_title' 				=> __( 'HOT ARTICLES', 'meistermag' ),
			'tagdiv_block_3_title' 				=> __( 'DON\'T MISS', 'meistermag' ),
			'tagdiv_block_4_title' 				=> __( 'FEATURED', 'meistermag' ),
			'tagdiv_block_5_title' 				=> __( 'FEATURED NEWS', 'meistermag' ),
			'tagdiv_block_6_title' 				=> __( 'HOT RIGHT NOW', 'meistermag' ),
			'tagdiv_latest_section_title' 		=> __( 'Latest Articles', 'meistermag' ),
			'tagdiv_subfooter_copyright' 		=> sprintf( __( '%s MeisterMag Theme - Free <a href="http://wordpress.org">WordPress</a> Theme made with <i class="tagdiv-icon-heart"></i> by <b>WPion</b>.', 'meistermag' ), date('Y') ),
			'tagdiv_accent_color' 				=> '',
			'tagdiv_text_logo_color' 			=> ''
		);

		return apply_filters( 'tagdiv_get_theme_options_defaults', $defaults );
	}

} //end class Tagdiv_Util
