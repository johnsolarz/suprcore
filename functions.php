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

// Load necessary files
require_once get_template_directory() . '/inc/suprcore-cleanup.php';	// Code cleanup
require_once get_template_directory() . '/inc/suprcore-htaccess.php';	// Custom rewrites and h5bp htaccess
require_once get_template_directory() . '/inc/suprcore-socials.php';	// Twitter and FB integration
//require_once get_template_directory() . '/inc/suprcore-post.php';	// Custom post type template
//require_once get_template_directory() . '/inc/suprcore-meta.php';	// Custom meta box template	
	
// Set up theme defaults and registers support for various WordPress features
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
	if (!defined('HEADER_IMAGE')) { define('HEADER_IMAGE', get_template_directory_uri() . '/inc/img/default.png'); }
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
    'utility_navigation' => __('Utility Navigation', 'suprcore')
  ));
}
add_action('after_setup_theme', 'suprcore_setup');

// Register our sidebars and widgetized areas
$sidebars = array('Sidebar', 'Footer 1', 'Footer 2', 'Footer 3', 'Footer 4');
foreach ($sidebars as $sidebar) {
  register_sidebar(array('name'=> $sidebar,
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h1>',
    'after_title' => '</h1>'
  ));
}

// Display navigation to next/previous pages when applicable
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

// Return post entry meta information
function suprcore_entry_meta() {
  echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on %s at %s.', 'suprcore'), get_the_time('l, F jS, Y'), get_the_time()) .'</time>';
  echo '<p class="byline author vcard">'. __('Written by', 'suprcore') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a></p>';
}

if ( ! function_exists( 'suprcore_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own suprcore_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Suprcore 2.2
 */
function suprcore_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'suprcore' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'suprcore' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">


			<p><?php printf(__('<cite class="comment-author">%s</cite>'), get_comment_author_link()) ?> <?php echo get_comment_text(); ?></p>

			<footer class="comment-meta">
			<div class="vcard">
				<?php
					$avatar_size = 30;
					if ( '0' != $comment->comment_parent )
						$avatar_size = 30;

					echo get_avatar( $comment, $avatar_size, $default='<path_to_url>' );
					
					/* translators: 1: comment author, 2: date and time */
					printf( __( '%1$s', 'suprcore' ),
						sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'suprcore' ), get_comment_date(), get_comment_time() )
						)
					);				
				
				?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'suprcore' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				<?php edit_comment_link( __( 'Edit', 'suprcore' ), '<span class="edit-link">', '</span>' ); ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<span class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'suprcore' ); ?></span>
				<?php endif; ?>
				</div><!-- .vcard -->
			</footer><!-- .comment-meta -->
			
		</article><!-- #comment-## -->
	<!-- </li> is added by wordpress automatically -->
	<?php
			break;
	endswitch;
}
endif; // ends check for suprcore_comment()

/**
 * Modify default WordPress comment form
 * http://devpress.com/blog/using-the-wordpress-comment-form/
 */
add_filter( 'comment_form_default_fields', 'suprcore_comment_form_default_fields' );

function suprcore_comment_form_default_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$fields['author'] = '<div class="comment-form-author label"><label for="author">' . __( 'Name' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) . '</div><div class="input push"><input type="text" id="author" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"'. $aria_req . ' /></div>';
	$fields['email'] = '<div class="comment-form-email label"><label for="email">' . __( 'Email' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) . '</div><div class="input push"><input type="text" id="email" name="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"'. $aria_req . ' /></div>';
	$fields['url'] = '<div class="comment-form-url label"><label for="url">' . __( 'Website' ) . '</label></div><div class="input push"><input type="text" id="url" name="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>';

	return $fields;
}

add_filter( 'comment_form_field_comment', 'suprcore_comment_form_field_comment' );

function suprcore_comment_form_field_comment( $comment_field ) {

	$comment_field = '<div class="comment-form-comment label"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label></div><div class="input push"><textarea id="comment" name="comment" style="width:380px" rows="8" aria-required="true"></textarea></div>';

	return $comment_field;
}

