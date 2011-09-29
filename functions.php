<?php
/**
 * Suprcore functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @package Wordpress
 * @subpackage Suprcore
 */
 
// Set the content width based on the theme's design and stylesheet.
if (!isset($content_width)) $content_width = 620;

// Use Facebook "Like" button under each post?
$like_btn = 0;

// Use Google Plus button under each post?
$gplus_btn = 0;

// Your Twitter username (optional)
$your_twitter_username = "";

/**
 * Load necessary files
 */
require_once get_template_directory() . '/inc/suprcore-cleanup.php';	// Code cleanup/removal
require_once get_template_directory() . '/inc/suprcore-dashboard.php';	// Admin login and dashboard
require_once get_template_directory() . '/inc/suprcore-htaccess.php';	// Rewrites and h5bp htaccess
require_once get_template_directory() . '/inc/suprcore-socials.php';	// Twitter and FB integration
//require_once get_template_directory() . '/inc/suprcore-post-type.php');	// Custom content template		
	
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function suprcore_setup() {
  // Tell the TinyMCE editor to use editor-style.css
  add_editor_style();

  // http://codex.wordpress.org/Post_Thumbnails
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 150, false);

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add excerpts to pages
	add_post_type_support( 'page', 'excerpt' );

  // Add support for a variety of post formats
  // http://codex.wordpress.org/Post_Formats
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

	// Allow users to set a custom background
	add_custom_background();

	// http://codex.wordpress.org/Function_Reference/add_custom_image_header
	if (!defined('HEADER_TEXTCOLOR')) { define('HEADER_TEXTCOLOR', '');	}
	if (!defined('NO_HEADER_TEXT')) { define('NO_HEADER_TEXT', true); }	
	if (!defined('HEADER_IMAGE')) { define('HEADER_IMAGE', get_template_directory_uri() . '/img/default.png'); }
	if (!defined('HEADER_IMAGE_WIDTH')) { define('HEADER_IMAGE_WIDTH', 940); }
	if (!defined('HEADER_IMAGE_HEIGHT')) { define('HEADER_IMAGE_HEIGHT', 320); }

	function suprcore_custom_image_header_site() { }
	function suprcore_custom_image_header_admin() { ?>
		<style type="text/css">
			.appearance_page_custom-header #headimg { min-height: 0; }
		</style>
	<?php }
	add_custom_image_header('suprcore_custom_image_header_site', 'suprcore_custom_image_header_admin');

  // Add support for menus and setup default menus
  add_theme_support('menus');
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'suprcore'),
    'footer_navigation' => __('Footer Navigation', 'suprcore')
  ));
}
add_action('after_setup_theme', 'suprcore_setup');

/**
 * Register our sidebars and widgetized areas.
 */
$sidebars = array('Sidebar', 'Footer 1', 'Footer 2', 'Footer 3', 'Footer 4');
foreach ($sidebars as $sidebar) {
  register_sidebar(array('name'=> $sidebar,
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h1>',
    'after_title' => '</h1>'
  ));
}

/**
 * Set our wp_nav_menu() fallback, suprcore_menu()
 */
function suprcore_menu() {
	echo '<ul>';
	wp_list_pages('title_li=');
	echo '</ul>';
}

/**
 * Display navigation to next/previous pages when applicable
 */
function suprcore_content_nav() {
  global $wp_query;

  if ($wp_query->max_num_pages > 1) : ?>
    <nav>
      <h1><?php _e('Post navigation', 'suprcore'); ?></h1>
      <ul>
        <li><?php next_posts_link(__('&larr; Older posts', 'suprcore')); ?></li>
        <li><?php previous_posts_link(__('Newer posts &rarr;', 'suprcore')); ?></li>
      </ul>
    </nav>
  <?php endif;
}

/**
 * Return post entry meta information
 */
function suprcore_entry_meta() {
  echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on %s at %s.', 'suprcore'), get_the_time('l, F jS, Y'), get_the_time()) .'</time>';
  echo '<p class="byline author vcard">'. __('Written by', 'suprcore') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a></p>';
}

/**
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if ( ! function_exists( 'suprcore_comment' ) ) :
function suprcore_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li>
		<article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<header class="grid_1 alpha avatar">
					<?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
			</header>
			
			<div class="grid_7 omega comment">
				<p><?php printf(__('<cite class="username">%s</cite>'), get_comment_author_link()) ?> <?php echo get_comment_text(); ?></p>
			
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'suprcore' ); ?></em>
					<br>
				<?php endif; ?>
			</div>

			<footer class="grid_7 omega">
				<ul class="comment-tools">
					<li><time><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></time></li>
					<li><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">Permalink</a></li> 
					<li><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></li> 
					<li><?php edit_comment_link(__('(Edit)'),' ','') ?></li>
				</ul>
			</footer>

		</article>
	<!-- </li> is added by wordpress automatically -->
	<?php
			break;
	endswitch;
}
endif;


