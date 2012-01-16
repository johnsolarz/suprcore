		<footer class="clearfix" role="contentinfo">

			<?php get_sidebar('footer'); ?>
					
			<nav class="grid_8">
				<?php wp_nav_menu(array(
					'container' => '', 
					'theme_location' => 'utility_navigation',
					'walker' => new custom_nav_walker())); 
				?>
			</nav>
			
			<p class="grid_4 copy">
				&copy; <?php bloginfo('name'); ?> <?php echo date('Y');?> &mdash; Site by <a href="http://eightsevencentral.com" target="_blank" title="8/7 Central">8/7 Central</a>
			</p>

		</footer>

	</div><!-- .container -->

</div><!-- .wrapper -->

  <!-- JavaScript at the bottom for fast page loading -->
  
	<?php if (use_facebook_like()) { ?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<?php } ?>

	<?php if (use_google_plus()) { ?>
		<script>
			(function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
		</script>
	<?php } ?>
	
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/jquery-1.7.1.min.js"><\/script>')</script>

	
  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="<?php echo get_template_directory_uri(); ?>/assets/js/plugins.js"></script>
  <script defer src="<?php echo get_template_directory_uri(); ?>/assets/js/script.js"></script>
  <!-- end scripts-->


  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview'],['_trackPageLoadTime']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

<?php wp_footer(); ?>

</body>
</html>