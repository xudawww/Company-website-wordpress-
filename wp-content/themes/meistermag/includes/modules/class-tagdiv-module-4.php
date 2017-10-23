<?php
/**
 * Class Tagdiv_Module_3 - theme module 3
 *
 * @since MeisterMag 1.2
 */

class Tagdiv_Module_4 extends Tagdiv_Module {

    function __construct( $post ) {
        //run the parrent constructor
        parent::__construct( $post );
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes( array( 'tagdiv-module-4' ) ); ?>" >
            <div class="tagdiv-module-image tagdiv-module-image-float">
                <?php echo $this->get_image( 'tagdiv_260x195' ); ?>
            </div>

            <div class="tagdiv-item-details tagdiv-category-small">
                <?php echo $this->get_category();?>
                <?php echo $this->get_title();?>

                <div class="tagdiv-module-meta-info">
                    <?php echo $this->get_author();?>
                    <?php echo $this->get_date();?>
                    <?php echo $this->get_comments();?>
                </div>
            </div>

            <div class="tagdiv-excerpt">
                <p> <?php echo $this->get_excerpt(25);?> </p>
            </div>

            <div class="tagdiv-clearfix"></div>
        </div>

        <?php return ob_get_clean();
    }
}