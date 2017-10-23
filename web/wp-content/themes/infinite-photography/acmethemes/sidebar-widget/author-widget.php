<?php
/**
 * Custom author
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */
if ( ! class_exists( 'Infinite_photography_author_widget' ) ) :
    /**
     * Class for adding author widget
     * A new way to add author
     * @package Acme Themes
     * @subpackage Infinite Photography
     * @since 1.1.0
     */
    class Infinite_photography_author_widget extends WP_Widget {
        /*defaults values for fields*/
        private $defaults = array(
            'infinite_photography_author_title' => '',
            'infinite_photography_author_image' => '',
            'infinite_photography_author_link'  => '',
            'infinite_photography_author_new_window' => 1,
            'infinite_photography_author_short_disc'  => '',
        );
        function __construct() {
            parent::__construct(
            /*Base ID of your widget*/
                'infinite_photography_author',
                /*Widget name will appear in UI*/
                __('Author', 'infinite-photography'),
                /*Widget description*/
                array( 'description' => __( 'Add author with different options.', 'infinite-photography' ), )
            );
        }

        /*Widget Backend*/
        public function form( $instance ) {
            /*merging arrays*/
            $instance = wp_parse_args( (array) $instance, $this->defaults);
            $infinite_photography_author_title  = esc_attr( $instance['infinite_photography_author_title'] );
            $infinite_photography_author_image  = esc_url( $instance['infinite_photography_author_image'] );
            $infinite_photography_author_link   = esc_url( $instance['infinite_photography_author_link'] );
            $infinite_photography_author_new_window = esc_attr( $instance['infinite_photography_author_new_window'] );
            $infinite_photography_author_short_disc = esc_textarea( $instance['infinite_photography_author_short_disc'] );
            ?>
            <p class="description">
                <?php
                _e('Note: Use square image. Recommended image size : 250 x 250', 'infinite-photography' );
                ?>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'infinite_photography_author_title' ); ?>"><?php _e( 'Title:', 'infinite-photography' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'infinite_photography_author_title' ); ?>" name="<?php echo $this->get_field_name( 'infinite_photography_author_title' ); ?>" type="text" value="<?php echo esc_attr( $infinite_photography_author_title ); ?>" />
            </p>
            <h4><?php _e( 'Author Image', 'infinite-photography' ); ?></h4>
            <p>
                <label for="<?php echo $this->get_field_id('infinite_photography_author_image'); ?>">
                    <?php _e( 'Select Author Image', 'infinite-photography' ); ?>
                </label>
                <?php
                $infinite_photography_display_none = '';
                if ( empty( $infinite_photography_author_image ) ){
                    $infinite_photography_display_none = ' style="display:none;" ';
                }
                ?>
                <span class="img-preview-wrap" <?php echo esc_attr( $infinite_photography_display_none ); ?>>
                    <img class="widefat" src="<?php echo esc_url( $infinite_photography_author_image ); ?>" alt="<?php _e( 'Image preview', 'infinite-photography' ); ?>"  />
                </span><!-- .ad-preview-wrap -->
                <input type="text" class="widefat" name="<?php echo $this->get_field_name('infinite_photography_author_image'); ?>" id="<?php echo $this->get_field_id('infinite_photography_author_image'); ?>" value="<?php echo esc_url( $infinite_photography_author_image ); ?>" />
                <input type="button" value="<?php _e( 'Upload Image', 'infinite-photography' ); ?>" class="button media-image-upload" data-title="<?php _e( 'Select Author Image','infinite-photography'); ?>" data-button="<?php _e( 'Select Author Image','infinite-photography'); ?>"/>
                <input type="button" value="<?php _e( 'Remove Image', 'infinite-photography' ); ?>" class="button media-image-remove" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'infinite_photography_author_short_disc' ); ?>"><?php _e( 'Author Short Disc:', 'infinite-photography' ); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id( 'infinite_photography_author_short_disc' ); ?>" name="<?php echo $this->get_field_name( 'infinite_photography_author_short_disc' ); ?>"><?php echo esc_attr( $infinite_photography_author_short_disc ); ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'infinite_photography_author_link' ); ?>"><?php _e( 'Link URL:', 'infinite-photography' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'infinite_photography_author_link' ); ?>" name="<?php echo $this->get_field_name( 'infinite_photography_author_link' ); ?>" type="text" value="<?php echo esc_attr( $infinite_photography_author_link ); ?>" />
            </p>
            <p>
                <input id="<?php echo $this->get_field_id( 'infinite_photography_author_new_window' ); ?>" name="<?php echo $this->get_field_name( 'infinite_photography_author_new_window' ); ?>" type="checkbox" <?php checked( 1 == $infinite_photography_author_new_window ? $instance['infinite_photography_author_new_window'] : 0); ?> />
                <label for="<?php echo $this->get_field_id( 'infinite_photography_author_new_window' ); ?>"><?php _e( 'Open in new window', 'infinite-photography' ); ?></label>
            </p>
            <hr />
            <?php
        }
        /**
         * Function to Updating widget replacing old instances with new
         *
         * @access public
         * @since 1.0
         *
         * @param array $new_instance new arrays value
         * @param array $old_instance old arrays value
         * @return array
         *
         */
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['infinite_photography_author_title'] = ( isset( $new_instance['infinite_photography_author_title'] ) ) ?  sanitize_text_field( $new_instance['infinite_photography_author_title'] ): '';
            $instance['infinite_photography_author_image'] = ( isset( $new_instance['infinite_photography_author_image'] ) ) ?  esc_url( $new_instance['infinite_photography_author_image'] ): '';
            $instance['infinite_photography_author_link'] = ( isset( $new_instance['infinite_photography_author_link'] ) ) ?  esc_url( $new_instance['infinite_photography_author_link'] ): '';
            $instance['infinite_photography_author_short_disc'] = ( isset( $new_instance['infinite_photography_author_short_disc'] ) ) ?  wp_kses_post( $new_instance['infinite_photography_author_short_disc'] ): '';
            $instance['infinite_photography_author_new_window'] = isset($new_instance['infinite_photography_author_new_window'])? 1 : 0;

            return $instance;
        }
        /**
         * Function to Creating widget front-end. This is where the action happens
         *
         * @access public
         * @since 1.0
         *
         * @param array $args widget setting
         * @param array $instance saved values
         * @return array
         *
         */
        function widget( $args, $instance ) {
            $instance = wp_parse_args( (array) $instance, $this->defaults);
            $infinite_photography_author_title      = apply_filters( 'widget_title', $instance['infinite_photography_author_title'], $instance, $this->id_base );
            $infinite_photography_author_image      = esc_url( $instance['infinite_photography_author_image'] );
            $infinite_photography_author_link       = esc_url( $instance['infinite_photography_author_link'] );
            $infinite_photography_author_new_window = esc_attr( $instance['infinite_photography_author_new_window'] );
            $infinite_photography_author_short_disc = wp_kses_post( $instance['infinite_photography_author_short_disc'] );

            echo $args['before_widget'];

            if ( !empty($infinite_photography_author_title) ) {
                echo $args['before_title'] . $infinite_photography_author_title . $args['after_title'];
            }
            $ad_content_image = '';
            if ( ! empty( $infinite_photography_author_image ) ) {
                /*creating add*/
                $img_html = '<img src="' . $infinite_photography_author_image . '"/>';
                $link_open = '';
                $link_close = '';
                if ( ! empty( $infinite_photography_author_link ) ) {
                    $target_text = ( 1 == $infinite_photography_author_new_window ) ? ' target="_blank" ' : '';
                    $link_open = '<a href="' .  $infinite_photography_author_link . '" ' . $target_text . '>';
                    $link_close = '</a>';
                }
                $ad_content_image = $link_open . $img_html .  $link_close.$infinite_photography_author_short_disc;
            }
            if ( !empty( $ad_content_image ) ) {
                echo '<div class="infinite-photography-author-widget">';
                echo $ad_content_image;
                echo '</div>';
            }
            echo $args['after_widget'];
        }
    }
endif;

if ( ! function_exists( 'infinite_photography_author_widget' ) ) :
    /**
     * Function to Register and load the widget
     *
     * @since 1.0
     *
     * @param null
     * @return null
     *
     */
    function infinite_photography_author_widget() {
        register_widget( 'Infinite_photography_author_widget' );
    }
endif;
add_action( 'widgets_init', 'infinite_photography_author_widget' );