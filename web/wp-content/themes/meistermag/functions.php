<?php

/**
 * Load theme configuration.
 */
require get_template_directory() . '/includes/class-tagdiv-config.php';
add_action( 'tagdiv_global_after', array( 'Tagdiv_Config', 'on_tagdiv_global_after_config' ), 9 );

require get_template_directory() . '/includes/tagdiv_css_generator.php';
require get_template_directory() . '/includes/wp-booster/wp-booster-functions.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';
