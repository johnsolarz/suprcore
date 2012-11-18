	</div><!-- #content -->

	<footer id="footer" class="container" role="contentinfo">

		<?php if (is_active_sidebar('sidebar-footer')) : ?>
			<aside class="twelve column" role="complementary">
				<?php dynamic_sidebar('sidebar-footer'); ?>
			</aside>
		<?php endif; ?>

		<div class="twelve column utility">
			<span class="copy">&copy; <?php echo date('Y');?> <?php bloginfo('name'); ?></span> &mdash;
			<a class="credit" href="http://eightsevencentral.com" target="_blank" title="8/7 Central">Site by 8/7 Central</a>
		</div>

	</footer>

  <?php if (GOOGLE_ANALYTICS_ID) : ?>
  <script>
    var _gaq=[['_setAccount','<?php echo GOOGLE_ANALYTICS_ID; ?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  <?php endif; ?>

  <?php wp_footer(); ?>

<!--

          |
   eeeee  | eeeee    8""""8
   8   8  | 8   8    8    " eeee eeeee eeeee eeeee  eeeee e
   8eee8  |    e'    8e     8    8   8   8   8   8  8   8 8
  88   88 |   e'     88     8eee 8e  8   8e  8eee8e 8eee8 8e
  88   88 |   8      88   e 88   88  8   88  88   8 88  8 88
  88eee88 |   8      88eee8 88ee 88  8   88  88   8 88  8 88eee

  Handcrafted code from Des Moines.

 -->

</body>
</html>
