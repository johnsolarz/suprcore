	</div><!-- #main -->

	<footer class="grid" role="contentinfo">

		<?php if (is_active_sidebar('custom-footer')) : ?>
			<aside class="twelve column" role="complementary">
				<?php dynamic_sidebar('custom-footer'); ?>
			</aside>
		<?php endif; ?>

		<div class="twelve column utility">
			<span class="copy">&copy; <?php echo date('Y');?> <?php bloginfo('name'); ?> &mdash; All rights reserved</span>
			<nav role="navigation">
				<?php wp_nav_menu(array(
					'theme_location' => 'utility_navigation',
					'walker' => new Custom_Navbar_Nav_Walker() 
      	));
      	?>
			</nav>
			<a class="eightsevencentral" href="http://eightsevencentral.com" target="_blank" title="8/7 Central">Site by 8/7 Central</a>
		</div>

	</footer>


  <!-- JavaScript at the bottom for fast page loading: http://developer.yahoo.com/performance/rules.html#js_bottom -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.7.2.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via build script -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/plugins.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
  <!-- end scripts -->

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>


  <?php wp_footer(); ?>
  <?php custom_footer(); ?>
  
<!--

  Handcrafted code from Des Moines.

    _____   |  _______    _______  _______  __    _  _______  ______   _______  ___     
   |  _  |  | |       |  |       ||       ||  |  | ||       ||    _ | |   _   ||   |    
   | |_| |  | |___    |  |       ||    ___||   |_| ||_     _||   | || |  |_|  ||   |    
  |   _   | |     |   |  |       ||   |___ |       |  |   |  |   |_|| |       ||   |    
  |  | |  | |     |   |  |      _||    ___||  _    |  |   |  |    __ ||       ||   |___ 
  |  |_|  | |     |   |  |     |_ |   |___ | | |   |  |   |  |   |  |||   _   ||       |
  |_______| |     |___|  |_______||_______||_|  |__|  |___|  |___|  |||__| |__||_______|

 -->

</body>
</html>