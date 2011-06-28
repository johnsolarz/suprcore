<?php

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 620;

// Tell WordPress to run suprcore_setup() when the 'after_setup_theme' hook is run.
add_action( 'after_setup_theme', 'suprcore_setup' );

if ( ! function_exists( 'suprcore_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function suprcore_setup() {
	
	// Uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// Add excerpts to pages
	add_post_type_support( 'page', 'excerpt' );

	// Uses wp_nav_menu() in header and footer
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'suprcore' ),
		'footer' => __( 'Footer Navigation', 'suprcore' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();
	
	// Your changeable header business starts here.
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/assets/img/default.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to suprcore_header_image_width and suprcore_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'suprcore_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'suprcore_header_image_height', 320 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 340 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See suprcore_admin_header_style(), below.
	add_custom_image_header( '', 'suprcore_admin_header_style' );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'default' => array(
			'url' => '%s/assets/img/headers/default.jpg',
			'thumbnail_url' => '%s/assets/img/default-thumbnail.jpg',
			'description' => __( 'Default', 'suprcore' )
		),
	) );
}
endif;

if ( ! function_exists( 'suprcore_admin_header_style' ) ) :
// Styles the header image displayed on the Appearance > Header admin panel.

function suprcore_admin_header_style() {
?>
<style type="text/css">
	#headimg { }
	#headimg #name { }
	#headimg #desc { }
</style>
<?php
}
endif;

// Set our wp_nav_menu() fallback, suprcore_menu()
function suprcore_menu() {
	echo '<ul><li><a href="'.get_bloginfo('url').'">Home</a></li>';
	wp_list_pages('title_li=');
	echo '</ul>';
}

// Returns a "Continue Reading" link for excerpts
function suprcore_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading', 'suprcore' ) . '</a>';
}

// Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and suprcore_continue_reading_link().
function suprcore_auto_excerpt_more( $more ) {
	return ' &hellip;' . suprcore_continue_reading_link();
}
add_filter( 'excerpt_more', 'suprcore_auto_excerpt_more' );

// Remove inline styles printed when the gallery shortcode is used, use style.css
add_filter( 'use_default_gallery_style', '__return_false' );


if ( ! function_exists( 'suprcore_comment' ) ) :
/**
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function suprcore_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			
			<div class="grid_2 alpha avatar">
				<?php echo get_avatar( $comment, 40 ); ?>
			</div><!-- .comment-author .vcard -->
			
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'suprcore' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="grid_6 omega">
			<?php printf( __( '%s', 'suprcore' ), sprintf( '<span class="comment_author">%s</span>', get_comment_author_link() ) ); ?>
			<span class="comment_date">
				<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'suprcore' ), get_comment_date(),  get_comment_time() ); ?>
			</span>
				
				<?php edit_comment_link( __( '(Edit)', 'suprcore' ), ' ' ); ?>
	
			<?php comment_text(); ?>

			<p><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></p>

		</div>
		
		<div class="clear"></div>

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback pad">
		<p><?php _e( 'Pingback:', 'suprcore' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'suprcore' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


// Register widgetized areas.
function suprcore_widgets_init() {
	// Sidebar widget.
	register_sidebar( array(
		'name' => __( 'Sidebar Widget', 'suprcore' ),
		'id' => 'primary-widget',
		'description' => __( '', 'suprcore' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="widget_title">',
		'after_title' => '</p>',
	) );

	// Footer widget 1.
	register_sidebar( array(
		'name' => __( 'Footer Widget 1', 'suprcore' ),
		'id' => 'footer-widget-1',
		'description' => __( '', 'suprcore' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="widget_title">',
		'after_title' => '</p>',
	) );

	// Footer widget 2.
	register_sidebar( array(
		'name' => __( 'Footer Widget 2', 'suprcore' ),
		'id' => 'footer-widget-2',
		'description' => __( '', 'suprcore' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="widget_title">',
		'after_title' => '</p>',
	) );

	// Footer widget 3.
	register_sidebar( array(
		'name' => __( 'Footer Widget 3', 'suprcore' ),
		'id' => 'footer-widget-3',
		'description' => __( '', 'suprcore' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="widget_title">',
		'after_title' => '</p>',
	) );

	// Footer widget 4.
	register_sidebar( array(
		'name' => __( 'Footer Widget 4', 'suprcore' ),
		'id' => 'footer-widget-4',
		'description' => __( '', 'suprcore' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<p class="widget_title">',
		'after_title' => '</p>',
	) );
}
/** Register sidebars by running suprcore_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'suprcore_widgets_init' );

/**
 * A clean theme
 * http://nicolasgallagher.com/anatomy-of-an-html5-wordpress-theme/
 */

// Remove actions from wp_head()
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );

// removes empty span
add_filter('the_content', 'remove_empty_read_more_span');
function remove_empty_read_more_span($content) {
	return eregi_replace("(<p><span id=\"more-[0-9]{1,}\"></span></p>)", "", $content);
}

// removes url hash to avoid the jump link
add_filter('the_content_more_link', 'remove_more_jump_link');
function remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return '<a href="'.get_permalink($post->ID).'" class="read_more_link">'.'Read more'.'</a>';
}

// Display images in the excerpt
function improved_trim_excerpt($text) {
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = strip_tags($text, '<p><img><a>');
		$excerpt_length = apply_filters('excerpt_length', 55);
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, '[...]');
			$text = implode(' ', $words);
			$text = force_balance_tags($text);
		}
	}
	return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');

/**
 * Remove default widgets 
 * http://www.everparent.com/lunaticfred/2011/05/05/how-to-remove-default-sidebar-widgets-in-wordpress/
 */
 
add_action( 'widgets_init', 'remove_default_widgets' );
function remove_default_widgets() {
	//unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	//unregister_widget('WP_Widget_Text');
	//unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Nav_Menu_Widget');
}

/**
 * Customize admin dashboard
 * http://www.smashingmagazine.com/2011/05/10/new-wordpress-power-tips-for-template-developers-and-consultants/
 */

// Remove admin menu items
add_action( 'admin_menu', 'suprcore_admin_menu' );
function suprcore_admin_menu() {
	remove_menu_page('link-manager.php');
}

// Dashboard news feeds
add_action('wp_dashboard_setup', 'suprcore_dashboard_widgets');
function suprcore_dashboard_widgets() {
	global $wp_meta_boxes;
	// remove unnecessary widgets
	// var_dump( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs
	unset(
		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']
	);
	// add a custom dashboard widget
	wp_add_dashboard_widget( 'dashboard_custom_feed', 'From the News Desk at 8/7 Central', 'dashboard_custom_feed_output' ); //add new RSS feed output
}
function dashboard_custom_feed_output() {
	echo '<div class="rss-widget">';
	wp_widget_rss_output(array(
		'url' => 'http://www.eightsevencentral.com/feed',
		'title' => 'What\'s up at 8/7',
		'items' => 2,
		'show_summary' => 1,
		'show_author' => 0,
		'show_date' => 1,
	));
	echo "</div>";
}

// Add footer credits
add_filter( 'admin_footer_text', 'suprcore_admin_footer_text' );
function suprcore_admin_footer_text( $default_text ) {
	return '<span id="footer-thankyou">Design + Development by <a href="http://eightsevencentral.com">8/7 Central</a><span> | Powered by <a href="http://www.wordpress.org">WordPress</a>';
}

/**
 * Admin login
 * http://digwp.com/2010/03/wordpress-functions-php-template-custom-functions/
 */
  
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('template_directory').'/assets/img/login.png) !important; height: 220px; }
	input.button-primary { background: #99CF52 !important; border-color: #99CF52; }
	input.button-primary:hover { color: #F9F9F9; border-color: #669900; }
	.login #nav a { color: #ccc !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');

/** 
 * Disable 3.1 admin bar for all users
 * http://www.snilesh.com/resources/wordpress/wordpress-3-1-enable-disable-remove-admin-bar/
 */

add_filter( 'show_admin_bar' , 'suprcore_admin_bar');
function suprcore_admin_bar(){
	return false;
}

/** 
 * Remove l10n.js from <head>
 * http://wordpress.stackexchange.com/questions/5451/what-does-l10n-js-do-in-wordpress-3-1-and-how-do-i-remove-it
 */
 
if ( !is_admin() ) {
	function remove_l10n() {
		wp_deregister_script( 'l10n' );
	}
add_action('init', 'remove_l10n'); 
}

/**
 * Remove recent comments style from <head>
 * http://beerpla.net/2010/01/31/how-to-remove-inline-hardcoded-recent-comments-sidebar-widget-style-from-your-wordpress-theme/
 */
     
function my_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'my_remove_recent_comments_style' );

/**
 * Remove the dashboard update link
 * http://www.vooshthemes.com/blog/wordpress-tip/wordpress-quick-tip-remove-the-dashboard-update-message/
 */
 
add_action( 'admin_init', create_function('', 'remove_action( \'admin_notices\', \'update_nag\', 3 );') );

/**
 * Register Google CDN's jQuery in footer 
 * http://digwp.com/2009/06/use-google-hosted-javascript-libraries-still-the-right-way/
 */
 
if( !is_admin()){
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, '1.6.1', true );
	wp_enqueue_script('jquery');
} 

/**
 * Use Facebook "Like" button under each post?
 * 1 = true (default)
 * 0 = false
 */

$like_btn = 1;

/** 
 * Your Twitter username (optional)
 * eg. return "your_username";
 */

$your_twitter_username = "";

// Socials, adjust params above
function use_facebook_like() {
	global $like_btn;
	return $like_btn;
}

function your_twitter_username() {
	global $your_twitter_username;
	return $your_twitter_username;
}

function twitter_followers_counter() {

	$username = your_twitter_username();
	
	$cache_file = CACHEDIR . 'twitter_followers_counter_' . md5 ( $username );
	
	if (is_file ( $cache_file ) == false) {
		$cache_file_time = strtotime ( '1984-01-11 07:15' );
	} else {
		$cache_file_time = filemtime ( $cache_file );
	} 
	
	$now = strtotime ( date ( 'Y-m-d H:i:s' ) );
	$api_call = $cache_file_time;
	$difference = $now - $api_call;
	$api_time_seconds = 1800;
	
	if ($difference >= $api_time_seconds) {

	  	$api_call = 'http://twitter.com/users/show/'.$username.'.json';
  		$results = json_decode(file_get_contents($api_call));
  		$count = $results->followers_count;

		if (is_file ( $cache_file ) == true) {
			unlink ( $cache_file );
		}
		touch ( $cache_file );
		file_put_contents ( $cache_file, strval ( $count ) );
		return strval ( $count );
	} else {
		$count = file_get_contents ( $cache_file );
		return strval ( $count );
	}
}


function __your_twitter_icon() {
	
  $username = your_twitter_username();

  $api_call = 'http://twitter.com/users/show/'.$username.'.json';
  $results = json_decode(file_get_contents($api_call));
  return $results->profile_image_url;
}


function your_twitter_icon() {

	$username = your_twitter_username();
	
	$cache_file = CACHEDIR . 'twitter_profile_image_url_' . md5 ( $username );
	
	if (is_file ( $cache_file ) == false) {
		$cache_file_time = strtotime ( '1984-01-11 07:15' );
	} else {
		$cache_file_time = filemtime ( $cache_file );
	} 
	
	$now = strtotime ( date ( 'Y-m-d H:i:s' ) );
	$api_call = $cache_file_time;
	$difference = $now - $api_call;
	$api_time_seconds = 1800;
	
	if ($difference >= $api_time_seconds) {
	
	  	$api_call = 'http://twitter.com/users/show/'.$username.'.json';
  		$results = json_decode(file_get_contents($api_call));
  		$count = $results->profile_image_url;

		if (is_file ( $cache_file ) == true) {
			unlink ( $cache_file );
		}
		touch ( $cache_file );
		file_put_contents ( $cache_file, strval ( $count ) );
		return strval ( $count );
	} else {
		$count = file_get_contents ( $cache_file );
		return strval ( $count );
	}
}

/**
 * Include primary project functions in separate folder.  
 */

//include('functions/custom-post.php');
