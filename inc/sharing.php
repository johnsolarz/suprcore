<?php

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

// returns twitter icon
function twitter_icon() {

  // bigger - 73px by 73px
  // normal - 48px by 48px
  // mini - 24px by 24px

  $username = twitter_username();
  $profile_img = 'https://api.twitter.com/1/users/profile_image/' . $username . '?size=bigger';
  return ( $profile_img );
}

// returns follow count
function twitter_followers_counter() {

  $username = twitter_username();

  $cache_file = CACHEDIR . 'twitter_followers_counter_' . md5 ( $username );

  if (is_file ( $cache_file ) == false) {
    $cache_file_time = strtotime ( '1984-01-11 07:15' );
  } else {
    $cache_file_time = filemtime ( $cache_file );
  }

  $now = strtotime ( date ( 'Y-m-d H:i:s' ) );
  $api_call = $cache_file_time;
  $difference = $now - $api_call;
  $api_time_seconds = 1800;

  if ($difference >= $api_time_seconds) {

      $api_call = 'http://twitter.com/users/show/'.$username.'.json';
      $results = json_decode(file_get_contents($api_call));
      $count = $results->followers_count;

    if (is_file ( $cache_file ) == true) {
      unlink ( $cache_file );
    }
    touch ( $cache_file );
    file_put_contents ( $cache_file, strval ( $count ) );
    return strval ( $count );
  } else {
    $count = file_get_contents ( $cache_file );
    return strval ( $count );
  }
}

// retreive first image from post
// http://wordpress.org/support/topic/retreive-first-image-from-post
function custom_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "/img/login.png";
  }
  return $first_img;
}

// sharing buttons
function custom_social_sharing() {

  $username = twitter_username();
  $title = get_the_title();
  $permalink = get_permalink();
  $firstimg = custom_first_image();

  if (use_twitter_share() || use_google_plus() || use_pinterest_pin() || use_facebook_like()) {
    echo '<ul class="sharing">';
    if (use_twitter_share()) {
      echo '<li class="one column"><a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-via="'.$username.'" data-text="'.$title.'">Tweet</a></li>';
    }
    if (use_facebook_like()) {
      echo '<li class="one column"><div class="fb-like" data-href="'.$permalink.'" data-send="false" data-layout="button_count" data-show-faces="false" data-colorscheme="light" data-font="arial"></div></li>';
    }
    if (use_pinterest_pin()) {
    	echo '<li class="one column"><a href="http://pinterest.com/pin/create/button/?url='.$permalink.'&media='.$firstimg.'&description='.$title.'" class="pin-it-button" count-layout="none">Pin It</a></li>';
    }
    if (use_google_plus()) {
      echo '<li class="one column"><div class="g-plusone" data-size="medium" data-href="'.$permalink.'" data-annotation="none"></div></li>';
    }
  echo '</ul>';
  }
}
