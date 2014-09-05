<?php
/*-----------------------------------------------------------------------------------*/
/* Section Title
/*-----------------------------------------------------------------------------------*/

function tt_section_title( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'heading'		=> 'h2'
	), $atts ) );
	
	if ( $heading ) {
		return '<' . $heading . ' class="section-title"><span>' . do_shortcode($content) . '</span></' . $heading . '>';
	}
	else {
		return '<h2 class="section-title"><span>' . do_shortcode($content) . '</span></h2>';
	}
		
}
add_shortcode('section_title', 'tt_section_title');


/*-----------------------------------------------------------------------------------*/
/* Testimonials
/*-----------------------------------------------------------------------------------*/

function tt_testimonials( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'columns'		=> '2'
	), $atts ) );
	
	ob_start();
	if ( $columns ) {
		echo '<div class="owl-carousel-' . $columns . ' testimonial">';
	}
	else {
		echo '<div class="owl-carousel-2 testimonial">';
	}

	get_template_part( 'lib/inc/template/testimonials' );
	return ob_get_clean();
	
}
add_shortcode('testimonials', 'tt_testimonials');


/*-----------------------------------------------------------------------------------*/
/* Agents
/*-----------------------------------------------------------------------------------*/

function tt_agents( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'columns'		=> '2'
	), $atts ) );
	
	ob_start();
	if ( $columns ) {
		echo '<div class="owl-carousel-' . $columns . '">';
	}
	else {
		echo '<div class="owl-carousel-2">';
	}

	get_template_part( 'lib/inc/template/agents' );
	return ob_get_clean();
	
}
add_shortcode('agents', 'tt_agents');


/*-----------------------------------------------------------------------------------*/
/* Featured Properties
/*-----------------------------------------------------------------------------------*/

function tt_featured_properties( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'columns'		=> '2'
	), $atts ) );
	
	ob_start();
	if ( $columns ) {
		echo '<div class="owl-carousel-' . $columns . '">';
	}
	else {
		echo '<div class="owl-carousel-2">';
	}
	get_template_part( 'lib/inc/template/property-featured' );
	return ob_get_clean();
	
}
add_shortcode('featured_properties', 'tt_featured_properties');


/*-----------------------------------------------------------------------------------*/
/*  Single Property
/*-----------------------------------------------------------------------------------*/

function tt_single_property( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'id'		=> '1'
	), $atts ) );

	$query_properties_args = array(
		'post_type' 			=> 'property',
		'posts_per_page' 	=> 1,
		//'orderby'					=> 'rand',
		'page_id' 				=> $id
	);
	
	$query_properties = new WP_Query( $query_properties_args );
	
	if ( $query_properties->have_posts() ) : while ( $query_properties->have_posts() ) : $query_properties->the_post();
		ob_start();
		echo '<div id="property-items">';
		get_template_part( 'lib/inc/template/property-item' );
		echo '</div>';
		return ob_get_clean();
	endwhile;
	wp_reset_query();
	endif;
	
}
add_shortcode('single_property', 'tt_single_property');


/*-----------------------------------------------------------------------------------*/
/*  Property Search Form
/*-----------------------------------------------------------------------------------*/

function tt_property_search_form( $atts, $content = null ) {

	ob_start();
	get_template_part( 'lib/inc/template/search-form' );
	return ob_get_clean();
	
}
add_shortcode('property_search_form', 'tt_property_search_form');


/*-----------------------------------------------------------------------------------*/
/*  Property Listing
/*-----------------------------------------------------------------------------------*/

function tt_property_listing( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'per_page'		=> '10',
		'columns'			=> '',
	), $atts ) );
	
	ob_start();
?>
	<div id="property-items">
	
	<?php
	if ( !$per_page ) {
		$per_page = 10;
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
		'posts_per_page' 	=> $per_page,
		'paged' 					=> $paged
	);
	
	$query_properties = new WP_Query( $query_properties_args );
	
	if ( $query_properties->have_posts() ) :
	?>
	<ul class="row list-unstyled">
		<?php 
		while ( $query_properties->have_posts() ) : $query_properties->the_post();
		
		// Shortcode Columns Setting
		if ( isset($columns) && $columns == "2" ) {
			echo '<li class="col-md-6">';
		}
		else if ( isset($columns) && $columns == "3" ) {
			echo '<li class="col-lg-4 col-md-6">';
		}
		else if ( isset($columns) && $columns == "4" ) {
			echo '<li class="col-lg-3 col-md-6">';
		}
		// Theme Options Columns Settings
		else {
			global $realty_theme_option;
			$columns_theme_option = $realty_theme_option['property-listing-columns'];
			if ( empty($columns_theme_option) ) {
				echo '<li class="col-md-6">';
			}
			else {
				echo '<li class="' . $columns_theme_option . '">';
			}
		}
		
		get_template_part( 'lib/inc/template/property', 'item' );
		
		echo '</li>';
		
		endwhile; 
		?>
	</ul>
	<?php wp_reset_query(); ?>
	
	<div id="pagination">
	<?php
	// Built Property Pagination
	$big = 999999999; // need an unlikely integer

	echo paginate_links( array(
		'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#property-items',
		'format' 			=> '?page=%#%',
		'total' 			=> $query_properties->max_num_pages,
		'show_all'		=> true,
		'type'				=> 'list',
		'current'     => $paged,
		'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
		'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
	) );
	?>
	</div>
	
	<?php
	else:
	?>
	<div>
		<p class="lead"><?php _e('No Properties Found.', 'tt') ?></p>
	</div>
	<?php
	endif;
	?>
	
	</div><!-- #property-items -->
<?php
	return ob_get_clean();	
}
add_shortcode('property_listing', 'tt_property_listing');


/*-----------------------------------------------------------------------------------*/
/*  Map
/*-----------------------------------------------------------------------------------*/

function tt_map( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'address'		=> '',
		'zoomlevel'	=> '14',
		'height'		=> '500px',
		'width'			=> '100%'
		
	), $atts ) );
	
	ob_start();
	// Property Query
	if ( is_front_page() ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	}
	else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}
		
	$query_properties_args = array(
		'post_type' 			=> 'property',
		'posts_per_page' 	=> -1,
		'paged' 					=> $paged
	);
	
	$query_properties = new WP_Query( $query_properties_args );
	
	if ( $query_properties->have_posts() ) :
	
	$property_string = '';
	
	while ( $query_properties->have_posts() ) : $query_properties->the_post();
	
	global $post;
	
	$google_maps = get_post_meta( $post->ID, 'estate_property_location', true );
	$coordinate = explode(',',$google_maps);
	
	$property_string .= '{ ';
	
	$property_string .= 'permalink:"' . get_the_permalink() . '", ';
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
	
	endwhile;
	?>	
	
	<script src="//maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<script src="<?php echo get_template_directory_uri() . '/assets/js/google.maps.markerclusterer.js'; ?>"></script>
	<script src="<?php echo get_template_directory_uri() . '/assets/js/google.maps.infobox.js'; ?>"></script>
	<script>
	
	
	function initialize() {
	  
	  // http://stackoverflow.com/questions/7308875/google-maps-api-infobox-plugin-and-multiple-markers
		var center = new google.maps.LatLng(0, 0),
			markers,
			myMapOptions = {
			zoom: 14,
			center: center,
			scrollwheel: false,
			streetViewControl: true,
			disableDefaultUI: true
		},
		
		map = new google.maps.Map(document.getElementById("map"), myMapOptions);
		
		var bounds = new google.maps.LatLngBounds();
		
		var customIcon = new google.maps.MarkerImage(
	    '<?php echo get_template_directory_uri(); ?>/lib/images/map-marker/map-marker-green-fat2.png',
	    null, // size is determined at runtime
	    null, // origin is 0,0
	    null, // anchor is bottom center of the scaled image
	    new google.maps.Size(50, 69)
	  );
		
		function initMarkers(map, markerData) {
		
			var newMarkers = [],
			    marker;
			    
			for( var i = 0; i < markerData.length; i++ ) {
				
				marker = new google.maps.Marker({
			    map: map,
			    position: markerData[i].latLng,
			    icon: customIcon,
			    animation: google.maps.Animation.DROP
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
			
			// http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html
			// https://developers.google.com/maps/articles/toomanymarkers
			var markerClusterOptions = {
				gridSize: 60, // Default: 60
				maxZoom: 14,
				styles: [{
					width: 50,
					height: 50,
					url: "<?php echo TT_LIB_URI . '/images/map-marker/map-marker-red-round.png'; ?>"
				}]
			};
			
			var markerCluster = new MarkerClusterer(map, newMarkers, markerClusterOptions);
				
			<?php if ( $address ) { ?>	
			// Center Shortcode Address		
			var address = '<?php echo $address; ?>';
		  geocoder = new google.maps.Geocoder();
		  
		  geocoder.geocode( { 'address': address}, function(results, status) {
		    if (status == google.maps.GeocoderStatus.OK) {
		    	map.setCenter(results[0].geometry.location);
		    	map.setZoom(<?php echo $zoomlevel; ?>);
		    }
		  });
			<?php 
			}
			else {	
			?>
			
			setTimeout(function() {
				map.fitBounds(bounds);
				// Set max. Zoom Level to 14
				var zoomOverride = map.getZoom();
				if(zoomOverride > 14) {
					zoomOverride = 14;
				}
				map.setZoom(zoomOverride);
			}, 1000);
			
			<?php } ?>
			
			return newMarkers;
			
		}
		
		markers = initMarkers(map, [ <?php echo $property_string; ?> ]);
		
		// Current Location Marker
		markerCurrent = new google.maps.Marker({
		  //clickable: false,
		  icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
			  new google.maps.Size(22,22),
			  new google.maps.Point(0,18),
			  new google.maps.Point(11,11)),
		  shadow: null,
		  zIndex: null,
		  map: map
		});
			
		// Geolocation - Current Location
		jQuery('#current-location').click(function() {
		
			jQuery(this).toggleClass('active');
	
			if ( !jQuery('#current-location').hasClass('draw') ) {
			
				// Create Loading Element
			  var loading = document.createElement('div');
		
		    loading.setAttribute( 'id', 'loading' );
		
		    loading.innerHTML = '<i class="fa fa-spinner fa-spin"></i><?php _e( 'Load Current Location..', 'tt' ); ?>';
		
		    document.getElementById('map-wrapper').appendChild(loading);
		    
		    // Remove Loader After .. ms
		    setTimeout(function() {
		    	loading.remove();
		    }, 2000)
			    
			}
	
			if (navigator.geolocation) {
			
				navigator.geolocation.getCurrentPosition(function(current) {
			    var me = new google.maps.LatLng(current.coords.latitude, current.coords.longitude);
			    markerCurrent.setPosition(me);
					map.panTo(me);
					
					// https://developers.google.com/maps/documentation/javascript/examples/circle-simple
					var currentRadiusCircleOptions = {
			      strokeColor: '#00CFF0',
			      strokeOpacity: 0.6,
			      strokeWeight: 2,
			      fillColor: '#00CFF0',
			      fillOpacity: 0.2,
			      map: map,
			      center: me,
			      visible: true,
			      radius: 1000 // Unit: meter
			    };
		    
		    // When Initializing
				if ( !jQuery('#current-location').hasClass('draw') ) {	
			    
			    // Create Circle
			    currentRadiusCircle = new google.maps.Circle(currentRadiusCircleOptions);
	    
				}
				
				jQuery('#current-location').addClass('draw');
				
				// Toggle Crrent Location Icon & Circle
				if ( jQuery('#current-location').hasClass('active') ) {
					markerCurrent.setMap(map);
					currentRadiusCircle.setMap(map);
				}
				else {
					markerCurrent.setMap(null);
					currentRadiusCircle.setMap(null);
				}
					
				});
				
			}
			// Error: Can't Retrieve Current Location
			else {
			  //alert("Current Position Not Found");
			}
			
		});
		
		// Toggle Current Location Circle Visibility				
		google.maps.event.addListener(markerCurrent, 'click', (function() {		
			if ( currentRadiusCircle.getVisible() ) {
	    	currentRadiusCircle.set( 'visible', false );
	  	}
	  	else {
	    	currentRadiusCircle.set( 'visible', true );
	  	}		
		}));
		
		// Zoom In
		if ( document.getElementById('zoom-in') ) {	
			google.maps.event.addDomListener(document.getElementById('zoom-in'), 'click', function () {      		
				var current = map.getZoom();
				current++;
				if ( current > 19 ) {
					current = 19;
				}
				map.setZoom(current);		
			}); 		 
		}
		
		// Zoom Out
		if ( document.getElementById('zoom-out') ) {	
			google.maps.event.addDomListener(document.getElementById('zoom-out'), 'click', function () {      		
				var current = map.getZoom();
				current--;
				if ( current < 2 ) {
					current = 2;
				}
				map.setZoom(current);		
			}); 		 
		}
	    
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
	
	</script>
	
	<div id="map-wrapper">
		
		<div class="container">
			
			<div id="map-controls">
				<a href="#" class="control" id="zoom-in" data-toggle="tooltip" title="<?php _e( 'Zoom In', 'tt' ); ?>"><i class="fa fa-plus"></i></a>
				<a href="#" class="control" id="zoom-out" data-toggle="tooltip" title="<?php _e( 'Zoom Out', 'tt' ); ?>"><i class="fa fa-minus"></i></a>
				<a href="#" class="control" id="current-location" data-toggle="tooltip" title="<?php _e( 'Radius: 1000m', 'tt' ); ?>"><i class="fa fa-crosshairs"></i><?php _e( 'Current Location', 'tt' ); ?></a>
			</div>
			
		</div>
			
		<div id="map" style="height: <?php echo $height; ?>">
			<div class="spinner">
			  <div class="bounce1"></div>
			  <div class="bounce2"></div>
			  <div class="bounce3"></div>
			</div>	
		</div>
		
	</div>
	
<?php

wp_reset_query();
	
else:
?>	
<div id="map-no-properties-found">
	<p class="lead text-center"><?php _e( 'No Properties Found.', 'tt' ) ?></p>
</div>
<?php
endif;
return ob_get_clean();
	
}
add_shortcode('map', 'tt_map');
				