<?php
/**
 * Enqueue scripts in the following order:
 * 1. /theme/js/vendor/modernizr-2.6.2.min.js  (in head.php)
 * 2. jquery-1.8.2.min.js via Google CDN       (in head.php)
 * 3. /theme/js/plugins.js                     (in head.php)
 * 4. /theme/js/main.js                        (in head.php)
 */

function roots_scripts() {

  // jQuery is loaded in header.php using the same method from HTML5 Boilerplate:
  // Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline
  // It's kept in the header instead of footer to avoid conflicts with plugins.
  if (!is_admin()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '', '', '1.8.2', false);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

}

add_action('wp_enqueue_scripts', 'roots_scripts', 100);
