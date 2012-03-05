<?php


function twitter_share_script() {
  if (use_twitter_share()) {
    echo "\n\t<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"//platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>";
  }
}

add_action('custom_footer', 'twitter_share_script');

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

add_action('custom_footer', 'facebook_like_script');

function pinterest_pin_script() {
  if (use_pinterest_pin()) {
    echo "\n\t<script type=\"text/javascript\">\n";
    echo "\t\t(function() {\n";
    echo "\t\twindow.PinIt = window.PinIt || { loaded:false };\n";
    echo "\t\tif (window.PinIt.loaded) return;\n";
    echo "\t\twindow.PinIt.loaded = true;\n";
    echo "\t\tfunction async_load(){\n";
    echo "\t\tvar s = document.createElement(\"script\");\n";
    echo "\t\ts.type = \"text/javascript\";\n";
    echo "\t\ts.async = true;\n";
    echo "\t\tif (window.location.protocol == \"https:\")\n";
    echo "\t\ts.src = \"https://assets.pinterest.com/js/pinit.js\";\n";
    echo "\t\telse\n";
    echo "\t\ts.src = \"http://assets.pinterest.com/js/pinit.js\";\n";
    echo "\t\tvar x = document.getElementsByTagName(\"script\")[0];\n";
    echo "\t\tx.parentNode.insertBefore(s, x);\n";
    echo "\t\t}\n";
    echo "\t\tif (window.attachEvent)\n";
    echo "\t\twindow.attachEvent(\"onload\", async_load)\n";
    echo "\t\telse\n";
    echo "\t\twindow.addEventListener(\"load\", async_load, false);\n";
    echo "\t\t})();\n";
    echo "\t</script>\n";
  }
}

add_action('custom_footer', 'pinterest_pin_script');

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

add_action('custom_footer', 'google_plus_script');