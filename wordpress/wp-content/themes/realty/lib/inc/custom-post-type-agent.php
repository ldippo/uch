<?php
/* CUSTOM POST TYPE: AGENT
============================== */
function tt_register_custom_post_type_agent() {

	$labels = array(
    'name' 									=> __( 'Agents','tt' ),
    'singular_name' 				=> __( 'Agent','tt' ),
    'add_new' 							=> __( 'Add New','tt' ),
    'add_new_item' 					=> __( 'Add New Agent','tt' ),
    'edit_item' 						=> __( 'Edit Agent','tt' ),
    'new_item' 							=> __( 'New Agent','tt' ),
    'view_item' 						=> __( 'View Agent','tt' ),
    'search_items' 					=> __( 'Search Agent','tt' ),
    'not_found' 						=> __( 'No Agent found.','tt' ),
    'not_found_in_trash' 		=> __( 'No Agent found in Trash.','tt' )
  );

  $args = array(
	  'labels' 								=> $labels,
	  'public' 								=> true,
	  'show_ui' 							=> true,
	  'show_in_admin_bar' 		=> true,
	  'menu_position' 				=> 20,
	  'menu_icon' 						=> 'dashicons-businessman',
	  'exclude_from_search' 	=> true,
	  'publicly_queryable' 		=> true,
	  'query_var' 						=> true,
	  'rewrite' 							=> true,
	  'hierarchical' 					=> true,
	  'supports' 							=> array( 'title', 'editor', 'thumbnail' ),
	  'rewrite' 							=> array( 'slug' => __( 'agent', 'tt' ) )
  );
	
	register_post_type( 'agent', $args );

}
add_action( 'init', 'tt_register_custom_post_type_agent' );

// Custom Property Columns
function tt_agent_columns( $property_columns ) {
  $property_columns = array(
      'cb' 				=> '<input type=\'checkbox\' />',
      'thumbnail'	=> __( 'Thumbnail','tt' ),
      'title'			=> __( 'Agent Name','tt' ),
      'email' 		=> __( 'Email','tt' ),
      'office' 		=> __( 'Office','tt' ),
      'mobile' 		=> __( 'Mobile','tt' ),
      'fax' 			=> __( 'Fax','tt' ),
      'date' 			=> __( 'Joined','tt' )
  );
  return $property_columns;
}
add_filter('manage_edit-agent_columns', 'tt_agent_columns');

function tt_agent_custom_columns( $property_column ) {
  
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
    case 'email' :
      echo get_post_meta( $post->ID, 'estate_agent_email', true ); 
      break;
    case 'office' :
      echo get_post_meta( $post->ID, 'estate_agent_office_phone_number', true ); 
      break;      
    case 'mobile' :
      echo get_post_meta( $post->ID, 'estate_agent_mobile_phone_number', true ); 
      break;
    case 'fax' :
      echo get_post_meta( $post->ID, 'estate_agent_fax_number', true ); 
      break;     
  }
  
}
add_action('manage_agent_posts_custom_column', 'tt_agent_custom_columns');

?>