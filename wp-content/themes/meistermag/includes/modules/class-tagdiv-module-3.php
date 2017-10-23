<?php
/**
 * Class Tagdiv_Module_3 - theme module 3
 *
 * @since MeisterMag 1.2
 */

class Tagdiv_Module_3 extends Tagdiv_Module {

    function __construct( $post ) {
        //run the parrent constructor
        parent::__construct( $post );
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes( array( 'tagdiv-module-3' ) ); ?>" >
            <div class="tagdiv-module-image tagdiv-module-image-float">
                <?php echo $this->get_image( 'tagdiv_100x70' ); ?>
            </div>

            <div class="tagdiv-item-details tagdiv-no-comment tagdiv-category-small">
                <?php echo $this->get_title();?>

                <div class="tagdiv-module-meta-info">
                    <?php echo $this->get_category();?>
                    <?php echo $this->get_date();?>
                </div>
            </div>

            <div class="tagdiv-clearfix"></div>
        </div>

        <?php return ob_get_clean();
    }
}