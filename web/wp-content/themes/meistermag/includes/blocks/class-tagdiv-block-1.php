<?php

/**
 * Class Tagdiv_Block_1 - theme block 1
 *
 * @since MeisterMag 1.0
 */
class Tagdiv_Block_1 extends Tagdiv_Block {
	function render( $atts, $content = null ) {
		parent::render( $atts ); // sets the live atts, $this->atts, $this->tagdiv_query (it runs the query)

		$buffy = ''; //output buffer

		$buffy .= '<div class="tagdiv-block-wrap tagdiv-block-1">';

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

				switch ( $tagdiv_column_number ) {

					case '1': //one column layout
						$buffy .= $tagdiv_module_1->render();
						break;

					case '2': //two column layout
						$buffy .= $tagdiv_block_layout->open_row();
						$buffy .= $tagdiv_block_layout->open6();
						$buffy .= $tagdiv_module_1->render();
						$buffy .= $tagdiv_block_layout->close6();

						if ( $tagdiv_current_column == 2 ) {
							$buffy .= $tagdiv_block_layout->close_row();
						}
						break;

					case '3': //three column layout
						$buffy .= $tagdiv_block_layout->open_row();
						$buffy .= $tagdiv_block_layout->open4();
						$buffy .= $tagdiv_module_1->render();
						$buffy .= $tagdiv_block_layout->close4();

						if ( $tagdiv_current_column == 3 ) {
							$buffy .= $tagdiv_block_layout->close_row();
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