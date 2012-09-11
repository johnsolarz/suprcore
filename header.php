<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <meta name="description" content="<?php echo bloginfo('description'); ?>">
    <meta name="viewport" content="width=device-width">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon.png">

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/grid.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/suprcore.css">

    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr-2.6.1.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.8.0.min.js"><\/script>')</script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>

    <?php if (is_singular() && comments_open() && get_option('thread_comments'))
      wp_enqueue_script('comment-reply');
      wp_head();
    ?>
  </head>
  <body <?php body_class(core_body_class()); ?>>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->

	<header class="grid" role="banner">

		<div class="twelve column">
			<a class="logo" href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" rel="index"><?php bloginfo('name'); ?></a>
			<p class="visuallyhidden"><?php bloginfo('description'); ?></p>
			<nav class="visuallyhidden">
				<ul>
					<li><a href="#content">Skip to content</a></li>
					<li><a href="<?php echo home_url('/contact');?>">Contact us</a></li>
					<li><a href="<?php echo home_url('/'); ?>">Home page</a></li>
				</ul>
			</nav>
			<nav role="navigation">
                <?php wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav')); ?>
			</nav>
		</div>

	</header>

	<?php if ( is_singular() && has_post_thumbnail( $post->ID ) && ( $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ) ) && $image[1] >= HEADER_IMAGE_WIDTH ) : ?>
		<section id="feature" class="grid">
			<div class="twelve column">
				<?php echo get_the_post_thumbnail( $post->ID ); ?>
			</div>
		</section>
	<?php endif; ?>

	<div id="content" class="grid" role="main">
