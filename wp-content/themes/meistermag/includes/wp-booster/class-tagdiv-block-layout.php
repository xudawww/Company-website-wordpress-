<?php

/*
 * theme blocks layout support
 *  * used by:
 *  - blocks
 *  - includes/tagdiv_page_generator/tagdiv_template_layout.php (author page, tag page)
 *
 * @since MeisterMag 1.0
 */

class Tagdiv_Block_Layout {


	var $row_is_open = false;
	var $span6_is_open = false;
	var $span4_is_open = false;
	var $span3_is_open = false;

	var $span12_is_open = false;

	var $row_class = 'tagdiv-row';
	var $span3_class = 'tagdiv-span3';
	var $span4_class = 'tagdiv-span4';
	var $span6_class = 'tagdiv-span6';
	var $span12_class = 'tagdiv-span12'; // this one does not use rows


	function open_row() {
		if ( $this->row_is_open ) {
			//open row only once
			return '';
		}

		$this->row_is_open = true;

		return "\n\n\t" . '<div class="' . $this->row_class . '">';
	}

	/**
	 * closes the row - it does not check if the row is already closed
	 * @return string
	 */
	function close_row() {
		$this->row_is_open = false;

		return '</div><!--./row-fluid-->';
	}


	//span 3
	function open3() {
		if ( $this->span3_is_open ) {
			//open row only once
			return '';
		}
		$this->span3_is_open = true;

		return "\n\n\t" . '<div class="' . $this->span3_class . '">' . "\n";
	}

	function close3() {
		$this->span3_is_open = false;

		return "\n\t" . '</div> <!-- ./' . $this->span3_class . ' -->';
	}


	//span 4
	function open4() {
		if ( $this->span4_is_open ) {
			//open row only once
			return '';
		}
		$this->span4_is_open = true;

		return "\n\n\t" . '<div class="' . $this->span4_class . '">' . "\n";
	}

	function close4() {
		$this->span4_is_open = false;

		return "\n\t" . '</div> <!-- ./' . $this->span4_class . ' -->';
	}


	//span 6
	function open6() {
		if ( $this->span6_is_open ) {
			//open row only once
			return '';
		}
		$this->span6_is_open = true;

		return "\n\n\t" . '<div class="' . $this->span6_class . '">' . "\n";
	}

	function close6() {
		$this->span6_is_open = false;

		return "\n\t" . '</div> <!-- ./' . $this->span6_class . ' -->';
	}


	//span 12 - doesn't use rows
	function open12() {
		if ( $this->span12_is_open ) {
			//open only once
			return '';
		}
		$this->span12_is_open = true;

		return "\n\n\t" . '<div class="' . $this->span12_class . '">' . "\n";
	}

	function close12() {
		$this->span12_is_open = false;

		return "\n\t" . '</div> <!-- ./' . $this->span12_class . ' -->';
	}


	/**
	 * closes all the spans that are open and also the rows
	 * @return string
	 */
	function close_all_tags() {
		$buffy = '';
		if ( $this->span6_is_open ) {
			$buffy .= $this->close6();
		}

		if ( $this->span3_is_open ) {
			$buffy .= $this->close3();
		}

		if ( $this->span4_is_open ) {
			$buffy .= $this->close4();
		}

		if ( $this->row_is_open ) {
			$buffy .= $this->close_row();
		}

		return $buffy;
	}
}
