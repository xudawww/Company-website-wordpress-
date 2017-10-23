<?php
/**
 * The template for displaying image attachments
 *
 * @since MeisterMag 1.0
 */

get_header();

?>

<div class="tagdiv-main-content-wrap">
    <div class="tagdiv-container">
        <div class="tagdiv-row">
            <div class="tagdiv-span8" role="main">

                <?php while ( have_posts() ) : the_post(); // Start the loop. ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <header class="tagdiv-page-header">
                            <?php the_title( '<h1 class="tagdiv-entry-title tagdiv-page-title">', '</h1>' ); ?>
                        </header><!-- /.tagdiv-page-header -->

                        <div class="tagdiv-attachment">
                            <?php
                            /**
                             * Filter the default meistermag image attachment size.
                             * @since MeisterMag 1.0
                             * @param string $image_size Image size. Default 'large'.
                             */
                            $image_size = apply_filters( 'tagdiv_attachment_size', 'large' );

                            echo wp_get_attachment_image( get_the_ID(), $image_size );
                            ?>

                            <?php tagdiv_excerpt( 'tagdiv-attachment-caption' ); ?>

                        </div><!-- /.tagdiv-attachment -->

                        <div class="tagdiv-attachment-page-content">
                            <?php the_content(); ?>
                        </div><!-- /.tagdiv-attachment-page-content -->

                        <footer class="tagdiv-page-footer">
                                <?php
                                wp_link_pages( array(
                                    'before' => '<div class="page-nav">',
                                    'after' => '</div>',
                                    'link_before' => '<div>',
                                    'link_after' => '</div>',
                                    'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'meistermag' ) . ' </span>%',
                                    'separator'   => '<span class="screen-reader-text">, </span>',
                                ) );
                                ?>


                                <div class="tagdiv-attachment-prev"><?php previous_image_link(); ?></div>
                                <div class="tagdiv-attachment-next"><?php next_image_link(); ?></div>

                        </footer><!-- /.tagdiv-page-footer -->
                    </article><!-- #post-## -->

                    <?php endwhile; // End the loop. ?>

            </div>

            <div class="tagdiv-span4 tagdiv-sidebar" role="complementary">
                    <?php get_sidebar(); ?>
            </div>
        </div> <!-- /.tagdiv-row -->
    </div> <!-- /.tagdiv-container -->
</div> <!-- /.tagdiv-main-content-wrap -->

<?php get_footer();