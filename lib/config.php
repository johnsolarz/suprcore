<?php
/**
 * Roots configuration
 */

// Enable theme features
add_theme_support('root-relative-urls');    // Enable relative URLs
add_theme_support('rewrite-urls');          // Enable URL rewrites
add_theme_support('h5bp-htaccess');         // Enable HTML5 Boilerplate's .htaccess
add_theme_support('bootstrap-top-navbar');  // Enable Bootstrap's fixed navbar

// Configuration values
define('GOOGLE_ANALYTICS_ID', ''); // UA-XXXXX-Y
define('POST_EXCERPT_LENGTH', 40);

// social.php
define('TWITTER_USERNAME',          '');
define('TWITTER_SHARE_POSTS',       0);
define('FACEBOOK_LIKE_POSTS',       0);
define('PINTEREST_PIN_POSTS',       0);
define('GOOGLE_PLUS_POSTS',         0);

// Set the post revisions to 5 unless the constant was set in wp-config.php to avoid DB bloat
if (!defined('WP_POST_REVISIONS')) { define('WP_POST_REVISIONS', 5); }

/**
* $content_width is a global variable used by WordPress for max image upload sizes and media embeds (in pixels)
*
* Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
*
* Default: 940px is the default Bootstrap container width.
*
* This is not required or used by Roots.
*/
if (!isset($content_width)) { $content_width = 940; }
