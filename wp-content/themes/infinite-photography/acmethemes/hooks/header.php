<?php
/**
 * Setting global variables for all theme options db saved values
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_set_global' ) ) :

    function infinite_photography_set_global() {
        /*Getting saved values start*/
        $infinite_photography_saved_theme_options = infinite_photography_get_theme_options();
        $GLOBALS['infinite_photography_customizer_all_values'] = $infinite_photography_saved_theme_options;
        /*Getting saved values end*/
    }
endif;
add_action( 'infinite_photography_action_before_head', 'infinite_photography_set_global', 0 );

/**
 * Doctype Declaration
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_doctype' ) ) :
    function infinite_photography_doctype() {
        ?>
        <!DOCTYPE html><html <?php language_attributes(); ?>>
    <?php
    }
endif;
add_action( 'infinite_photography_action_before_head', 'infinite_photography_doctype', 10 );

/**
 * Code inside head tage but before wp_head funtion
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_before_wp_head' ) ) :

    function infinite_photography_before_wp_head() {
        ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="<?php echo esc_url('http://gmpg.org/xfn/11')?>">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
    }
endif;
add_action( 'infinite_photography_action_before_wp_head', 'infinite_photography_before_wp_head', 10 );

/**
 * Add body class
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_body_class' ) ) :

    function infinite_photography_body_class( $infinite_photography_classes ) {
        global $infinite_photography_customizer_all_values;
        if ( 'photography' == $infinite_photography_customizer_all_values['infinite-photography-blog-archive-layout'] ) {
            $infinite_photography_classes[] = 'blog-photography';
        }
        $infinite_photography_classes[] = infinite_photography_sidebar_selection();

        return $infinite_photography_classes;

    }
endif;
add_action( 'body_class', 'infinite_photography_body_class', 10, 1);

/**
 * Page start
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_page_start' ) ) :

    function infinite_photography_page_start() {
        ?>
        <div id="page" class="hfeed site">
<?php
    }
endif;
add_action( 'infinite_photography_action_before', 'infinite_photography_page_start', 15 );

/**
 * Skip to content
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_skip_to_content' ) ) :

    function infinite_photography_skip_to_content() {
        ?>
        <a class="skip-link screen-reader-text" href="#content" title="link"><?php esc_html_e( 'Skip to content', 'infinite-photography' ); ?></a>
    <?php
    }

endif;
add_action( 'infinite_photography_action_before_header', 'infinite_photography_skip_to_content', 10 );

/**
 * Main header
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_header' ) ) :

    function infinite_photography_header() {
        global $infinite_photography_customizer_all_values;
	    $infinite_photography_customizer_all_values['infinite-photography-header-id-display-opt'];
	    $infinite_photography_show_search = $infinite_photography_customizer_all_values['infinite-photography-show-search']
        ?>
        <header id="masthead" class="site-header" role="banner">
            <div class="wrapper header-wrapper clearfix">
                <div class="header-container">
                    <div class="site-branding clearfix">
                        <div class="site-logo acme-col-3">
                            <?php if ( 'disable' != $infinite_photography_customizer_all_values['infinite-photography-header-id-display-opt'] ):?>
                            <?php
                            if ( 'logo-only' == $infinite_photography_customizer_all_values['infinite-photography-header-id-display-opt'] ):

                                if ( function_exists( 'the_custom_logo' ) ) :
                                    the_custom_logo();
                                else :
                                    if( !empty( $infinite_photography_customizer_all_values['infinite-photography-header-logo'] ) ):
                                        $infinite_photography_header_alt = get_bloginfo('name');
                                        ?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                            <img src="<?php echo esc_url( $infinite_photography_customizer_all_values['infinite-photography-header-logo'] ); ?>" alt="<?php echo esc_attr( $infinite_photography_header_alt ); ?>">
                                        </a>
                                        <?php
                                    endif;/*infinite-photography-header-logo*/
                                endif;
                            else:/*else is title-only or title-and-tagline*/
                                if ( is_front_page() && is_home() ) : ?>
                                    <h1 class="site-title">
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                                    </h1>
                                <?php else : ?>
                                    <p class="site-title">
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                                    </p>
                                <?php endif;
                                if ( 'title-and-tagline' == $infinite_photography_customizer_all_values['infinite-photography-header-id-display-opt'] ):
                                    $description = get_bloginfo( 'description', 'display' );
                                    if ( $description || is_customize_preview() ) : ?>
                                        <p class="site-description"><?php echo esc_html( $description ); ?></p>
                                    <?php endif;
                                endif;
                            endif; ?>
                            <?php endif;?><!--infinite-photography-header-id-display-opt-->
                        </div><!--site-logo-->
                        <nav id="site-navigation" class="main-navigation clearfix" role="navigation">
                            <div class="header-main-menu clearfix">
                                <?php
                                if( has_nav_menu( 'primary' ) ){
                                    ?>
                                    <?php wp_nav_menu(array('theme_location' => 'primary','container' => 'div', 'container_class' => 'infinite-nav')); ?>
                                    <?php
                                }
                                if( 1 == $infinite_photography_show_search ){
                                    echo '<i class="fa fa-search icon-menu search-icon-menu"></i>';
                                }
                                ?>

                            </div>
                            <!--slick menu container-->
                            <div class="responsive-slick-menu clearfix"></div>
                        </nav>
                    </div>

                    <!-- #site-navigation -->
                </div>
                <!-- .header-container -->
            </div>
            <!-- header-wrapper-->
        </header><!-- #masthead -->
        <?php
	    if( 1 == $infinite_photography_show_search ){
		    ?>
            <div class="search-slider">
			    <?php get_search_form()?>
            </div>
            <?php
	    }
    }
endif;
add_action( 'infinite_photography_action_header', 'infinite_photography_header', 10 );

/**
 * Before main content
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return void
 *
 */
if ( ! function_exists( 'infinite_photography_before_content' ) ) :

    function infinite_photography_before_content() {

        global $infinite_photography_customizer_all_values;
        $infinite_photography_enable_feature = $infinite_photography_customizer_all_values['infinite-photography-enable-feature'];
        if ( 1 == $infinite_photography_enable_feature ) {
            echo '<div class="slider-feature-wrap clearfix">';
            /**
             * Slide
             * infinite_photography_action_feature_slider
             * @since infinite-photography 1.1.0
             *
             * @hooked infinite_photography_feature_slider -  0
             */
            do_action('infinite_photography_action_feature_slider');
            echo "</div>";
            $infinite_photography_content_id = "home-content";
        } else {
            $infinite_photography_content_id = "content";
        }
        ?>
        <div class="wrapper content-wrapper clearfix">
    <div id="<?php echo esc_attr( $infinite_photography_content_id ); ?>" class="site-content">
    <?php
        if( 1 == $infinite_photography_customizer_all_values['infinite-photography-show-breadcrumb'] && !is_front_page() ){
            infinite_photography_breadcrumbs();
        }
    }
endif;
add_action( 'infinite_photography_action_after_header', 'infinite_photography_before_content', 10 );
