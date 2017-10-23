<?php
/**
 * Template for displaying search forms in our theme
 *
 * @since MeisterMag 1.0
 */
?>

<form role="search" method="get" class="search-form tagdiv-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'meistermag' ); ?></span>
		<input type="search" id="tagdiv-header-search" class="search-field" placeholder="<?php esc_attr_e( 'Search &hellip;', 'meistermag' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
		<span class="tagdiv-search-input-bar"></span>
	</label>
	<button type="submit" class="search-submit wpb_button wpb_btn-inverse btn">
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'meistermag' ); ?></span>
		<?php esc_html_e( 'Search', 'meistermag' ) ?>
	</button>
</form>
