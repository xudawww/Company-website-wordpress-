<?php
/**
 * Class Tagdiv_Module_MX_1 - theme module mx 1
 *
 * @since MeisterMag 1.2
 */

class Tagdiv_Module_Mx_1 extends Tagdiv_Module {

    function __construct( $post ) {
        //run the parrent constructor
        parent::__construct( $post );
    }

    function render() {
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes( array( 'tagdiv-module-mx-1' ) ); ?>" >
            <div class="tagdiv-module-image">
                <?php echo $this->get_image( 'tagdiv_300x444' ); ?>
            </div>

            <div class="tagdiv-meta-info-container">
                <?php echo $this->get_category();?>
                <?php echo $this->get_title();?>

                <div class="tagdiv-module-meta-info">
                    <?php echo $this->get_author();?>
                    <?php echo $this->get_date();?>
                </div>
            </div>
        </div>

        <?php return ob_get_clean();
    }
}