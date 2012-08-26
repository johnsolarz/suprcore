	</div><!-- #content -->

	<footer class="grid" role="contentinfo">

		<?php if (is_active_sidebar('sidebar-footer')) : ?>
			<aside class="twelve column" role="complementary">
				<?php dynamic_sidebar('sidebar-footer'); ?>
			</aside>
		<?php endif; ?>

		<div class="twelve column utility">
			<span class="copy">&copy; <?php echo date('Y');?> <?php bloginfo('name'); ?></span>
			<nav role="navigation">
				<?php wp_nav_menu(array('theme_location' => 'footer_navigation', 'menu_class' => 'nav')); ?>
			</nav>
			<a class="eightsevencentral" href="http://eightsevencentral.com" target="_blank" title="8/7 Central">Site by 8/7 Central</a>
		</div>

	</footer>

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
