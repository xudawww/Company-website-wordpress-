<?php
/**
 * Featured Slider display function
 *
 * @since Infinite Photography  1.1.0
 *
 * @param null
 * @return void
 */

if ( ! function_exists( 'infinite_photography_display_feature_slider' ) ) :

    function infinite_photography_display_feature_slider( ){

        global $infinite_photography_customizer_all_values;
        $feature_image_style = '';
        if ( get_header_image() ) :
            $feature_image_style .= esc_url( get_header_image() );
        else:
            $feature_image_style .= esc_url( get_template_directory_uri()."/assets/img/banner-image.jpg" );
        endif; // End header image check.

        $infinite_photography_feature_text = $infinite_photography_customizer_all_values['infinite-photography-feature-text'];
        ?>
        <li>
            <img width="1600" height="650px" src="<?php echo esc_url( $feature_image_style ); ?>"/>
            <div class="slider-desc">
                <?php if(!empty( $infinite_photography_feature_text) ){
                    ?>
                    <div class="slider-title"><?php echo esc_html( $infinite_photography_feature_text );?></div>
                    <?php
                }
                ?>
            </div>
        </li>
        <?php
    }
endif;
/**
 * Display featured slider
 *
 * @since infinite-photography 1.0.0
 *
 * @param int $post_id
 * @return void
 *
 */
if ( !function_exists('infinite_photography_feature_slider') ) :
    function infinite_photography_feature_slider() {
        $inner_class ='';
        if( !is_front_page() ){
            ?>
            <div class="inner-header-image"></div>
            <?php
            return;
        }
        ?>
        <div class="slider-section <?php echo $inner_class;?>">
            <ul class="home-bxslider">
                <?php infinite_photography_display_feature_slider(); ?>
            </ul>
        </div>
        <?php
    }
endif;
add_action( 'infinite_photography_action_feature_slider', 'infinite_photography_feature_slider', 0 );