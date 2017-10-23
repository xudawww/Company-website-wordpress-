<?php
/**
 * Display Social Links
 *
 * @since infinite-photography 1.1.0
 *
 * @param null
 * @return void
 *
 */

if ( !function_exists('infinite_photography_social_links') ) :

    function infinite_photography_social_links( ) {

        global $infinite_photography_customizer_all_values;
        ?>
        <div class="socials">
            <?php
            if ( !empty( $infinite_photography_customizer_all_values['infinite-photography-facebook-url'] ) ) { ?>
                <a href="<?php echo esc_url( $infinite_photography_customizer_all_values['infinite-photography-facebook-url'] ); ?>" class="facebook" data-title="<?php esc_attr_e('Facebook','infinite-photography');?>" target="_blank">
                    <span class="font-icon-social-facebook"><i class="fa fa-facebook"></i></span>
                </a>
            <?php }
            if ( !empty( $infinite_photography_customizer_all_values['infinite-photography-twitter-url'] ) ) { ?>
                <a href="<?php echo esc_url( $infinite_photography_customizer_all_values['infinite-photography-twitter-url'] ); ?>" class="twitter" data-title="<?php esc_attr_e('Twitter','infinite-photography');?>" target="_blank">
                    <span class="font-icon-social-twitter"><i class="fa fa-twitter"></i></span>
                </a>
            <?php }
            if ( !empty( $infinite_photography_customizer_all_values['infinite-photography-youtube-url'] ) ) { ?>
                <a href="<?php echo esc_url( $infinite_photography_customizer_all_values['infinite-photography-youtube-url'] ); ?>" class="youtube" data-title="<?php esc_attr_e('Youtube','infinite-photography');?>" target="_blank">
                    <span class="font-icon-social-youtube"><i class="fa fa-youtube"></i></span>
                </a>
            <?php }
            if ( !empty( $infinite_photography_customizer_all_values['infinite-photography-instagram-url'] ) ) { ?>
                <a href="<?php echo esc_url( $infinite_photography_customizer_all_values['infinite-photography-instagram-url'] ); ?>" class="instagram" data-title="<?php esc_attr_e('Instagram','infinite-photography');?>" target="_blank">
                    <span class="font-icon-social-instagram"><i class="fa fa-instagram"></i></span>
                </a>
            <?php }
            if ( !empty( $infinite_photography_customizer_all_values['infinite-photography-google-plus-url'] ) ) {
                ?>
                <a href="<?php echo esc_url( $infinite_photography_customizer_all_values['infinite-photography-google-plus-url'] ); ?>" class="google-plus" data-title="<?php esc_attr_e('Google Plus','infinite-photography');?>" target="_blank">
                    <span class="font-icon-social-google-plus"><i class="fa fa-google-plus"></i></span>
                </a>
                <?php
            }
            if ( !empty( $infinite_photography_customizer_all_values['infinite-photography-pinterest-url'] ) ) { ?>
                <a href="<?php echo esc_url( $infinite_photography_customizer_all_values['infinite-photography-pinterest-url'] ); ?>" class="pinterest" data-title="<?php esc_attr_e('Pinterest','infinite-photography');?>" target="_blank">
                    <span class="font-icon-social-pinterest"><i class="fa fa-pinterest"></i></span>
                </a>
            <?php }
            ?>
        </div>
        <?php
    }

endif;

add_action( 'infinite_photography_action_social_links', 'infinite_photography_social_links', 10 );