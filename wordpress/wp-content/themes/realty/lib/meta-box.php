<?php
function estate_register_meta_boxes( $meta_boxes ) {
	
	$prefix = 'estate_';
	
	// Property Agents
	$agents_posts = get_posts( array( 'post_type' => 'agent', 'posts_per_page' => -1 ) );
	$agents = array( 0 => __( 'None', 'tt' ) );
	
	if( !empty( $agents_posts ) ) {
		foreach( $agents_posts as $agent_post ) {
	  	$agents[$agent_post->ID] = $agent_post->post_title;
	  }
	}

	/* PROPERTY
	============================== */
	$meta_boxes[] = array(		
		'id' 						=> 'property_settings',
		'title' 				=> __( 'Property Settings', 'rwmb' ),
		'pages' 				=> array( 'property' ),
		'context' 			=> 'normal',
		'priority' 			=> 'high',
		'autosave' 			=> true,
		'fields' 				=> array(
			array(
				'name' 					=> __( 'Property Layout', 'rwmb' ),
				'id'   					=> "{$prefix}property_layout",
				'desc'  				=> __( 'Choose Property Layout.', 'rwmb' ),
				'type' 					=> 'select',
				'options'  => array(
					'theme_option_setting' 	=> __( 'Theme Option Setting', 'rwmb' ),
					'full_width' 						=> __( 'Full Width', 'rwmb' ),
					'boxed' 								=> __( 'Boxed', 'rwmb' ),
				),
				'std'  					=> 'theme_option_setting',
			),
			array(
				'name' 					=> __( 'Sold', 'rwmb' ),
				'id'   					=> "{$prefix}property_sold",
				'desc'  				=> __( 'Check To Show Property Status "SOLD".', 'rwmb' ),
				'type' 					=> 'checkbox',
				'std'  					=> 0,
			),
			array(
				'name' 					=> __( 'Featured Property', 'rwmb' ),
				'id'   					=> "{$prefix}property_featured",
				'type' 					=> 'checkbox',
				'std'  					=> 0,
			),
			array(
				'name'             => __( 'Property Images', 'rwmb' ),
				'id'               => "{$prefix}property_images",
				'type'             => 'image_advanced',
				'max_file_uploads' => 100,
			),
			array(
				'name'  				=> __( 'Property ID', 'rwmb' ),
				'id'    				=> "{$prefix}property_id",
				'desc'  				=> __( '', 'rwmb' ),
				'type'  				=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name'  				=> __( 'Address', 'rwmb' ),
				'id'    				=> "{$prefix}property_address",
				'desc'  				=> __( '', 'rwmb' ),
				'type'  				=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
        'id'            => "{$prefix}property_location",
        'name'          => __( 'Google Maps' , 'rwmb' ),
        'desc'          => __( 'Enter Property Address Above, Then Click "Find Address" To Search For Exact Location On The Map. Drag & Drop Map Marker If Necessary.' , 'rwmb' ),
        'type'          => 'map',
        'std'           => '', // 'latitude,longitude[,zoom]' (zoom is optional)
        'style'         => 'width: 400px; height: 200px; margin-bottom: 1em',
        'address_field' => "{$prefix}property_address", // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
      ),
			array(
				'name' => __( 'Available From', 'rwmb' ),
				'id'   => "{$prefix}property_available_from",
				'type' => 'date',
				// jQuery date picker options. See here http://api.jqueryui.com/datepicker
				'js_options' => array(
					'appendText'      => __( '(YYYYMMDD)', 'rwmb' ),
					'dateFormat'      => __( 'yymmdd', 'rwmb' ),
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => false,
				),
			),
			array(
				'name'  				=> __( 'Property Price', 'rwmb' ),
				'id'    				=> "{$prefix}property_price",
				'desc'  				=> __( 'Property Sale or Rent Price (Digits Only, i.e. "1000")', 'rwmb' ),
				'type'  				=> 'number',
				'std'   				=> __( '1000', 'rwmb' ),
			),
			array(
				'name'  				=> __( 'Property Price Text', 'rwmb' ),
				'id'    				=> "{$prefix}property_price_text",
				'desc'  				=> __( 'Text After Property Price (i.e. "per month")', 'rwmb' ),
				'type'  				=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name'  				=> __( 'Size', 'rwmb' ),
				'id'    				=> "{$prefix}property_size",
				'desc'  				=> __( 'Property Size (Digits Only, i.e. "250")', 'rwmb' ),
				'type'  				=> 'text',
				'std'   				=> __( '250', 'rwmb' ),
			),
			array(
				'name'  				=> __( 'Size Unit', 'rwmb' ),
				'id'    				=> "{$prefix}property_size_unit",
				'desc'  				=> __( 'Unit Appears After Property Size (i.e. "sq ft")', 'rwmb' ),
				'type'  				=> 'text',
				'std'   				=> __( 'sq ft', 'rwmb' ),
			),
			array(
				'name' 					=> __( 'Rooms', 'rwmb' ),
				'id'   					=> "{$prefix}property_rooms",
				'type' 					=> 'number',
				'prefix' 				=> __( '', 'rwmb' ),
				'suffix' 				=> __( '', 'rwmb' ),
				'js_options' 		=> array(
					'min'   					=> 0,
					'max'   					=> 100,
					'step'  					=> 1,
				),
			),
			array(
				'name' 					=> __( 'Bedrooms', 'rwmb' ),
				'id'   					=> "{$prefix}property_bedrooms",
				'type' 					=> 'number',
				'prefix' 				=> __( '', 'rwmb' ),
				'suffix' 				=> __( '', 'rwmb' ),
				'js_options' 		=> array(
					'min'   					=> 0,
					'max'   					=> 100,
					'step'  					=> 1,
				),
			),
			array(
				'name' 					=> __( 'Bathrooms', 'rwmb' ),
				'id'   					=> "{$prefix}property_bathrooms",
				'type' 					=> 'number',
				'prefix' 				=> __( '', 'rwmb' ),
				'suffix' 				=> __( '', 'rwmb' ),
				'js_options' 		=> array(
					'min'   					=> 0,
					'max'   					=> 100,
					'step'  					=> 1,
				),
			),
			array(
				'name' 					=> __( 'Garages', 'rwmb' ),
				'id'   					=> "{$prefix}property_garages",
				'type' 					=> 'number',
				'prefix' 				=> __( '', 'rwmb' ),
				'suffix' 				=> __( '', 'rwmb' ),
				'js_options' 		=> array(
					'min'   					=> 0,
					'max'   					=> 100,
					'step'  					=> 1,
				),
			),
			array(
				'name'     			=> __( 'Agent', 'rwmb' ),
				'id'       			=> "{$prefix}property_agent",
				'type'     			=> 'select',
				'options'  			=> $agents,
			),
		)
	);
	
	
	/* AGENT
	============================== */
	$meta_boxes[] = array(		
		'id' 						=> 'agent_settings',
		'title' 				=> __( 'Agent Contact Details', 'rwmb' ),
		'pages' 				=> array( 'agent' ),
		'context' 			=> 'normal',
		'priority' 			=> 'high',
		'autosave' 			=> true,
		'fields' 				=> array(
			array(
				'name' 					=> __( 'Email Address', 'rwmb' ),
				'id'   					=> "{$prefix}agent_email",
				'type' 					=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name' 					=> __( 'Office Phone Number', 'rwmb' ),
				'id'   					=> "{$prefix}agent_office_phone_number",
				'type' 					=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name' 					=> __( 'Mobile Phone Number', 'rwmb' ),
				'id'   					=> "{$prefix}agent_mobile_phone_number",
				'type' 					=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name' 					=> __( 'Fax Number', 'rwmb' ),
				'id'   					=> "{$prefix}agent_fax_number",
				'type' 					=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name' 					=> __( 'Facebook', 'rwmb' ),
				'id'   					=> "{$prefix}agent_facebook",
				'type' 					=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name' 					=> __( 'Twitter', 'rwmb' ),
				'id'   					=> "{$prefix}agent_twitter",
				'type' 					=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name' 					=> __( 'Google+', 'rwmb' ),
				'id'   					=> "{$prefix}agent_google",
				'type' 					=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
			array(
				'name' 					=> __( 'LinkedIn', 'rwmb' ),
				'id'   					=> "{$prefix}agent_linkedin",
				'type' 					=> 'text',
				'std'   				=> __( '', 'rwmb' ),
			),
		)
	);
	
	
	/* TESTIMONIAL
	============================== */
	$meta_boxes[] = array(		
		'id' 						=> 'testimonial_settings',
		'title' 				=> __( 'Testimonial', 'rwmb' ),
		'pages' 				=> array( 'testimonial' ),
		'context' 			=> 'normal',
		'priority' 			=> 'high',
		'autosave' 			=> true,
		'fields' 				=> array(
			array(
				'name' 					=> __( 'Testimonial Text', 'rwmb' ),
				'id'   					=> "{$prefix}testimonial_text",
				'type' 					=> 'textarea',
				'std'  					=> __( '', 'rwmb' ),
			),
		)
	);
	
	
	/* POST TYPE "GALLERY"
	============================== */
	$meta_boxes[] = array(		
		'id' 						=> 'post_type_gallery',
		'title' 				=> __( 'Gallery Settings', 'rwmb' ),
		'pages' 				=> array( 'post' ),
		'context' 			=> 'normal',
		'priority' 			=> 'high',
		'autosave' 			=> true,
		'fields' 				=> array(
			array(
				'name'             => __( 'Gallery Images', 'rwmb' ),
				'id'               => "{$prefix}post_gallery",
				'type'             => 'image_advanced',
				'max_file_uploads' => 100,
			),
		)
	);
	
	
	/* POST TYPE "VIDEO"
	============================== */
	$meta_boxes[] = array(		
		'id' 						=> 'post_type_video',
		'title' 				=> __( 'Video Settings', 'rwmb' ),
		'pages' 				=> array( 'post' ),
		'context' 			=> 'normal',
		'priority' 			=> 'high',
		'autosave' 			=> true,
		'fields' 				=> array(
			array(
			'name'	=> 'Full Video URL',
			'id'	=> "{$prefix}post_video_url",
			'desc'	=> 'Insert Full Video URL (i.e. <strong>http://vimeo.com/99370876</strong>)',
			'type' 	=> 'text',
			'std' 	=> ''
		)
		)
	);
	
	
	/* PAGE SETTINGS
	============================== */
	$meta_boxes[] = array(		
		'id' 						=> 'pages_settings',
		'title' 				=> __( 'Page Settings', 'rwmb' ),
		'pages' 				=> array( 'post', 'page', 'property', 'agent' ),
		'context' 			=> 'normal',
		'priority' 			=> 'high',
		'autosave' 			=> true,
		'fields' 				=> array(
			array(
				'name' 					=> __( 'Hide Sidebar', 'rwmb' ),
				'id'   					=> "{$prefix}page_hide_sidebar",
				'type' 					=> 'checkbox',
				'std'  					=> 0,
			),
			// Intro Page Only
			array(
				'name'             => __( 'Intro Fullscreen Background Slideshow Images', 'rwmb' ),
				'id'               => "{$prefix}intro_fullscreen_background_slideshow_images",
				'class'						 => 'intro-only',
				'type'             => 'image_advanced',
				'max_file_uploads' => 100,
			),
			/*
			array(
				'name'             => __( 'Intro Fullscreen Background Video URL', 'rwmb' ),
				'id'               => "{$prefix}intro_fullscreen_background_video_url",
				'class'						 => 'intro-only',
				'type'             => 'text',
				'desc'						 => 'Insert Full Video URL (i.e. <strong>https://www.youtube.com/watch?v=0q_oXY0thxo</strong>)',
			),
			*/
		)
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'estate_register_meta_boxes' );