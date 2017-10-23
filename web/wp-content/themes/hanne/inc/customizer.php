<?php
/**
 * hanne Theme Customizer
 *
 * @package hanne
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hanne_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	
	
	//Logo Settings
	$wp_customize->add_section( 'title_tagline' , array(
	    'title'      => __( 'Title, Tagline & Logo', 'hanne' ),
	    'priority'   => 30,
	) );
	
	
	$wp_customize->add_setting( 'hanne_logo_resize' , array(
	    'default'     => 100,
	    'sanitize_callback' => 'hanne_sanitize_positive_number',
	) );
	$wp_customize->add_control(
	        'hanne_logo_resize',
	        array(
	            'label' => __('Resize & Adjust Logo','hanne'),
	            'section' => 'title_tagline',
	            'settings' => 'hanne_logo_resize',
	            'priority' => 6,
	            'type' => 'range',
	            'active_callback' => 'hanne_logo_enabled',
	            'input_attrs' => array(
			        'min'   => 30,
			        'max'   => 200,
			        'step'  => 5,
			    ),
	        )
	);
	
	function hanne_logo_enabled($control) {
		$option = $control->manager->get_setting('custom_logo');
		return $option->value() == true;
	}
	
	
	
	//Replace Header Text Color with, separate colors for Title and Description
	$wp_customize->get_control('header_textcolor')->label = __('Site Title Color','hanne');
	$wp_customize->add_setting('hanne_header_desccolor', array(
	    'default'     => '#000',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'hanne_header_desccolor', array(
			'label' => __('Site Tagline Color','hanne'),
			'section' => 'colors',
			'settings' => 'hanne_header_desccolor',
			'type' => 'color'
		) ) 
	);
	
	//Settings for Header Image
	$wp_customize->add_setting( 'hanne_himg_style' , array(
	    'default'     => 'cover',
	    'sanitize_callback' => 'hanne_sanitize_himg_style'
	) );
	
	/* Sanitization Function */
	function hanne_sanitize_himg_style( $input ) {
		if (in_array( $input, array('contain','cover') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'hanne_himg_style', array(
		'label' => __('Header Image Arrangement','hanne'),
		'section' => 'header_image',
		'settings' => 'hanne_himg_style',
		'type' => 'select',
		'choices' => array(
				'contain' => __('Contain','hanne'),
				'cover' => __('Cover Completely (Recommended)','hanne'),
				)
	) );
	
	$wp_customize->add_setting( 'hanne_himg_align' , array(
	    'default'     => 'center',
	    'sanitize_callback' => 'hanne_sanitize_himg_align'
	) );
	
	/* Sanitization Function */
	function hanne_sanitize_himg_align( $input ) {
		if (in_array( $input, array('center','left','right') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'hanne_himg_align', array(
		'label' => __('Header Image Alignment','hanne'),
		'section' => 'header_image',
		'settings' => 'hanne_himg_align',
		'type' => 'select',
		'choices' => array(
				'center' => __('Center','hanne'),
				'left' => __('Left','hanne'),
				'right' => __('Right','hanne'),
			)
	) );
	
	$wp_customize->add_setting( 'hanne_himg_repeat' , array(
	    'default'     => true,
	    'sanitize_callback' => 'hanne_sanitize_checkbox'
	) );
	
	$wp_customize->add_control(
	'hanne_himg_repeat', array(
		'label' => __('Repeat Header Image','hanne'),
		'section' => 'header_image',
		'settings' => 'hanne_himg_repeat',
		'type' => 'checkbox',
	) );
	

	
	//FEATURED POSTS	
	$wp_customize->add_section(
	    'hanne_featposts',
	    array(
	        'title'     => __('Featured Posts','hanne'),
	        'priority'  => 35,
	    )
	);
	
	$wp_customize->add_setting(
		'hanne_featposts_enable',
		array( 'sanitize_callback' => 'hanne_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'hanne_featposts_enable', array(
		    'settings' => 'hanne_featposts_enable',
		    'label'    => __( 'Enable', 'hanne' ),
		    'section'  => 'hanne_featposts',
		    'type'     => 'checkbox',
		)
	);	
	
	$wp_customize->add_setting(
		    'hanne_featposts_cat',
		    array( 'sanitize_callback' => 'hanne_sanitize_category' )
		);
	
		
	$wp_customize->add_control(
	    new Hanne_WP_Customize_Category_Control(
	        $wp_customize,
	        'hanne_featposts_cat',
	        array(
	            'label'    => __('Category For Featured Posts','hanne'),
	            'settings' => 'hanne_featposts_cat',
	            'section'  => 'hanne_featposts'
	        )
	    )
	);
	
		
	// Layout and Design
	$wp_customize->add_panel( 'hanne_design_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Design & Layout','hanne'),
	) );
	
	$wp_customize->add_section(
	    'hanne_design_options',
	    array(
	        'title'     => __('Blog Layout','hanne'),
	        'priority'  => 0,
	        'panel'     => 'hanne_design_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'hanne_blog_layout',
		array( 'sanitize_callback' => 'hanne_sanitize_blog_layout' )
	);
	
	function hanne_sanitize_blog_layout( $input ) {
		if ( in_array($input, array('grid','grid_2_column','grid_3_column','hanne') ) )
			return $input;
		else 
			return '';	
	}
	
	$wp_customize->add_control(
		'hanne_blog_layout',array(
				'label' => __('Select Layout','hanne'),
				'settings' => 'hanne_blog_layout',
				'section'  => 'hanne_design_options',
				'type' => 'select',
				'choices' => array(
						'hanne' => __('Hanne Theme Layout','hanne'),
						'grid' => __('Basic Blog Layout','hanne'),
						'grid_2_column' => __('Grid - 2 Column','hanne'),
						'grid_3_column' => __('Grid - 3 Column','hanne'),
						
					)
			)
	);
	
	$wp_customize->add_section(
	    'hanne_sidebar_options',
	    array(
	        'title'     => __('Sidebar Layout','hanne'),
	        'priority'  => 0,
	        'panel'     => 'hanne_design_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'hanne_disable_sidebar',
		array( 'sanitize_callback' => 'hanne_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'hanne_disable_sidebar', array(
		    'settings' => 'hanne_disable_sidebar',
		    'label'    => __( 'Disable Sidebar Everywhere.','hanne' ),
		    'section'  => 'hanne_sidebar_options',
		    'type'     => 'checkbox',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'hanne_disable_sidebar_home',
		array( 'sanitize_callback' => 'hanne_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'hanne_disable_sidebar_home', array(
		    'settings' => 'hanne_disable_sidebar_home',
		    'label'    => __( 'Disable Sidebar on Home/Blog.','hanne' ),
		    'section'  => 'hanne_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'hanne_show_sidebar_options',
		    'default'  => true
		)
	);
	
	$wp_customize->add_setting(
		'hanne_disable_sidebar_front',
		array( 'sanitize_callback' => 'hanne_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'hanne_disable_sidebar_front', array(
		    'settings' => 'hanne_disable_sidebar_front',
		    'label'    => __( 'Disable Sidebar on Front Page.','hanne' ),
		    'section'  => 'hanne_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'hanne_show_sidebar_options',
		    'default'  => false
		)
	);
	
	
	$wp_customize->add_setting(
		'hanne_sidebar_width',
		array(
			'default' => 4,
		    'sanitize_callback' => 'hanne_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'hanne_sidebar_width', array(
		    'settings' => 'hanne_sidebar_width',
		    'label'    => __( 'Sidebar Width','hanne' ),
		    'description' => __('Min: 25%, Default: 33%, Max: 40%','hanne'),
		    'section'  => 'hanne_sidebar_options',
		    'type'     => 'range',
		    'active_callback' => 'hanne_show_sidebar_options',
		    'input_attrs' => array(
		        'min'   => 3,
		        'max'   => 5,
		        'step'  => 1,
		        'class' => 'sidebar-width-range',
		        'style' => 'color: #0a0',
		    ),
		)
	);
	
	/* Active Callback Function */
	function hanne_show_sidebar_options($control) {
	   
	    $option = $control->manager->get_setting('hanne_disable_sidebar');
	    return $option->value() == false ;
	    
	}
	
	function hanne_sanitize_text( $input ) {
	    return wp_kses_post( force_balance_tags( $input ) );
	}
	
	$wp_customize-> add_section(
    'hanne_custom_footer',
    array(
    	'title'			=> __('Custom Footer Text','hanne'),
    	'description'	=> __('Enter your Own Copyright Text.','hanne'),
    	'priority'		=> 11,
    	'panel'			=> 'hanne_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'hanne_footer_text',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(	 
	       'hanne_footer_text',
	        array(
	            'section' => 'hanne_custom_footer',
	            'settings' => 'hanne_footer_text',
	            'type' => 'text'
	        )
	);	
	
	$wp_customize->add_section(
	    'hanne_typo_options',
	    array(
	        'title'     => __('Google Web Fonts','hanne'),
	        'priority'  => 41,
	    )
	);
	
	$font_array = array('HIND','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','Arimo','Bitter','Noto Sans');
	$fonts = array_combine($font_array, $font_array);
	
	$wp_customize->add_setting(
		'hanne_title_font',
		array(
			'default'=> 'HIND',
			'sanitize_callback' => 'hanne_sanitize_gfont' 
			)
	);
	
	function hanne_sanitize_gfont( $input ) {
		if ( in_array($input, array('HIND','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','Arimo','Bitter','Noto Sans') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
		'hanne_title_font',array(
				'label' => __('Title','hanne'),
				'settings' => 'hanne_title_font',
				'section'  => 'hanne_typo_options',
				'type' => 'select',
				'choices' => $fonts,
			)
	);
	
	$wp_customize->add_setting(
		'hanne_body_font',
			array(	'default'=> 'Open Sans',
					'sanitize_callback' => 'hanne_sanitize_gfont' )
	);
	
	$wp_customize->add_control(
		'hanne_body_font',array(
				'label' => __('Body','hanne'),
				'settings' => 'hanne_body_font',
				'section'  => 'hanne_typo_options',
				'type' => 'select',
				'choices' => $fonts
			)
	);
	
	// Social Icons
	$wp_customize->add_section('hanne_social_section', array(
			'title' => __('Social Icons','hanne'),
			'priority' => 44 ,
	));
	
	$social_networks = array( //Redefinied in Sanitization Function.
					'none' => __('-','hanne'),
					'facebook' => __('Facebook','hanne'),
					'twitter' => __('Twitter','hanne'),
					'google-plus' => __('Google Plus','hanne'),
					'instagram' => __('Instagram','hanne'),
					'rss' => __('RSS Feeds','hanne'),
					'vine' => __('Vine','hanne'),
					'vimeo-square' => __('Vimeo','hanne'),
					'youtube' => __('Youtube','hanne'),
					'flickr' => __('Flickr','hanne'),
				);
				
	$social_count = count($social_networks);
				
	for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :
			
		$wp_customize->add_setting(
			'hanne_social_'.$x, array(
				'sanitize_callback' => 'hanne_sanitize_social',
				'default' => 'none'
			));

		$wp_customize->add_control( 'hanne_social_'.$x, array(
					'settings' => 'hanne_social_'.$x,
					'label' => __('Icon ','hanne').$x,
					'section' => 'hanne_social_section',
					'type' => 'select',
					'choices' => $social_networks,			
		));
		
		$wp_customize->add_setting(
			'hanne_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'hanne_social_url'.$x, array(
					'settings' => 'hanne_social_url'.$x,
					'description' => __('Icon ','hanne').$x.__(' Url','hanne'),
					'section' => 'hanne_social_section',
					'type' => 'url',
					'choices' => $social_networks,			
		));
		
	endfor;
	
	function hanne_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook',
					'twitter',
					'google-plus',
					'instagram',
					'rss',
					'vine',
					'vimeo-square',
					'youtube',
					'flickr'
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return '';	
	}	
	
	$wp_customize->add_section(
	    'hanne_sec_upgrade',
	    array(
	        'title'     => __('Hanne - Help & Support','hanne'),
	        'priority'  => 45,
	    )
	);
	
	$wp_customize->add_setting(
			'hanne_upgrade',
			array( 'sanitize_callback' => 'esc_textarea' )
		);
			
	$wp_customize->add_control(
	    new Hanne_WP_Customize_Upgrade_Control(
	        $wp_customize,
	        'hanne_upgrade',
	        array(
	            'label' => __('Free Email Support','hanne'),
	            'description' => __('Currently We are Offering Free Email Support with our theme. If you have any queries or require help please <a href="https://inkhive.com/product/hanne/">Read our FAQs</a> and if your problem is still not solved then contact us. <br><br> If you are looking for more features in your site like Unlimited Colors, More Layouts, Better Pages, More Social Icons, More Skins, More Widgets then please consider upgrading to <a href="https://inkhive.com/product/hanne-plus/" target="_blank">Hanne Plus</a>.','hanne'),
	            'section' => 'hanne_sec_upgrade',
	            'settings' => 'hanne_upgrade',			       
	        )
		)
	);
	
	
	/* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
	function hanne_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return '';
	    }
	}
	
	function hanne_sanitize_positive_number( $input ) {
		if ( ($input >= 0) && is_numeric($input) )
			return $input;
		else
			return '';	
	}
	
	function hanne_sanitize_category( $input ) {
		if ( term_exists(get_cat_name( $input ), 'category') )
			return $input;
		else 
			return '';	
	}
	
}
add_action( 'customize_register', 'hanne_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hanne_customize_preview_js() {
	wp_enqueue_script( 'hanne_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'hanne_customize_preview_js' );
