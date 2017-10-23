<?php
/**
 * Reset options
 * Its outside options panel
 *
 * @param  array $reset_options
 * @return void
 *
 * @since infinite-photography 1.1.0
 */
if ( ! function_exists( 'infinite_photography_reset_db_options' ) ) :
    function infinite_photography_reset_db_options( $reset_options ) {
        set_theme_mod( 'infinite_photography_theme_options', $reset_options );
    }
endif;

function infinite_photography_reset_db_setting( ){
	$infinite_photography_customizer_all_values = infinite_photography_get_theme_options();
	$input = $infinite_photography_customizer_all_values['infinite-photography-reset-options'];
	if( '0' == $input ){
		return;
	}
    $infinite_photography_default_theme_options = infinite_photography_get_default_theme_options();
    $infinite_photography_get_theme_options = get_theme_mod( 'infinite_photography_theme_options');

    switch ( $input ) {
        case "reset-color-options":
            $infinite_photography_get_theme_options['infinite-photography-primary-color'] = $infinite_photography_default_theme_options['infinite-photography-primary-color'];
            infinite_photography_reset_db_options($infinite_photography_get_theme_options);
            break;

        case "reset-all":
            infinite_photography_reset_db_options($infinite_photography_default_theme_options);
            break;

        default:
            break;
    }
    return '0';
}
add_action( 'customize_save_after','infinite_photography_reset_db_setting' );

/*adding sections for Reset Options*/
$wp_customize->add_section( 'infinite-photography-reset-options', array(
    'priority'       => 220,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Reset Options', 'infinite-photography' )
) );

/*Reset Options*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-reset-options]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-reset-options'],
    'sanitize_callback' => 'infinite_photography_sanitize_select',
    'transport'			=> 'postMessage'
) );

$choices = infinite_photography_reset_options();
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-reset-options]', array(
    'choices'  	    => $choices,
    'label'		    => __( 'Reset Options', 'infinite-photography' ),
    'description'   => __( 'Caution: Reset theme settings according to the given options. Refresh the page after saving to view the effects. ', 'infinite-photography' ),
    'section'       => 'infinite-photography-reset-options',
    'settings'      => 'infinite_photography_theme_options[infinite-photography-reset-options]',
    'type'	  	    => 'select'
) );