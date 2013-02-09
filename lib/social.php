<?php

define('TWITTER_USERNAME',    'johnsolarz');
define('TWITTER_SHARE_POSTS',  0);
define('FACEBOOK_LIKE_POSTS',  0);
define('PINTEREST_PIN_POSTS',  0);
define('GOOGLE_PLUS_POSTS',    0);

function twitter_username() {
	return TWITTER_USERNAME;
}

function use_twitter_share() {
  return TWITTER_SHARE_POSTS;
}

function use_facebook_like() {
  return FACEBOOK_LIKE_POSTS;
}

function use_pinterest_pin() {
  return PINTEREST_PIN_POSTS;
}

function use_google_plus() {
  return GOOGLE_PLUS_POSTS;
}


/**
 * Return twitter icon
 */
function twitter_icon() {

  // bigger - 73px by 73px
  // normal - 48px by 48px
  // mini - 24px by 24px

  $username = twitter_username();
  $profile_img = 'https://api.twitter.com/1/users/profile_image/' . $username . '?size=normal';
  return ( $profile_img );
}

/**
 * Retreive first image from post, used for Pin button
 *
 * @link http://wordpress.org/support/topic/retreive-first-image-from-post
 */

function get_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ // Be sure to define a default image here per project
    $first_img = "/img/login.png";
  }
  return $first_img;
}

/**
 * Show sharing buttons
 */
function core_social_sharing() {

  $username = twitter_username();
  $title = get_the_title();
  $permalink = get_permalink();
  $firstimg = get_first_image();

  if (use_twitter_share() || use_google_plus() || use_pinterest_pin() || use_facebook_like()) {
    echo '<div class="social">';
    if (use_twitter_share()) {
      echo '<div class="tweet-this"><a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-via="'.$username.'" data-text="'.$title.'">Tweet</a></div>';
    }
    if (use_pinterest_pin()) {
      echo '<div class="pinterest-pin"><a href="http://pinterest.com/pin/create/button/?url='.$permalink.'&media='.$firstimg.'&description='.$title.'" class="pin-it-button" count-layout="none"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>';
    }
    if (use_google_plus()) {
      echo '<div class="google-plus"><div class="g-plusone" data-size="medium" data-href="'.$permalink.'" data-annotation="none"></div></div>';
    }
    if (use_facebook_like()) {
      echo '<div class="facebook-like"><div class="fb-like" data-href="'.$permalink.'" data-send="false" data-layout="button_count" data-show-faces="false" data-colorscheme="light" data-font="arial"></div></div>';
    }
  echo '</div>';
  }
}

/**
 * Output sharing scripts in footer
 *
 * HTML tags should be in the templates when possible:
 * @todo https://github.com/retlehs/roots/pull/554
 */

function twitter_share_script() {
  if (use_twitter_share()) {
    echo "\n\t<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"//platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>";
  }
}

add_action('wp_footer', 'twitter_share_script');

function facebook_like_script() {
  if (use_facebook_like()) {
    echo "\n\t<div id=\"fb-root\"></div>\n";
    echo "\n\t<script>(function(d, s, id) {\n";
    echo "\t\tvar js, fjs = d.getElementsByTagName(s)[0];\n";
    echo "\t\tif (d.getElementById(id)) return;\n";
    echo "\t\tjs = d.createElement(s); js.id = id;\n";
    echo "\t\tjs.src = \"//connect.facebook.net/en_US/all.js#xfbml=1\";\n";
    echo "\t\tfjs.parentNode.insertBefore(js, fjs);\n";
    echo "\t\t}(document, 'script', 'facebook-jssdk'));</script>\n";
  }
}

add_action('wp_footer', 'facebook_like_script');

function pinterest_pin_script() {
  if (use_pinterest_pin()) {
    echo "\n\t<script type=\"text/javascript\" src=\"//assets.pinterest.com/js/pinit.js\">\n";
    echo "\t</script>\n";
  }
}

add_action('wp_footer', 'pinterest_pin_script');

function google_plus_script() {
  if (use_google_plus()) {
    echo "\n\t<script type=\"text/javascript\">\n";
    echo "\t\t(function() {\n";
    echo "\t\tvar po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;\n";
    echo "\t\tpo.src = 'https://apis.google.com/js/plusone.js';\n";
    echo "\t\tvar s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);\n";
    echo "\t\t})();\n";
    echo "\t</script>\n";
  }
}

add_action('wp_footer', 'google_plus_script');
