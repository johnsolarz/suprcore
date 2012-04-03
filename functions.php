<?php

if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }

require_once locate_template('/inc/config.php');      // config
require_once locate_template('/inc/utilities.php');   // utility functions

define('WP_BASE', wp_base_dir());
define('THEME_NAME', next(explode('/themes/', get_template_directory())));
define('RELATIVE_PLUGIN_PATH', str_replace(site_url() . '/', '', plugins_url()));
define('FULL_RELATIVE_PLUGIN_PATH', WP_BASE . '/' . RELATIVE_PLUGIN_PATH);
define('RELATIVE_CONTENT_PATH', str_replace(site_url() . '/', '', content_url()));
define('THEME_PATH', RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);

require_once locate_template('/inc/cleanup.php');     // cleanup
require_once locate_template('/inc/htaccess.php');    // rewrites for assets, h5bp htaccess
require_once locate_template('/inc/hooks.php');       // hooks
require_once locate_template('/inc/actions.php');     // actions
require_once locate_template('/inc/dashboard.php');   // admin dashboard
require_once locate_template('/inc/discussion.php');  // comments and pingbacks
require_once locate_template('/inc/sharing.php');     // social media
require_once locate_template('/inc/custom.php');      // custom functions
// require_once locate_template('/inc/post-type.php');   // post type template
// require_once locate_template('/inc/post-meta.php');   // meta box template

// set the maximum 'Large' image width to the maximum grid width
// http://wordpress.stackexchange.com/q/11766
if (!isset($content_width)) { $content_width = 940; }

function custom_setup() {

  // tell the TinyMCE editor to use editor-style.css
  // if you have issues with getting the editor to show your changes then
  // use this instead: add_editor_style('editor-style.css?' . time());
  add_editor_style('wp-editor.css');

  // http://codex.wordpress.org/Post_Thumbnails
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 150, false);

  // Create custom sizes
  // This is then pulled through to your theme using the_post_thumbnail('custombig'); 
  // add_image_size('customsmall', 300, 200, true); // narrow column
  // add_image_size('custombig', 620, 400, true); // wide column

  // Add default posts and comments RSS feed links to head
  // add_theme_support( 'automatic-feed-links' );

  // Add excerpts to pages
  // add_post_type_support( 'page', 'excerpt' );

  // http://codex.wordpress.org/Post_Formats
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

  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'suprcore'),
    'utility_navigation' => __('Utility Navigation', 'suprcore')
  ));
}

add_action('after_setup_theme', 'custom_setup');

// http://codex.wordpress.org/Function_Reference/register_sidebar
function custom_register_sidebars() {
  $sidebars = array('Sidebar', 'Footer');

  foreach($sidebars as $sidebar) {
    register_sidebar(
      array(
        'id'            => 'custom-' . sanitize_title($sidebar),
        'name'          => __($sidebar, 'suprcore'),
        'description'   => __($sidebar, 'suprcore'),
        'before_widget' => '<article id="%1$s" class="widget %2$s">',
        'after_widget'  => '</article>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
      )
    );
  }
}

add_action('widgets_init', 'custom_register_sidebars');

// return post entry meta information
function custom_entry_meta() {
  echo '<div class="post-meta"><time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('%s at %s ', 'suprcore'), get_the_date(), get_the_time()) .'</time>';
  echo '<span class="author">'. __('| By', 'suprcore') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a></span></div>';
}

// display navigation to next/previous pages when applicable
// http://dimox.net/wordpress-pagination-without-a-plugin-wp-pagenavi-alternative/
function custom_page_navigation() {
  global $wp_query, $wp_rewrite;
  $pages = '';
  $max = $wp_query->max_num_pages;
  if (!$current = get_query_var('paged')) $current = 1;
  $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
  $a['total'] = $max;
  $a['current'] = $current;
 
  $total = 1; //1 - display the text "Page N of N", 0 - not display
  $a['mid_size'] = 2; //how many links to show on the left and right of the current
  $a['end_size'] = 1; //how many links to show in the beginning and end
  $a['prev_text'] = '&laquo; Previous'; //text of the "Previous page" link
  $a['next_text'] = 'Next &raquo;'; //text of the "Next page" link
 
  if ($max > 1) echo '<nav class="toolbar" role="navigation">';
  if ($total == 1 && $max > 1) $pages = '<span class="page-current">Page ' . $current . ' of ' . $max . '</span>'."\r\n";
  echo $pages . paginate_links($a);
  if ($max > 1) echo '</nav>';
}

// retreive first image from post
// http://wordpress.org/support/topic/retreive-first-image-from-post
function custom_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "/img/login.png";
  }
  return $first_img;
}