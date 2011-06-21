<?php

/**
 * Custom Posts template:
 * 
 *   1. Add Custom Content Types to left-nav Admin Menu and output correct update messages 
 *   2. Register taxonomies for each new Content Page and add terms to post_class()
 *   3. Add "Meta Box" options, callback, save and upload functions to Post editor 
 *   4. Manage custom content columns in admin view
 */
 
/** 
 * Create custom post type
 * http://codex.wordpress.org/Function_Reference/register_post_type
 */
 
add_action('init', 'post_type_book');
function post_type_book() 
{
  $labels = array(
    'name' => _x('Books', 'post type general name'),
    'singular_name' => _x('Book', 'post type singular name'),
    'add_new' => _x('Add New', 'book'),
    'add_new_item' => __('Add New Book'),
    'edit_item' => __('Edit Book'),
    'new_item' => __('New Book'),
    'view_item' => __('View Book'),
    'search_items' => __('Search Books'),
    'not_found' =>  __('No books found'),
    'not_found_in_trash' => __('No books found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Books'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail','excerpt','comments')
  ); 
  register_post_type('book',$args);
}

// Add filter to ensure the text Book, or book, is displayed when user updates a book 
add_filter('post_updated_messages', 'updated_messages_book');
function updated_messages_book( $messages ) {
  global $post, $post_ID;

  $messages['book'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Book updated. <a href="%s">View book</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Book updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Book published. <a href="%s">View book</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Book saved.'),
    8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Book draft updated. <a target="_blank" href="%s">Preview book</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//display contextual help for Books
add_action( 'contextual_help', 'help_text_book', 10, 3 );

function help_text_book($contextual_help, $screen_id, $screen) { 
  //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
  if ('book' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a book:') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct genre such as Mystery, or Historic.') . '</li>' .
      '<li>' . __('Specify the correct writer of the book.  Remember that the Author module refers to you, the author of this book review.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the book review to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>' ;
  } elseif ( 'edit-book' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of books blah blah blah.') . '</p>' ;
  }
  return $contextual_help;
}

/**
 * Create custom taxonomies
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
 
//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_book_taxonomies', 0 );

//create two taxonomies, genres and writers for the post type "book"
function create_book_taxonomies() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Genres', 'taxonomy general name' ),
    'singular_name' => _x( 'Genre', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Genres' ),
    'all_items' => __( 'All Genres' ),
    'parent_item' => __( 'Parent Genre' ),
    'parent_item_colon' => __( 'Parent Genre:' ),
    'edit_item' => __( 'Edit Genre' ), 
    'update_item' => __( 'Update Genre' ),
    'add_new_item' => __( 'Add New Genre' ),
    'new_item_name' => __( 'New Genre Name' ),
    'menu_name' => __( 'Genre' ),
  ); 	

  register_taxonomy('genre',array('book'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'genre' ),
  ));

  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Writers', 'taxonomy general name' ),
    'singular_name' => _x( 'Writer', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Writers' ),
    'popular_items' => __( 'Popular Writers' ),
    'all_items' => __( 'All Writers' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Writer' ), 
    'update_item' => __( 'Update Writer' ),
    'add_new_item' => __( 'Add New Writer' ),
    'new_item_name' => __( 'New Writer Name' ),
    'separate_items_with_commas' => __( 'Separate writers with commas' ),
    'add_or_remove_items' => __( 'Add or remove writers' ),
    'choose_from_most_used' => __( 'Choose from the most used writers' ),
    'menu_name' => __( 'Writers' ),
  ); 

  register_taxonomy('writer','book',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'writer' ),
  ));
}

// Add new custom taxonomies to post_class()
// http://www.wptavern.com/forum/troubleshooting/1758-custom-taxonomy-css-class.html#post17171

add_filter( 'post_class', 'suprcore_post_class', 10, 3 );
if( !function_exists( 'suprcore_post_class' ) ) {
    /**
     * Append taxonomy terms to post class.
     * @since 2011-02-01
     */
    function suprcore_post_class( $classes, $class, $ID ) {
        $taxonomy = array('genre', 'writer');
        $terms = get_the_terms( (int) $ID, $taxonomy );
        if( !empty( $terms ) ) {
            foreach( (array) $terms as $order => $term ) {
                if( !in_array( $term->slug, $classes ) ) {
                    $classes[] = $term->slug;
                }
            }
        }
        return $classes;
    }
}


/**
 * Create custom meta box
 * http://sicdigital.com/2010/07/create-custom-post-type-for-image-upload-wordpress3/
 */

$prefix = 'supr_';
 
$meta_box = array(
	'id' => 'meta-box-book',
	'title' => 'Book Info',
	'page' => 'book',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Title',
			'desc' => 'The title',
			'id' => $prefix .'title',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => 'Photo',
			'desc' => 'Please select a photo',
			'id' => $prefix .'photo',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => '',
			'desc' => '',
			'id' => $prefix .'upload_photo_button',
			'type' => 'button',
			'std' => 'Browse'
		),
	)
);
 
add_action('admin_menu', 'suprcore_add_box');
 
// Add meta box
function suprcore_add_box() {
	global $meta_box;
 
	add_meta_box($meta_box['id'], $meta_box['title'], 'suprcore_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}
 
// Callback function to show fields in meta box
function suprcore_show_box() {
	global $meta_box, $post;
 
	// Use nonce for verification
	echo '<input type="hidden" name="suprcore_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table">';
 
	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
 
		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
				'<td>';
		switch ($field['type']) {
 
 
 
 
//If Text		
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
					'<br />', $field['desc'];
				break;
 
 
//If Text Area			
			case 'textarea':
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
					'<br />', $field['desc'];
				break;
 
 
//If Button	
 
				case 'button':
				echo '<input type="button" name="', $field['id'], '" id="', $field['id'], '"value="', $meta ? $meta : $field['std'], '" />';
				break;
		}
		echo 	'<td>',
			'</tr>';
	}
 
	echo '</table>';
}
 
add_action('save_post', 'suprcore_save_data');
 
// Save data from meta box
function suprcore_save_data($post_id) {
	global $meta_box;
 
	// verify nonce
	if (!wp_verify_nonce($_POST['suprcore_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
 
	foreach ($meta_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}

// Get the WordPress media upload working
function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', get_bloginfo('template_url') . '/functions/custom-upload.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}
function my_admin_styles() {
	wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');

/**
 * Manage custom columns in custom post WP admin
 * http://shibashake.com/wordpress-theme/add-custom-post-type-columns
 */
 
add_filter('manage_edit-book_columns', 'supr_columns');
function supr_columns($book_columns) {
	$new_columns['cb'] = '<input type="checkbox" />';
	$new_columns['title'] = _x('Title', 'column name');
	$new_columns['supr_title'] = _x('Book Title', 'column name');	
	$new_columns['author'] = __('Author');
 	$new_columns['date'] = _x('Date', 'column name');
 
	return $new_columns;
}

add_action('manage_book_posts_custom_column',  'manage_supr_columns');
function manage_supr_columns($name) {
    global $post;
    switch ($name) {
        case 'supr_title':
            echo get_post_meta($post->ID, 'supr_title', true);
			break;
    }
}

?>