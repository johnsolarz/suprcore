<?php

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

/**
 * Add the asynchronous Google Analytics snippet from HTML5 Boilerplate
 * if an ID is defined in config.php
 *
 * @link mathiasbynens.be/notes/async-analytics-snippet
 */
function google_analytics() {
  if (GOOGLE_ANALYTICS_ID) {
    echo "\n\t<script>\n";
    echo "\t\tvar _gaq=[['_setAccount','" . GOOGLE_ANALYTICS_ID . "'],['_trackPageview']];\n";
    echo "\t\t(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];\n";
    echo "\t\tg.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';\n";
    echo "\t\ts.parentNode.insertBefore(g,s)}(document,'script'));\n";
    echo "\t</script>\n";
  }
}

add_action('wp_footer', 'google_analytics');
