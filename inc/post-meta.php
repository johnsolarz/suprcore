<?php 
/**
 * Custom meta boxes
 * http://wp.tutsplus.com/tutorials/reusable-custom-meta-boxes-part-1-intro-and-basic-fields/
 */

/*
    Add meta box:

    The $id will be added to the box as an id to make it easy to reference in style sheets and other functions
    The $title will be displayed in the handle of the box
    The $callback is the function we’ll use to define the output inside the box
    $page is used to select which post type the box will be used on
    We use $context to determine where the box will show up on the page
    Having $priority set at “high” will put the box as close to the editor as we can and factors in other boxes added by core and plugins.
    
*/
function add_custom_meta_box() {
	add_meta_box(
		'custom_meta_box', // $id
		'Custom Meta Box', // $title 
		'show_custom_meta_box', // $callback 
		'post', // $page 
		'normal', // $context 
		'high'); // $priority 
}
add_action('add_meta_boxes', 'add_custom_meta_box');  

// Field Array  
$prefix = 'custom_';  
$custom_meta_fields = array(  
    array(  
        'label'=> 'Text Input',  
        'desc'  => 'A description for the text.',  
        'id'    => $prefix.'text',  
        'type'  => 'text'  
    ),
		array(
        'label'=> 'Text Input Button',
        'desc'  => 'A description for the button.',
        'id'    => $prefix.'button', 
        'type'  => 'button',
        'std' => 'Browse'
		), 
    array(  
        'label'=> 'Textarea',  
        'desc'  => 'A description for the textarea.',  
        'id'    => $prefix.'textarea',  
        'type'  => 'textarea'  
    ),  
    array(  
        'label'=> 'Checkbox Input',  
        'desc'  => 'A description for the checkbox.',  
        'id'    => $prefix.'checkbox',  
        'type'  => 'checkbox'  
    ),  
    array(  
        'label'=> 'Select Box',  
        'desc'  => 'A description for the select box.',  
        'id'    => $prefix.'select',  
        'type'  => 'select',  
        'options' => array (  
            'one' => array (  
                'label' => 'Option One',  
                'value' => 'one'  
            ),  
            'two' => array (  
                'label' => 'Option Two',  
                'value' => 'two'  
            ),  
            'three' => array (  
                'label' => 'Option Three',  
                'value' => 'three'  
            )  
        )  
    )  
);

/*
    The Callback:

    Echo a hidden nonce field to verify the fields when we save them later
    Start a table and begin a loop through each field from the $custom_meta_fields array.
    Get the value of the field if it has been saved for the current post already so that we can output it in the field
    Begin a table row with two cells: a <th> for the label of the field, and a <td> for the field itself.
    Then we’ll insert our switch case items.
    Finally, end the table row, the loop, and the table before closing the function

*/
function show_custom_meta_box() {  
global $custom_meta_fields, $post;  
// Use nonce for verification  
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
  
	// Begin the field table and loop
	echo '<table class="form-table">';  
	foreach ($custom_meta_fields as $field) {  
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);  
		// begin a table row with  
		echo '<tr> 
			<th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
			<td>';  
			switch($field['type']) {  
 
    // text  
    case 'text':  
        echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" style="width:98%" /> 
            <br /><span class="description">'.$field['desc'].'</span>';  
    break; 

    // button	
    case 'button':
        echo '<input type="button" name="', $field['id'], '" id="', $field['id'], '"value="', $meta ? $meta : $field['std'], '" />
            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
    break;
				
    // textarea  
    case 'textarea':  
        echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4" style="width:98%">'.$meta.'</textarea> 
            <br /><span class="description">'.$field['desc'].'</span>';  
    break;

    // checkbox  
    case 'checkbox':  
        echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/> 
            <label for="'.$field['id'].'">'.$field['desc'].'</label>';  
    break;

    // select  
    case 'select':  
        echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';  
        foreach ($field['options'] as $option) {  
            echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';  
        }  
        echo '</select><br /><span class="description">'.$field['desc'].'</span>';  
    break;

			} //end switch  
		echo '</td></tr>';  
	} // end foreach  
	echo '</table>'; // end table  
}

/*
    Save the Data:

    Get the field’s value if it has been saved before and store it as $old
    Get the current value that has been entered and store it as $new
    If there is a $new value and it isn’t the same as old, update the post meta field with the $new value
    If the $new value is empty and there is an $old value, delete the post meta field $old value
    If there are no changes, nothing happens

*/
function save_custom_meta($post_id) {  
	global $custom_meta_fields;  
      
	// verify nonce  
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))  
		return $post_id;  
	// check autosave  
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
		return $post_id;  
	// check permissions  
	if ('page' == $_POST['post_type']) {  
		if (!current_user_can('edit_page', $post_id))  
			return $post_id;  
		} elseif (!current_user_can('edit_post', $post_id)) {  
			return $post_id;  
	}  
      
	// loop through fields and save the data  
	foreach ($custom_meta_fields as $field) {  
		$old = get_post_meta($post_id, $field['id'], true);  
		$new = $_POST[$field['id']];  
		if ($new && $new != $old) {  
			update_post_meta($post_id, $field['id'], $new);  
		} elseif ('' == $new && $old) {  
			delete_post_meta($post_id, $field['id'], $old);  
		}  
	} // end foreach  
}  
add_action('save_post', 'save_custom_meta');   

/**
 * WordPress media upload
 * http://www.webmaster-source.com/2010/01/08/using-the-wordpress-uploader-in-your-plugin-or-theme/
 */
 
function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', get_bloginfo('template_url') . '/inc/post-meta.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}

function my_admin_styles() {
	wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');