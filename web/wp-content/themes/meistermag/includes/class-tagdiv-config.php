<?php
/**
 * This is the config file for the theme.
 */

define( 'TAGDIV_THEME_VERSION', "1.2" );
define( 'TAGDIV_THEME_OPTIONS_NAME', "tagdiv_theme_options"); //where to store theme options


class Tagdiv_Config {

	/* setup the global theme specific variables */
	static function on_tagdiv_global_after_config() {

		/* The theme module */
		Tagdiv_API_Module::add( 'Tagdiv_Module_1',
			array(
				'file' 			 => get_template_directory() . '/includes/modules/class-tagdiv-module-1.php',
				'text' 			 => 'Module 1',
				'class' 		 => 'tagdiv-module-wrap',
				'used_on_blocks' => array( 'tagdiv_block_1' )
			)
		);

		Tagdiv_API_Module::add( 'Tagdiv_Module_2',
			array(
				'file' 			 => get_template_directory() . '/includes/modules/class-tagdiv-module-2.php',
				'text' 			 => 'Module 2',
				'class' 		 => 'tagdiv-module-wrap',
				'used_on_blocks' => array( 'tagdiv_block_2' )
			)
		);

		Tagdiv_API_Module::add( 'Tagdiv_Module_3',
			array(
				'file' 			 => get_template_directory() . '/includes/modules/class-tagdiv-module-3.php',
				'text' 			 => 'Module 3',
				'class' 		 => 'tagdiv-module-wrap',
				'used_on_blocks' => array( 'tagdiv_block_3' )
			)
		);

		Tagdiv_API_Module::add( 'Tagdiv_Module_4',
			array(
				'file' 			 => get_template_directory() . '/includes/modules/class-tagdiv-module-4.php',
				'text' 			 => 'Module 4',
				'class' 		 => 'tagdiv-module-wrap',
				'used_on_blocks' => array( 'tagdiv_block_5' )
			)
		);

		Tagdiv_API_Module::add( 'Tagdiv_Module_Mx_1',
			array(
				'file' 			 => get_template_directory() . '/includes/modules/class-tagdiv-module-mx-1.php',
				'text' 			 => 'Module MX 1',
				'class' 		 => 'tagdiv-module-wrap',
				'used_on_blocks' => array( 'tagdiv_block_mx_1' )
			)
		);


		/* The theme blocks */
		Tagdiv_API_Block::add( 'Tagdiv_Block_1',
			array(
				"file" 	   => get_template_directory() . '/includes/blocks/class-tagdiv-block-1.php',
				"name" 	   => 'Block 1',
				"class"    => 'tagdiv_block_1',
				"category" => 'Blocks'
			)
		);

		Tagdiv_API_Block::add( 'Tagdiv_Block_2',
			array(
				"file" 	   => get_template_directory() . '/includes/blocks/class-tagdiv-block-2.php',
				"name" 	   => 'Block 2',
				"class"    => 'tagdiv_block_2',
				"category" => 'Blocks'
			)
		);

		Tagdiv_API_Block::add( 'Tagdiv_Block_3',
			array(
				"file" 	   => get_template_directory() . '/includes/blocks/class-tagdiv-block-3.php',
				"name" 	   => 'Block 3',
				"class"    => 'tagdiv_block_3',
				"category" => 'Blocks'
			)
		);

		Tagdiv_API_Block::add( 'Tagdiv_Block_4',
			array(
				"file" 	   => get_template_directory() . '/includes/blocks/class-tagdiv-block-4.php',
				"name" 	   => 'Block 4',
				"class"    => 'tagdiv_block_4',
				"category" => 'Blocks'
			)
		);

		Tagdiv_API_Block::add( 'Tagdiv_Block_5',
			array(
				"file" 	   => get_template_directory() . '/includes/blocks/class-tagdiv-block-5.php',
				"name" 	   => 'Block 5',
				"class"    => 'tagdiv_block_5',
				"category" => 'Blocks'
			)
		);

		Tagdiv_API_Block::add( 'Tagdiv_Block_6',
			array(
				"file" 	   => get_template_directory() . '/includes/blocks/class-tagdiv-block-6.php',
				"name" 	   => 'Block 6',
				"class"    => 'tagdiv_block_6',
				"category" => 'Blocks'
			)
		);


		/* The thumbs used by the theme */
		Tagdiv_API_Thumb::add( 'tagdiv_300x220',
			array(
				'name' 	  => 'tagdiv_300x220',
				'width'   => 300,
				'height'  => 220,
				'crop' 	  => array( 'center', 'top' ),
				'used_on' => array( 'Module 1' )
			)
		);

		Tagdiv_API_Thumb::add( 'tagdiv_640x0',
			array(
				'name' 	  => 'tagdiv_640x0',
				'width'   => 640,
				'height'  => 0,
				'crop' 	  => array( 'center', 'top' ),
				'used_on' => array( 'Post template default, Module 2' )
			)
		);

		Tagdiv_API_Thumb::add( 'tagdiv_100x70',
			array(
				'name' 	  => 'tagdiv_100x70',
				'width'   => 100,
				'height'  => 70,
				'crop' 	  => array( 'center', 'top' ),
				'used_on' => array( 'Module 3' )
			)
		);

		Tagdiv_API_Thumb::add( 'tagdiv_300x444',
			array(
				'name' 	  => 'tagdiv_300x444',
				'width'   => 300,
				'height'  => 444,
				'crop' 	  => array( 'center', 'top' ),
				'used_on' => array( 'Module MX 1' )
			)
		);

		Tagdiv_API_Thumb::add( 'tagdiv_260x195',
			array(
				'name' 	  => 'tagdiv_260x195',
				'width'   => 260,
				'height'  => 195,
				'crop' 	  => array( 'center', 'top' ),
				'used_on' => array( 'Module 4' )
			)
		);

	}
}
