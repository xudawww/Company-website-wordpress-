<?php
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Infinite_Photography_Customize_Category_Dropdown_Control' )):

    /**
     * Custom Control for category dropdown
     * @package Acme Themes
     * @subpackage Infinite Photography
     * @since 1.0.0
     *
     */
    class Infinite_Photography_Customize_Category_Dropdown_Control extends WP_Customize_Control {

        /**
         * Declare the control type.
         *
         * @access public
         * @var string
         */
        public $type = 'category_dropdown';

        /**
         * Function to  render the content on the theme customizer page
         *
         * @access public
         * @since 1.0.0
         *
         * @param null
         * @return void
         *
         */
        public function render_content() {
            $infinite_photography_customizer_name = 'infinite_photography_customizer_dropdown_categories_' . $this->id;;
            $infinite_photography_dropdown_categories = wp_dropdown_categories(
                array(
                    'name'              => $infinite_photography_customizer_name,
                    'echo'              => 0,
                    'show_option_none'  =>__('Select','infinite-photography'),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
            $infinite_photography_dropdown_final = str_replace( '<select', '<select ' . $this->get_link(), $infinite_photography_dropdown_categories );
            printf(
                '<label><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $infinite_photography_dropdown_final
            );
        }
    }
    endif;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Infinite_Photography_Customize_Post_Dropdown_Control' )):

    /**
     * Custom Control for post dropdown
     * @package Acme Themes
     * @subpackage Infinite Photography
     * @since 1.0.0
     *
     */
    class Infinite_Photography_Customize_Post_Dropdown_Control extends WP_Customize_Control {
        /**
         * Declare the control type.
         *
         * @access public
         * @var string
         */
        public $type = 'post_dropdown';

        /**
         * Function to  render the content on the theme customizer page
         *
         * @access public
         * @since 1.0.0
         *
         * @param null
         * @return void
         *
         */
        public function render_content() {
            $infinite_photography_customizer_post_args = array(
                'posts_per_page'   => 50,
            );
            $infinite_photography_posts = get_posts( $infinite_photography_customizer_post_args );
            if(!empty($infinite_photography_posts))  {
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <select <?php $this->link(); ?>>
                        <?php
                        $infinite_photography_default_value = $this->value();
                        if( -1 == $infinite_photography_default_value || empty($infinite_photography_default_value)){
                            $infinite_photography_default_selected = 1;
                        }
                        else{
                            $infinite_photography_default_selected = 0;
                        }
                        printf('<option value="-1" %s>%s</option>',selected($infinite_photography_default_selected, 1, false),__('Select','infinite-photography'));
                        foreach ( $infinite_photography_posts as $infinite_photography_post ) {
                            printf('<option value="%s" %s>%s</option>', $infinite_photography_post->ID, selected($this->value(), $infinite_photography_post->ID, false), $infinite_photography_post->post_title);
                        }
                        ?>
                    </select>
                </label>
                <?php
            }
        }
    }
endif;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Infinite_Photography_Customize_Message_Control' )):
    /**
     * Custom Control for html display
     * @package Acme Themes
     * @subpackage Infinite Photography
     * @since 1.0.0
     *
     */
    class Infinite_Photography_Customize_Message_Control extends WP_Customize_Control {

        /**
         * Declare the control type.
         * @access public
         * @var string
         */
        public $type = 'message';

        /**
         * Function to  render the content on the theme customizer page
         *
         * @access public
         * @since 1.0.0
         *
         * @param null
         * @return void
         *
         */
        public function render_content() {
            if ( empty( $this->description ) ) {
                return;
            }
            ?>
            <div class="infinite-photography-customize-customize-message">
                <?php echo wp_kses_post($this->description); ?>
            </div> <!-- .infinite-photography-customize-customize-message -->
            <?php
        }
    }
endif;