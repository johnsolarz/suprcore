<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="no-js ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php wp_title( '&mdash;', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<meta name="author" content="">

	<!-- Mobile viewport optimized: j.mp/bplateviewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/root/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/root/apple-touch-icon.png">

	<!-- CSS: implied media="all" -->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>">

	<!-- All JavaScript at the bottom, except for Modernizr and Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries -->
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/modernizr-2.0.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/respond.min.js"></script>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="wrapper" class="container_12 clearfix">

		<header class="grid_12 clearfix" role="banner">
		
			<a id="logo" href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo( 'name' ); ?></a>
			<p class="visuallyhidden"><?php bloginfo( 'description' ); ?></p>

			<nav class="visuallyhidden">
				<ul>
					<li><a href="#content">Skip to content</a></li>
					<li><a href="<?php echo bloginfo( 'url' ); ?>/contact">Contact us</a></li>
					<li><a href="<?php echo home_url( '/' ); ?>">Go to home page</a></li>
				</ul>
			</nav>

			<nav role="navigation">
				<?php wp_nav_menu( array( 'container' => 'false', 'fallback_cb' => 'suprcore_menu', 'theme_location' => 'primary' ) ); ?>
			</nav>

		</header>

		<div id="feature" class="grid_12">

		<?php
		// Check if this is a post or page, if it has a thumbnail, and if it's a big one
		if ( is_singular() && current_theme_supports( 'post-thumbnails' ) &&
				has_post_thumbnail( $post->ID ) &&
				( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) ) &&
				$image[1] >= HEADER_IMAGE_WIDTH ) :
			// Houston, we have a new header image!
			echo get_the_post_thumbnail( $post->ID );
		elseif ( get_header_image() ) : ?>
			<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
		<?php endif; ?>

		</div>

		<?php if(function_exists( 'bcn_display' )) { ?>

			<nav id="breadcrumbs" class="grid_12">
				<?php bcn_display(); ?>
			</nav>
		
		<?php } ?>

		<div id="content" class="grid_12" role="main">