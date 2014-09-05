<?php
// Get page that is using Property Search Template
$template_page_property_search_array = get_pages( array (
	'meta_key' => '_wp_page_template',
	'meta_value' => 'template-property-search.php'
	)
);
foreach( $template_page_property_search_array as $template_page_property_search ) {
	$template_page_property_search = $template_page_property_search->ID;
	break;
}
?>
<form class="property-search-form" action="<?php if ( isset( $template_page_property_search ) && !empty( $template_page_property_search ) ) { echo get_permalink( $template_page_property_search ); } ?>">
	
	<div class="row">
	
		<?php
		global $realty_theme_option;
		$property_search_form_fields = $realty_theme_option['property-search-form-fields']['enabled'];

		foreach ( $property_search_form_fields as $property_search_form_field => $value ) {			
			
			switch($property_search_form_field) {
			
			case 'id' : ?>
			<div class="col-xs-6 col-sm-4 col-md-3 form-group">
				<input type="text" name="id" id="property-search-id" value="<?php echo isset( $_GET[ 'id' ])?$_GET[ 'id' ]:''; ?>" placeholder="<?php _e( 'Property ID:', 'tt' ); ?>" class="form-control" />
			</div>
			<?php
			break;
			
			case 'location' : ?>
			<div class="col-xs-6 col-sm-4 col-md-3 form-group select">
				<select name="location" id="property-search-location" class="form-control">
					<option value="all"><?php _e( 'Any Location', 'tt' ); ?></option>
					<?php
					$property_locations = get_terms( 'property-location' );
					foreach ( $property_locations as $property_location ) {
						
						$property_location_parent = $property_location->parent;
						if ( $property_location_parent ) {
							$property_location_parent_term = get_term_by( 'id', $property_location_parent, 'property-location' );
							$property_location_parent_text = $property_location_parent_term->name . ' - ';
						}
						else {
							$property_location_parent_text = false;
						}
						if ( isset( $_GET['location'] ) ) {
							$get_location = $_GET['location'];
						}
						else {
							$get_location = '';
						}
						echo '<option value="' . $property_location->slug . '" ' . selected( $property_location->slug, $get_location ) . '>' . $property_location_parent_text . $property_location->name . '</option>';
						
					}
					?>
				</select>
			</div>
			<?php
			break;
			
			case 'type' : ?>
			<div class="col-xs-6 col-sm-4 col-md-3 form-group select">
				<select name="type" id="property-search-type" class="form-control">
					<option value="all"><?php _e( 'Any Type', 'tt' ); ?></option>
					<?php
					$property_types = get_terms( 'property-type' );
					if ( isset( $_GET['type'] ) ) {
						$get_type = $_GET['type'];
					}
					else {
						$get_type = '';
					}
					foreach ( $property_types as $property_type ) {
						echo '<option value="' . $property_type->slug . '" ' . selected( $property_type->slug, $get_type ) . '>' . $property_type->name . '</option>';
					}
					?>
				</select>
			</div>
			<?php
			break;
			
			case 'status' :?>
			<div class="col-xs-6 col-sm-4 col-md-3 form-group select">
				<select name="status" id="property-search-status" class="form-control">
					<option value="all"><?php _e( 'Any Status', 'tt' ); ?></option>
					<?php
					$property_status_array = get_terms( 'property-status' );
					if ( isset( $_GET['status'] ) ) {
						$get_status = $_GET['status'];
					}
					else {
						$get_status = '';
					}
					foreach ( $property_status_array as $property_status ) {
						echo '<option value="' . $property_status->slug . '" ' . selected( $property_status->slug, $get_status ) . '>' . $property_status->name . '</option>';
					}
					?>
				</select>
			</div>
			<?php
			break;
			
			case 'maxprice' : ?>
			<div class="col-xs-6 col-sm-4 col-md-3 form-group">
				<input type="number" name="max-price" id="property-search-max-price" value="<?php echo isset( $_GET[ 'max-price' ])?$_GET[ 'max-price' ]:''; ?>" placeholder="<?php _e( 'Max. Price:', 'tt' ); ?>" min="0" class="form-control" />
			</div>
			<?php
			break;
			
			case 'minrooms' : ?>
			<div class="col-xs-6 col-sm-4 col-md-3 form-group">
				<input type="number" name="min-rooms" id="property-search-min-rooms" value="<?php echo isset( $_GET[ 'min-rooms' ])?$_GET[ 'min-rooms' ]:''; ?>" placeholder="<?php _e( 'Min. Rooms:', 'tt' ); ?>" min="0" class="form-control" />
			</div>
			<?php
			break;
			
			case 'availablefrom' : ?>
			<div class="col-xs-6 col-sm-4 col-md-3 form-group">
				<div class="input-group">
					<input type="text" name="datepicker" id="property-search-availability" class="form-control datepicker" value="<?php echo isset( $_GET[ 'datepicker' ])?$_GET[ 'datepicker' ]:''; ?>" placeholder="<?php _e( 'Available From:', 'tt' ); ?>" /><span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
				</div>
			</div>
			<?php 
			} // switch 
			} // foreach
			?>
			
			
			<!-- Default Order: Newest Properties First -->
			<input type="hidden" name="orderby" value="date-new" />
			
			<div class="col-xs-6 col-sm-4 col-md-3 form-group">
				<input type="submit" value="<?php _e( 'Search', 'tt' ); ?>" class="btn btn-primary btn-block form-control" />
			</div>
		
	</div>

</form>