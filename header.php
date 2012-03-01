<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
  <meta name="description" content="<?php echo bloginfo('description'); ?>">

  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
 
  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon.png">

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except this Modernizr build.
       Modernizr enables HTML5 elements & feature detects for optimal performance.
       Create your own custom Modernizr build: www.modernizr.com/download/ -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.5.3.min.js"></script>

  <?php if (is_singular() && comments_open() && get_option('thread_comments'))
    wp_enqueue_script('comment-reply');
    wp_head();
  ?>
</head>
<body <?php body_class(custom_body_class()); ?>>
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<header class="grid" role="banner">

		<div class="twelve column">
			<h1 id="logo"><a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" rel="index"><?php bloginfo('name'); ?></a></h1>
			<p class="visuallyhidden"><?php bloginfo('description'); ?></p>
			<nav class="visuallyhidden">
				<ul>
					<li><a href="#main">Skip to content</a></li>
					<li><a href="<?php echo home_url('/contact');?>">Contact us</a></li>
					<li><a href="<?php echo home_url('/'); ?>">Go to home page</a></li>
				</ul>
			</nav>
			<nav role="navigation">
				<?php wp_nav_menu(array(
					'theme_location' => 'primary_navigation',
					'walker' => new Custom_Navbar_Nav_Walker() 
      	));
      	?>
			</nav>
		</div>

	</header>

	<?php if ( is_singular() && has_post_thumbnail( $post->ID ) && ( $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ) ) && $image[1] >= HEADER_IMAGE_WIDTH ) : ?>
		<div id="hero" class="grid">
			<div class="twelve column">
				<?php echo get_the_post_thumbnail( $post->ID ); ?>
			</div>
		</div>
	<?php elseif ( get_header_image() ) : ?>
		<div id="hero" class="grid">
			<div class="twelve column">
				<a href="<?php echo esc_url( home_url('/') ); ?>">
					<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
				</a>
			</div>
		</div>
	<?php endif; ?>

	<div id="main" class="grid" role="main">