<?php
/**
 * Class Tagdiv_Module_2 - theme module 2
 *
 * @since MeisterMag 1.2
 */

class Tagdiv_Module_2 extends Tagdiv_Module {

    function __construct( $post ) {
        //run the parrent constructor
        parent::__construct( $post );
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes( array( 'tagdiv-module-2' ) ); ?>" >
            <div class="tagdiv-module-image">
                <?php echo $this->get_image( 'tagdiv_640x0' ); ?>
                <div class="tagdiv-post-category-wrap">
                    <?php echo $this->get_category(); ?>
                </div>
            </div>

            <?php echo $this->get_title(); ?>

            <div class="tagdiv-module-meta-info">
                <?php echo $this->get_author(); ?>
                <?php echo $this->get_date(); ?>
                <?php echo $this->get_comments(); ?>
            </div>

            <div class="tagdiv-excerpt">
                <p> <?php echo $this->get_excerpt(25);?> </p>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}