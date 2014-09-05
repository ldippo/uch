<?php
function tt_google_maps_api_single_property() {
global $post;
$google_maps = get_post_meta( $post->ID, 'estate_property_location', true );
$coordinate = explode(',',$google_maps); 

if ( has_post_thumbnail() ) { 
	$property_thumbnail = get_the_post_thumbnail( get_the_id(), 'medium' ); 
}	
else {
	$property_thumbnail = '<img src="//placehold.it/300x150/eee/ccc/&text=.." />';
}
?>

<script>
function initMap() {

	// https://developers.google.com/maps/documentation/javascript/examples/
	var location = new google.maps.LatLng(<?php echo $coordinate[0]; ?>, <?php echo $coordinate[1]; ?>);
  var mapOptions = { 
    center: location,
    zoom: 14,
    scrollwheel: false,
    streetViewControl: true,
		disableDefaultUI: true
  };
  
  <?php 
	global $realty_theme_option;
	$default_marker_property = $realty_theme_option['map-marker-property-default'];	
	$custom_marker_property = $realty_theme_option['map-marker-property'];
	$custom_marker_property_width_retina = $custom_marker_property['width'] / 2;
	$custom_marker_property_height_retina = $custom_marker_property['height'] / 2;
	
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
		null, // size is determined at runtime
    null, // origin is 0,0
    null, // anchor is bottom center of the scaled image
    new google.maps.Size(50, 69)
  );
	<?php } ?> 
  
  map = new google.maps.Map(document.getElementById('map'), mapOptions);

  var marker = new google.maps.Marker({
      map: map,
      position: location,
      icon: customIcon,
      title: '<?php the_title(); ?>'
  });
  
  var propertyThumbnail = '<?php echo $property_thumbnail; ?>';
  var propertyPrice = '<?php echo tt_property_price(); ?>';
  var propertyTitle = '<?php the_title( '<h5 class="title">', '</h5>' ); ?>';

	// http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/docs/reference.html
	infobox = new InfoBox({
	  content: 	'<div class="map-marker-wrapper">'+
    						'<div class="map-marker-container">'+
	    						'<div class="arrow-down"></div>'+
									propertyThumbnail+
									'<div class="content">'+
									propertyTitle+
									propertyPrice+
									'</div>'+
								'</div>'+
					    '</div>',
	  disableAutoPan: false,
	  pixelOffset: new google.maps.Size(-33, -90),
	  zIndex: null,
	  alignBottom: true,
	  closeBoxURL: "<?php echo TT_LIB_URI . '/images/close.png'; ?>",
	  infoBoxClearance: new google.maps.Size(50, 50)
	});
  
  google.maps.event.addListener(marker, 'click', function() {
  	infobox.open(map, marker);
    map.panTo(location);
	});
	
	// Maps Fully Loaded: Hide + Remove Spinner
	google.maps.event.addListenerOnce(map, 'idle', function() {
		jQuery('.spinner').fadeTo(800, 0.5);
		setTimeout(function() {
		  jQuery('.spinner').remove();
		}, 800);
	});
	
}

google.maps.event.addDomListener(window, 'load', initMap);

</script>

<?php
}
add_action( 'wp_footer', 'tt_google_maps_api_single_property', 20 );
?>

<section id="location">
<?php 
global $realty_theme_option;
$property_title_map = $realty_theme_option['property-title-map'];
if ( $property_title_map ) { echo '<h3 class="section-title"><span>' . $property_title_map . '</span></h3>'; } 
?>

<div id="map-wrapper">
	<div class="container">		
		<div id="map-controls">
			<a href="#" class="control" id="zoom-in" data-toggle="tooltip" title="<?php _e( 'Zoom In', 'tt' ); ?>"><i class="fa fa-plus"></i></a>
			<a href="#" class="control" id="zoom-out" data-toggle="tooltip" title="<?php _e( 'Zoom Out', 'tt' ); ?>"><i class="fa fa-minus"></i></a>
			<a href="#" class="control" id="current-location" data-toggle="tooltip" title="<?php _e( 'Radius: 1000m', 'tt' ); ?>"><i class="fa fa-crosshairs"></i><?php _e( 'Current Location', 'tt' ); ?></a>
		</div>		
	</div>		
	
	<div id="map"></div>	
	
	<div class="spinner">
	  <div class="bounce1"></div>
	  <div class="bounce2"></div>
	  <div class="bounce3"></div>
	</div>
</div>

<?php $address = get_post_meta( $post->ID, 'estate_property_address', true ); ?>
<a class="view-on-google-maps-link" href="https://www.google.com/maps/preview?q=<?php $maplink = str_replace(' ', '+', $address); echo $maplink; ?>" target="_blank"><?php _e( 'View on Google Maps', 'tt' ); ?></a>
</section>