<?php
/**
 * tagDiv WordPress booster
 *
 * @since MeisterMag 1.0
 */

// theme utility files
require get_template_directory() . '/includes/wp-booster/class-tagdiv-global.php';
require get_template_directory() . '/includes/wp-booster/class-tagdiv-util.php';
require get_template_directory() . '/includes/wp-booster/class-tagdiv-preview-demo.php';

// load the wp-booster_api
require get_template_directory() . '/includes/wp-booster/class-tagdiv-api-base.php';
require get_template_directory() . '/includes/wp-booster/class-tagdiv-api-block.php';
require get_template_directory() . '/includes/wp-booster/class-tagdiv-api-module.php';
require get_template_directory() . '/includes/wp-booster/class-tagdiv-api-thumb.php';
require get_template_directory() . '/includes/wp-booster/class-tagdiv-api-css-generator.php';
require get_template_directory() . '/includes/wp-booster/class-tagdiv-api-autoload.php';

// hook here to use the theme api
do_action( 'tagdiv_global_after' );

require get_template_directory() . '/includes/wp-booster/class-tagdiv-global-blocks.php'; // no autoload
require get_template_directory() . '/includes/wp-booster/class-tagdiv-menu.php'; 		// theme menu support
require get_template_directory() . '/includes/wp-booster/class-tagdiv-module.php'; 		// module builder
require get_template_directory() . '/includes/wp-booster/class-tagdiv-block.php'; 		// block builder

require get_template_directory() . '/includes/wp-booster/class-tagdiv-autoload-classes.php'; //used to autoload classes

// every class after this is autoloaded only when it's required
Tagdiv_API_Autoload::add('Tagdiv_Css_Compiler', get_template_directory() . '/includes/wp-booster/class-tagdiv-css-compiler.php');
Tagdiv_API_Autoload::add('Tagdiv_Block_Layout', get_template_directory() . '/includes/wp-booster/class-tagdiv-block-layout.php');
Tagdiv_API_Autoload::add('Tagdiv_Template_Layout', get_template_directory() . '/includes/wp-booster/class-tagdiv-template-layout.php');
Tagdiv_API_Autoload::add('Tagdiv_Data_Source', get_template_directory() . '/includes/wp-booster/class-tagdiv-data-source.php');

/* ----------------------------------------------------------------------------
 * Add theme support for features
 */

if ( ! function_exists( 'tagdiv_setup' ) ) {
	function tagdiv_setup() {

		/**
		 * Localization
		 * Make theme available for translation.
		 */
		// If a child theme is active
		if ( is_child_theme() ) {
			load_child_theme_textdomain( 'meistermag', get_stylesheet_directory() . '/languages' );
		} else {
			load_theme_textdomain( 'meistermag', get_template_directory() . '/languages' );
		}

		/**
		 * Enable support for Post Formats.
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'status',
			'audio',
			'chat',
		) );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 90,
			'width'       => 272,
			'flex-width' => true,
		) );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'gallery',
			'caption'
		) );

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
}
add_action('after_setup_theme', 'tagdiv_setup');

/* ----------------------------------------------------------------------------
 * Set content width global
 */

if ( ! function_exists( 'tagdiv_content_width' ) ) {
	/**
	 * Sets the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 *
	 * @since MeisterMag 1.0
	 */
	function tagdiv_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'tagdiv_content_width', 640 );
	}
}
add_action( 'after_setup_theme', 'tagdiv_content_width', 0 );

/* ----------------------------------------------------------------------------
 * Registers theme widget areas
 */

if ( ! function_exists( 'tagdiv_widgets_init' ) ) {
	/**
	 * Registers the theme sidebar and the footer widget areas.
	 *
	 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
	 *
	 * @since MeisterMag 1.0
	 */
	function tagdiv_widgets_init() {

		// Default sidebar
		register_sidebar( array(
			'name'          => __( 'Theme Default Sidebar', 'meistermag' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'meistermag' ),
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="tagdiv-block-title"><span>',
			'after_title'   => '</span></div>'
		) );

		// Footer sections
		register_sidebar( array(
			'name'          => __( 'Footer 1', 'meistermag' ),
			'id'            => 'tagdiv-footer-1',
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="tagdiv-block-title"><span>',
			'after_title'   => '</span></div>'
		) );

		register_sidebar( array(
			'name'          => __( 'Footer 2', 'meistermag' ),
			'id'            => 'tagdiv-footer-2',
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="tagdiv-block-title"><span>',
			'after_title'   => '</span></div>'
		) );

		register_sidebar( array(
			'name'          => __( 'Footer 3', 'meistermag' ),
			'id'            => 'tagdiv-footer-3',
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="tagdiv-block-title"><span>',
			'after_title'   => '</span></div>'
		) );

	}
}
add_action( 'widgets_init', 'tagdiv_widgets_init' );

/* ----------------------------------------------------------------------------
 * Theme fonts & scripts
 */

if ( ! function_exists( 'tagdiv_fonts' ) ) {
	/**
	 * Register Google fonts.
	 *
	 * @since MeisterMag 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function tagdiv_fonts() {
		$fonts_url = '';
		$fonts = array();
		$subsets = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Work Sans font, translate this to 'off'. Do not translate into your own language. */
		if ('off' !== _x( 'on', 'Work Sans font: on or off', 'meistermag' ) ) {
			$fonts[] = 'Work Sans:400,500,600,700';
		}

		/* translators: If there are characters in your language that are not supported by Source Sans Pro font, translate this to 'off'. Do not translate into your own language. */
		if ('off' !== _x( 'on', 'Source Sans Pro font: on or off', 'meistermag' ) ) {
			$fonts[] = 'Source Sans Pro:400,400italic,600,600italic,700';
		}


        /* translators: If there are characters in your language that are not supported by Source Sans Pro font, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x( 'on', 'Roboto font: on or off', 'meistermag' ) ) {
            $fonts[] = 'Roboto:400,500';
        }






		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css');
		}

		return $fonts_url;
	}
}

if ( ! function_exists( 'tagdiv_scripts' ) ) {
	/**
	 * Enqueues scripts and styles.
	 *
	 * @since MeisterMag 1.0
	 */
	function tagdiv_scripts() {
		// Add custom fonts, used in the main stylesheet.
		wp_enqueue_style( 'tagdiv-fonts', tagdiv_fonts(), array(), null );

		// If a child theme is active
		if ( is_child_theme() ) {
			// Theme main stylesheet
			wp_enqueue_style( 'tagdiv-style', get_template_directory_uri() . '/style.css', array(), TAGDIV_THEME_VERSION );

			// Theme child style
			wp_enqueue_style( 'tagdiv-child-style', get_stylesheet_uri(), array( 'tagdiv-style' ), TAGDIV_THEME_VERSION );
		} else {
			// Theme stylesheet.
			wp_enqueue_style( 'tagdiv-style', get_stylesheet_uri(), array(), TAGDIV_THEME_VERSION );
		}

		// Load the html5shiv.
		wp_enqueue_script( 'html5', get_template_directory_uri() . '/includes/js_files/html5shiv.js', array(), '3.7.3' );
		wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

		// Load 'Supersubs' plugin menu support
		wp_enqueue_script( 'supersubs', get_template_directory_uri() . '/includes/js_files/supersubs.js', array( 'jquery' ), '0.3b', true );

		// Load comments reply support if needed
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Load the theme detect script
		wp_enqueue_script( 'tagdiv-detect-script', get_template_directory_uri() . '/includes/js_files/tagdiv-detect-script.js', array( 'jquery' ), TAGDIV_THEME_VERSION, true );

		// Load theme menu support
		wp_enqueue_script( 'tagdiv-menu-script', get_template_directory_uri() . '/includes/js_files/tagdiv-menu-script.js', array( 'jquery' ), TAGDIV_THEME_VERSION, true );
		// Pass screen reader support data as tagdivScreenReaderText global
		wp_localize_script( 'tagdiv-menu-script', 'tagdivScreenReaderText', array(
			'expand'   => __( 'expand child menu', 'meistermag' ),
			'collapse' => __( 'collapse child menu', 'meistermag' ),
			'submenu'  => __( 'menu item with sub-menu', 'meistermag' ),
		) );

		// Load the theme mobile menu handler
		wp_enqueue_script( 'tagdiv-mobile-menu-handler-script', get_template_directory_uri() . '/includes/js_files/tagdiv-mobile-menu-handler.js', array( 'jquery' ), TAGDIV_THEME_VERSION, true );

		// Load theme main menu search support
		wp_enqueue_script( 'tagdiv-search-script', get_template_directory_uri() . '/includes/js_files/tagdiv-search-script.js', array( 'jquery' ), TAGDIV_THEME_VERSION, true );

	}
}
add_action( 'wp_enqueue_scripts', 'tagdiv_scripts' );

/* ----------------------------------------------------------------------------
 * Theme add span wrap for category number in widget
 */

if ( ! function_exists( 'tagdiv_category_count_span' ) ) {
	/**
	 * add count span to wp categories list
	 * @param $links
	 * @return mixed
	 */
	function tagdiv_category_count_span( $links ) {
		$links = str_replace( '</a> (', '<span class="tagdiv-widget-no">', $links );
		$links = str_replace( ')', '</span></a>', $links );

		return $links;
	}
}
add_filter( 'wp_list_categories', 'tagdiv_category_count_span' );

/* ----------------------------------------------------------------------------
 * Disable the gallery style css
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/* ----------------------------------------------------------------------------
 * Theme excerpt length
 */

if ( ! function_exists( 'tagdiv_custom_excerpt_length' ) ) {
	/**
	 * Filter the except length to 20 characters.
	 * Returns default on admin side
	 *
	 * @return int - modified excerpt length.
	 */
	function tagdiv_custom_excerpt_length( $length ) {
		return is_admin() ? $length : 20;
	}
}
add_filter( 'excerpt_length', 'tagdiv_custom_excerpt_length', 999 );

/* ----------------------------------------------------------------------------
 * Theme safe fail for for when the post title is left empty
 */

if ( ! function_exists( 'tagdiv_no_title' ) ) {
	/**
	 * Filer the post title when it is left empty
	 *
	 * @param $title
	 * @return string
	 */
	function tagdiv_no_title( $title ) {
		if ( $title == '' ) {
			return __( 'Untitled', 'meistermag' );
		} else {
			return $title;
		}
	}
}
add_filter('the_title', 'tagdiv_no_title');

/* ----------------------------------------------------------------------------
 * Excerpts read more
 */

if ( ! function_exists( 'tagdiv_excerpt_more' ) && ! is_admin() ) {
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
	 * a 'Read More' link.
	 *
	 * @since 1.0.0
	 * @return string 'Read More' link prepended with an ellipsis.
	 */
	function tagdiv_excerpt_more()
	{
		$link = sprintf( '<a href="%1$s" class="tagdiv-more-link">%2$s</a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( __( 'Read More<span class="screen-reader-text"> "%s"</span>', 'meistermag' ), get_the_title( get_the_ID() ) )
		);
		return ' &hellip; ' . $link;
	}
}

add_filter( 'excerpt_more', 'tagdiv_excerpt_more' );

/* ----------------------------------------------------------------------------
 * tagdiv wp booster init
 */

if ( ! function_exists( 'tagdiv_init_booster' ) ) {
	/**
	 * register the them thumbs and adds theme blocks
	 */
	function tagdiv_init_booster() {

		/*
         * add_image_size for WordPress - register all the thumbs from the thumblist
         */
		foreach ( Tagdiv_API_Thumb::get_all() as $thumb_array ) {
			add_image_size( $thumb_array['name'], $thumb_array['width'], $thumb_array['height'], $thumb_array['crop'] );
		}


		/*
         * Add the registered blocks
         */
		foreach ( Tagdiv_API_Block::get_all() as $block_settings_key => $block_settings_value ) {
			Tagdiv_Global_Blocks::add_block_id( $block_settings_key );
		}

	}
}
tagdiv_init_booster();

/* ----------------------------------------------------------------------------
 * Customizer: Sanitization Callbacks
 */

if ( ! function_exists( 'tagdiv_sanitize_checkbox' ) ) {
	/**
	 * Checkbox sanitization callback
	 *
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function tagdiv_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

if ( ! function_exists( 'tagdiv_sanitize_email' ) ) {
	/**
	 * Email sanitization callback
	 *
	 * - Sanitization: email
	 * - Control: text
	 *
	 * Sanitization callback for 'email' type text controls. This callback sanitizes `$email`
	 * as a valid email address.
	 *
	 * @see sanitize_email() https://developer.wordpress.org/reference/functions/sanitize_key/
	 * @link sanitize_email() https://codex.wordpress.org/Function_Reference/sanitize_email
	 *
	 * @param string               $email   Email address to sanitize.
	 * @param WP_Customize_Setting $setting Setting instance.
	 * @return string The sanitized email if not null; otherwise, the setting default.
	 */
	function tagdiv_sanitize_email(  $email, $setting  ) {
		$email = sanitize_email( $email );

		// If $email is a valid email, return it; otherwise, return the default.
		return ( ! is_null( $email ) ? $email : $setting->default );
	}
}

if ( ! function_exists( 'tagdiv_sanitize_image' ) ) {
	/**
	 * Image sanitization callback
	 *
	 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
	 * send back the filename, otherwise, return the setting default.
	 *
	 * - Sanitization: image file extension
	 * - Control: text, WP_Customize_Image_Control
	 *
	 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
	 *
	 * @param string               $image   Image filename.
	 * @param WP_Customize_Setting $setting Setting instance.
	 * @return string The image filename if the extension is allowed; otherwise, the setting default.
	 */
	function tagdiv_sanitize_image( $image, $setting ) {

		/*
         * Array of valid image file types.
         *
         * The array includes image mime types that are included in wp_get_mime_types()
         */
		$mimes = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
			'bmp'          => 'image/bmp',
			'tif|tiff'     => 'image/tiff',
			'ico'          => 'image/x-icon'
		);

		// Return an array with file extension and mime_type.
		$file = wp_check_filetype( $image, $mimes );

		// If $image has a valid mime_type, return it; otherwise, return the default.
		return ( $file['ext'] ? $image : $setting->default );
	}
}

if ( ! function_exists( 'tagdiv_get_sample_image' ) ) {
	/**
	 * Returns a random sample image placeholder
	 *
	 * @since MeisterMag 1.1.1
	 * @return mixed
	 */
	function tagdiv_get_sample_image() {
		$tagdiv_sample_image = esc_url( get_template_directory_uri() . '/images/sample/' . Tagdiv_Global::$tagdiv_demo_image . '.jpg' );

		if ( Tagdiv_Global::$tagdiv_demo_image === 6 ) {
			Tagdiv_Global::$tagdiv_demo_image = 1;
		} else {
			Tagdiv_Global::$tagdiv_demo_image++;
		}

		return $tagdiv_sample_image;
	}
}

if ( ! function_exists( 'tagdiv_theme_colors_css' ) ) {
	/**
	 * Display custom theme accent color css.
	 *
	 * @since MeisterMag 1.2
	 */
	function tagdiv_theme_colors_css() {

		$tagdiv_theme_css = '<style type="text/css">' . PHP_EOL;
		$tagdiv_theme_css .= tagdiv_css_generator() . PHP_EOL;
		$tagdiv_theme_css .= '</style>' . PHP_EOL;

		echo $tagdiv_theme_css;
	}
	add_action( 'wp_head', 'tagdiv_theme_colors_css' );
}






