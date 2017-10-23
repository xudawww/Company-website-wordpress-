<?php
/*It is underscores functions.php file and its modification*/
if ( ! function_exists( 'infinite_photography_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function infinite_photography_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
        load_theme_textdomain( 'infinite-photography', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Re -added
         *
         *  @since Infinite  1.1.1
        */
        add_theme_support( 'custom-logo', array(
            'height'      => 70,
            'width'       => 290,
            'flex-height' => true,
        ) );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 500, 300, true );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Menu', 'infinite-photography' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'gallery',
            'caption',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'infinite_photography_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );

	    /*woocommerce support*/
	    add_theme_support( 'woocommerce' );
    }
endif; // infinite_photography_setup
add_action( 'after_setup_theme', 'infinite_photography_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function infinite_photography_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'infinite_photography_content_width', 640 );
}
add_action( 'after_setup_theme', 'infinite_photography_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function infinite_photography_scripts() {
    /*bxslider css*/
    wp_enqueue_style( 'bxslider', get_template_directory_uri() . '/assets/library/bxslider/css/jquery.bxslider.min.css', array(), '4.2.5' );

    /*google font*/
    wp_enqueue_style( 'infinite-photography-googleapis', '//fonts.googleapis.com/css?family=Roboto:400,500,700|Open+Sans:400,600,700', array(), '1.0.1' );

    /*Font-Awesome-master*/
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/library/Font-Awesome/css/font-awesome.min.css', array(), '4.5.0' );

    /*Font-Awesome-master*/
    wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/library/magnific-popup/magnific-popup.css', array(), '1.1.0' );

    /*custom-css*/
    wp_enqueue_style( 'infinite-photography-style', get_stylesheet_uri() );

    /*jquery start*/
    /*html5shiv*/
    wp_enqueue_script('html5shiv', get_template_directory_uri() . '/assets/library/html5shiv/html5shiv.min.js', array('jquery'), '3.7.3', false);
    wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

    /*respond js*/
    wp_enqueue_script('respond', get_template_directory_uri() . '/assets/library/respond/respond.min.js', array('jquery'), '1.1.2', false);
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

    /*bxslider js*/
    wp_enqueue_script('bxslider', get_template_directory_uri() . '/assets/library/bxslider/js/jquery.bxslider.min.js', array('jquery'), '4.2.5', 1);

    /*masonry js*/
    wp_enqueue_script( 'masonry' );

    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/library/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', 1);

    /*custom-js*/
    wp_enqueue_script('infinite-photography-custom', get_template_directory_uri() . '/assets/js/infinite-photography-custom.js', array('jquery'), '1.0.1', 1);


    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'infinite_photography_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function infinite_photography_admin_scripts( $hook ) {

	$screen = get_current_screen();

	if ( 'widgets.php' == $hook || $screen->parent_base == 'edit') {
        wp_enqueue_media();
        wp_enqueue_script( 'infinite-photography-widgets-script', get_template_directory_uri() . '/assets/js/widget.js', array( 'jquery' ), '1.0.0' );
    }

}
add_action( 'admin_enqueue_scripts', 'infinite_photography_admin_scripts' );

/**
 * Custom template tags for this theme.
 */
$infinite_photography_template_tags_file_path = infinite_photography_file_directory('acmethemes/core/template-tags.php');
require $infinite_photography_template_tags_file_path;

/**
 * Custom functions that act independently of the theme templates.
 */
$infinite_photography_extras_file_path = infinite_photography_file_directory('acmethemes/core/extras.php');
require $infinite_photography_extras_file_path;


/**
 * Custom Header file.
 */
$infinite_photography_custom_header_file_path = infinite_photography_file_directory('acmethemes/core/custom-header.php');
require $infinite_photography_custom_header_file_path;