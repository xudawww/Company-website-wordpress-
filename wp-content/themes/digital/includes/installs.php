<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function digital_notice() {
	if ( isset( $_GET['activated'] ) ) {
		$return = '<div class="updated activation">';				
		$return .= ' <a class="button button-primary theme-options" href="' . admin_url( 'themes.php?page=options-framework' ) . '">' . __( 'Theme Options', 'digital' ) . '</a>';
		$return .= ' <a class="button button-primary help" href="http://www.insertcart.com/digital-theme-documentation-setup/">' . __( 'Instruction & Help', 'digital' ) . '</a>';
		$return .= '</p></div>';
		echo $return;
	}
}
add_action( 'admin_notices', 'digital_notice' );

/*
 * Hide core theme activation message.
 */
function digital_admincss() { ?>
	<style>
	.themes-php #message2 {
		display: none;
	}
	.themes-php div.activation a {
		text-decoration: none;
	}
	</style>
<?php }
add_action( 'admin_head', 'digital_admincss' );
