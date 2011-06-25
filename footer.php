		</div> <!-- #content -->
		
		<footer class="grid_12 clearfix" role="contentinfo">
		
			<?php get_sidebar( 'footer' ); ?>

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

	<!-- jQuery CDN included via functions.php; fall back to local if offline -->
	<script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/jquery-1.6.1.min.js">\x3C/script>')</script>


	<!-- scripts concatenated and minified via ant build script-->
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/plugins.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/script.js"></script>
	<!-- end scripts-->


	<!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
	<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview'],['_trackPageLoadTime']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>

</body>
</html>