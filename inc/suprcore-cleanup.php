<?php
/**
 * Suprcore cleanup
 *
 * @package Wordpress
 * @subpackage Suprcore
 */

/**
 * Redirect /?s to /search/
 * http://txfx.net/wordpress-plugins/nice-search/
 */
function suprcore_nice_search_redirect() {
  if (is_search() && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && strpos($_SERVER['REQUEST_URI'], '/search/') === false) {
    wp_redirect(home_url('/search/' . str_replace(array(
      ' ',
      '%20'
    ), array(
      '+',
      '+'
    ), urlencode(get_query_var('s')))), 301);
    exit();
  }
}
add_action('template_redirect', 'suprcore_nice_search_redirect');

function suprcore_search_query($escaped = true) {
  $query = apply_filters('suprcore_search_query', get_query_var('s'));
  if ($escaped) {
    $query = esc_attr($query);
  }
  return urldecode($query);
}
add_filter('get_search_query', 'suprcore_search_query');

/**
 * Fix for empty search query
 * http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 */
function suprcore_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = " ";
  }
  return $query_vars;
}
add_filter('request', 'suprcore_request_filter');

/**
 * Root relative URLs for everything
 * http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 */
function suprcore_root_relative_url($input) {
  $output = preg_replace_callback('!(https?://[^/|"]+)([^"]+)?!', create_function('$matches',
  // if full URL is site_url, return a slash for relative root
    'if (isset($matches[0]) && $matches[0] === site_url()) { return "/";' .
  // if domain is equal to site_url, then make URL relative
    '} elseif (isset($matches[0]) && strpos($matches[0], site_url()) !== false) { return $matches[2];' .
  // if domain is not equal to site_url, do not make external link relative
    '} else { return $matches[0]; };'), $input);
  return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of JS/CSS tags
 * Example: /subfolder/subfolder/css/style.css
 */
function suprcore_fix_duplicate_subfolder_urls($input) {
  $output = suprcore_root_relative_url($input);
  preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);
  if (isset($matches[1]) && isset($matches[2])) {
    if ($matches[1][0] === $matches[2][0]) {
      $output = substr($output, strlen($matches[1][0]) + 1);
    }
  }
  return $output;
}

/**
 * Apply relative URLs
 */
if (!is_admin() && !in_array($GLOBALS['pagenow'], array(
  'wp-login.php',
  'wp-register.php'
))) {
  add_filter('bloginfo_url', 'suprcore_root_relative_url');
  add_filter('theme_root_uri', 'suprcore_root_relative_url');
  add_filter('stylesheet_directory_uri', 'suprcore_root_relative_url');
  add_filter('template_directory_uri', 'suprcore_root_relative_url');
  add_filter('script_loader_src', 'suprcore_fix_duplicate_subfolder_urls');
  add_filter('style_loader_src', 'suprcore_fix_duplicate_subfolder_urls');
  add_filter('plugins_url', 'suprcore_root_relative_url');
  add_filter('the_permalink', 'suprcore_root_relative_url');
  add_filter('wp_list_pages', 'suprcore_root_relative_url');
  add_filter('wp_list_categories', 'suprcore_root_relative_url');
  add_filter('wp_nav_menu', 'suprcore_root_relative_url');
  add_filter('the_content_more_link', 'suprcore_root_relative_url');
  add_filter('the_tags', 'suprcore_root_relative_url');
  add_filter('get_pagenum_link', 'suprcore_root_relative_url');
  add_filter('get_comment_link', 'suprcore_root_relative_url');
  add_filter('month_link', 'suprcore_root_relative_url');
  add_filter('day_link', 'suprcore_root_relative_url');
  add_filter('year_link', 'suprcore_root_relative_url');
  add_filter('tag_link', 'suprcore_root_relative_url');
  add_filter('the_author_posts_link', 'suprcore_root_relative_url');
}

/**
 * Remove root relative URLs on any attachments in the feed
 */
function suprcore_root_relative_attachment_urls() {
  if (!is_feed()) {
    add_filter('wp_get_attachment_url', 'suprcore_root_relative_url');
    add_filter('wp_get_attachment_link', 'suprcore_root_relative_url');
  }
}
add_action('pre_get_posts', 'suprcore_root_relative_attachment_urls');

/**
 * Remove WordPress version from RSS feed
 */
function suprcore_no_generator() {
  return '';
}
add_filter('the_generator', 'suprcore_no_generator');

/**
 * Add meta tags if the user chooses to hide blog from search engines
 */
function suprcore_noindex() {
  if (get_option('blog_public') === '0') {
    echo '<meta name="robots" content="noindex,nofollow">', "\n";
  }
}

/**
 * Add canonical links for single pages
 */
function suprcore_rel_canonical() {
  if (!is_singular()) {
    return;
  }

  global $wp_the_query;
  if (!$id = $wp_the_query->get_queried_object_id()) {
    return;
  }

  $link = get_permalink($id);
  echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

/**
 * Remove CSS from recent comment widget
 */
function suprcore_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array(
      $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
      'recent_comments_style'
    ));
  }
}

/**
 * Remove CSS from gallery
 */
function suprcore_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/**
 * Remove unnecessary stuff from head
 * http://wpengineer.com/1438/wordpress-header/
 */
function suprcore_head_cleanup() {
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'noindex', 1);
  add_action('wp_head', 'suprcore_noindex');
  remove_action('wp_head', 'rel_canonical');
  add_action('wp_head', 'suprcore_rel_canonical');
  add_action('wp_head', 'suprcore_remove_recent_comments_style', 1);
  add_filter('gallery_style', 'suprcore_gallery_style');

  if (!is_admin()) {
    // Deregister l10n.js (new since WordPress 3.1)
    // Why you might want to keep it: http://wordpress.stackexchange.com/questions/5451/what-does-l10n-js-do-in-wordpress-3-1-and-how-do-i-remove-it/5484#5484
    wp_deregister_script('l10n');

    // Don't load jQuery through WordPress since it's linked in footer.php
    wp_deregister_script('jquery');
    wp_register_script('jquery', '', '', '', true);
  }
}
add_action('init', 'suprcore_head_cleanup');

/**
 * Cleanup gallery_shortcode()
 */
function suprcore_gallery_shortcode($attr) {
  global $post, $wp_locale;

  static $instance = 0;
  $instance++;

  // Allow plugins/themes to override the default gallery template.
  $output = apply_filters('post_gallery', '', $attr);
  if ($output != '')
    return $output;

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if (isset($attr['orderby'])) {
    $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
    if (!$attr['orderby'])
      unset($attr['orderby']);
  }

  extract(shortcode_atts(array(
    'order' => 'ASC',
    'orderby' => 'menu_order ID',
    'id' => $post->ID,
    'icontag' => 'figure',
    'captiontag' => 'figcaption',
    'columns' => 3,
    'size' => 'thumbnail',
    'include' => '',
    'exclude' => ''
  ), $attr));

  $id = intval($id);
  if ('RAND' == $order)
    $orderby = 'none';

  if (!empty($include)) {
    $include      = preg_replace('/[^0-9,]+/', '', $include);
    $_attachments = get_posts(array(
      'include' => $include,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby
    ));

    $attachments = array();
    foreach ($_attachments as $key => $val) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif (!empty($exclude)) {
    $exclude     = preg_replace('/[^0-9,]+/', '', $exclude);
    $attachments = get_children(array(
      'post_parent' => $id,
      'exclude' => $exclude,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby
    ));
  } else {
    $attachments = get_children(array(
      'post_parent' => $id,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby
    ));
  }

  if (empty($attachments))
    return '';

  if (is_feed()) {
    $output = "\n";
    foreach ($attachments as $att_id => $attachment)
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }

  $captiontag = tag_escape($captiontag);
  $columns    = intval($columns);
  $itemwidth  = $columns > 0 ? floor(100 / $columns) : 100;
  $float      = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if (apply_filters('use_default_gallery_style', true))
    $gallery_style = "";
  $size_class  = sanitize_html_class($size);
  $gallery_div = "<section id='$selector' class='clearfix gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output      = apply_filters('gallery_style', $gallery_style . "\n\t\t" . $gallery_div);

  $i = 0;
  foreach ($attachments as $id => $attachment) {
    // Make the gallery link to the file by default instead of the attachment
    $link = isset($attr['link']) && $attr['link'] === 'attachment' ? wp_get_attachment_link($id, $size, true, false) : wp_get_attachment_link($id, $size, false, false);
    $output .= "
      <{$icontag} class=\"gallery-item\">
        $link
      ";
    if ($captiontag && trim($attachment->post_excerpt)) {
      $output .= "
        <{$captiontag} class=\"gallery-caption\">
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>";
    }
    $output .= "</{$icontag}>";
    if ($columns > 0 && ++$i % $columns == 0)
      $output .= '';
  }

  $output .= "</section>\n";

  return $output;
}
remove_shortcode('gallery');
add_shortcode('gallery', 'suprcore_gallery_shortcode');

/**
 * Sets the post excerpt length to 40.
 */
function suprcore_excerpt_length($length) {
  return 40;
}
add_filter('excerpt_length', 'suprcore_excerpt_length');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and suprcore_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function suprcore_excerpt_more($more) {
  return ' &hellip;' . suprcore_continue_reading_link();
}
add_filter('excerpt_more', 'suprcore_excerpt_more');

/**
 * Remove container from menus.
 */
function suprcore_nav_menu_args($args = '') {
  $args['container'] = false;
  return $args;
}
add_filter('wp_nav_menu_args', 'suprcore_nav_menu_args');

/**
 * Get our wp_nav_menu() fallback, wp_page_menu()
 */
function suprcore_page_menu_args() {
	echo '<ul>';
		wp_list_pages('title_li=');
	echo '</ul>';
}
add_filter('wp_page_menu_args', 'suprcore_page_menu_args');

/**
 * Custom Walker for cleaner menu output
 */
class suprcore_nav_walker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
      $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

      $slug = sanitize_title($item->title);

      $class_names = $value = '';
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;

      $classes = array_filter($classes, 'suprcore_check_current');

      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

      $id = apply_filters( 'nav_menu_item_id', 'menu-' . $slug, $item, $args );
      $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

      $output .= $indent . '<li' . $id . $class_names . '>';

      $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
      $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
      $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
      $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

      $item_output = $args->before;
      $item_output .= '<a'. $attributes .'>';
      $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
      $item_output .= '</a>';
      $item_output .= $args->after;

      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}

/**
 * Checks active page and adds active class to the menu item
 */
function suprcore_check_current($val) {
  return preg_match('/current-menu/', $val);
}

/**
 * Add to robots.txt
 * http://codex.wordpress.org/Search_Engine_Optimization_for_WordPress#Robots.txt_Optimization
 */
function suprcore_robots() {
  echo "Disallow: /cgi-bin\n";
  echo "Disallow: /wp-admin\n";
  echo "Disallow: /wp-includes\n";
  echo "Disallow: /wp-content/plugins\n";
  echo "Disallow: /plugins\n";
  echo "Disallow: /wp-content/cache\n";
  echo "Disallow: /wp-content/themes\n";
  echo "Disallow: /trackback\n";
  echo "Disallow: /feed\n";
  echo "Disallow: /comments\n";
  echo "Disallow: /category/*/*\n";
  echo "Disallow: */trackback\n";
  echo "Disallow: */feed\n";
  echo "Disallow: */comments\n";
  echo "Disallow: /*?*\n";
  echo "Disallow: /*?\n";
  echo "Allow: /wp-content/uploads\n";
  echo "Allow: /assets";
}
add_action('do_robots', 'suprcore_robots');

/**
 * We don't need to self-close these tags in html5:
 * <img>, <input>
 */
function suprcore_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar', 'suprcore_remove_self_closing_tags');
add_filter('comment_id_fields', 'suprcore_remove_self_closing_tags');

/**
 * Check to see if the tagline is set to default
 * Show an admin notice to update if it hasn't been changed
 * You want to change this or remove it because it's used as the description in the RSS feed
 */
function suprcore_notice_tagline() {
    global $current_user;
  $user_id = $current_user->ID;
    if (!get_user_meta($user_id, 'ignore_tagline_notice')) {
    echo '<div class="error">';
    echo '<p>', sprintf(__('Please update your <a href="%s">site tagline</a> <a href="%s" style="float: right;">Hide Notice</a>', 'suprcore'), admin_url('options-general.php'), '?tagline_notice_ignore=0'), '</p>';
    echo '</div>';
    }
}
if (get_option('blogdescription') === 'Just another WordPress site') {
  add_action('admin_notices', 'suprcore_notice_tagline');
}

function suprcore_notice_tagline_ignore() {
  global $current_user;
  $user_id = $current_user->ID;
  if (isset($_GET['tagline_notice_ignore']) && '0' == $_GET['tagline_notice_ignore']) {
    add_user_meta($user_id, 'ignore_tagline_notice', 'true', true);
    }
}
add_action('admin_init', 'suprcore_notice_tagline_ignore');

/**
 * Set the post revisions to 5 unless the constant was set in wp-config.php to avoid DB bloat
 */
if (!defined('WP_POST_REVISIONS'))
  define('WP_POST_REVISIONS', 5);

/**
 * Allow more tags in TinyMCE including iframes
 */
function suprcore_change_mce_options($options) {
  $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';
  if (isset($initArray['extended_valid_elements'])) {
    $options['extended_valid_elements'] .= ',' . $ext;
  } else {
    $options['extended_valid_elements'] = $ext;
  }
  return $options;
}
add_filter('tiny_mce_before_init', 'suprcore_change_mce_options');

/**
 * Clean up the default WordPress style tags
 */
function suprcore_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  //only display media if it's print
  $media = $matches[3][0] === 'print' ? ' media="print"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'suprcore_clean_style_tag');

/**
 * Removes URL hash to avoid the jump link
 */
function suprcore_remove_more_jump_link($link) {
   $offset = strpos($link, '#more-');
   if ($offset) {
      $end = strpos($link, '"',$offset);
   }
   if ($end) {
      $link = substr_replace($link, '', $offset, $end-$offset);
   }
   return $link;
}
add_filter('the_content_more_link', 'suprcore_remove_more_jump_link');

/**
 * A clean theme
 * http://nicolasgallagher.com/anatomy-of-an-html5-wordpress-theme/
 */
add_filter('the_content', 'remove_empty_read_more_span');
function remove_empty_read_more_span($content) {
	return eregi_replace("(<p><span id=\"more-[0-9]{1,}\"></span></p>)", "", $content);
} // removes empty span

add_filter('the_content_more_link', 'remove_more_jump_link');
function remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return '<a href="'.get_permalink($post->ID).'" class="read-more-link">'.'Read more'.'</a>';
} // removes url hash to avoid the jump link

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
 * Remove languages dir and set lang="en" as default (rather than en-US)
 */
function suprcore_language_attributes() {
  $attributes = array();
  $output = '';
  $lang = get_bloginfo('language');
  if ($lang && $lang !== 'en-US') {
    $attributes[] = "lang=\"$lang\"";
  } else {
    $attributes[] = 'lang="en"';
  }

  $output = implode(' ', $attributes);
  $output = apply_filters('suprcore_language_attributes', $output);
  return $output;
}

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
	//unregister_widget('WP_Widget_Recent_Posts');
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
	h1 a { background-image: url('.get_bloginfo('template_directory').'/inc/img/login.png) !important; height: 220px !important; }
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