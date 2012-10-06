<?php
/**
 * Roots initial setup and constants
 */

function roots_setup() {

  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'roots'),
  ));

  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 150, false);
  // add_image_size('category-thumb', 300, 9999); // 300px wide (and unlimited height)

  // Add post formats (http://codex.wordpress.org/Post_Formats)
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style('assets/css/wp/editor.css');

  // Add excerpts to pages
  // add_post_type_support( 'page', 'excerpt' );

  // Allow users to set a custom background
  // add_custom_background();

  // http://codex.wordpress.org/Function_Reference/add_custom_image_header
  // if (!defined('HEADER_TEXTCOLOR')) { define('HEADER_TEXTCOLOR', '');  }
  // if (!defined('NO_HEADER_TEXT')) { define('NO_HEADER_TEXT', true); }
  // if (!defined('HEADER_IMAGE_WIDTH')) { define('HEADER_IMAGE_WIDTH', 940); }
  // if (!defined('HEADER_IMAGE_HEIGHT')) { define('HEADER_IMAGE_HEIGHT', 324); }

  // function custom_image_header_site() { }
  // function custom_image_header_admin() { }
  // add_custom_image_header('custom_image_header_site', 'custom_image_header_admin');

}

add_action('after_setup_theme', 'roots_setup');

// Backwards compatibility for older than PHP 5.3.0
if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }

// Define helper constants
$get_theme_name = explode('/themes/', get_template_directory());

define('WP_BASE',                   wp_base_dir());
define('THEME_NAME',                next($get_theme_name));
define('RELATIVE_PLUGIN_PATH',      str_replace(site_url() . '/', '', plugins_url()));
define('FULL_RELATIVE_PLUGIN_PATH', WP_BASE . '/' . RELATIVE_PLUGIN_PATH);
define('RELATIVE_CONTENT_PATH',     str_replace(site_url() . '/', '', content_url()));
define('THEME_PATH',                RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);
