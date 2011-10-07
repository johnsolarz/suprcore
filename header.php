<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="<?php bloginfo('charset'); ?>">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php 
		wp_title( '|', true, 'right' ); bloginfo( 'name' );
		
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
		
		?></title>
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <meta name="author" content="<?php bloginfo('name'); ?>">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">
 
  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/inc/root/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/inc/root/apple-touch-icon.png">

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
       Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects; 
       for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.0.6.min.js"></script>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="wrapper" class="container_12 clearfix">

		<header id="masthead" class="grid_12 clearfix" role="banner">		
			<a id="logo" href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" rel="index"><?php bloginfo('name'); ?></a>
			<p class="visuallyhidden"><?php bloginfo('description'); ?></p>
			<nav class="visuallyhidden">
				<ul>
					<li><a href="#content">Skip to content</a></li>
					<li><a href="<?php echo site_url('/contact');?>">Contact us</a></li>
					<li><a href="<?php echo site_url(); ?>">Go to home page</a></li>
				</ul>
			</nav>
			<nav role="navigation">
				<?php wp_nav_menu(array(
					'container' => 'false', 
					'fallback_cb' => 'suprcore_menu', 
					'theme_location' => 'primary_navigation',
					'walker' => new suprcore_nav_walker())); 
				?>
			</nav>
		</header>

		<?php if ( is_singular() && has_post_thumbnail( $post->ID ) &&
			( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) ) && $image[1] >= HEADER_IMAGE_WIDTH ) : ?>
			<div id="feature" class="grid_12">
				<?php echo get_the_post_thumbnail( $post->ID ); ?>
			</div>
		<?php elseif ( get_header_image() ) : ?>
			<div id="feature" class="grid_12">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
				</a>
			</div>
		<?php endif; ?>

		<?php if(function_exists( 'bcn_display' )) { ?>
			<nav id="breadcrumbs" class="grid_12">
				<?php bcn_display(); ?>
			</nav>
		<?php } ?>

		<div id="content" class="grid_12" role="main">