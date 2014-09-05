function tt_ajax_search_results() {
  "use strict";

  var id, location, type, status, max_price, min_rooms, availability, results = jQuery('#property-items');
  id      			=   jQuery('#property-search-id').attr('value');
  location    	=   jQuery('#property-search-location').attr('value');
  type        	=   jQuery('#property-search-type').attr('value');
  status        =   jQuery('#property-search-status').attr('value');
  max_price     =   parseInt(jQuery('#property-search-max-price').val(), 10);
  min_rooms     =   parseInt(jQuery('#property-search-min-rooms').val(), 10);
  availability  =   parseInt(jQuery('#property-search-availability').val(), 10);

  jQuery.ajax({
    
    type: 'GET',
    url: ajaxURL,
    data: {
	    'action'          :   'tt_ajax_search', // WP Function
	    'id'              :   id,
	    'location'        :   location,
	    'type'    				:   type,
	    'status'     			:   status,
	    'max_price'       :   max_price,
	    'min_rooms'       :   min_rooms,
	    'availability'    : 	availability
    },
    success: function (response) {
      results.html(response); // Show response from function tt_ajax_search()
    },
    error: function () {
	    //alert("Search Error");
    }
    
  });

}

// Fire Search Results Ajax On Serach Field Change
jQuery('.property-search-form select, .property-search-form input').change(function() {
	removeMarkers();
	tt_ajax_search_results();
});