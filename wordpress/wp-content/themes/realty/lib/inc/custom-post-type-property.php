<?php
/* CUSTOM POST TYPE: PROPERTY
============================== */
function tt_register_custom_post_type_property() {

  $labels = array(
    'name' 									=> __( 'Properties','tt' ),
    'singular_name' 				=> __( 'Property','tt' ),
    'add_new' 							=> __( 'Add New','tt' ),
    'add_new_item' 					=> __( 'Add New Property','tt' ),
    'edit_item' 						=> __( 'Edit Property','tt' ),
    'new_item' 							=> __( 'New Property','tt' ),
    'view_item' 						=> __( 'View Property','tt' ),
    'search_items' 					=> __( 'Search Property','tt' ),
    'not_found' 						=> __( 'No Property found.','tt' ),
    'not_found_in_trash' 		=> __( 'No Property found in Trash.','tt' )
  );

  $args = array(
	  'labels' 								=> $labels,
	  'public' 								=> true,
	  'show_ui' 							=> true,
	  'show_in_admin_bar' 		=> true,
	  'menu_position' 				=> 20,
	  'menu_icon' 						=> 'dashicons-admin-home',
	  'publicly_queryable' 		=> true,
	  'query_var' 						=> true,
	  'rewrite' 							=> true,
	  'hierarchical' 					=> true,
	  'supports' 							=> array( 'title', 'editor', 'thumbnail', 'author', 'page-attributes' ),
	  'rewrite' 							=> array( 'slug' => __( 'property', 'tt' ) )
  );

  register_post_type( 'property', $args );

}

register_taxonomy( 'property-location', 'property', array(  
    'labels' 						=> array(
    	'name' 												=> __( 'Property Location', 'tt' ),
    	'singular_name' 							=> __( 'Property Location', 'tt' ),
    	'search_items' 								=> __( 'Search Property Location', 'tt' ),
    	'popular_items' 							=> __( 'Popular Property Location', 'tt' ),
    	'all_items' 									=> __( 'All Property Location', 'tt' ),
    	'edit_item' 									=> __( 'Edit Property Location', 'tt' ),
    	'update_item' 								=> __( 'Update Property Location', 'tt' ),
    	'add_new_item' 								=> __( 'Add New Property Location', 'tt' ),
    	'new_item_name' 							=> __( 'New Property Location Name', 'tt' ),
    	'separate_items_with_commas' 	=> __( 'Separate Property Location With Commas', 'tt' ),
    	'add_or_remove_items' 				=> __( 'Add or Remove Property Location', 'tt' ),
    	'choose_from_most_used' 			=> __( 'Choose From Most Used Property Location', 'tt' ),  
    	'parent' 											=> __( 'Parent Property Location', 'tt' )      	
    	),
    'hierarchical'			=> true,
    'query_var' 				=> true,  
    'rewrite' 					=> array( 'slug' => __('property-location', 'tt') ),
    'show_ui'           => true, // Whether to generate a default UI for managing this taxonomy
		'show_admin_column' => true, // Whether to allow automatic creation of taxonomy columns on associated post-Locations table
	)  
);

register_taxonomy( 'property-status', 'property', array(  
    'labels' 						=> array(
    	'name' 												=> __( 'Property Status', 'tt' ),
    	'singular_name' 							=> __( 'Property Status', 'tt' ),
    	'search_items' 								=> __( 'Search Property Status', 'tt' ),
    	'popular_items' 							=> __( 'Popular Property Status', 'tt' ),
    	'all_items' 									=> __( 'All Property Status', 'tt' ),
    	'edit_item' 									=> __( 'Edit Property Status', 'tt' ),
    	'update_item' 								=> __( 'Update Property Status', 'tt' ),
    	'add_new_item' 								=> __( 'Add New Property Status', 'tt' ),
    	'new_item_name' 							=> __( 'New Property Status Name', 'tt' ),
    	'separate_items_with_commas' 	=> __( 'Separate Property Status With Commas', 'tt' ),
    	'add_or_remove_items' 				=> __( 'Add or Remove Property Status', 'tt' ),
    	'choose_from_most_used' 			=> __( 'Choose From Most Used Property Status', 'tt' ),  
    	'parent' 											=> __( 'Parent Property Status', 'tt' )      	
    	),
    'hierarchical'			=> true,
    'query_var' 				=> true,  
    'rewrite' 					=> array( 'slug' => __('property-status', 'tt') ),
    'show_ui'           => true, // Whether to generate a default UI for managing this taxonomy
		'show_admin_column' => true, // Whether to allow automatic creation of taxonomy columns on associated post-Statuss table
	)  
);

register_taxonomy( 'property-type', 'property', array(  
    'labels' 						=> array(
    	'name' 												=> __( 'Property Type', 'tt' ),
    	'singular_name' 							=> __( 'Property Type', 'tt' ),
    	'search_items' 								=> __( 'Search Property Type', 'tt' ),
    	'popular_items' 							=> __( 'Popular Property Type', 'tt' ),
    	'all_items' 									=> __( 'All Property Type', 'tt' ),
    	'edit_item' 									=> __( 'Edit Property Type', 'tt' ),
    	'update_item' 								=> __( 'Update Property Type', 'tt' ),
    	'add_new_item' 								=> __( 'Add New Property Type', 'tt' ),
    	'new_item_name' 							=> __( 'New Property Type Name', 'tt' ),
    	'separate_items_with_commas' 	=> __( 'Separate Property Type With Commas', 'tt' ),
    	'add_or_remove_items' 				=> __( 'Add or Remove Property Type', 'tt' ),
    	'choose_from_most_used' 			=> __( 'Choose From Most Used Property Type', 'tt' ),  
    	'parent' 											=> __( 'Parent Property Type', 'tt' )      	
    	),
    'hierarchical'			=> true,
    'query_var' 				=> true,  
    'rewrite' 					=> array( 'slug' => __('property-type', 'tt') ),
    'show_ui'           => true, // Whether to generate a default UI for managing this taxonomy
		'show_admin_column' => true, // Whether to allow automatic creation of taxonomy columns on associated post-types table
	)  
);

register_taxonomy( 'property-features', 'property', array(  
    'labels' 						=> array(
    	'name' 												=> __( 'Property Features', 'tt' ),
    	'singular_name' 							=> __( 'Property Features', 'tt' ),
    	'search_items' 								=> __( 'Search Property Features', 'tt' ),
    	'popular_items' 							=> __( 'Popular Property Features', 'tt' ),
    	'all_items' 									=> __( 'All Property Features', 'tt' ),
    	'edit_item' 									=> __( 'Edit Property Features', 'tt' ),
    	'update_item' 								=> __( 'Update Property Features', 'tt' ),
    	'add_new_item' 								=> __( 'Add New Property Features', 'tt' ),
    	'new_item_name' 							=> __( 'New Property Features Name', 'tt' ),
    	'separate_items_with_commas' 	=> __( 'Separate Property Features With Commas', 'tt' ),
    	'add_or_remove_items' 				=> __( 'Add or Remove Property Features', 'tt' ),
    	'choose_from_most_used' 			=> __( 'Choose From Most Used Property Features', 'tt' ),  
    	'parent' 											=> __( 'Parent Property Features', 'tt' )      	
    	),
    'hierarchical'			=> true,
    'query_var' 				=> true,  
    'rewrite' 					=> array( 'slug' => __('property-feature', 'tt') ),
    'show_ui'           => true, // Whether to generate a default UI for managing this taxonomy
		'show_admin_column' => true, // Whether to allow automatic creation of taxonomy columns on associated post-types table
	)  
);


add_action('init', 'tt_register_custom_post_type_property');


// Custom Property Columns
function tt_property_columns( $property_columns ) {
  $property_columns = array(
      'cb' 				=> '<input type=\'checkbox\' />',
      'thumbnail'	=> __( 'Thumbnail','tt' ),
      'title' 		=> __( 'Property Name','tt' ),
      'featured' 	=> __( 'Featured','tt' ),
      'address' 	=> __( 'Address','tt' ),
      'location' 	=> __( 'Location','tt' ),
      'status' 		=> __( 'Status','tt' ),
      'type' 			=> __( 'Type','tt' ),
      'features' 	=> __( 'Features','tt' ),
      'price' 		=> __( 'Price','tt' ),      
      'date' 			=> __( 'Published','tt' )
  );
  return $property_columns;
}
add_filter('manage_edit-property_columns', 'tt_property_columns');

function tt_property_custom_columns( $property_column ) {
  
  global $post;
  
  switch ( $property_column ) {
    case 'thumbnail' :
      if( has_post_thumbnail( $post->ID ) ) {
      	the_post_thumbnail( 'thumbnail' );
      }
      else{
      	_e( '-', 'tt' );
      }
      break;
    case 'featured' :
      if( get_post_meta( $post->ID, 'estate_property_featured', true ) ) {
      	_e( 'Yes', 'tt' );
      }
      else{
      	_e( 'No', 'tt' );
      }
      break;
    case 'address' :
      $address = get_post_meta( $post->ID, 'estate_property_address', true );
      if( !empty( $address ) ) {
      	echo $address;
      }
      else{
      	_e( 'No Address Provided', 'tt' );
      }
      break;
    case 'location' :
      echo get_the_term_list( $post->ID, 'property-location', '', ', ', '' );
      break;
    case 'status' :
      echo get_the_term_list( $post->ID, 'property-status', '', ', ', '' );
      break;      
    case 'type' :
      echo get_the_term_list( $post->ID, 'property-type', '', ', ', '' );
      break;
    case 'features' :
      echo get_the_term_list( $post->ID, 'property-features', '', ', ', '' );
      break;
		case 'price' :
			$properts_price = tt_property_price();
      if ( empty( $properts_price ) ) {
	      _e( '-', 'tt' );
      }
      else {
	      echo $properts_price;
      }
      break;      
  }
  
}
add_action('manage_property_posts_custom_column', 'tt_property_custom_columns');