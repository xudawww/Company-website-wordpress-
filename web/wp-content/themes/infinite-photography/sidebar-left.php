<?php
/**
 * The left sidebar containing the main widget area.
 */
if ( ! is_active_sidebar( 'infinite-photography-sidebar' ) ) {
    return;
}
$sidebar_layout = infinite_photography_sidebar_selection();
?>
<?php if( $sidebar_layout == "left-sidebar" ) : ?>
    <div id="secondary-left" class="widget-area sidebar secondary-sidebar" role="complementary">
        <div id="sidebar-section-top" class="widget-area sidebar clearfix">
            <?php dynamic_sidebar( 'infinite-photography-sidebar' ); ?>
        </div>
    </div>
<?php endif;
