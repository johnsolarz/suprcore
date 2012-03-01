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

// sharing buttons
function custom_social_sharing() {

  $username = twitter_username();
  $title = get_the_title();
  $permalink = get_permalink();

  if (use_twitter_share() || use_google_plus() || use_facebook_like()) {
    echo '<ul class="share">';
    if (use_twitter_share()) {
      echo '<li><a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="'.$username.'" data-text="'.$title.'">Tweet</a></li><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
    }
    if (use_google_plus()) { 
      echo '<li><div class="g-plusone" data-size="medium" data-href="'.$permalink.'"></div></li><script>(function() {var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;po.src = \'https://apis.google.com/js/plusone.js\';var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);})();</script>';
    }
    if (use_facebook_like()) {
      echo '<li><div class="fb-like" data-href="'.$permalink.'" data-send="false" data-layout="button_count" data-width="80" data-show-faces="false" data-colorscheme="light" data-font="arial"></div></li><div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) {return;}js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>';
    }
  echo '</ul>';
  }
}