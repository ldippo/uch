var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
var windowHeight = jQuery(window).height();
var windowWidth = jQuery(window).width();
var navHeight = jQuery('header.navbar').height();
var homeBannerHeight = windowHeight - navHeight - 210;

jQuery(document).ready(function() {

	// Home Page - Banner Height
	jQuery('#home-slideshow, body.page-template-template-home-properties-map-php #map, body.page-template-template-property-search-php #map').css('height', homeBannerHeight);
	
	// Navigation
	jQuery('.navbar-toggle').click(function() {
		jQuery('body').toggleClass('show-nav');
	});
	
	
	/* Bootstrap Plugins
	-------------------------*/
	
	// Tooltip
	jQuery('[data-toggle="tooltip"]').tooltip();
	
	
	/* Smooth scroll for menu links
	-------------------------*/
	jQuery('#up i, .property-header a').on('click', function(e) {
    e.preventDefault();
    jQuery('html,body').animate({scrollTop:jQuery(this.hash).offset().top-15}, 800); 
  });
  
  
  /* Scroll To The Top - Button
	-------------------------*/
	jQuery('#up').click(function(e) {
		e.preventDefault();
		jQuery('html, body').animate({scrollTop: 0}, 800);
	});
	
	
	/* Bootstrap Datepicker
	// http://eternicode.github.io/bootstrap-datepicker/
	-------------------------*/
	jQuery('.datepicker').datepicker({
    language: 	'en',
    autoclose: 	true,
    format: "yyyymmdd"
	});
	
	
	/* Chosen.js - Custom Select Boxes
	http://harvesthq.github.io/chosen/options.html
	-------------------------*/
	jQuery('.property-search-form select, .dsidx-widget select').chosen({
		width: "100%"
	});
	jQuery('.search-results-order select').chosen({
		disable_search: true,
		width: "100%"
	});
	jQuery('#dsidx select').chosen({
		width: "auto"
	});
	
	
	/* FitVids v1.0 - Fluid Width Video Embeds
	https://github.com/davatron5000/FitVids.js/
	-------------------------*/
	jQuery('#main-content, article, #intro-wrapper').fitVids();
	jQuery('.fluid-width-video-wrapper').css('padding-top','56.25%'); // Always display videos 16:9 (100/16*9=56.25)

	
	/* Property Search Results
	-------------------------*/
	jQuery('.search-results-view i').click(function() {
		jQuery('.search-results-view i').removeClass('active');
		jQuery(this).toggleClass('active');
		
		jQuery('#property-items').fadeTo( 300 , 0, function() {
    	jQuery(this).fadeTo( 300, 1 );
		});
		
		setTimeout(function() {
			jQuery('#property-search-results').attr( 'data-view', jQuery('.search-results-view i.active').attr('data-view') );
		}, 300);
		
	});
	
	jQuery('#orderby').on('change', function() {

		var orderValue = jQuery(this).val();
		var OrderKey = 'orderby';	
		var windowLocationHref = window.location.href;
		
		// http://stackoverflow.com/questions/5999118/add-or-update-query-string-parameter
		function updateQueryStringParameter(uri, key, value) {
		  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
		  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
		  if (uri.match(re)) {
		    return uri.replace(re, '$1' + key + "=" + value + '$2');
		  }
		  else {
		    return uri + separator + key + "=" + value;
		  }
		}
		
		// Load new-built URI (Refresh With Orderby Update)
		document.location = updateQueryStringParameter( windowLocationHref, OrderKey, orderValue );
		
	});
	
	jQuery('.search-results-header .fa-repeat').click(function() {
		location.reload();
	});
	
	
	/* Scroll To Top Button
	-------------------------*/
	jQuery(window).scroll(function() {
		if ( jQuery(this).scrollTop() > 200 ) {
			jQuery('#fixed-controls').addClass('show');
		}
		else {
			jQuery('#fixed-controls').removeClass('show');
		}
	});
	
	
	/* Map - Button
	-------------------------*/
	jQuery('#map-controls a').click(function(e) {
		e.preventDefault();
	});
	
	
	/* Template - Intro
	-------------------------*/	
	
	jQuery('#intro-wrapper .toggle').click(function(e) {
		e.preventDefault();
		jQuery('.intro-search, .intro-map').toggleClass('transform');
		
		var introMapHeight = jQuery('.intro-map').height();
		jQuery('#intro-wrapper .intro-right').css( 'height', introMapHeight );
	});
	
	
	jQuery('#toggle-intro-wrapper').click(function(e) {
		e.preventDefault();
		jQuery('#intro-wrapper').find('.inner').fadeToggle();
		jQuery(this).find('i').toggleClass('fa-expand, fa-compress');
	});
	
	
	
	/* Logo Retina
	-------------------------*/
	var logoHeight = jQuery('.navbar-brand img').height() / 2;
	jQuery('.navbar-brand img').height(logoHeight);
	
	
	/* Contact Form - Single Property
	-------------------------*/
	if( jQuery().validate && jQuery().ajaxSubmit ) {

		var contactForm = {
			target: 'form-submitted'
		};
		
		jQuery('#contact-form').validate({
			errorLabelContainer: jQuery('#form-errors'),
	    submitHandler: function(form) {
							         jQuery(form).ajaxSubmit(contactForm); 
							         jQuery('#form-success').removeClass('hide');
								     },
			rules: {
		    email: {
		      required: true,
		      email: true
		    },
		    message: {
		      required: true
		    }
		  }
		});
	
	}

		
	/* Property Pagination
	-------------------------*/
	jQuery('#property-items').fadeTo(0, 0);
	jQuery('#property-items').fadeTo(400, 1);
	
	jQuery('#pagination a').click(function() {
		jQuery('#property-items').fadeTo(400, 0);
	});    

});


jQuery(window).load(function() {

	/* Layout "Full Width" - Property Image Height
	-------------------------*/
	function layoutFullWidth() {
		jQuery('#property-layout-full-width').each(function() {
			
			var singlePropertyImageContainerHeight = windowHeight - navHeight - 150;
			jQuery(this).find('.property-image-container').height( singlePropertyImageContainerHeight );
			jQuery('.flexslider-thumbnail').height( singlePropertyImageContainerHeight );
			
			// Set Property Image Offset To Vertically Center It
			jQuery(this).find('img.property-image').each(function() {
				var singlePropertyImageHeight = jQuery(this).height();
				var singlePropertyImageOffset = ( singlePropertyImageHeight - singlePropertyImageContainerHeight ) / 2;
				jQuery(this).css( 'bottom', singlePropertyImageOffset );

			});
			
		});
	
	}
			
	/* Layout "Boxed" - Property Image Height
	-------------------------*/	
	function layoutBoxed() {
		jQuery('#property-layout-boxed').each(function() {
		
			var singlePropertyImageContainerHeight = windowHeight - navHeight - 150;
			jQuery(this).find('.property-image-container').height( singlePropertyImageContainerHeight );
			
			var propertyHeaderHeight = jQuery('.property-header').height();
			var singlePropertyImageContainerBoxedHeight = windowHeight - navHeight - 50 - propertyHeaderHeight - 30 - 125;
			jQuery(this).find('.property-image-container').height( singlePropertyImageContainerBoxedHeight );			
			jQuery('.flexslider-thumbnail').height( singlePropertyImageContainerBoxedHeight );
			
			// Set Property Image Offset To Vertically Center It
			jQuery(this).find('img.property-image').each(function() {
				var singlePropertyImageHeight = jQuery(this).height();
				var singlePropertyImageOffset = ( singlePropertyImageHeight - singlePropertyImageContainerBoxedHeight ) / 2;
				jQuery(this).css( 'bottom', singlePropertyImageOffset );
				
			});   
			
		});
	}

	// Only Run Property Image Resize On A Min. Width of 1200px	& Desktops
	if ( windowWidth >= 1200 && !isMobile ) {
		
		layoutFullWidth();
		layoutBoxed();
		
		
		jQuery(window).on("throttledresize", function( event ) {
	  	layoutFullWidth();
			layoutBoxed();
		});
		
		jQuery(window).trigger( "throttledresize" );
		
	}
	
	/* Fullscreen Images On Click
	-------------------------*/	
	jQuery('body.single-property').find('.property-image').each(function() {
		Intense( jQuery(this) );
	});

	/* Template - Intro
	-------------------------*/	
	jQuery('#intro-wrapper').find('.intro-left, .intro-left-bg').addClass('show');
	
	setTimeout( function() {
		jQuery('#intro-wrapper').find('.intro-right').addClass('show');
	}, 500);
	
	setTimeout( function() {
		jQuery('#intro-wrapper').find('.social').fadeTo(1000, 1);
	}, 1500);
	

	/* Flexslider 2
	https://github.com/woothemes/FlexSlider
	============================== */
	jQuery('.flexslider').flexslider({
    animation: 			'fade',
    slideshow: 			true,
    slideshowSpeed: 5000,
    animationSpeed: 750,
    controlNav: 		false,
    start: 					function() {
											jQuery('.flex-active-slide').find('.container').addClass('in');
											jQuery('.spinner').delay(400).fadeOut(400, function(){
												jQuery(this).remove();
											});
										},
    before: 				function() {
	    								jQuery('.flex-active-slide').find('.container').removeClass('in');
	    								jQuery('.flex-active-slide').find('.container').addClass('out');
    								},
    after: 					function() {
   										jQuery('.slides').find('.container').removeClass('out');
   										jQuery('.flex-active-slide').find('.container').addClass('in');
										},
		
  });
  
  jQuery('.flexslider-off').flexslider({
    animation: 			'fade',
    slideshow: 			false,
    slideshowSpeed: 5000,
    animationSpeed: 750,
    controlNav: 		false
  });
  
  jQuery('.flexslider-nav').flexslider({
    animation: 			'fade',
    slideshow: 			true,
    slideshowSpeed: 5000,
    animationSpeed: 750
  });
  
  jQuery('.flexslider-nav-off').flexslider({
    animation: 			'fade',
    slideshow: 			false,
    slideshowSpeed: 5000,
    animationSpeed: 750
  });
  
  // Property Images Thumbnail Navigation "single-property.php"
  jQuery('.flexslider-thumbnail-navigation').flexslider({
    animation: 			'slide',
    animationLoop: 	false,
    slideshow: 			false,
    slideshowSpeed: 5000,
    animationSpeed: 750,
    directionNav: 	true,
    itemWidth: 			340,
    minItems: 			4,
    maxItems: 			4,
    itemMargin: 		10,
    controlNav: 		false,
    asNavFor: 			'.flexslider-thumbnail'
  });
  
  // Property Images Slideshow "single-property.php"
  jQuery('.flexslider-thumbnail').flexslider({
    animation: 			'slide',
    animationLoop: 	false,
    slideshow: 			false,
    slideshowSpeed: 5000,
    animationSpeed: 750,
    controlNav: 		false,
    sync: 					'.flexslider-thumbnail-navigation',
    start: 					function(slider) { // Initiate CSS spinner & fadeOut when slide is loaded
    	jQuery('.spinner').fadeOut(400);
    	setTimeout(function() {
				slider.removeClass('loading');
			}, 400);
    }
  });
  
  
  /* Latest Tweets Widget Plugin
  https://wordpress.org/plugins/latest-tweets-widget/
	============================== */
	var latestTweets = jQuery('.latest-tweets')
	var latestTweetsItems = jQuery(latestTweets).find('ul').children('li');
	
	if ( latestTweetsItems.length > 1 ) {
  	jQuery(latestTweets).find('ul').addClass('owl-carousel-1');
  }
  
  /* Owl Carousel ( 1 to 6 Columns )
  http://www.owlcarousel.owlgraphic.com/demos/responsive.html
	============================== */
     
  // Carousel: 1 Column
  jQuery('.owl-carousel-1').owlCarousel({
	  items: 					1,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
  });
 
  // Carousel: 2 Columns
  jQuery('.owl-carousel-2').owlCarousel({
	  items: 					2,
	  margin: 				30,
	  loop: 					true,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 2
							        }
							    }
  });
  
  // Carousel: 3 Columns
  jQuery('.owl-carousel-3').owlCarousel({
	  items: 					3,
	  margin: 				30,
	  loop: 					true,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 3
							        }
							    }
  });
  
  // Carousel: 4 Columns
  jQuery('.owl-carousel-4').owlCarousel({
	  items: 					4,
	  margin: 				30,
	  loop: 					true,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 4
							        }
							    }
  });
  
  // Carousel: 5 Columns
  jQuery('.owl-carousel-5').owlCarousel({
	  items: 					5,
	  margin: 				30,
	  loop: 					true,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 5
							        }
							    }
  });
  
  // Carousel: 6 Columns
  jQuery('.owl-carousel-6').owlCarousel({
	  items: 					6,
	  margin: 				30,
	  loop: 					true,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 6
							        }
							    }
  });


  /* Print Button
	-------------------------*/	
	jQuery('#print').click(function(e) {
		e.preventDefault();
		javascript:window.print();
	});

});