<?php

// Custom CSS for the login page
function custom_login_css() {
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/css/wp/login.css"/>';
}
add_action('login_head', 'custom_login_css');

/**
 * Login URL and title
 *
 * @link http://primegap.net/2011/01/26/wordpress-quick-tip-custom-wp-login-php-logo-url-without-hacks/
 */
function custom_login_url() {
  return ('http://eightsevencentral.com');
}
add_filter( 'login_headerurl', 'custom_login_url', 10, 4 );

function custom_login_title() {
  return ('Eight Seven Central');
}
add_filter( 'login_headertitle', 'custom_login_title', 10, 4 );

// Add a custom dashboard widget
add_action('wp_dashboard_setup', 'custom_add_dashboard_widgets');
function custom_add_dashboard_widgets() {
  wp_add_dashboard_widget( 'dashboard_custom_feed', 'From the News Desk at 8/7 Central', 'dashboard_custom_feed_output' );
}
function dashboard_custom_feed_output() {
	echo '<div class="rss-widget">';
	wp_widget_rss_output(array(
		'url'          => 'http://www.eightsevencentral.com/feed',
		'title'        => 'What\'s up at 8/7',
		'items'        => 3,
		'show_summary' => 1,
		'show_author'  => 0,
		'show_date'    => 1,
	));
	echo "</div>";
}

// Add footer credits
add_filter( 'admin_footer_text', 'custom_admin_footer_text' );
function custom_admin_footer_text( $default_text ) {
	return '<span id="footer-thankyou">Design + Development by <a href="http://eightsevencentral.com">8/7 Central</a><span> &mdash; Powered by <a href="http://www.wordpress.org">WordPress</a>';
}

/**
 * Disable 3.1 admin bar for all users
 *
 * @link http://www.snilesh.com/resources/wordpress/wordpress-3-1-enable-disable-remove-admin-bar/
 */
add_filter( 'show_admin_bar' , 'custom_admin_bar');
function custom_admin_bar(){
	return false;
}

/**
 * Remove the dashboard update link
 *
 * @link http://www.vooshthemes.com/blog/wordpress-tip/wordpress-quick-tip-remove-the-dashboard-update-message/
 */
add_action( 'admin_init', create_function('', 'remove_action( \'admin_notices\', \'update_nag\', 3 );') );

/**
 * Remove unnecessary menu items
 *
 * @link http://www.smashingmagazine.com/2011/05/10/new-wordpress-power-tips-for-template-developers-and-consultants/
 */
// function custom_admin_menu() {
//   remove_menu_page('link-manager.php'); // Links screen
// }
//
// add_action( 'admin_menu', 'custom_admin_menu' );

/**
 * Remove default sidebar widgets
 *
 * @link http://www.everparent.com/lunaticfred/2011/05/05/how-to-remove-default-sidebar-widgets-in-wordpress/
 */
function core_default_widgets() {
  //unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Search');
  //unregister_widget('WP_Widget_Text');
  //unregister_widget('WP_Widget_Categories');
  //unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Tag_Cloud');
  //unregister_widget('WP_Nav_Menu_Widget');
}
add_action( 'widgets_init', 'core_default_widgets' );
