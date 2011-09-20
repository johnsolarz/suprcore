		</div> <!-- #content -->
		
		<footer class="grid_12 clearfix" role="contentinfo">
		
			<nav class="grid_8 alpha">
				<?php wp_nav_menu( array( 'container' => 'false', 'fallback_cb' => 'suprcore_menu', 'theme_location' => 'footer' ) ); ?>
			</nav>
			
			<p class="grid_4 omega copy">
				&copy; <strong><?php bloginfo( 'name' ); ?></strong> <?php echo date('Y');?> &mdash; Site by <a href="http://eightsevencentral.com" target="_blank" title="Eight Seven Central">8/7central</a>
			</p>
			
			<?php get_sidebar( 'footer' ); ?>

		</footer> <!-- #footer -->

	</div> <!-- #wrapper -->
	
<?php wp_footer(); ?>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <!-- jQuery enqueued in footer via functions.php -->
  <script>window.jQuery || document.write('<script src="<?php echo bloginfo('template_url'); ?>/assets/js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="<?php echo bloginfo('template_url'); ?>/assets/js/plugins.js"></script>
  <script defer src="<?php echo bloginfo('template_url'); ?>/assets/js/script.js"></script>
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

</body>
</html>