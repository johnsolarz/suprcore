<?php
/**
 * Suprcore htaccess
 *
 * Add rewrites and our custom htaccess to Wordpress
 *
 * @package Wordpress
 * @subpackage Suprcore
 */

if (stristr($_SERVER['SERVER_SOFTWARE'], 'apache') !== false) {
  /**
   * Add notice in admin if htaccess isn't writable
   */
  function suprcore_htaccess_writable() {
    if (!is_writable(get_home_path() . '.htaccess')) {
      if (current_user_can('administrator')) {
        add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>" . sprintf(__('Please make sure your <a href="%s">.htaccess</a> file is writable ', 'suprcore'), admin_url('options-permalink.php')) . "</p></div>';"));
      }
    };
  }
  add_action('admin_init', 'suprcore_htaccess_writable');

  /**
   * Flush rewrite rules
   */
  function suprcore_flush_rewrites() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
  }

  /**
   * Set the permalink structure to /category/postname/
   */
  if (get_option('permalink_structure') != '/%category%/%postname%/') {
    update_option('permalink_structure', '/%category%/%postname%/');
  }

  /**
   * Set upload folder to /uploads/.
   */
  update_option('uploads_use_yearmonth_folders', 0);
  update_option('upload_path', 'uploads');

  /**
   * Apply rewrites
   */
  function suprcore_add_rewrites($content) {
    $theme_name = next(explode('/themes/', get_stylesheet_directory()));
    global $wp_rewrite;
    $suprcore_new_non_wp_rules = array(
      'assets/(.*)'   => 'wp-content/themes/'. $theme_name . '/assets/$1',
      'inc/(.*)'      => 'wp-content/themes/'. $theme_name . '/inc/$1',
      'plugins/(.*)'  => 'wp-content/plugins/$1'
    );
    $wp_rewrite->non_wp_rules += $suprcore_new_non_wp_rules;
  }
  add_action('admin_init', 'suprcore_flush_rewrites');

  /**
   * Apply new path to assets
   */
  function suprcore_clean_assets($content) {
      $theme_name = next(explode('/themes/', $content));
      $current_path = '/wp-content/themes/' . $theme_name;
      $new_path = '';
      $content = str_replace($current_path, $new_path, $content);
      return $content;
  }

  /**
   * Apply new plugins
   */
  function suprcore_clean_plugins($content) {
      $current_path = '/wp-content/plugins';
      $new_path = '/plugins';
      $content = str_replace($current_path, $new_path, $content);
      return $content;
  }

  /**
   * Only use clean URLs if the theme isn't a child or an MU (Network) install
   */
  if (!is_multisite() && !is_child_theme()) {
    add_action('generate_rewrite_rules', 'suprcore_add_rewrites');
    if (!is_admin()) {
      add_filter('plugins_url', 'suprcore_clean_plugins');
      add_filter('bloginfo', 'suprcore_clean_assets');
      add_filter('stylesheet_directory_uri', 'suprcore_clean_assets');
      add_filter('template_directory_uri', 'suprcore_clean_assets');
      add_filter('script_loader_src', 'suprcore_clean_plugins');
      add_filter('style_loader_src', 'suprcore_clean_plugins');
    }
  }

  /**
   * Write new htaccess
   */
  function suprcore_add_h5bp_htaccess($rules) {
    global $wp_filesystem;

    if (!defined('FS_METHOD')) define('FS_METHOD', 'direct');
    if (is_null($wp_filesystem)) WP_Filesystem(array(), ABSPATH);

    if (!defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH . 'wp-content');

    $theme_name = next(explode('/themes/', get_template_directory()));
    $filename = WP_CONTENT_DIR . '/themes/' . $theme_name . '/inc/suprcore-htaccess.htaccess';

    $rules .= $wp_filesystem->get_contents($filename);

    return $rules;
  }

  add_action('mod_rewrite_rules', 'suprcore_add_h5bp_htaccess');
}

?>