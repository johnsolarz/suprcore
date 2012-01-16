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
if (!isset( $content_width )) $content_width = 620;

// Load necessary files
require_once get_template_directory() . '/inc/cleanup.php';	// Code cleanup
require_once get_template_directory() . '/inc/htaccess.php';	// Custom rewrites and h5bp htaccess
require_once get_template_directory() . '/inc/sharing.php';	// fb, g+ and twitter integration
//require_once get_template_directory() . '/inc/custom-post-type.php';	// Custom post type template
//require_once get_template_directory() . '/inc/custom-post-meta.php';	// Custom meta box template	
	
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
	if (!defined('HEADER_IMAGE_WIDTH')) { define('HEADER_IMAGE_WIDTH', 940); }
	if (!defined('HEADER_IMAGE_HEIGHT')) { define('HEADER_IMAGE_HEIGHT', 324); }

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
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
}

/**
 * Display navigation to next/previous pages when applicable
 * http://dimox.net/wordpress-pagination-without-a-plugin-wp-pagenavi-alternative/
 */
function suprcore_page_nav() {
  global $wp_query, $wp_rewrite;
  $pages = '';
  $max = $wp_query->max_num_pages;
  if (!$current = get_query_var('paged')) $current = 1;
  $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
  $a['total'] = $max;
  $a['current'] = $current;
 
  $total = 1; //1 - display the text "Page N of N", 0 - not display
  $a['mid_size'] = 5; //how many links to show on the left and right of the current
  $a['end_size'] = 1; //how many links to show in the beginning and end
  $a['prev_text'] = '&laquo; Previous'; //text of the "Previous page" link
  $a['next_text'] = 'Next &raquo;'; //text of the "Next page" link
 
  if ($max > 1) echo '<nav class="navigation" role="navigation">';
  if ($total == 1 && $max > 1) $pages = '<span class="page-current">Page ' . $current . ' of ' . $max . '</span>'."\r\n";
  echo $pages . paginate_links($a);
  if ($max > 1) echo '</nav>';
}


// Return post entry meta information
function suprcore_entry_meta() {
  echo '<span class="byline author vcard">'. __('Posted by', 'suprcore') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a>, </span>';
  echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('%s at %s', 'suprcore'), get_the_date(), get_the_time()) .'</time>';
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
	<li class="pingback">
		<p><span class="pingback-title"><?php _e( 'Pingback', 'suprcore' ); ?></span> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'suprcore' ), '<span class="edit-link">', '</span>' ); ?></p>
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

