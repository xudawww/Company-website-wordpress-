<?php
/**
 * Template Name: MeisterMag Homepage 3
 * Custom Template used for the display of landing pages.
 */

get_header();

global $post;

if ( get_query_var( 'paged' ) ) {
    $tagdiv_paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
    $tagdiv_paged = get_query_var( 'page' );
} else {
    $tagdiv_paged = 1;
}

$tagdiv_home_latest_articles_title  = esc_html ( trim( Tagdiv_Util::tagdiv_get_theme_options( 'tagdiv_latest_section_title') ) );
$tagdiv_home_block_1_title          = esc_html ( trim( Tagdiv_Util::tagdiv_get_theme_options( 'tagdiv_block_1_title' ) ) );
$tagdiv_home_block_2_title          = esc_html ( trim( Tagdiv_Util::tagdiv_get_theme_options( 'tagdiv_block_2_title' ) ) );
$tagdiv_home_block_6_title          = esc_html ( trim( Tagdiv_Util::tagdiv_get_theme_options( 'tagdiv_block_6_title' ) ) );

?>

    <div class="tagdiv-main-content-wrap">
        <div class="tagdiv-container">

            <?php if ( 2 > $tagdiv_paged ) { //show this only on the first page ?>

                <!-- Block 4 -->
                <div class="tagdiv-row">
                    <div class="tagdiv-span12" role="main">
                        <?php
                        echo tagdiv_global_blocks::get_instance( 'Tagdiv_Block_4' )->render( array(
                            'tagdiv_block_posts_limit' => 4,
                            'tagdiv_column_number'     => 3,
                            'tagdiv_block_sort'        => 'random_posts', // you can set here other sort option value from @see Tagdiv_Data_Source > $tagdiv_block_sort switch
                        ) );
                        ?>
                    </div>
                </div> <!-- /.tagdiv-row -->

                <!-- Block 6 + Block 1 -->
                <div class="tagdiv-row">
                    <div class="tagdiv-span8" role="main">
                        <?php
                        echo tagdiv_global_blocks::get_instance( 'Tagdiv_Block_6' )->render( array(
                            'tagdiv_custom_title'      => $tagdiv_home_block_6_title,
                            'tagdiv_block_posts_limit' => 5,
                            'tagdiv_column_number'     => 2,
                            'tagdiv_block_sort'        => 'random_posts', // you can set here other sort option value from @see Tagdiv_Data_Source > $tagdiv_block_sort switch
                        ) );
                        ?>
                    </div>
                    <div class="tagdiv-span4" role="main">
                        <?php
                        echo tagdiv_global_blocks::get_instance( 'Tagdiv_Block_1' )->render( array(
                            'tagdiv_custom_title'      => $tagdiv_home_block_1_title,
                            'tagdiv_block_posts_limit' => 1,
                            'tagdiv_column_number'     => 1,
                            'tagdiv_block_sort'        => 'random_posts', // you can set here other sort option value from @see Tagdiv_Data_Source > $tagdiv_block_sort switch
                        ) );
                        ?>
                    </div>
                </div> <!-- /.tagdiv-row -->

                <!-- Block 2 -->
                <div class="tagdiv-row">
                    <div class="tagdiv-span12" role="main">
                        <?php
                        echo tagdiv_global_blocks::get_instance( 'Tagdiv_Block_2' )->render( array(
                            'tagdiv_custom_title'      => $tagdiv_home_block_2_title,
                            'tagdiv_block_posts_limit' => 2,
                            'tagdiv_column_number'     => 3,
                            'tagdiv_block_sort'        => 'random_posts', // you can set here other sort option value from @see Tagdiv_Data_Source > $tagdiv_block_sort switch
                        ) );
                        ?>
                    </div>
                </div> <!-- /.tagdiv-row -->

            <?php } ?>

            <div class="tagdiv-row">
                <div class="tagdiv-span8" role="main">

                    <div class="tagdiv-block-title-wrap">
                        <h4 class="tagdiv-block-title">
                            <span><?php echo $tagdiv_home_latest_articles_title ?></span>
                        </h4>
                    </div>

                    <?php

                    // custom query parameters
                    $args = array(
                        'post_type'=> 'post',
                        'paged'    => $tagdiv_paged
                    );

                    // instantiate our custom query
                    $tagdiv_home_query = new WP_Query( $args );
                    $tagdiv_template_layout = new Tagdiv_Template_Layout( 'default' );

                    if ( $tagdiv_home_query->have_posts() ) {

                        while ( $tagdiv_home_query->have_posts() ) : $tagdiv_home_query->the_post();

                            echo $tagdiv_template_layout->layout_open_element();

                            $tagdiv_modul_1 = new Tagdiv_Module_1( $post );
                            echo $tagdiv_modul_1->render();

                            echo $tagdiv_template_layout->layout_close_element();
                            $tagdiv_template_layout->layout_next();

                        endwhile;

                        // reset postdata
                        wp_reset_postdata();

                        echo $tagdiv_template_layout->close_all_tags(); ?>

                        <?php

                    } else {
                        get_template_part( 'template-parts/content', 'none' );
                    }

                    ?>

                    <div class="page-nav">

                        <?php
                        $total_pages = $tagdiv_home_query->max_num_pages;
                        $current_page = max(1, get_query_var('page'));

                        if ( 1 < $total_pages ){
                            echo paginate_links( array(
                                'total'    => $total_pages,
                                'current'  => $current_page,
                                'mid_size' => 1,
                            )  );
                        }
                        ?>

                    </div>

                </div>

                <div class="tagdiv-span4 tagdiv-sidebar" role="complementary">
                    <?php get_sidebar(); ?>
                </div>

            </div> <!-- /.tagdiv-row -->
        </div> <!-- /.tagdiv-container -->
    </div> <!-- /.tagdiv-main-content-wrap -->

<?php get_footer(); ?>