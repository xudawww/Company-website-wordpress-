<?php
/**
 * AppPresser Theme functions and definitions
 *
 * @package Ion
 * @since   0.0.1
 */

define( 'APPP_ION_PATH', get_template_directory().'/' );
define( 'APPP_ION_URL', get_template_directory_uri().'/' );
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Include theme setup file. Loads the childtheme class if it exists.
 * @since  0.0.1
 * @return string  Path to setup file
 */
function appp_ion_theme_setup_path() {
	// Include 'AppPresser_3_Theme_Setup' class file
	// Will only load if the 'AppPresser_3_Theme_Setup' class
	// hasn't been added in a child-theme
	return APPP_ION_PATH . 'inc/classes/AppPresser_3_Theme_Setup.php';
}
require_once( appp_ion_theme_setup_path() );

/**
 * Requires 'AppPresser_3_Theme_Setup' class to be loaded in app_theme_setup_path()
 */
class AppPresser_Ion_AP3_Functions extends AppPresser_3_Theme_Setup {

	// A single instance of this class.
	protected static $instance = null;
	public $App_Functionality;
	public $Extra_Functionality;
	public $Customizer;
	public $Tags;

	/**
	 * Creates or returns an instance of this class.
	 * @since  0.0.1
	 * @return AppPresser_Ion_AP3_Functions A single instance of this class.
	 */
	public static function run() {
		if ( self::$instance === null )
			self::$instance = new self();

		return self::$instance;
	}

	/**
	 * Setup our plugin
	 * @since 0.0.1
	 */
	protected function __construct() {
		// Autoload classes
		spl_autoload_register( array( $this, 'autoload_classes' ) );
		// Run classes
		$this->run_classes();
		if ( class_exists( 'AppPresser_Admin_Settings' ) )
			require_once( APPP_ION_PATH .'appp-settings.php' );

		// setup our theme
		$this->run_hooks( array( array( 'after_setup_theme', 'after_setup_theme' ) ) );
	}

	/**
	 * Adds our extra functionality classes
	 * @since  0.0.1
	 */
	protected function run_classes() {
		// Load custom app functionality.
		$this->App_Functionality = new AppPresser_AP3_Functionality();
		$this->run_hooks( 'App_Functionality' );

		// Custom functions that act independently of the theme templates.
		$this->Extra_Functionality = new AppPresser_AP3_Extra_Functionality();
		$this->run_hooks( 'Extra_Functionality' );

		// Customizer additions.
		// require_once( dirname( __FILE__ ) . '/classes/AppPresser_Customizer.php' );
		// $this->Customizer = new AP3_Customizer();
		// $this->run_hooks( 'Customizer' );

		// Get colors from My AppPresser
		require_once( dirname( __FILE__ ) . '/classes/AppPresser_MyAppp.php' );

		// Custom template tags
		$this->Tags = new AppPresser_AP3_Tags();
		$this->run_hooks( 'Tags' );

		$this->Extension_Compatibility = new AppPresser_AP3_Extension_Compatibility();
		$this->run_hooks( 'Extension_Compatibility' );

		require_once( dirname( __FILE__ ) . '/classes/AppPresser_Query.php' );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	public function after_setup_theme() {

		// remove this line to show admin bar
		show_admin_bar( false );

		// Gets rid of woo no theme support message
		add_theme_support( 'woocommerce' );
		// Our theme check condition.
		add_theme_support( 'apppresser' );
		// Add custom editor styles
		add_editor_style( 'editor-style.css' );
		// Set the content width based on the theme's design and stylesheet.
		if ( ! isset( $content_width ) )
			$content_width = 1024; /* pixels */

		$this->run_hooks( array(
			array( 'wp_enqueue_scripts', 'scripts_styles' ),
			array( 'wp_page_menu', 'add_menuclass' ),
		) );

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 */
		load_theme_textdomain( 'ap3-ion-theme', APPP_ION_PATH . 'languages' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'logo', 500, 100 ); // Header logo. Works cause it's in the customizer

		// Custom image sizes won't do anything if theme is inactive

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary-menu' => __( 'Primary Menu', 'ap3-ion-theme' ),
			'footer-menu' => __('Footer Menu', 'ap3-ion-theme' )
		) );

		$this->run_hooks( array(
			// Hook in page title or appp logo
			array( 'appp_page_title', 'do_page_title' ),
			// Add body classes
			array( 'body_class', 'bodyclasses' ),
		) );

	}

	/**
	 * Adds customizer logo or page title to the nav bar
	 * @since  0.0.1
	 */
	public function do_page_title() {

		// If we have a logo, show that
		if ( $logo = appp_has_logo() ) {
			$blog_title = esc_attr( get_bloginfo( 'name', 'display' ) );

			// Try to get attachment ID from logo url
			if( $id = AppPresser_Tags::image_id_from_url( $logo ) ) {
				// If we have an ID, get a smaller image
				$logo = wp_get_attachment_image( $id, 'logo', false, array( 'id' => 'site-logo' ) );
			} else {
				// Otherwise, use the original
				$logo = '<img src="'. esc_url( $logo ) .'" alt="'. $blog_title .'" id="site-logo">';
			}

			?>
		 	<a href="<?php echo home_url(); ?>" class="site-logo-link" title="<?php echo $blog_title; ?>" rel="home"><?php echo $logo; ?></a>
		 	<?php
		} else {

			?>
			<h1 class="title site-title">
			<?php

			// if we have woocommerce installed and a page title, show that.
			if ( function_exists( 'is_woocommerce' ) && is_woocommerce() && ! is_product() ) {
				woocommerce_page_title();
				add_filter( 'woocommerce_show_page_title', '__return_false' );
			} else if ( function_exists( 'is_buddypress' ) && is_buddypress() ) {
				the_title();
				add_filter( 'bp_page_title', '__return_false' );
			} else {
				appp_get_title();
			}

			?>
			</h1>
			<?php

		}

	}

	/**
	 * Add body class if there is a footer menu saved
	 * @since  0.0.1
	 * @param  array  $classes Body classes
	 * @return array           Ammended body classes
	 */
	public function bodyclasses($classes) {
		
		$classes[] = 'ion-ap3';

		// Only add the class if the footer menu is present
		if ( has_nav_menu( 'footer-menu' ) )
			$classes[] = 'has-footer-menu';
		// Add a class if user NOT logged in
		if ( ! is_user_logged_in() )
			$classes[] = 'not-logged-in';
		return $classes;
	}

	/**
	 * Enqueue scripts and styles
	 * @since  0.0.1
	 */
	public function scripts_styles() {

		$isloggedin = is_user_logged_in();
		if( $isloggedin ) {
			$user = wp_get_current_user();
		}

		// Only use minified files if SCRIPT_DEBUG is off
		$min = $use_concatenated = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		// Main stylesheet
		wp_enqueue_style( 'ap3-ion-style', get_stylesheet_directory_uri() . "/style$min.css", null, self::VERSION );

		// Fixes 300ms touch click delay
		wp_enqueue_script( 'fastclick', APPP_ION_URL .'js/fastclick.js', array( 'jquery' ) );

		wp_enqueue_script( 'app-ios-keyboard-helper', APPP_ION_URL ."js/app-ios-keyboard-helper$min.js", array('jquery'), '2.1', true );

		wp_enqueue_script( 'appp-js', APPP_ION_URL ."js/custom$min.js", array( 'jquery' ), self::VERSION, true );
		wp_enqueue_script( 'appp-modal', APPP_ION_URL ."js/apppmodal.js", array('jquery'), self::VERSION, true );

		wp_localize_script( 'appp-js', 'l10n', array(
			'back' => __( 'Back', 'ap3-ion-theme' ),
			'offline' => __( 'You appear to be offline, please try again when you are online.', 'ap3-ion-theme' )
		) );

		wp_localize_script( 'appp-js', 'appp', array(
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'debug'    => defined( 'WP_DEBUG' ) && WP_DEBUG || defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG,
			'home_url' => home_url(),
			'i18n_required_comment_text' => esc_attr__( 'Please enter comment text.', 'ap3-ion-theme' ),
			'nonce' => wp_create_nonce( 'app-load-more-nonce' ),
			'loggedin' => $isloggedin,
			'avatar_url' => ( $isloggedin ? get_avatar_url( $user->ID ) : '' ),
			'loggedin_message' => ( $isloggedin ? __( 'Welcome back ', 'ap3-ion-theme' ) . $user->display_name : '' ),
			'post_title' => get_the_title(),
			'post_url' => get_the_permalink()
		) );

		//wp_enqueue_script( 'appp-skip-link-focus-fix', APPP_ION_URL .'js/skip-link-focus-fix.js', array(), '20130115', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
	 * @since 0.0.1
	 * @param string  $ulclass html markup
	 *
	 * @return string updated html markup
	 */
	public function add_menuclass($ulclass) {
		return preg_replace('/<ul>/', '<ul class="menu">', $ulclass, 1);
	}

	/**
	 * Autoloads class files when needed
	 * @since  0.0.1
	 * @param  string $class_name Name of the class being requested
	 */
	protected function autoload_classes( $class_name ) {
		if ( class_exists( $class_name, false ) )
			return;

		$file = APPP_ION_PATH .'inc/classes/'. $class_name .'.php';
		if ( file_exists( $file ) )
			require_once( $file );
	}

	/**
	 * Takes an array of hooks and loops through, adding them
	 * @since  1.0.1
	 * @param  object $object_name The object with a hooks method (or an array of hooks for $this)
	 * @param  array   $hooks  Array of hooks
	 *
	 * @return mixed           False if no hooks, otherwise void
	 */
	public function run_hooks( $object_name, $hooks = array() ) {

		$prefix = '';
		// If first parameter is an array, then we're dealing with this Class
		if ( empty( $hooks ) && is_array( $object_name ) ) {
			$hooks       = $object_name;
			$object_name = false;
			$object      = $this;
			$prefix      = 'this';
		}

		// Check if object has a hooks method, and get the hooks that way
		if ( empty( $hooks ) && is_callable( array( $this->$object_name, 'hooks' ) ) ) {
			$object = $this->$object_name;
			$hooks = $object->hooks();
		}

		// No hooks, then bail
		if ( empty( $hooks ) )
			return false;

		// Loop through the hooks and hook them in
		foreach ( (array) $hooks as $hook ) {
			if ( ! isset( $hook[0], $hook[1] ) )
				continue;
			// add_filter can be used since add_action is just a wrapper
			add_filter(
				$hook[0],
				array( $object, $hook[1] ),
				isset( $hook[2] ) ? $hook[2] : 10,
				isset( $hook[3] ) ? $hook[3] : 1
			);
			// Store all hooks to be easly unhooked
			$this->hooks[ $prefix . $hook[0] . $hook[1] ] = $object_name;
		}
	}

	/**
	 * Helper to remove hooks
	 * @since  1.0.1
	 * @param  string  $tag                The tag to hook into
	 * @param  string  $function_to_remove Function/Method name to unhook
	 * @param  integer $priority           Hook Priority
	 *
	 * @return bool Whether or not the filter was removed.
	 */
	public function remove_hook( $tag, $function_to_remove, $priority = 10 ) {
		// Check if hook/function combo is stored to our hooks array
		if ( isset( $this->hooks[ $tag . $function_to_remove ] ) ) {
			return remove_filter( $tag, array( $this->{ $this->hooks[ $tag . $function_to_remove ] }, $function_to_remove ), $priority );
		}
		if ( isset( $this->hooks[ 'this' . $tag . $function_to_remove ] ) ) {
			return remove_filter( $tag, array( $this, $function_to_remove ), $priority );
		}

	}

}
AppPresser_Ion_AP3_Functions::run();

/**
 * Helper function to remove AppPresser hooks
 * @since  1.0.1
 * @param  string  $tag                The tag to hook into
 * @param  string  $function_to_remove Function/Method name to unhook
 * @param  integer $priority           Hook Priority
 *
 * @return void
 */
function appp_remove_hook( $tag, $function_to_remove, $priority = 10 ) {
	return AppPresser_Ion_AP3_Functions::run()->remove_hook( $tag, $function_to_remove, $priority );
}
