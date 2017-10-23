<?php
/**
 * The template for displaying custom search
 *
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */
?>

<div class="search-block">
    <form action="<?php echo esc_url( home_url() )?>" class="searchform" id="searchform" method="get" role="search">
        <div>
            <label for="menu-search" class="screen-reader-text"></label>
            <?php
            global $infinite_photography_customizer_all_values;
            $placeholder_text = '';
            if ( isset( $infinite_photography_customizer_all_values['infinite-photography-search-placeholder']) ):
                $placeholder_text = ' placeholder="' . esc_attr( $infinite_photography_customizer_all_values['infinite-photography-search-placeholder'] ). '" ';
            endif; ?>
            <input type="text" <?php echo  $placeholder_text ;?> class="menu-search" id="menu-search" name="s" value="<?php echo esc_attr( get_search_query() );?>">
            <button class="searchsubmit fa fa-search" type="submit" id="searchsubmit"></button>
        </div>
    </form>
</div>
