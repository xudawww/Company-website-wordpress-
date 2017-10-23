<?php
/**
 * Add div for masonry
 *
 * @since infinite-photography 1.1.0
 *
 * @param null
 * @return null
 *
 */

if ( !function_exists('infinite_photography_masonry_start') ) :
    function infinite_photography_masonry_start( ) {
        global $infinite_photography_customizer_all_values;
        if ( $infinite_photography_customizer_all_values['infinite-photography-blog-archive-layout'] != 'photography') {
           return;
        }
        ?>
        <div class="masonry-start"><div id="masonry-loop">
        <?php
    }
endif;
//add_action('infinite_photography_action_masonry_start', 'infinite_photography_masonry_start');


/**
 * End div for masonry
 *
 * @since infinite-photography 1.1.0
 *
 * @param null
 * @return null
 *
 */

if ( !function_exists('infinite_photography_masonry_end') ) :
    function infinite_photography_masonry_end( ) {
        global $infinite_photography_customizer_all_values;
        if ( $infinite_photography_customizer_all_values['infinite-photography-blog-archive-layout'] != 'photography') {
            return;
        }
        ?>
        </div><!--#masonry-loop-->
        </div><!--masonry-start-->
        <?php
    }
endif;
//add_action('infinite_photography_action_masonry_end', 'infinite_photography_masonry_end');