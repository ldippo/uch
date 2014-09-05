<?php

/* THEME CONTENT WIDTH
============================== */
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

/* THEME VARIABLES
============================== */
define('TT_LIB', get_template_directory()  . '/lib');
define('TT_LIB_URI', get_template_directory_uri()  . '/lib');


/* METABOXES
 * https://github.com/rilwis/meta-box
============================== */
define( 'RWMB_URL', trailingslashit( TT_LIB_URI . '/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( TT_LIB . '/meta-box' ) );
require_once TT_LIB . '/meta-box/meta-box.php';
include_once TT_LIB . '/meta-box.php';


/* REDUX FRAMEWORK - THEME OPTIONS
============================== */
if ( !class_exists( 'ReduxFramework' ) && file_exists( TT_LIB . '/redux/ReduxCore/framework.php' ) ) {
	require_once( TT_LIB . '/redux/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( TT_LIB . '/redux/realty/realty-config.php' ) ) {
	require_once( TT_LIB . '/redux/realty/realty-config.php' );
}


/* REDUX FRAMEWORK - ADD FONTAWESOME ICON FONT
============================== */
function tt_themeOptionsStyles($hook) {
	if( 'themes.php?page=_options' == $hook ) {
  	return;
  }
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), time(), 'all' );  
	wp_enqueue_style( 'redux-custom-css', TT_LIB_URI . '/redux/realty/style.css', array( 'redux-css' ), time(), 'all' );  
}
add_action( 'admin_enqueue_scripts', 'tt_themeOptionsStyles' );


/* TGM PLUGIN ACTIVATION
============================== */
require_once TT_LIB . '/tgm/class-tgm-plugin-activation.php';
require_once TT_LIB . '/tgm/plugins.php';


/* CUSTOM POST TYPES
============================== */
require_once ( TT_LIB . '/inc/custom-post-type-property.php' );
require_once ( TT_LIB . '/inc/custom-post-type-agent.php' );
require_once ( TT_LIB . '/inc/custom-post-type-testimonial.php' );


/* WIDGETS
============================== */
require_once ( TT_LIB . '/widgets/widget-agents.php' );
require_once ( TT_LIB . '/widgets/widget-featured-properties.php' );
require_once ( TT_LIB . '/widgets/widget-latest-posts.php' );
require_once ( TT_LIB . '/widgets/widget-property-search.php' );
require_once ( TT_LIB . '/widgets/widget-testimonials.php' );



/* OTHER INCLUDES
============================== */
require_once ( TT_LIB . '/shortcodes.php' );
require_once ( TT_LIB . '/tinymce/tinymce-buttons.php' );


/* LOAD ADMIN SCRIPT
============================== */
function tt_admin_scripts() {	

	wp_register_script('tt-admin-script', get_template_directory_uri() . '/assets/js/admin.js' );
	wp_enqueue_script('tt-admin-script');
	
	wp_enqueue_style('tinymce', get_template_directory_uri() . '/lib/tinymce/tinymce-style.css', null, null );
	
	// Absolute Template Path
  $tt_abs_path = array( 'template_url' => get_template_directory_uri() );
  wp_localize_script( 'jquery', 'abspath', $tt_abs_path );
  
}
add_action('admin_enqueue_scripts', 'tt_admin_scripts');


/* ENQUEUES
============================== */
function tt_realty_scripts() {
	
	// Stylesheets
	//wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', null, null );
	//wp_enqueue_style( 'bootstrap', '//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', null, null );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', null, '4.1.0' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', null, '3.2.0' );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/assets/css/flexslider.css', null, null );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/css/owl2.carousel.css', null, null );
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Lato:100,100italic,300,300italic,regular,italic,700,700italic,900,900italic', null, null );	
	wp_enqueue_style( 'chosen-select', get_template_directory_uri() . '/assets/chosen/chosen.css', null, null );
	wp_enqueue_style( 'style', get_stylesheet_uri(), null, null );
	wp_enqueue_style( 'print', get_template_directory_uri() . '/print.css', null, null, 'print' );
	//wp_enqueue_style( 'leaflet', '//cdn.leafletjs.com/leaflet-0.7/leaflet.css', array( 'jquery'), null, null );
	//wp_enqueue_style( 'markercluster', get_template_directory_uri() . '/assets/css/MarkerCluster.css', null, null );
	//wp_enqueue_style( 'markercluster-default', get_template_directory_uri() . '/assets/css/MarkerCluster.Default.css', null, null );
	
	/* Move All Scripts in Footer
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);
	*/
	
	// Scripts
	wp_enqueue_script( 'jquery', null, null, false );
	wp_enqueue_script( 'bootstrap', '//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'throttledresize', get_template_directory_uri() . '/assets/js/jquery.throttledresize.js', array( 'jquery' ), null, true ); 
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl2.carousel.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'owl-carousel-navigation', get_template_directory_uri() . '/assets/js/owl2.navigation.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'owl-carousel-autoheight', get_template_directory_uri() . '/assets/js/owl2.autoheight.js', array( 'jquery' ), null, true );
	
	global $realty_theme_option;
	// Check if Theme Option for "Google Maps API" is on/off, to avoid duplicate API load
	$disableGoogleMapsApi = $realty_theme_option['disable-google-maps-api'];
	if ( !is_page_template('template-idx.php') && $disableGoogleMapsApi == false ) {
	wp_enqueue_script( 'google-maps-api', '//maps.google.com/maps/api/js?sensor=false', array( 'jquery' ), null, false );
	}
	if ( !is_page_template('template-idx.php') ) {
	wp_enqueue_script( 'google-maps-markerclusterer', get_template_directory_uri() . '/assets/js/google.maps.markerclusterer.js', array( 'jquery' ), null, false );
	wp_enqueue_script( 'google-maps-infobox', get_template_directory_uri() . '/assets/js/google.maps.infobox.js', array( 'jquery' ), null, false );
	}
	
	//wp_enqueue_script( 'leaflet', '//cdn.leafletjs.com/leaflet-0.7/leaflet.js', array( 'jquery'), '0.7', true );
	//wp_enqueue_script( 'markercluster', get_template_directory_uri() . '/assets/js/leaflet.markercluster-src.js', array( 'jquery' ), null, true );
	
	wp_enqueue_script( 'form', get_template_directory_uri() . '/assets/js/jquery.form.js', array( 'jquery'), '3.51', true );
	wp_enqueue_script( 'validate', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array( 'jquery'), '1.13.0', true );
	wp_enqueue_script( 'additional-methods', get_template_directory_uri() . '/assets/js/additional-methods.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'datepicker', get_template_directory_uri() . '/assets/js/bootstrap-datepicker/bootstrap-datepicker.js', array( 'jquery' ), null, true );
	// Property Search: Datepicker Languages
	wp_enqueue_script( 'datepicker-de', get_template_directory_uri() . '/assets/js/bootstrap-datepicker/locales/bootstrap-datepicker.de.js', array( 'datepicker' ), null, true ); 
	wp_enqueue_script( 'datepicker-es', get_template_directory_uri() . '/assets/js/bootstrap-datepicker/locales/bootstrap-datepicker.es.js', array( 'datepicker' ), null, true ); 
	wp_enqueue_script( 'datepicker-fr', get_template_directory_uri() . '/assets/js/bootstrap-datepicker/locales/bootstrap-datepicker.fr.js', array( 'datepicker' ), null, true ); 
	wp_enqueue_script( 'chosen-select', get_template_directory_uri() . '/assets/chosen/chosen.jquery.js', array( 'jquery' ), null, true );	
	wp_enqueue_script( 'intense-images', get_template_directory_uri() . '/assets/js/intense.min.js', array( 'jquery' ), null, true );	
	wp_enqueue_script( 'theme', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'ajax', get_template_directory_uri() . '/assets/js/ajax.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'theme-google-maps-api', get_template_directory_uri() . '/assets/js/theme-google-maps-api.js', array( 'jquery' ), null, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'tt_realty_scripts' );


/* CUSTOM LOGIN PAGE (wp-login.php)
============================== */
function tt_custom_login() {

	// Login Page Logo
	$output  = '<style type="text/css">';
	global $realty_theme_option;
	if ( !empty( $realty_theme_option['logo-login'] ) ) {
		$site_logo = $realty_theme_option['logo-login']['url'];
		$output .= '.login h1 a { background: url(' . $site_logo . ') 50% 50% no-repeat !important; width: auto; }';
	}
	$output .= '.login { background-color: #f8f8f8; }';
	$output .= '.login form input[type="submit"] { border-radius: 0; border: none; -webkit-box-shadow: none; box-shadow: none; }';
	$output .= '.login form .input, .login .form input:focus { padding: 5px 10px; color: #666; -webkit-box-shadow: none; box-shadow: none; }';
	$output .= 'input[type=checkbox]:focus, input[type=email]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=url]:focus, select:focus, textarea:focus { -webkit-box-shadow: none; box-shadow: none; }';
	$output .= '</style>';
	
	echo $output;
	
	// Remove Login Shake
	remove_action('login_head', 'wp_shake_js', 12);

}
add_action('login_head', 'tt_custom_login');

// Login Logo Link
function tt_wp_login_url() {
	return home_url();
}
add_filter('login_headerurl', 'tt_wp_login_url');


/* SETUP THEME
============================== */
function tt_estate_setup() {
	
	// Make theme available for translation.
	load_theme_textdomain( 'tt', get_template_directory() . '/languages' );
	
	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( 'assets/css/editor-styles.css' );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	
	// Enable support for Post Thumbnails and declare custom sizes.
	add_theme_support( 'post-thumbnails' );
	
	// Custom Image Sizes
	add_image_size( 'thumbnail-1200', 1200, 9999, false );
	add_image_size( 'thumbnail-16-9', 1200, 675, true );
	add_image_size( 'thumbnail-1200-400', 1200, 400, true );
	add_image_size( 'thumbnail-400-300', 400, 300, true );	
	add_image_size( 'property-thumb', 600, 300, true );
	add_image_size( 'square-400', 400, 400, true );
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array( 'primary' => __( 'Main Menu', 'tt' ) ) );
	register_nav_menus( array( 'footer' => __( 'Footer Menu', 'tt' ) ) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', ) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'image', 'gallery', 'video' ) );

}
add_action( 'after_setup_theme', 'tt_estate_setup' );


/* Sidebars
============================== */

// if no title then add widget content wrapper to before widget
// http://wordpress.stackexchange.com/questions/74732/adding-a-div-to-wrap-widget-content-after-the-widget-title
function tt_check_sidebar_params( $params ) {
  global $wp_registered_widgets;

  $settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
  $settings = $settings_getter->get_settings();
  $settings = $settings[ $params[1]['number'] ];

  if ( $params[0][ 'after_widget' ] == '</div></li>' && isset( $settings[ 'title' ] ) && empty( $settings[ 'title' ] ) )
  	$params[0][ 'before_widget' ] .= '<div class="widget-content empty-title">';
		
  return $params;
}
add_filter( 'dynamic_sidebar_params', 'tt_check_sidebar_params' );

register_sidebar(
	array(
		'name'						=> __( 'Blog Sidebar', 'tt' ),
		'id'   						=> 'sidebar_blog',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'						=> __( 'Property Sidebar', 'tt' ),
		'id'   						=> 'sidebar_property',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'						=> __( 'Agent Sidebar', 'tt' ),
		'id'   						=> 'sidebar_agent',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'						=> __( 'Page Sidebar', 'tt' ),
		'id'   						=> 'sidebar_page',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'						=> __( 'Contact Sidebar', 'tt' ),
		'id'   						=> 'sidebar_contact',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'						=> __( 'IDX Sidebar', 'tt' ),
		'id'   						=> 'sidebar_idx',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'						=> __( 'Footer Column 1', 'tt' ),
		'id'   						=> 'sidebar_footer_1',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'						=> __( 'Footer Column 2', 'tt' ),
		'id'   						=> 'sidebar_footer_2',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'						=> __( 'Footer Column 3', 'tt' ),
		'id'   						=> 'sidebar_footer_3',
		'before_widget' 	=> '<li id="%2$s" class="widget">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);


/* WordPress AJAX API for Search Form
============================== */
function tt_ajax_url() {
?>
<script type="text/javascript">
var ajaxURL = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php 
}
add_action('wp_head','tt_ajax_url');


/* AJAX Search
============================== */
function tt_ajax_search() {
	
	// Build Property Search Query
	$search_results_args = array();
	$search_results_args = apply_filters( 'property_search_args', $search_results_args );
	$count_results = "0";
	
	$query_search_results = new WP_Query( $search_results_args );
	
	if ( !isset( $orderby ) || empty( $orderby ) ) {
		$orderby = "date-new";
	}
	
	if ( $query_search_results->have_posts() ) :
	
	$count_results = $query_search_results->found_posts;
	// template-property-search.php
	?>
	<ul class="row list-unstyled">	
		<?php
		while ( $query_search_results->have_posts() ) : $query_search_results->the_post();
		global $realty_theme_option;
		$columns = $realty_theme_option['property-listing-columns'];
		if ( empty($columns) ) {
			$columns = "col-md-6";
		}
		?>
		<li class="<?php echo $columns; ?>">
			<?php get_template_part( 'lib/inc/template/property', 'item' );	?>
		</li>
		<?php endwhile; ?>
		
	</ul>
	<?php wp_reset_query(); ?>

	<div id="pagination">
	<?php
	// Built Property Pagination
	$big = 999999999; // need an unlikely integer

	echo paginate_links( array(
		'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' 			=> '?page=%#%',
		'total' 			=> $query_search_results->max_num_pages,
		'show_all'		=> true,
		'type'				=> 'list',
		'current'     => $search_results_args['paged'],
		'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
		'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
	) );
	?>
	</div>
	
	<?php
	else : ?>
	<p class="lead text-center text-muted"><?php _e( 'No Properties Match Your Search Criteria.', 'tt' ); ?></p>
	<?php
	endif;
	?>
	
	<script>
	jQuery('.search-results-header, #property-search-results').fadeOut(0);
	<?php 
	// No Results Found
	if ( $count_results == "0" ) { ?>
	jQuery('#map-overlay-no-results, #property-search-results').fadeIn();
	<?php }
	// Results Found
	else {
	// AJAX Refresh Property Map Markers
	$search_results_args['posts_per_page'] = -1;
	$query_search_results = new WP_Query( $search_results_args );
	
	if ( $query_search_results->have_posts() ) :
	
	$property_string = '';
	$i = 0;

	while ( $query_search_results->have_posts() ) : $query_search_results->the_post(); 
	global $post;
	$google_maps = get_post_meta( $post->ID, 'estate_property_location', true );
	
	// Check For Map Coordinates
	if ( $google_maps ) {	
		
		$coordinate = explode( ',', $google_maps );	
		$property_string .= '{ ';	
		$property_string .= 'permalink:"' . get_permalink() . '", ';
		$property_string .= 'title:"' . get_the_title() . '", ';
		$property_string .= 'price:"' . tt_property_price() . '", ';
		$property_string .= 'latLng: new google.maps.LatLng(' . $coordinate[0] . ', ' . $coordinate[1] . '), ';
		if ( has_post_thumbnail() ) { 
			$property_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			$property_string .= 'thumbnail: "' . $property_thumbnail[0] . '"';
		}	
		else { 
			$property_string .= 'thumbnail: "//placehold.it/300x100/eee/ccc/&text=.."';
		}
		$property_string .= ' },' . "\n";
	}
	
	$i++;
	endwhile;
	wp_reset_query();
	endif;
	?>	
	bounds = new google.maps.LatLngBounds();
	
	initMarkers(map, [ <?php echo $property_string; ?> ]);
	markerCluster = new MarkerClusterer(map, newMarkers, markerClusterOptions);
	
	google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
		map.fitBounds(bounds);
		if (this.getZoom() > 13) {
	    this.setZoom(13);
	  }
	});
	
	jQuery('#map-overlay-no-results').fadeOut();
	jQuery('.search-results-header, #property-search-results').fadeIn();
	jQuery('.page-title span').html(<?php echo $count_results; ?>);
	<?php } ?>
	</script>
	
	<?php
	
	die();
	
}
add_action('wp_ajax_tt_ajax_search', 'tt_ajax_search');
add_action('wp_ajax_nopriv_tt_ajax_search', 'tt_ajax_search');	


/* Excerpt
============================== */
function tt_excerpt_more( $more ) {
	return ' ..';
}
add_filter('excerpt_more', 'tt_excerpt_more');

function tt_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'tt_excerpt_length', 999 );


/* PROPERTY
============================== */

// Property Price
function tt_property_price() {
	
	global $post, $realty_theme_option;
	
	$property_price = doubleval( get_post_meta( $post->ID, 'estate_property_price', true ) );
	$property_price_text = get_post_meta( $post->ID, 'estate_property_price_text', true );
	
	$currency_sign = $realty_theme_option['currency-sign'];
	$currency_sign_position = $realty_theme_option['currency-sign-position'];
	$price_thousands_separator = $realty_theme_option['price-thousands-separator'];
	$decimals = 0;
	$decimal_point = '.';
	
	// Default Currency Sign "$"
	if ( empty( $currency_sign ) ) {
  	$currency_sign = __( '$', 'tt' );
  }
    
	if( $property_price ) {

		$formatted_price = number_format( $property_price, $decimals, $decimal_point, $price_thousands_separator );
		
		if( $currency_sign_position == 'right' ) {
			$output = $formatted_price . $currency_sign;
		}
		else {
			$output = $currency_sign . $formatted_price;
		}
		
		if ( $property_price_text ) {
			$output .= '<span>' . $property_price_text . '</span>';
		}
		
	}
	else {
		$output = false;
	}
	
	return $output;
	
}

// New Property
function tt_icon_new_property() {

	// Current Date
	$today = date( 'r' );
	// Property Publishing Date
	$property_published = get_the_time( 'r' );
	// Property Age in Days
	$property_age = round( (strtotime( $today ) - strtotime( $property_published ) ) / ( 24 * 60 * 60 ),0 );
	
	// If Property Publishing Date is .. days or less, show New Icon
	global $realty_theme_option;
	$new_days_integer = $realty_theme_option['property-new-badge'];
	if ( $new_days_integer && $property_age <= $new_days_integer ) {
		return '<i class="fa fa-fire" data-toggle="tooltip" title="' . __( 'New Offer', 'tt' ) . '"></i>';
	}
	else {
		return false;
	}

}

// Featured Property
function tt_icon_property_featured() {
	
	$property_featured = get_post_meta( get_the_ID(), 'estate_property_featured', true );
	if ( $property_featured ) {
		echo '<i class="fa fa-star" data-toggle="tooltip" title="' . __( 'Featured Property', 'tt' ) . '"></i>';
	}
	else {
		return false;
	}
	
}

// Property Address
function tt_icon_property_address() {
	
	$property_address = get_post_meta( get_the_ID(), 'estate_property_address', true ); 
	if ( $property_address ) {
		echo '<i class="fa fa-map-marker" data-toggle="tooltip" title="' . $property_address . '"></i>';
	}
	else {
		return false;
	}
	
}


/* PROPERTY SEARCH QUERY ARGUMENTS
============================== */

function tt_property_search_args($search_results_args) {
	
	$search_results_args['post_type'] = 'property';
	$search_results_args['paged'] = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	
	global $realty_theme_option;
	$search_results_per_page = $realty_theme_option['search-results-per-page'];
	
	// Search Results Per Page: Check for Theme Option
	if ( $search_results_per_page ) {
		$search_results_args['posts_per_page'] = $search_results_per_page;
	}
	else {
		$search_results_args['posts_per_page'] = 10;
	}
	
	// Search Results Order
	if( !empty( $_GET[ 'orderby' ] ) ) {
		
		$orderby = $_GET[ 'orderby' ];
		
		// By Date (Newest First)
		if ( $orderby == 'date-new' ) {
			$search_results_args['orderby'] = 'date';
			$search_results_args['order'] = 'DESC';
		}
		
		// By Date (Oldest First)
		if ( $orderby == 'date-old' ) {
			$search_results_args['orderby'] = 'date';
			$search_results_args['order'] = 'ASC';
		}
		
		// By Price (Highest First)
		if ( $orderby == 'price-high' ) {
			$search_results_args['meta_key'] = 'estate_property_price';
			$search_results_args['orderby'] = 'meta_value_num';
			$search_results_args['order'] = 'DESC';
		}
		
		// By Price (Lowest First)
		if ( $orderby == 'price-low' ) {
			$search_results_args['meta_key'] = 'estate_property_price';
			$search_results_args['orderby'] = 'meta_value_num';
			$search_results_args['order'] = 'ASC';
		}
		
		// Random
		if ( $orderby == 'random' ) {
			$search_results_args['orderby'] = 'rand';
		}
		
	}
	else {
		$orderby = '';
	}
	
	/* META QUERIES: 
	============================== */
	
	$meta_query = array();
	
	// Property ID
	if( !empty( $_GET[ 'id' ] ) ) {
		$search_id = $_GET['id'];
		$meta_query[] = array(
			'key' 			=> 'estate_property_id',
			'value' 		=> $search_id
		);
	}
	
	// Max. Price
	if( !empty( $_GET[ 'max-price' ] ) ) {
		$max_price = $_GET['max-price'];
		$max_price = number_format( $max_price, 0, '', '' );
		$meta_query[] = array(
			'key' 			=> 'estate_property_price',
			'value' 		=> $max_price,
			'type' 			=> 'NUMERIC',
	    'compare' 	=> '<='
		);
	}
	
	// Min. Rooms
	if( !empty( $_GET[ 'min-rooms' ] ) ) {
		$min_rooms = $_GET['min-rooms'];
		$min_rooms = number_format( $min_rooms, 0, '', '' );
		$meta_query[] = array(
			'key' 			=> 'estate_property_rooms',
			'value' 		=> $min_rooms,
			'type' 			=> 'NUMERIC',
	    'compare' 	=> '>='
		);
	}
	
	// Available From
	if( !empty( $_GET[ 'datepicker' ] ) ) {
		$datepicker = $_GET['datepicker'];
		$meta_query[] = array(
			'key' 			=> 'estate_property_available_from',
			'value' 		=> $datepicker,
			'type' 			=> 'DATE',
	    'compare' 	=> '<='
		);
		
	}
	
	//echo $datepicker;
	
	// Count Meta Queries + set their relation for search query
	$meta_count = count( $meta_query );
	if ( $meta_count > 1 ) {
	  $meta_query['relation'] = 'AND';
	}
	
	if ( $meta_count > 0 ) {
		$search_results_args['meta_query'] = $meta_query;
	}
			
	/* TAX QUERIES: 
	============================== */
	
	$tax_query = array();
	
	// Property Location
	if( !empty( $_GET[ 'location' ] ) ) {
		$search_location = $_GET['location'];
		if ( $search_location != "all" ) {
			$tax_query[] = array(
				'taxonomy' 	=> 'property-location',
				'field' 		=> 'slug',
				'terms'			=> $search_location
			);
		}
	}
	
	// Property Type		
	if( !empty( $_GET[ 'type' ] ) ) {
		$search_type = $_GET['type'];
		if ( $search_type != "all" ) {
			$tax_query[] = array(
				'taxonomy' 	=> 'property-type',
				'field' 		=> 'slug',
				'terms'			=> $search_type
			);
		}				
	}
	
	// Property Status
	if( !empty( $_GET[ 'status' ] ) ) {
		$search_status = $_GET['status'];		
		if ( $search_status && $search_status != "all" ) {
			$tax_query[] = array(
				'taxonomy' 	=> 'property-status',
				'field' 		=> 'slug',
				'terms'			=> $search_status
			);
		}
	}
	
	// Count Taxonomy Queries + set their relation for search query
	$tax_count = count( $tax_query );
	if ( $tax_count > 1 ) {
		$tax_query['relation'] = 'AND';
	}
	
	if ( $tax_count > 0 ) {
		$search_results_args['tax_query'] = $tax_query;
	}
	
	return $search_results_args;

}
add_filter( 'property_search_args', 'tt_property_search_args' );


/* CONTACT FORM - Single Property
============================== */

function submit_property_contact_form() {

	if ( wp_verify_nonce( $_POST['nonce'] ) && !empty( $_POST['email'] ) && !empty( $_POST['message'] ) ) {
		
		$property_title = $_POST['property_title'];
		$property_url = $_POST['property_url'];
		
		$recipient = $_POST['agent_email'];
		$subject = __( 'Property', 'tt' ) . ' - '. $property_title;
		$name = $_POST['name'];
	  $email = $_POST['email'];
	  $phone = '-';
	  $phone = $_POST['phone'];
		$headers = array();
	  $headers[] = "From: $name <$email>";
	  
	  $message = __( 'Name:', 'tt' ) . ' ' . $name . "\r\n" . __( 'Phone:', 'tt' ) . ' ' . $phone . "\r\n" . __( 'Property:', 'tt' ) . ' ' . $property_title . "\r\n" . $property_url . "\r\n\n" . __( 'Message:', 'tt' ) . "\r\n\n" . $_POST['message'];
		
		wp_mail( $recipient, $subject, $message, $headers );
		
	}
	
	die;
	
}
add_action( 'wp_ajax_nopriv_submit_property_contact_form', 'submit_property_contact_form' );
add_action( 'wp_ajax_submit_property_contact_form', 'submit_property_contact_form' );


/* CONTACT FORM - Single Agent
============================== */

function submit_agent_contact_form() {

	if ( wp_verify_nonce( $_POST['nonce'] ) && !empty( $_POST['email'] ) && !empty( $_POST['message'] ) ) {
		
		$recipient = $_POST['agent_email'];
		$name = $_POST['name'];
		$subject = __( 'Message from', 'tt' ) . ' ' . $name;
	  $email = $_POST['email'];
	  $phone = '-';
	  $phone = $_POST['phone'];
		$headers = array(); 
	  $headers[] = "From: $name <$email>";
	  
	  $message = __( 'Name:', 'tt' ) . ' ' . $name . "\r\n" . __( 'Phone:', 'tt' ) . ' ' . $phone . "\r\n\n" . __( 'Message:', 'tt' ) . "\r\n\n" . $_POST['message'];
		
		wp_mail( $recipient, $subject, $message, $headers );
		
	}
	
	die;
	
}
add_action( 'wp_ajax_nopriv_submit_agent_contact_form', 'submit_agent_contact_form' );
add_action( 'wp_ajax_submit_agent_contact_form', 'submit_agent_contact_form' );


/* BLOG
============================== */

function tt_blog_pagination() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     		=> $pagenum_link,
		'format'   		=> $format,
		'total'    		=> $GLOBALS['wp_query']->max_num_pages,
		'current'  		=> $paged,
		'mid_size' 		=> 1,
		'type'				=> 'list',
		'add_args' 		=> array_map( 'urlencode', $query_args ),
		'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
		'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
	) );

	if ( $links ) :

	?>
	<nav id="pagination" role="navigation">
		<?php echo $links; ?>
	</nav>
	<?php
	endif;
}

// Post Content & Navigation
function tt_post_content_navigation() {
	
	if ( is_singular() ) : ?>
		
		<div class="entry-content">
			<?php 
			the_content( __( 'Continue reading ..', 'tt' ) ); 
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tt' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			
			tt_social_sharing();
			?>
		</div><!-- .entry-content -->
		
	<?php else : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<a class="btn btn-primary" href="<?php echo get_permalink(); ?>"><?php _e( 'Read more', 'tt' ); ?></a>
		</div>
	<?php endif;
		
}

// Comments
function tt_list_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$args = array(
		'walker'            => null,
		'max_depth'         => '10',
		'style'             => 'ul',
		'callback'          => null,
		'end-callback'      => null,
		'type'              => 'comment',
		'reply_text'        => __( 'Reply', 'tt' ),
		'page'              => '',
		'per_page'          => '',
		'avatar_size'       => 130,
		'reverse_top_level' => null,
		'reverse_children'  => '',
		'format'            => 'html5',
		'short_ping'        => true
	);
	
	if ( 'div' == $args['style'] ) {
	$tag = 'div';
	$add_below = 'comment';
	} else {
	$tag = 'li';
	$add_below = 'div-comment';
	}
	?>
	<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
		<div class="comment-avatar">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</div>
		<div class="comment-author vcard">
			<?php printf(__('<h5 class="fn">%s</h5>'), get_comment_author_link()) ?>
			
			<?php if ($comment->comment_approved == '0') : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'tt' ) ?></em>
			<br />
			<?php endif; ?>
			
			<div class="comment-meta">
			<span><?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . " " . __('ago', 'tt'); ?></span>
			</div>
		
		</div>
		
		<div class="comment-content">
			<?php comment_text() ?>
			<?php if( comments_open() ) { ?>
			<div class="reply btn btn-default btn-xs">
				<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			<?php } ?>
		</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif;
}

// Social Sharing Buttons
function tt_social_sharing() {
?>
  <div id="share-post" class="social-transparent primary-tooltips">
		<a href="http://www.facebook.com/share.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-facebook" data-toggle="tooltip" title="Share on Facebook"></i></a>
		<a href="http://twitter.com/share?text=<?php the_title(); ?>&url=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-twitter" data-toggle="tooltip" title="Share on Twitter"></i></a>
		<a href="https://plus.google.com/share?url=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-google-plus" data-toggle="tooltip" title="Share on Google+"></i></a>
		<?php 
		if ( has_post_thumbnail() ) {
			$attachment_id =  get_post_thumbnail_id();
			$attachment_array = wp_get_attachment_image_src( $attachment_id );
		?>
		<a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url( get_permalink() ); ?>&media=<?php echo $attachment_array[0]; ?>&description=<?php echo strip_tags( get_the_excerpt() ); ?>" target="_blank"><i class="fa fa-pinterest" data-toggle="tooltip" title="Share on Pinterest"></i></a>
		<?php } ?>
	</div>
	<?php
}


/* Page Banner
============================== */
function tt_page_banner() {
	if ( has_post_thumbnail( get_the_ID() ) ) {	
		$post_thumbnail_id = get_post_thumbnail_id();
		$post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, 'full', true );
		?>
		<div id="page-banner" style="background-image: url(<?php echo $post_thumbnail[0]; ?>)">
			<div class="overlay"></div>
			<div class="container">
				<div class="banner-title">
					<?php the_title(); ?>
				</div>
			</div>
		</div>
		<?php 
	}
}


/* Custom Styles
============================== */
function tt_custom_styles() {
	
	global $realty_theme_option;
	$color_accent = $realty_theme_option['color-accent'];
	$color_header = $realty_theme_option['color-header'];
	
	echo "\n<style>\n";
		 
	echo "a, #footer h5.title, #map #map-marker-container .content .title, #map .map-marker-container .content .title, body.single-property #property-features li i.fa-check, ul#sidebar li.widget .widget-content table a { color: $color_accent; }\n";
	
	echo "input:focus, .form-control:focus, input:active, .form-control:active, ul#sidebar li.widget .wpcf7 textarea:focus, #footer li.widget .wpcf7 textarea:focus, ul#sidebar li.widget .wpcf7 input:not([type='submit']):focus, #footer li.widget .wpcf7 input:not([type='submit']):focus, .chosen-container.chosen-container-active .chosen-single, .chosen-container .chosen-drop { border-color: $color_accent }\n";
	
	echo ".primary-tooltips .tooltip.top .tooltip-arrow, .arrow-down, .sticky .entry-header { border-top-color: $color_accent }\n";
	echo ".primary-tooltips .tooltip.right .tooltip-arrow, .arrow-left { border-right-color: $color_accent }\n";
	echo ".primary-tooltips .tooltip.bottom .tooltip-arrow, .arrow-up { border-bottom-color: $color_accent }\n";
	echo ".primary-tooltips .tooltip.left .tooltip-arrow, .arrow-right, #home-slideshow .description .arrow-right { border-left-color: $color_accent }\n";
	
	echo ".btn-primary, .btn-primary:focus, input[type='submit'], .primary-tooltips .tooltip-inner, .content-with-details > div .on-hover, #fixed-controls a:hover, header.navbar .navbar-nav > ul > li::after, header.navbar nav > div > ul > li::after, header.navbar .navbar-nav > ul > li.current-menu-item::after, header.navbar nav > div > ul > li.current-menu-item::after, header.navbar .navbar-nav > ul > li.current-menu-parent::after, header.navbar nav > div > ul > li.current-menu-parent::after, header.navbar .navbar-nav > ul > li.current-menu-ancestor::after, header.navbar nav > div > ul > li.current-menu-ancestor::after, #footer #footer-bottom .social-transparent a:hover, #footer #footer-bottom #up:hover, #home-slideshow .title, #pagination .page-numbers li .current, #pagination .page-numbers li .current:hover, #map-wrapper #map-controls .control.active, .owl-theme .owl-controls .owl-nav [class*='owl-'], #property-items .property-item .property-excerpt::after { background-color: $color_accent }\n";
	
	echo "header.navbar, header.navbar .navbar-brand a, header.navbar, header.navbar .navbar-nav > ul > li:hover, header.navbar nav > div > ul > li:hover, header.navbar .navbar-nav > ul > li a, header.navbar nav > div > ul > li a, header.navbar .navbar-nav > ul > li ul.sub-menu li:hover a, header.navbar nav > div > ul > li ul.sub-menu li:hover a { color: $color_header }\n";
	
	// Theme Options: Custom Styles
	echo $realty_theme_option['custom-styles']."\n";
	
	echo "</style>\n";

}
add_action( 'wp_head', 'tt_custom_styles', 151 ); // Fire after Redux


/* Custom Scripts
============================== */
function tt_custom_scripts() {

global $realty_theme_option;
$datepicker_language = $realty_theme_option['datepicker-language'];
?>
<script>	
<?php if ( isset( $datepicker_language ) ) { ?>

jQuery('.datepicker').datepicker({
language: '<?php echo $datepicker_language; ?>',
autoclose: true,
format: "yyyymmdd"
});

<?php }

// Theme Options: Custom Scripts
echo $realty_theme_option['custom-scripts']."\n";
?>
</script>	
<?php
}
add_action( 'wp_footer', 'tt_custom_scripts', 20 );


/* Query - Taxonomy
============================== */
function tt_taxonomy_query( $query ) {
	if( is_tax() ) {
		// Search Results Per Page: Check for Theme Option
		global $realty_theme_option;
		$search_results_per_page = $realty_theme_option['search-results-per-page'];
		if ( $search_results_per_page ) {
			$query->set( 'posts_per_page', $search_results_per_page );
		}
  }
}
  
add_action( 'pre_get_posts', 'tt_taxonomy_query' );