<?php
// Credits: http://buffercode.com/simple-method-create-custom-wordpress-widget-admin-dashboard/
// REGISTER WIDGET
function widget_agents() {
	register_widget( 'widget_agents' );
}
add_action( 'widgets_init', 'widget_agents' );

class widget_agents extends WP_Widget {

	// CONSTRUCT WIDGET
	function widget_agents() {
		$widget_ops = array( 'classname' => 'widget_agents', 'description' => __( 'Featured Agent', 'tt' ) );
		$this->WP_Widget( 'widget_agents', __( 'Realty - Featured Agent', 'tt' ), $widget_ops );
	}
	
	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
  
	  if ( isset( $instance[ 'title' ] ) && isset ( $instance[ 'agent' ] ) ) {
			$title = $instance[ 'title' ];
			$agent = $instance[ 'agent' ];
		}
		else {
			$title = __( 'Featured Agent', 'tt' );
			$agent = false;
		}
		if ( isset ( $instance[ 'random' ] ) ) {
			$random = $instance[ 'random' ];
		}
		else {
			$random = false;
		}
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title );?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'agent' ); ?>"><?php _e( 'Choose Featured Agent:', 'tt' ); ?></label> 
			<?php
			$args_agent = array(
				'post_type' 				=> 'agent',
				'posts_per_page' 		=> -1
			);
			
			$query_agent = new WP_Query( $args_agent );
			
			if ( $query_agent->have_posts() ) : 

			?>
			<select name="<?php echo $this->get_field_name( 'agent' ); ?>" id="<?php echo $this->get_field_id( 'agent' ); ?>" class="widefat">
				<?php 
				while ( $query_agent->have_posts() ) : $query_agent->the_post();
				global $post;
				?>
				<option value="<?php echo $post->ID; ?>" <?php selected( $agent, $post->ID ); ?>><?php the_title(); ?></option>
				<?php
				endwhile;
				?>
			</select>
			<?php
			wp_reset_query();
			endif;
			?>

		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Show Random Agent:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'random' ); ?>" type="checkbox" <?php checked( $random, 'on' ); ?> />
		</p>
		 
		<?php
		
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {
  	  
	  $instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		 
		$instance['agent'] = $new_instance['agent'];		 		 
		$instance['random'] = $new_instance['random'];		 		 
		
		return $instance;
	  
  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {
	  
	  extract( $args );
 
		// Widget starts to print information
		echo $before_widget;
		 
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );	 
		$agent = empty( $instance[ 'agent' ] ) ? '1' : $instance[ 'agent' ];
		$random = $instance[ 'random' ] ? true : false;
		 
		if ( !empty( $title ) ) { 
			echo $before_title . $title . $after_title; 
		};

		// Query Featured Agent
		$args_featured_agent = array(
			'post_type' 				=> 'agent',
			'posts_per_page' 		=> 1,
		);
		
		// Show Random Agent:
		if ( $random ) {
			$args_featured_agent[ 'orderby' ] = 'rand';
		}
		// Show Selected Agent
		else {
			$args_featured_agent[ 'p' ] = $agent;
		}
		
		$query_featured_agent = new WP_Query( $args_featured_agent );
		
		if ( $query_featured_agent->have_posts() ) :
		?>
		<div class="">
			<?php
			while ( $query_featured_agent->have_posts() ) : $query_featured_agent->the_post();
			global $post;
			$email = get_post_meta( $post->ID, 'estate_agent_email', true );
			$office = get_post_meta( $post->ID, 'estate_agent_office_phone_number', true );
			$mobile = get_post_meta( $post->ID, 'estate_agent_mobile_phone_number', true );
			$facebook = get_post_meta( $post->ID, 'estate_agent_facebook', true );
			$twitter = get_post_meta( $post->ID, 'estate_agent_twitter', true );
			$google = get_post_meta( $post->ID, 'estate_agent_google', true );
			$linkedin = get_post_meta( $post->ID, 'estate_agent_linkedin', true );
			if ( $facebook || $twitter || $google || $linkedin ) {
				$no_socials = false;
			}
			else {
				$no_socials = true;
			}
			?>
				<div>
					<div class="widget-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php 
							if ( has_post_thumbnail() ) { 
								the_post_thumbnail( 'thumbnail-400-300' ); 
							}	
							else {
								echo '<img src ="//placehold.it/400x300/eee/ccc/&text=.." />';
							}
							?>
						</a>
					</div>
					<div class="content-with-details">
						<div class="agent-details<?php if ( $no_socials ) { echo " no-details"; } ?>">
							<?php the_title( '<h4>', '</h4>' ); ?>
							<?php if ( $email ) { ?><div class="contact"><i class="fa fa-envelope-o"></i><?php echo antispambot( $email ); ?></div><?php } ?>
							<?php if ( $office ) { ?><div class="contact"><i class="fa fa-phone"></i><?php echo $office; ?></div><?php } ?>
							<?php if ( $mobile ) { ?><div class="contact"><i class="fa fa-mobile"></i><?php echo $mobile; ?></div><?php } ?>
							<?php if ( !$no_socials ) { ?>
							<div class="on-hover">
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
					</div>
				</div>
			<?php
			endwhile;
			?>
		</div>
		<?php
		wp_reset_query();
		endif;
		
		// Widget ends printing information
		echo $after_widget;
	  
  }
	
	

}