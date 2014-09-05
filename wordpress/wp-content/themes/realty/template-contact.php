<?php get_header();
/*
Template Name: Contact
*/
global $post, $realty_theme_option;

$hide_sidebar = get_post_meta( $post->ID, 'estate_page_hide_sidebar', true );

$address = $realty_theme_option['contact-address'];
$phone = $realty_theme_option['contact-phone'];
$mobile = $realty_theme_option['contact-mobile'];
$email = $realty_theme_option['contact-email'];
$logo = $realty_theme_option['contact-logo'];
$logo_src = '';
if ( !empty( $logo['url'] ) ) {
	$logo_array = wp_get_attachment_image_src( $logo['id'], 'medium' );
	$logo_src = $logo_array[0];
	$logo_img = '<img src="' . $logo_array[0] . '" />';
}
?>

<?php while ( have_posts() ) : the_post(); 
	
	tt_page_banner();
	?>	
	
	<div class="row">
	
		<?php 
		// Check for Agent Sidebar
		if ( !$hide_sidebar && is_active_sidebar( 'sidebar_contact' ) ) {
			echo '<div class="col-sm-8 col-md-9">';
		} else {
			echo '<div class="col-sm-12">';
		}
		?>
		
			<div id="main-content" class="content-box template-contact">
			
				<?php 
				// Check Contact Theme Option for Googe Maps Visibility
				if ( $realty_theme_option['contact-google-map'] ) { 
				?>
				
				<script src="//maps.googleapis.com/maps/api/js?v=3.exp"></script>
				<script src="<?php echo get_template_directory_uri() . '/assets/js/google.maps.infobox.js'; ?>"></script>
				<script>
				var map;
				function initialize() {
				
					// https://developers.google.com/maps/documentation/javascript/examples/  
				  var mapOptions = {
				    zoom: 14,
				    center: new google.maps.LatLng(-34.397, 150.644),
				    scrollwheel: false,
				    streetViewControl: true,
						disableDefaultUI: true
				  };
				  
				  map = new google.maps.Map(document.getElementById('map'), mapOptions);
				
					var customIcon = new google.maps.MarkerImage(
				    '<?php echo get_template_directory_uri(); ?>/lib/images/map-marker/map-marker-green-fat2.png',
				    null, // size is determined at runtime
				    null, // origin is 0,0
				    null, // anchor is bottom center of the scaled image
				    new google.maps.Size(50, 69)
				  );
  
					// https://developers.google.com/maps/documentation/javascript/geocoding
				  var address = '<?php echo $address; ?>';
				  geocoder = new google.maps.Geocoder();
				  
				  geocoder.geocode( { 'address': address}, function(results, status) {
				    if (status == google.maps.GeocoderStatus.OK) {
				     
				      map.setCenter(results[0].geometry.location);
				      var marker = new google.maps.Marker({
				          map: map,
				          position: results[0].geometry.location,
				          icon: customIcon,
				          animation: google.maps.Animation.DROP
				      });
				      
				      var logo 		= '<?php echo $logo_src; ?>';
				      var address = '<?php echo $address; ?>';
				      var phone 	= '<?php echo $phone; ?>';
				      var mobile 	= '<?php echo $mobile; ?>';
				      var email 	= '<?php echo antispambot(  $email ); ?>';
				           
				      // http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/docs/reference.html
							infobox = new InfoBox({
						  content: 	'<div class="map-marker-wrapper">'+
	    						'<div class="map-marker-container">'+
		    						'<div class="arrow-down"></div>'+
										<?php if ( $logo_src ) { ?>'<img src="'+logo+'" style="max-width:50%" />'+<?php } ?>
										'<div class="content">'+
										<?php if ( $address ) { ?>'<div class="contact-detail"><i class="fa fa-map-marker"></i>'+address+'</div>'<?php } ?>+
										<?php if ( $phone ) { ?>'<div class="contact-detail"><i class="fa fa-phone"></i>'+phone+'</div>'<?php } ?>+
										<?php if ( $mobile ) { ?>'<div class="contact-detail"><i class="fa fa-mobile"></i>'+mobile+'</div>'<?php } ?>+
										<?php if ( $email ) { ?>'<div class="contact-detail"><i class="fa fa-envelope"></i><a href="mailto:'+email+'">'+email+'</a></div>'<?php } ?>+
										'</div>'+
									'</div>'+
						    '</div>',
							  disableAutoPan: false,
							  pixelOffset: new google.maps.Size(-33, -90),
							  zIndex: null,
							  //isHidden: true,
							  alignBottom: true,
							  closeBoxURL: "<?php echo TT_LIB_URI . '/images/close.png'; ?>",
							  infoBoxClearance: new google.maps.Size(60, 60)
							});
						
						  infobox.open(map, marker);
						  map.panTo(results[0].geometry.location);
						  
						  google.maps.event.addListener(marker, 'click', function() {					    	
					    	if ( infobox.getVisible() ) {
						    	infobox.hide();
					    	}
					    	else {
						    	infobox.show();
					    	}						    	
					    	infobox.open(map, marker);
								map.panTo(results[0].geometry.location);						      
							});
				      
				    } 
				    else {
				      alert("Geocode was not successful for the following reason: " + status);
				    }
				    
				  });
				  
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
						
					<div id="map">
						<div class="spinner">
						  <div class="bounce1"></div>
						  <div class="bounce2"></div>
						  <div class="bounce3"></div>
						</div>	
					</div>
					
				</div>
				
				<?php } // END IF Show Google Map
				else {
				?>
				
				<ul class="list-unstyled">
					<?php if ( $address ) { ?> <li class="contact-detail"><i class="fa fa-map-marker"></i><?php echo $address; } ?></li>
					<?php if ( $phone ) { ?> <li class="contact-detail"><i class="fa fa-phone"></i><?php echo $phone; } ?></li>
					<?php if ( $mobile ) { ?> <li class="contact-detail"><i class="fa fa-mobile"></i><?php echo $mobile; } ?></li>
					<?php if ( $email ) { ?> <li class="contact-detail"><i class="fa fa-envelope"></i><?php echo '<a href="mailto:' . antispambot( $email ) . '">' . antispambot( $email ) . '</a>'; } ?></li>
				</ul>
				
				<?php	} // END "Don't Show Noogle Map" ?>
				
				<?php the_content(); ?>
			</div>
		
		</div><!-- .col-sm-9 -->
		
		<?php 
		// Check for Page Sidebar
		if ( !$hide_sidebar && is_active_sidebar( 'sidebar_contact' ) ) : 
		?>
		<div class="col-sm-4 col-md-3">
			<ul id="sidebar">
				<?php dynamic_sidebar( 'sidebar_contact' ); ?>
			</ul>
		</div>
		<?php endif; ?>
	
	
	</div><!-- .row -->
	
<?php
endwhile;

get_footer(); 
?>