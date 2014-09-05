<?php 
get_header(); 

$hide_sidebar = get_post_meta( $post->ID, 'estate_page_hide_sidebar', true );

$property_location = get_the_terms( $post->ID, 'property-location' );
$property_status = get_the_terms( $post->ID, 'property-status' );
$property_type = get_the_terms( $post->ID, 'property-type' );
$property_features = get_the_terms( $post->ID, 'property-features' );

// Get Date Format Settings from "Settings > General >Date Format"
$date_format = get_option( 'date_format' );

$available_from = get_post_meta( $post->ID, 'estate_property_available_from', true );
// Create Date from Post Meta Data
$available_from_create_date = date_create( $available_from );
$available_from_date = date_format( $available_from_create_date, $date_format );
$today = current_time( $date_format );

$single_property_layout = get_post_meta( get_the_ID(), 'estate_property_layout', true );
$property_images = get_post_meta( get_the_ID(), 'estate_property_images', false );
$featured = get_post_meta( $post->ID, 'estate_property_featured', true );
$property_id = get_post_meta( $post->ID, 'estate_property_id', true );
$address = get_post_meta( $post->ID, 'estate_property_address', true );
$google_maps = get_post_meta( $post->ID, 'estate_property_location', true );
$size = get_post_meta( $post->ID, 'estate_property_size', true );
$size_unit = get_post_meta( $post->ID, 'estate_property_size_unit', true );
$rooms = get_post_meta( $post->ID, 'estate_property_rooms', true );
$bedrooms = get_post_meta( $post->ID, 'estate_property_bedrooms', true );
$bathrooms = get_post_meta( $post->ID, 'estate_property_bathrooms', true );
$garages = get_post_meta( $post->ID, 'estate_property_garages', true );
$agent = get_post_meta( $post->ID, 'estate_property_agent', true );

$email = get_post_meta( $agent, 'estate_agent_email', true );
$office = get_post_meta( $agent, 'estate_agent_office_phone_number', true );
$mobile = get_post_meta( $agent, 'estate_agent_mobile_phone_number', true );
$fax = get_post_meta( $agent, 'estate_agent_fax_number', true );
$facebook = get_post_meta( $agent, 'estate_agent_facebook', true );
$twitter = get_post_meta( $agent, 'estate_agent_twitter', true );
$google = get_post_meta( $agent, 'estate_agent_google', true );
$linkedin = get_post_meta( $agent, 'estate_agent_linkedin', true );

global $realty_theme_option;
$property_layout = $realty_theme_option['property-layout'];
$property_title_details = $realty_theme_option['property-title-details'];
$property_title_features = $realty_theme_option['property-title-features'];
$property_title_agent = $realty_theme_option['property-title-agent'];
$agent_information = $realty_theme_option['property-agent-information'];
$property_contact_form = $realty_theme_option['property-contact-form'];
$property_contact_form_default_email = $realty_theme_option['property-contact-form-default-email'];
$social_sharing = $realty_theme_option['property-social-sharing'];
?>

<?php 
// Check Theme Option - Property Layout "Full Width"
if ( ( $property_layout == "layout-full-width" || $single_property_layout == "full_width" ) && $single_property_layout != "boxed" ) { ?>
</div><!-- .container -->

<div id="property-layout-full-width">
	
	<div class="property-header-container<?php if ( !has_post_thumbnail() ) { echo " no-property-image"; } ?>">
		<div class="container">
			<div class="property-header">
				<h1 class="title">
					<?php echo get_the_title(); ?>
					<?php if ( $address ) { ?><a href="#map" class="address" data-toggle="tooltip" title="<?php echo $address; ?>"><i class="fa fa-map-marker"></i></a><?php } ?>
				</h1>
				<div class="clearfix"></div>
				<div class="meta">
					<?php 
					echo tt_property_price();
					if ( $property_status ) { foreach ( $property_status as $status ) { echo ' <span class="property-status">(' . $status->name . ')</span>'; break; } }
					if ( $property_type && $property_status ) echo '<span class="separator">&middot;</span>';
					if ( $property_type ) { foreach ( $property_type as $type ) { echo '<span class="property-type">' . $type->name . '</span>'; break; } }
					?>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	// No Gallery Found -> Use Featured Image
	if ( !$property_images ) {
		if ( has_post_thumbnail() ) {
			echo '<div class="property-image-container">';
			the_post_thumbnail( 'full', array( 'class' => 'property-image' ) );
			echo '</div>';
		}
	}
	// Gallery Found -> Show Slideshow + Thumbnail Navigation
	else {
	?>
	
	<div class="property-image-container">
	
		<div class="spinner">
		  <div class="bounce1"></div>
		  <div class="bounce2"></div>
		  <div class="bounce3"></div>
		</div>
	
		<div class="flexslider-thumbnail loading">
			<ul class="slides">					
			<?php
			$args = array(
				'post_type' => 'attachment',
				'orderby' => 'post__in',
				'post__in' => $property_images,
				'posts_per_page' => count($property_images)
			);
			
			$gallery_array = get_posts( $args );
			
			foreach ($gallery_array as $slide) {
				$attachment = wp_get_attachment_image_src( $slide->ID, 'full' );
				$attachment_url = $attachment[0];
			?>
				<li><img src="<?php echo $attachment_url; ?>" alt="" class="property-image" /></li>
			<?php }	?>
			</ul>
		</div>
	
	</div>
	
	<div class="flexslider-thumbnail-navigation">
		<ul class="slides">					
		<?php		
		foreach ($gallery_array as $slide) {
			$attachment = wp_get_attachment_image_src( $slide->ID, 'property-thumb' );
			$attachment_url = $attachment[0];
		?>
			<li><img src="<?php echo $attachment_url; ?>" alt="" /></li>
		<?php }	?>
		</ul>
	</div>
	<?php } // END Gallery Found ?>
	
</div>

<div class="container"> 

	<div class="property-meta primary-tooltips">
		<div class="row">
			<?php if ( $available_from ) { ?>
			<div class="col-sm-4 col-md-3">
				<div class="meta-title"><i class="fa fa-calendar-o"></i></div>
				<div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Available From', 'tt' ); ?>"><?php echo $available_from_date; // if ( $available_from_date <= $today ) { echo '<i class="fa fa-check"></i>'; } ?></div>
			</div>
			<?php }
			if ( $size ) { ?>
			<div class="col-sm-4 col-md-3">
				<div class="meta-title"><i class="fa fa-expand"></i></div>
				<div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Size', 'tt' ); ?>"><?php echo $size . ' ' . $size_unit; ?></div>
			</div>
			<?php }
			if ( $rooms ) { ?>
			<div class="col-sm-4 col-md-3">
				<div class="meta-title"><i class="fa fa-building-o"></i></div>
				<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Rooms', 'tt' ); ?>"><?php echo $rooms . ' ' . _n( __( 'Room', 'tt' ), __( 'Rooms', 'tt' ), $rooms, 'tt' ); ?></div>
			</div>
			<?php }
			if ( $bedrooms ) { ?>
			<div class="col-sm-4 col-md-3">
				<div class="meta-title"><i class="fa fa-inbox"></i></div>
				<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Bedrooms', 'tt' ); ?>"><?php echo $bedrooms . ' ' . _n( __( 'Bedroom', 'tt' ), __( 'Bedrooms', 'tt' ), $bedrooms, 'tt' ); ?></div>
			</div>
			<?php }
			if ( $bathrooms ) { ?>
			<div class="col-sm-4 col-md-3">
				<div class="meta-title"><i class="fa fa-tint"></i></div>
				<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Bathrooms', 'tt' ); ?>"><?php echo $bathrooms . ' ' . _n( __( 'Bathroom', 'tt' ), __( 'Bathrooms', 'tt' ), $bathrooms, 'tt' ); ?></div>
			</div>
			<?php }
			if ( $garages ) { ?>
			<div class="col-sm-4 col-md-3">
				<div class="meta-title"><i class="fa fa-car"></i></div>
				<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Garages', 'tt' ); ?>"><?php echo $garages . ' '. _n( __( 'Garage', 'tt' ), __( 'Garages', 'tt' ), $garages, 'tt' ); ?></div>
			</div>
			<?php } 
			if ( $property_id ) { ?>
			<div class="col-sm-4 col-md-3">
				<div class="meta-title"><i class="fa fa-slack"></i></div>
				<div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Property ID', 'tt' ); ?>"><?php echo $property_id; ?></div>
			</div>
			<?php } ?>
			<div class="col-sm-4 col-md-3">
				<a href="#" id="print">
					<div class="meta-title"><i class="fa fa-print"></i></div>
					<div class="meta-data"><?php _e( 'Print this page', 'tt' ); ?></div>
				</a>
			</div>	
		</div>
	</div>

<?php } // END Property Layout "Full Width" ?>

		<?php
		// Check Theme Option - Property Layout "Boxed"
		if ( ( $property_layout == "layout-boxed" || $single_property_layout == "boxed" ) && $single_property_layout != "full_width" ) {
		?>
				
		<div id="property-layout-boxed">
			
			<div class="property-header-container">
				<div class="property-header">
					<h1 class="title">
						<?php echo get_the_title(); ?>
						<?php if ( $address ) { ?><a href="#map" class="address" data-toggle="tooltip" title="<?php echo $address; ?>"><i class="fa fa-map-marker"></i></a><?php } ?>
					</h1>
					<div class="clearfix"></div>
					<div class="meta">
						<?php 
						echo tt_property_price();
						if ( $property_status ) { foreach ( $property_status as $status ) { echo ' <span class="property-status">(' . $status->name . ')</span>'; break; } }
						if ( $property_type && $property_status ) echo '<span class="separator">&middot;</span>';
						if ( $property_type ) { foreach ( $property_type as $type ) { echo '<span class="property-type">' . $type->name . '</span>'; break; } }
						?>
					</div>
				</div>
			</div>
		
			<?php
			// No Gallery Found -> Use Featured Image
			if ( !$property_images ) {
				if ( has_post_thumbnail() ) { 
					echo '<div class="property-image-container">';
					the_post_thumbnail( 'thumbnail-1200', array( 'class' => 'property-image' ) );
					echo '</div>';
				}	
				else {
					echo '<img src ="//placehold.it/1200x420/eee/ccc/&text=.." />';
				}
			}
			// Gallery Found -> Show Slideshow + Thumbnail Navigation
			else {
			?>
	
			<div class="property-image-container">
			
				<div class="spinner">
				  <div class="bounce1"></div>
				  <div class="bounce2"></div>
				  <div class="bounce3"></div>
				</div>
		
				<div class="flexslider-thumbnail loading">
					<ul class="slides">					
					<?php
					$args = array(
						'post_type' => 'attachment',
						'orderby' => 'post__in',
						'post__in' => $property_images,
						'posts_per_page' => count($property_images)
					);
					
					$gallery_array = get_posts( $args );
					
					foreach ($gallery_array as $slide) {
						$attachment = wp_get_attachment_image_src( $slide->ID, 'thumbnail-1200' );
						$attachment_url = $attachment[0];
					?>
						<li><img src="<?php echo $attachment_url; ?>" alt="" class="property-image" /></li>
					<?php }	?>
					</ul>
				</div>
			
			</div>
			
			<div class="flexslider-thumbnail-navigation">
				<ul class="slides">					
				<?php		
				foreach ($gallery_array as $slide) {
					$attachment = wp_get_attachment_image_src( $slide->ID, 'property-thumb' );
					$attachment_url = $attachment[0];
				?>
					<li><img src="<?php echo $attachment_url; ?>" alt="" /></li>
				<?php }	?>
				</ul>
			</div>
			<?php } // END Gallery Found ?>
		
		</div>
		
		<div class="property-meta primary-tooltips">
			<div class="row">
				<?php if ( $available_from ) { ?>
				<div class="col-sm-4 col-md-3">
					<div class="meta-title"><i class="fa fa-calendar-o"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Available From', 'tt' ); ?>"><?php echo $available_from_date; // if ( $available_from_date <= $today ) { echo '<i class="fa fa-check"></i>'; } ?></div>
				</div>
				<?php }
				if ( $size ) { ?>
				<div class="col-sm-4 col-md-3">
					<div class="meta-title"><i class="fa fa-expand"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Size', 'tt' ); ?>"><?php echo $size . ' ' . $size_unit; ?></div>
				</div>
				<?php }
				if ( $rooms ) { ?>
				<div class="col-sm-4 col-md-3">
					<div class="meta-title"><i class="fa fa-building-o"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Rooms', 'tt' ); ?>"><?php echo $rooms . ' ' . _n( __( 'Room', 'tt' ), __( 'Rooms', 'tt' ), $rooms, 'tt' ); ?></div>
				</div>
				<?php }
				if ( $bedrooms ) { ?>
				<div class="col-sm-4 col-md-3">
					<div class="meta-title"><i class="fa fa-inbox"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Bedrooms', 'tt' ); ?>"><?php echo $bedrooms . ' ' . _n( __( 'Bedroom', 'tt' ), __( 'Bedrooms', 'tt' ), $bedrooms, 'tt' ); ?></div>
				</div>
				<?php }
				if ( $bathrooms ) { ?>
				<div class="col-sm-4 col-md-3">
					<div class="meta-title"><i class="fa fa-tint"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Bathrooms', 'tt' ); ?>"><?php echo $bathrooms . ' ' . _n( __( 'Bathroom', 'tt' ), __( 'Bathrooms', 'tt' ), $bathrooms, 'tt' ); ?></div>
				</div>
				<?php }
				if ( $garages ) { ?>
				<div class="col-sm-4 col-md-3">
					<div class="meta-title"><i class="fa fa-car"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Garages', 'tt' ); ?>"><?php echo $garages . ' '. _n( __( 'Garage', 'tt' ), __( 'Garages', 'tt' ), $garages, 'tt' ); ?></div>
				</div>
				<?php } 
				if ( $property_id ) { ?>
				<div class="col-sm-4 col-md-3">
					<div class="meta-title"><i class="fa fa-slack"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Property ID', 'tt' ); ?>"><?php echo $property_id; ?></div>
				</div>
				<?php } ?>
				<div class="col-sm-4 col-md-3">
					<a href="#" id="print">
						<div class="meta-title"><i class="fa fa-print"></i></div>
						<div class="meta-data"><?php _e( 'Print this page', 'tt' ); ?></div>
					</a>
				</div>	
			</div>
		</div>

		<?php 
		} // END Property Layout "Boxed"
		
		wp_reset_postdata(); 
		
		echo '<div class="row">';
		
		if ( !$hide_sidebar && is_active_sidebar( 'sidebar_property' ) ) {
			echo '<div class="col-sm-8 col-md-9">';
		} else {
			echo '<div class="col-sm-12">';
		}
		?>
		
		<div id="main-content" class="content-box">
			
			<section>
				<?php if ( $property_title_details ) { echo '<h3 class="section-title"><span>' . $property_title_details . '</span></h3>'; } ?>
				<?php the_content(); ?>
			</section>
			
			<?php	if ( $property_features ) { ?>
			<section id="property-features" class="primary-tooltips">
				<?php if ( $property_title_features ) { echo '<h3 class="section-title"><span>' . $property_title_features . '</span></h3>'; } ?>
				<ul class="list-unstyled row">
				<?php
				
				$property_features_all = get_terms( 'property-features', array( 'hide_empty' => false ) ); // Get All Property Features
				$property_features_slug = array();

				// Built Array With All Property Features
				foreach ( $property_features as $property_feature ) {
					$property_features_slug[] = $property_feature->slug;
				}
				
				// Loop Thorugh All Features												
				foreach( $property_features_all as $property_feature_item ) {
				
					$property_feature_slug = $property_feature_item->slug;
			    $description = $property_feature_item->description;
			    $description = wp_trim_words( $description, 10, ' ..' ); 

					// Add Class "inactive" To Every Feature, That This Property Doesn't Have
					if ( !in_array( $property_feature_slug, $property_features_slug ) ) { 
						$inactive = ' class="inactive"'; 
					}
					else {
						$inactive = '';
					}
					
					if ( !$hide_sidebar && is_active_sidebar( 'sidebar_property' ) ) {
						$output  = '<li class="col-sm-6 col-md-4">';
					} else {
						$output  = '<li class="col-sm-3">';
					}
					
					$output .= '<a href="' . site_url() . '/property-feature/'. $property_feature_item->slug . '"' . $inactive . '>';
					if ( $inactive ) {
						$output .= '<i class="fa fa-times"></i>';
					}
					else {
						$output .= '<i class="fa fa-check"></i>';
					}
					
					$output .=  $property_feature_item->name;
					if ( $description ) {
						$output .= '<i class="fa fa-question-circle" data-toggle="tooltip" title="' . $description . '"></i>';
					}
					$output .= '</a>';
					$output .= '</li>';
					
					echo $output;
					
			  }
				
				?>
				</ul>
			</section>
			<?php } ?>
			
			<?php
			if ( $google_maps ) { 
				get_template_part( 'lib/inc/template/google-map-single-property' ); 
			}
			if ( $social_sharing ) { 
				echo '<div class="primary-tooltips">';
				tt_social_sharing();
				echo '</div>';
			}
			?>
			
		</div><!-- #main-container -->
		
		<?php	if ( $agent_information || $property_contact_form ) { ?>
		<div id="agent" class="content-box">
			<?php
			// Check Theme Option - Display Agent Information
			if ( $agent && $agent_information ) {
			
			if ( $property_title_agent ) { echo '<h3 class="section-title"><span>' . $property_title_agent . '</span></h3>'; }
			
			$args = array(
				'post_type' 				=> 'agent',
				'posts_per_page' 		=> 1,
				'page_id'						=> $agent
			);
			
			$query_property_agent = new WP_Query( $args );
	
			if ( $query_property_agent->have_posts() ) : while ( $query_property_agent->have_posts() ) : $query_property_agent->the_post(); 
			?>			
	
			<section class="row">
				<?php
				if ( has_post_thumbnail() ) {
					echo '<div class="col-sm-4">';
					echo the_post_thumbnail( 'square-400', array( 'class' => 'agent-thumbnail' ) );
					echo '</div>';
					echo '<div class="col-sm-8">';
				}	
				else {
					echo '<div class="col-sm-12">';
				}
				
					the_title( '<h3 class="title">', '</h3>' ); ?>
					
					<?php if ( $email ) { ?><div class="contact"><i class="fa fa-envelope-o"></i><?php echo antispambot( $email ); ?></div><?php } ?>
					<?php if ( $office ) { ?><div class="contact"><i class="fa fa-phone"></i><?php echo $office; ?></div><?php } ?>
					<?php if ( $mobile ) { ?><div class="contact"><i class="fa fa-mobile"></i><?php echo $mobile; ?></div><?php } ?>
					<?php if ( $fax ) { ?><div class="contact"><i class="fa fa-fax"></i><?php echo $fax; ?></div><?php } ?>
					
					<div class="description">
						<?php
							$content = get_the_content();
							$trim = wp_trim_words( $content, 40, '..<div class="agent-more-link"><a href="'. get_permalink() .'" class="btn btn-primary">' . __( 'Read More', 'tt' ) . '</a></div>' );
							echo $trim;
						?>
					</div>
					
				</div>
			</section>
			<?php
			endwhile;
			wp_reset_query();
			endif;
			}
			// Check Theme Option - Display Agent Contact Form
			if ( $property_contact_form ) {
			?>
			<h4 class="section-title"><span><?php _e( 'Contact', 'tt' ); ?></span></h4>
			<form id="contact-form" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">

				<div class="row primary-tooltips">
				
					<div class="form-group col-sm-4">
          	<input type="text" name="name" id="name" class="form-control" placeholder="<?php _e( 'Name', 'tt' ); ?>" title="<?php _e( 'Please enter your name.', 'tt' ); ?>">
          	<input type="text" name="email" id="email" class="form-control" placeholder="<?php _e( 'Email', 'tt' ); ?>" title="<?php _e( 'Please enter your email.', 'tt' ); ?>">
          	<input type="text" name="phone" id="phone" class="form-control" placeholder="<?php _e( 'Phone', 'tt' ); ?>" title="<?php _e( 'Please enter only digits for your phone number.', 'tt' ); ?>">
					</div>
					
					<div class="form-group col-sm-8">	
          	<textarea name="message" id="comment" class="form-control" placeholder="<?php _e( 'Message', 'tt' ); ?>" title="<?php _e( 'Please enter your message.', 'tt' ); ?>"></textarea>
					</div>
					          
				</div>
				
				<input type="submit" name="submit" value="<?php _e( 'Send Message', 'tt' ); ?>" >
				
        <input type="hidden" name="action" value="submit_property_contact_form" />
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(); ?>" />
        <?php 
        // Check If Agent Has An Email Address
        if ( $email ) { 
        ?>
        	<input type="hidden" name="agent_email" value="<?php echo antispambot( $email ); ?>">
        <?php 
        } 
        // No Agent Email Address Found -> Send Email To Site Administrator
        else { ?>
	        <input type="hidden" name="agent_email" value="<?php echo antispambot( $property_contact_form_default_email ); ?>">
	      <?php } ?>
        <input type="hidden" name="property_title" value="<?php echo get_the_title( get_the_ID() ); ?>" />
        <input type="hidden" name="property_url" value="<?php echo get_permalink( get_the_ID() ); ?>" />

      </form>
      
      <div id="form-errors"></div>
      <div id="form-success" class="hide alert alert-success alert-dismissable">
      	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      	<?php _e( 'Message has been sent successfully.', 'tt' ); ?>
      </div>
      <div id="form-submitted"></div>
      
      <?php } ?>
	
		</div><!-- #agent -->
		<?php } ?>
	
	</div><!-- .col-sm-9 -->
	
	<?php 
	// Check for Property Sidebar
	if ( !$hide_sidebar && is_active_sidebar( 'sidebar_property' ) ) : 
	?>
	<div class="col-sm-4 col-md-3">
		<ul id="sidebar">
			<?php dynamic_sidebar( 'sidebar_property' ); ?>
		</ul>
	</div>
	<?php endif; ?>
	
</div><!-- .row -->

<?php get_footer(); ?>