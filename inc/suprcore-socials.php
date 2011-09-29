<?php

function use_facebook_like() {
	global $like_btn;
	return $like_btn;
}

function use_google_plus() {
	global $gplus_btn;
	return $gplus_btn;
}

function your_twitter_username() {
	global $your_twitter_username;
	return $your_twitter_username;
}


function twitter_followers_counter() {

	$username = your_twitter_username();
	
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


function __your_twitter_icon() {
	
  $username = your_twitter_username();

  $api_call = 'http://twitter.com/users/show/'.$username.'.json';
  $results = json_decode(file_get_contents($api_call));
  return $results->profile_image_url;
}


function your_twitter_icon() {

	$username = your_twitter_username();
	
	$cache_file = CACHEDIR . 'twitter_profile_image_url_' . md5 ( $username );
	
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
  		$count = $results->profile_image_url;

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


?>