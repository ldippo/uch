jQuery(document).ready(function($) {

	// Toggle Metaboxes based on selected Post Format		
	$('#post-formats-select input').change(changeFormat);
	
	function changeFormat() {
		var postFormat = $('#post-formats-select input:checked').attr('value');		
		// Run Only On Posts
		if( typeof postFormat != 'undefined' ) {			
			// Hide all Post Metaboxes by Default
			$('.postbox-container div[id^=post_type_]').fadeOut();
			// Show Metabox that matches the selected Post Format
			$('.postbox-container #post_type_' + postFormat + '').fadeIn();					
		}
	}
	
	// Intro Template Only
	$('#page_template').change(changeTemplate);
	
	function changeTemplate() {
		var pageTemplate = $('#page_template option:selected').attr('value');		
		// Run Only On Posts
		if( pageTemplate != 'template-intro.php' ) {			
			// Hide all Post Metaboxes by Default
			$('.intro-only').fadeOut();
		}
		else {
			$('.intro-only').fadeIn();
		}
	}
	
	$(window).load(function() {
	
		changeFormat(); 	// Post Format Meta Boxes
		
		$('.intro-only').fadeOut();	// Hide Intro Meta Box Initially
		changeTemplate(); // Page template Meta Boxes
	});
		    
});