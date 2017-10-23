<?php
/**
 * Content and content wrapper end
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_after_content' ) ) :

    function infinite_photography_after_content() {
      ?>
        </div><!-- #content -->
        </div><!-- content-wrapper-->
    <?php
    }
endif;
add_action( 'infinite_photography_action_after_content', 'infinite_photography_after_content', 10 );

/**
 * Footer content
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_footer' ) ) :

    function infinite_photography_footer() {

        global $infinite_photography_customizer_all_values;
        ?>
        <div class="clearfix"></div>
        <footer id="colophon" class="site-footer" role="contentinfo">
            <div class="footer-wrapper">
                <?php
                $infinit_photography_enable_social = $infinite_photography_customizer_all_values['infinite-photography-enable-social'];
                if( 1 == $infinit_photography_enable_social ){
	                do_action('infinite_photography_action_social_links');
                }
                ?>
                <div class="footer-copyright border text-center">
                    <?php if( isset( $infinite_photography_customizer_all_values['infinite-photography-footer-copyright'] ) ): ?>
                        <p><?php echo wp_kses_post( $infinite_photography_customizer_all_values['infinite-photography-footer-copyright'] ); ?></p>
                    <?php endif; ?>
                    <div class="site-info">
                    <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'infinite-photography' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'infinite-photography' ), 'WordPress' ); ?></a>
                    <span class="sep"> | </span>
                    <?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'infinite-photography' ), 'Infinite Photography ', '<a href="http://www.acmethemes.com/" rel="designer">Acme Themes</a>' ); ?>
                    </div><!-- .site-info -->
                </div>
            </div><!-- footer-wrapper-->
        </footer><!-- #colophon -->
    <?php
    }
endif;
add_action( 'infinite_photography_action_footer', 'infinite_photography_footer', 10 );

/**
 * Page end
 *
 * @since infinite-photography 1.1.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_page_end' ) ) :

    function infinite_photography_page_end() {
        ?>
        </div><!-- #page -->
    <?php
    }
endif;
add_action( 'infinite_photography_action_after', 'infinite_photography_page_end', 10 );