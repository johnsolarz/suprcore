<?php
/**
 * Core functions
 */

if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }

require_once locate_template('/lib/utils.php');           // Utility functions
require_once locate_template('/lib/config.php');          // Configuration and constants
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/htaccess.php');        // Rewrites for assets, H5BP .htaccess
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/admin.php');           // Admin dashboard
require_once locate_template('/lib/social.php');          // Social media sharing
require_once locate_template('/lib/post-types.php');      // Custom post types
require_once locate_template('/lib/meta-boxes.php');      // Custom metaboxes
require_once locate_template('/lib/custom.php');          // Custom functions

function core_setup() {

  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'suprcore'),
    'footer_navigation'  => __('Footer Navigation', 'suprcore')
  ));

  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 150, false);
  // Create custom sizes using the_post_thumbnail('custombig');
  // add_image_size('category-thumb', 300, 9999); // 300px wide (and unlimited height)

  // Add default posts and comments RSS feed links to head
  // add_theme_support( 'automatic-feed-links' );

  // Add excerpts to pages
  // add_post_type_support( 'page', 'excerpt' );

  // Add post formats (http://codex.wordpress.org/Post_Formats)
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // Allow users to set a custom background
  // add_custom_background();

	// http://codex.wordpress.org/Function_Reference/add_custom_image_header
	// if (!defined('HEADER_TEXTCOLOR')) { define('HEADER_TEXTCOLOR', '');	}
	// if (!defined('NO_HEADER_TEXT')) { define('NO_HEADER_TEXT', true); }
	// if (!defined('HEADER_IMAGE_WIDTH')) { define('HEADER_IMAGE_WIDTH', 940); }
	// if (!defined('HEADER_IMAGE_HEIGHT')) { define('HEADER_IMAGE_HEIGHT', 324); }

  // function custom_image_header_site() { }
  // function custom_image_header_admin() { }
  // add_custom_image_header('custom_image_header_site', 'custom_image_header_admin');

  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style('/css/wp/editor.css');

}

add_action('after_setup_theme', 'core_setup');
