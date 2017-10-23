<?php
/**
 * The template for displaying search forms in Ion Theme
 *
 * @package Ion
 */
?>

<form method="get" id="searchform" class="searchform list" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label for="s" class="item item-input">
		<input type="search" class="form-control" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'ap3-ion-theme' ); ?>" />
	</label>
	
	<input type="submit" class="button button-primary submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'ap3-ion-theme' ); ?>" />
</form>
