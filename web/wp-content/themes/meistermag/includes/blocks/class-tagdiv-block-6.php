<?php
/**
 * Class Tagdiv_Block_6 - theme block 6
 *
 * @since MeisterMag 1.2
 */
class Tagdiv_Block_6 extends Tagdiv_Block {
    function render( $atts, $content = null ) {
        parent::render( $atts ); // sets the live atts, $this->atts, $this->tagdiv_query (it runs the query)

        $buffy = ''; //output buffer

        $buffy .= '<div class="tagdiv-block-wrap tagdiv-block-6 tagdiv-column-' . $this->tagdiv_query_atts['tagdiv_column_number'] . '">';

        // block title wrap
        $buffy .= '<div class="tagdiv-block-title-wrap">';
        $buffy .= $this->get_block_title(); //get the block title
        $buffy .= '</div>';

        $buffy .= '<div id="block_id" class="tagdiv_block_inner">';
        $buffy .= $this->inner( $this->tagdiv_query->posts, $this->tagdiv_query_atts['tagdiv_column_number'] );  //inner content of the block
        $buffy .= '</div>';

        $buffy .= '</div> <!-- /.tagdiv-block-wrap -->';

        return $buffy;
    }

    function inner( $posts, $tagdiv_column_number = '' ) {
        $buffy = '';

        $tagdiv_block_layout   = new Tagdiv_Block_Layout();
        $tagdiv_post_count     = 0; // the number of posts rendered
        $tagdiv_current_column = 1; // the current column

        if ( ! empty( $posts ) ) {
            foreach ( $posts as $post ) {
                $tagdiv_module_1 = new Tagdiv_Module_1( $post );
                $tagdiv_module_3 = new Tagdiv_Module_3( $post );

                switch ( $tagdiv_column_number ) {

                    case '1': //one column layout

                        $buffy .= $tagdiv_block_layout->open12();
                        if ($tagdiv_post_count == 0) { //first post
                            $buffy .= $tagdiv_module_1->render();
                        } else {
                            $buffy .= $tagdiv_module_3->render();
                        }
                        $buffy .= $tagdiv_block_layout->close12();
                        
                        break;

                    case '2': //two column layout
                        $buffy .= $tagdiv_block_layout->open_row();
                        if ($tagdiv_post_count == 0) { //first post
                            $buffy .= $tagdiv_block_layout->open6();
                            $buffy .= $tagdiv_module_1->render();
                            $buffy .= $tagdiv_block_layout->close6();
                        } else { //the rest
                            $buffy .= $tagdiv_block_layout->open6();
                            $buffy .= $tagdiv_module_3->render();
                        }
                        
                        break;

                    case '3': //three column layout

                        $buffy .= $tagdiv_block_layout->open_row();

                        if ($tagdiv_post_count == 0) { //first post
                            $buffy .= $tagdiv_block_layout->open4();
                            $buffy .= $tagdiv_module_1->render();
                            $buffy .= $tagdiv_block_layout->close4();
                        } else { //2-3 cols
                            $buffy .= $tagdiv_block_layout->open4();
                            $buffy .= $tagdiv_module_3->render();

                            if ($tagdiv_post_count == 4) { //make new column
                                $buffy .= $tagdiv_block_layout->close4();
                            }
                        }

                        break;
                }

                //current column
                if ( $tagdiv_current_column == $tagdiv_column_number ) {
                    $tagdiv_current_column = 1;
                } else {
                    $tagdiv_current_column ++;
                }

                $tagdiv_post_count ++;
            }
        }
        $buffy .= $tagdiv_block_layout->close_all_tags();

        return $buffy;
    }
}
