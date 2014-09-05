<?php 
get_header();

global $post;

$hide_sidebar = get_post_meta( $post->ID, 'estate_page_hide_sidebar', true );

$email = get_post_meta( $post->ID, 'estate_agent_email', true );
$office = get_post_meta( $post->ID, 'estate_agent_office_phone_number', true );
$mobile = get_post_meta( $post->ID, 'estate_agent_mobile_phone_number', true );
$fax = get_post_meta( $post->ID, 'estate_agent_fax_number', true );
$facebook = get_post_meta( $post->ID, 'estate_agent_facebook', true );
$twitter = get_post_meta( $post->ID, 'estate_agent_twitter', true );
$google = get_post_meta( $post->ID, 'estate_agent_google', true );
$linkedin = get_post_meta( $post->ID, 'estate_agent_linkedin', true );
?>

<div class="row">
	
	<?php 
	// Check for Agent Sidebar
	if ( !$hide_sidebar && is_active_sidebar( 'sidebar_agent' ) ) {
		echo '<div class="col-sm-8 col-md-9">';
	} else {
		echo '<div class="col-sm-12">';
	}
	?>
	
		<div id="main-content" class="content-box">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>			
		
			<section>
				<div class="row">
					
					<?php
					if ( has_post_thumbnail() ) {
						echo '<div class="col-sm-4">';
						echo the_post_thumbnail( 'square-400', array( 'class' => 'agent-thumbnail' ) );
						echo '</div>';
						echo '<div class="col-sm-8 agent-details">';
					}	
					else {
						echo '<div class="col-sm-12 agent-details">';
					}
				
					the_title( '<h3 class="title">', '</h3>' ); ?>
						
						<?php if ( $email ) { ?><div class="contact"><i class="fa fa-envelope-o"></i><?php echo antispambot( $email ); ?></div><?php } ?>
						<?php if ( $office ) { ?><div class="contact"><i class="fa fa-phone"></i><?php echo $office; ?></div><?php } ?>
						<?php if ( $mobile ) { ?><div class="contact"><i class="fa fa-mobile"></i><?php echo $mobile; ?></div><?php } ?>
						<?php if ( $fax ) { ?><div class="contact"><i class="fa fa-fax"></i><?php echo $fax; ?></div><?php } ?>
						
						<?php if ( $facebook || $twitter || $google || $linkedin ) { ?>
						<div class="social-transparent">
						<?php
						if ( $facebook ) { ?>
						<a href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a>
						<?php }
						if ( $twitter ) { ?>
						<a href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a>
						<?php }
						if ( $google ) { ?>
						<a href="<?php echo $google; ?>"><i class="fa fa-google-plus"></i></a>
						<?php }
						if ( $linkedin ) { ?>
						<a href="<?php echo $linkedin; ?>"><i class="fa fa-linkedin"></i></a>
						<?php }	?>
						</div>
						<?php }	?>
					</div>
					
				</div><!-- .row -->
			</section>
				
			<?php the_content(); ?>
			
			<h4 class="section-title"><span><?php _e( 'Contact', 'tt' ); ?></span></h4>
			<form id="contact-form" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">

				<div class="row primary-tooltips">
				
					<?php
					if ( !$hide_sidebar && is_active_sidebar( 'sidebar_agent' ) ) {
						echo '<div class="form-group col-md-4">';
					} else {
						echo '<div class="form-group col-sm-4">';
					}
					?>
          	<input type="text" name="name" id="name" class="form-control" placeholder="<?php _e( 'Name', 'tt' ); ?>" title="<?php _e( 'Please enter your name.', 'tt' ); ?>">
          	<input type="text" name="email" id="email" class="form-control" placeholder="<?php _e( 'Email', 'tt' ); ?>" title="<?php _e( 'Please enter your email.', 'tt' ); ?>">
          	<input type="text" name="phone" id="phone" class="form-control" placeholder="<?php _e( 'Phone', 'tt' ); ?>" title="<?php _e( 'Please enter only digits for your phone number.', 'tt' ); ?>">
					</div>
					
					<?php
					if ( !$hide_sidebar && is_active_sidebar( 'sidebar_agent' ) ) {
						echo '<div class="form-group col-md-8">';
					} else {
						echo '<div class="form-group col-sm-8">';
					}
					?>
          	<textarea name="message" id="comment" class="form-control" placeholder="<?php _e( 'Message', 'tt' ); ?>" title="<?php _e( 'Please enter your message.', 'tt' ); ?>"></textarea>
					</div>
					          
				</div>
				
				<input type="submit" name="submit" value="<?php _e( 'Send Message', 'tt' ); ?>" >
				
        <input type="hidden" name="action" value="submit_agent_contact_form" />
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(); ?>" />
        <?php 
        global $realty_theme_option;
        $property_contact_form_default_email = $realty_theme_option['property-contact-form-default-email'];
        $email = get_post_meta( get_the_ID(), 'estate_agent_email', true );
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

      </form>
      
      <div id="form-errors"></div>
      <div id="form-success" class="hide alert alert-success alert-dismissable">
      	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      	<?php _e( 'Message has been sent successfully.', 'tt' ); ?>
      </div>
      <div id="form-submitted"></div>
			
			<?php
			endwhile;
			wp_reset_query();
			endif;
			?>
	
		</div><!-- #main-content -->
		
		<?php 
		// Property Listings
		get_template_part( 'lib/inc/template/property', 'featured' );
		?>
	
	</div><!-- .col-sm-9 -->
	
	<?php 
	// Check for Agent Sidebar
	if ( !$hide_sidebar && is_active_sidebar( 'sidebar_agent' ) ) : 
	?>
	<div class="col-sm-4 col-md-3">
		<ul id="sidebar">
			<?php dynamic_sidebar( 'sidebar_agent' ); ?>
		</ul>
	</div>
	<?php endif; ?>
	
</div><!-- .row -->

<?php get_footer(); ?>