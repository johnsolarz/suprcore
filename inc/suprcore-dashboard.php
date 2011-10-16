<?php
/**
 * Suprcore dashboard
 *
 * Adds custom functionality to login screen and dashboard, sets default menu items and widgets and disables admin bar.
 *
 * @package Wordpress
 * @subpackage Suprcore
 */
 
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
	// remove unnecessary widgets: http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
	// var_dump( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs
	unset(
		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'],
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
		'items' => 3,
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
	h1 a { background-image: url('.get_bloginfo('template_directory').'/inc/img/login.png) !important; height: 220px; }
	input.button-primary { background: #99CF52 !important; border-color: #99CF52; }
	input.button-primary:hover { color: #F9F9F9; border-color: #669900; }
	.login #nav a { color: #ccc !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');

/**
 * Custom Login URL and title
 * http://primegap.net/2011/01/26/wordpress-quick-tip-custom-wp-login-php-logo-url-without-hacks/
 */
function custom_login_url() {
  return ('http://eightsevencentral.com');
}
add_filter( 'login_headerurl', 'custom_login_url', 10, 4 );

function custom_login_title() {
  return ('Eight Seven Central');
}
add_filter( 'login_headertitle', 'custom_login_title', 10, 4 );

/** 
 * Disable 3.1 admin bar for all users
 * http://www.snilesh.com/resources/wordpress/wordpress-3-1-enable-disable-remove-admin-bar/
 */
add_filter( 'show_admin_bar' , 'suprcore_admin_bar');
function suprcore_admin_bar(){
	return false;
}

/**
 * Remove the dashboard update link
 * http://www.vooshthemes.com/blog/wordpress-tip/wordpress-quick-tip-remove-the-dashboard-update-message/
 */
add_action( 'admin_init', create_function('', 'remove_action( \'admin_notices\', \'update_nag\', 3 );') );

?>