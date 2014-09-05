<?php
/* Google Maps API - Multiple Properties
============================== */
function tt_google_maps_api_multiple_properties() {

// Check For Property Search Template 
if ( is_page_template( 'template-property-search.php' ) ) {
	// Build Property Search Query
	$query_properties_args = array();
	$query_properties_args = apply_filters( 'property_search_args', $query_properties_args );
	$query_properties_args['posts_per_page'] = -1;
}

else {

	global $post, $realty_theme_option;
	$properties_homepage_quantity = intval( $realty_theme_option['map-properties-quantity'] );
	
	if( !$properties_homepage_quantity ) {
		$properties_homepage_quantity = -1;
	}
		
	// Property Query
	if ( is_front_page() ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	}
	else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}
	$query_properties_args = array(
		'post_type' 			=> 'property',
		'posts_per_page' 	=> $properties_homepage_quantity,
		'paged' 					=> $paged
	);
	
}

$query_properties = new WP_Query( $query_properties_args );

//if ( $query_properties->have_posts() ) : 

$property_string = '';
$i = 0;

while ( $query_properties->have_posts() ) : $query_properties->the_post();
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

global $realty_theme_option;
$default_marker_property = $realty_theme_option['map-marker-property-default'];	
$custom_marker_property = $realty_theme_option['map-marker-property'];
$custom_marker_property_width_retina = $custom_marker_property['width'] / 2;
$custom_marker_property_height_retina = $custom_marker_property['height'] / 2;

?>
<script>
<?php
// No Properties Found - Hide Map
if ( $i == 0 ) { ?>
jQuery('#map-wrapper').hide();
<?php } ?>
var map = null, markers = [], newMarkers = [], markerCluster = null, bounds = [], infobox = [];

<?php
// Check For Custom Marker Property
if ( $custom_marker_property['url'] ) {
?>		
var customIcon = new google.maps.MarkerImage(
	'<?php echo $custom_marker_property['url']; ?>',
	null, // size is determined at runtime
  null, // origin is 0,0
  null, // anchor is bottom center of the scaled image
  new google.maps.Size(<?php echo $custom_marker_property_width_retina; ?>, <?php echo $custom_marker_property_height_retina; ?>)
);
			
<?php
}
// No Custom Marker Property Found: Use Default
else {
?>
var customIcon = new google.maps.MarkerImage(
	'<?php echo $default_marker_property; ?>',
	//'<?php echo get_template_directory_uri(); ?>/lib/images/map-marker/map-marker-green-fat.png',
	null, // size is determined at runtime
  null, // origin is 0,0
  null, // anchor is bottom center of the scaled image
  new google.maps.Size(50, 69)
);
<?php } ?>  

var markerClusterOptions = {
	gridSize: 60, // Default: 60
	maxZoom: 14,
	styles: [{
<?php
// http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html
// https://developers.google.com/maps/articles/toomanymarkers

// Check For Custom Marker Cluster
$default_marker_cluster = $realty_theme_option['map-marker-cluster-default'];	
$custom_marker_cluster = $realty_theme_option['map-marker-cluster'];
$custom_marker_cluster_width_retina = $custom_marker_cluster['width'] / 2;
$custom_marker_cluster_height_retina = $custom_marker_cluster['height'] / 2;
if ( $custom_marker_cluster['url'] ) {
?>
	width: <?php echo $custom_marker_cluster_width_retina; ?>,
	height: <?php echo $custom_marker_cluster_height_retina; ?>,
	url: "<?php echo $custom_marker_cluster['url']; ?>"
<?php
}
// No Custom Marker Cluster Found: Use Default
else {
?>
	width: 50,
	height: 50,
	url: "<?php echo $default_marker_cluster; ?>"
<?php } ?>
	}]
};

function initMap() {
  
  // http://stackoverflow.com/questions/7308875/google-maps-api-infobox-plugin-and-multiple-markers
	var	mapOptions = {
		center: new google.maps.LatLng(0, 0),
		zoom: 14,
		scrollwheel: false,
		streetViewControl: true,
		disableDefaultUI: true
	};
	
	map = new google.maps.Map(document.getElementById("map"), mapOptions);
	
	bounds = new google.maps.LatLngBounds();
	
	markers = initMarkers(map, [ <?php echo $property_string; ?> ]);
	
	markerCluster = new MarkerClusterer(map, newMarkers, markerClusterOptions);

	// Maps Fully Loaded: Hide + Remove Spinner
	google.maps.event.addListenerOnce(map, 'idle', function() {
		jQuery('.spinner').fadeTo(800, 0.5);
		setTimeout(function() {
		  jQuery('.spinner').remove();
		}, 800);
	});
		
}

google.maps.event.addDomListener(window, 'load', initMap);

function initMarkers(map, markerData) {
	    
	for( var i = 0; i < markerData.length; i++ ) {
		
		marker = new google.maps.Marker({
	    map: map,
	    position: markerData[i].latLng,
			icon: customIcon,
	    //animation: google.maps.Animation.DROP
		}),
		
		bounds.extend(markerData[i].latLng);
	  
		infoboxOptions = {
	    content: 	'<div class="map-marker-wrapper">'+
	    						'<div class="map-marker-container">'+
		    						'<div class="arrow-down"></div>'+
										'<img src="'+markerData[i].thumbnail+'" />'+
										'<div class="content">'+
										'<a href="'+markerData[i].permalink+'">'+
										'<h5 class="title">'+markerData[i].title+'</h5>'+
										'</a>'+
										markerData[i].price+
										'</div>'+
									'</div>'+
						    '</div>',
	    disableAutoPan: false,
		  pixelOffset: new google.maps.Size(-33, -90),
		  zIndex: null,
		  isHidden: true,
		  alignBottom: true,
		  closeBoxURL: "<?php echo TT_LIB_URI . '/images/close.png'; ?>",
		  infoBoxClearance: new google.maps.Size(25, 25)
		};
		
		newMarkers.push(marker);
	
		newMarkers[i].infobox = new InfoBox(infoboxOptions);
		newMarkers[i].infobox.open(map, marker);
	
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
	    return function() {
	    	
	    	if ( newMarkers[i].infobox.getVisible() ) {
		    	newMarkers[i].infobox.hide();
	    	}
	    	else {
		    	newMarkers[i].infobox.show();
	    	}
	    	
	    	newMarkers[i].infobox.open(map, this);
	      map.panTo(markerData[i].latLng);
	      
	    }
		})( marker, i ) );
		
	}
	
	// Set Map Bounds And Max. Zoom Level
	google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
		map.fitBounds(bounds);
		if (this.getZoom() > 13) {
	    this.setZoom(13);
	  }
	});
	
	return newMarkers;
	
} // initMarkers();

</script>

<?php
}
add_action( 'wp_footer', 'tt_google_maps_api_multiple_properties', 20 );
?>

<div id="map-wrapper">
	
		
	<div id="map"></div>
	
	<div class="spinner">
	  <div class="bounce1"></div>
	  <div class="bounce2"></div>
	  <div class="bounce3"></div>
	</div>
	
	<div id="map-controls">
		<a href="#" class="control" id="zoom-in" data-toggle="tooltip" title="<?php _e( 'Zoom In', 'tt' ); ?>"><i class="fa fa-plus"></i></a>
		<a href="#" class="control" id="zoom-out" data-toggle="tooltip" title="<?php _e( 'Zoom Out', 'tt' ); ?>"><i class="fa fa-minus"></i></a>
		<a href="#" class="control" id="current-location" data-toggle="tooltip" title="<?php _e( 'Radius: 1000m', 'tt' ); ?>"><i class="fa fa-crosshairs"></i><?php _e( 'Current Location', 'tt' ); ?></a>
	</div>
	
	<div class="container">		
		<div id="map-overlay-no-results">
			<?php _e( 'No Properties Found.', 'tt' ); ?>
		</div>
	</div>
		
</div>
<?php 
wp_reset_query();
//else:
?>

<div id="map-no-properties-found" class="hide">
	<p class="lead text-center"><?php _e( 'No Properties Found.', 'tt' ) ?></p>
</div>
<?php
//endif;
?>