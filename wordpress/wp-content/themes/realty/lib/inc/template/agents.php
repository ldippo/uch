<?php
/* AGENTS
============================== */
$args_agents = array(
	'post_type' 				=> 'agent',
	'posts_per_page' 		=> -1
);

$query_agents = new WP_Query( $args_agents );

global $post;

if ( $query_agents->have_posts() ) : 

while ( $query_agents->have_posts() ) : $query_agents->the_post();
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
	<div class="owl-thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php 
			if ( has_post_thumbnail() ) { 
				the_post_thumbnail( 'square-400' ); 
			}	
			else {
				echo '<img src ="//placehold.it/400x400/eee/ccc/&text=.." />';
			}
			?>
		</a>
	</div>
	<div class="content-with-details">
		<div class="agent-details<?php if ( $no_socials ) { echo " no-details"; } ?>">
			<?php the_title( '<h4 class="title">', '</h4>' ); ?>
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
</div><!-- .owl-carousel -->
<?php
wp_reset_query();
endif;