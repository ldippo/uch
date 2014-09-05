<?php
header('X-UA-Compatible: IE=edge,chrome=1'); 
global $realty_theme_option;
if ( !empty( $realty_theme_option['logo-menu'] ) ) {
	$logo = $realty_theme_option['logo-menu']['url'];
}
if ( !empty( $realty_theme_option['favicon'] ) ) {
	$favicon = $realty_theme_option['favicon']['url'];
}
else {
	$favicon = '';
}
$phone = $realty_theme_option['site-header-phone'];
$email = $realty_theme_option['site-header-email'];
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
<?php if( $favicon ) { ?>
<link rel="shortcut icon" href="<?php echo $favicon; ?>" />
<?php } ?>
<?php wp_head(); ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
<![endif]-->
</head>

<body <?php body_class(); ?>>

<?php if ( !is_page_template( 'template-intro.php' ) ) { ?>
<header class="navbar">
  <div class="container">
	  
	  <div class="navbar-header">
	  
	    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
	    	<span class="sr-only">Skip navigation</span>
	    	<span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
		  </button>
		  
		  <div class="navbar-brand">
		    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
		    <?php 
		    if( empty( $logo ) ) { ?>
		    <span><?php bloginfo('name'); ?></span>
		    <?php
		    } else { ?>
		    <img src="<?php echo $logo; ?>" alt="" />
 				<?php } ?>
		    </a>
	    </div>
	    
	    <div class="navbar-contact-details">
		    <?php if( !empty( $phone ) ) { ?>
			  <div class="navbar-phone-number"><?php echo $phone; ?></div>
		    <?php 
		    }
		    if( !empty( $email ) ) { ?>
			  <div class="navbar-email"><?php echo antispambot( $email ); ?></div>
		    <?php } ?>
	    </div>
	    
		</div>
  
	  <nav class="collapse navbar-collapse" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'div', 'container_class' => 'nav navbar-nav', 'menu_class' => 'clearfix', 'depth' => 3 ) ); ?>
			<div id="toggle-navbar"><i class="icon-angle-right"></i></div>
		</nav>
	  
  </div> 
</header>
<?php } ?>

<?php if ( !is_page_template( 'template-intro.php' ) && !is_page_template( 'template-home-slideshow.php' ) && !is_page_template( 'template-home-properties-map.php' ) && !is_page_template( 'template-property-search.php' ) ) { ?>
<div class="container">
<?php } ?>