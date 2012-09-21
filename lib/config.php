<?php
/**
 * Core configuration and constants
 */
add_theme_support('root-relative-urls');    // Enable relative URLs
add_theme_support('rewrite-urls');          // Enable URL rewrites
add_theme_support('h5bp-htaccess');         // Enable HTML5 Boilerplate's .htaccess
add_theme_support('bootstrap-top-navbar');  // Enable Bootstrap's fixed navbar

$get_theme_name = explode('/themes/', get_template_directory());
define('GOOGLE_ANALYTICS_ID',       ''); // UA-XXXXX-Y
define('POST_EXCERPT_LENGTH',       40);
define('WP_BASE',                   wp_base_dir());
define('THEME_NAME',                next($get_theme_name));
define('RELATIVE_PLUGIN_PATH',      str_replace(site_url() . '/', '', plugins_url()));
define('FULL_RELATIVE_PLUGIN_PATH', WP_BASE . '/' . RELATIVE_PLUGIN_PATH);
define('RELATIVE_CONTENT_PATH',     str_replace(site_url() . '/', '', content_url()));
define('THEME_PATH',                RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);

// Call actions in social.php
define('TWITTER_USERNAME',          '');
define('TWITTER_SHARE_POSTS',       0);
define('FACEBOOK_LIKE_POSTS',       0);
define('PINTEREST_PIN_POSTS',       0);
define('GOOGLE_PLUS_POSTS',         0);

// Set the post revisions to 5 unless the constant was set in wp-config.php to avoid DB bloat
if (!defined('WP_POST_REVISIONS')) { define('WP_POST_REVISIONS', 5); }

// Set the content width based on the theme's design and stylesheet
if (!isset($content_width)) { $content_width = 940; }
