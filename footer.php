		</div> <!-- #content -->
		
		<footer class="grid_12 clearfix" role="contentinfo">
		
			<nav class="grid_8 alpha">
				<?php wp_nav_menu( array( 'container' => 'false', 'fallback_cb' => 'suprcore_menu', 'theme_location' => 'footer' ) ); ?>
			</nav>
			
			<p class="grid_4 omega copy">
				&copy; <strong><?php bloginfo( 'name' ); ?></strong> <?php echo date('Y');?> &mdash; Site by <a href="http://eightsevencentral.com" target="_blank" title="Eight Seven Central">8/7central</a>
			</p>

		</footer> <!-- #footer -->

	</div> <!-- #wrapper -->
	
<?php wp_footer(); ?>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <!-- jQuery enqueued in footer via functions.php -->
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="<?php echo get_template_directory_uri(); ?>/assets/js/plugins.js"></script>
  <script defer src="<?php echo get_template_directory_uri(); ?>/assets/js/script.js"></script>
  <!-- end scripts-->


  <!-- Change UA-XXXXX-X to be your site's ID -->
  <script>
    window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

</body>
</html>