<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
  <meta charset="utf-8">
  <!--

  .....................................................................

  Built by Eight Seven Central in Des Moines, Iowa

  .....................................................................

  Hi.
  http://eightsevencentral.com
  design@eightsevencentral.com
  @87central

  .....................................................................

  -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
  <meta name="description" content="<?php echo bloginfo('description'); ?>">
  <meta name="viewport" content="width=device-width">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <!--[if lt IE 7]>
      <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
  <![endif]-->

  <header class="banner container" role="banner">
    <a class="brand" href="<?php echo home_url(); ?>/" title="<?php bloginfo('name'); ?>" rel="index"><?php bloginfo('name'); ?></a>
    <nav class="nav-main" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav'));
        endif;
      ?>
    </nav>
  </header>

  <?php if ( is_singular() && has_post_thumbnail( $post->ID ) && ( $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' ) ) && $image[1] >= HEADER_IMAGE_WIDTH ) : ?>
  <section id="hero" class="container">
    <div class="twelve column">
      <?php echo get_the_post_thumbnail( $post->ID ); ?>
    </div>
  </section>
  <?php endif; ?>

  <div class="wrap container" role="main">
    <div class="row">
