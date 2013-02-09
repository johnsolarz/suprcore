<aside id="sidebar" class="four column" role="complementary">

	<?php if (!dynamic_sidebar('sidebar-primary')) : ?>

	<section class="row">
		<div class="three column">
			<h3><?php bloginfo('title');?></h3>
			<?php bloginfo('description');?>
		</div>
		<?php if (twitter_username()) { ?>
			<div class="one column twitter-icon">
				<img src="<?php echo twitter_icon(); ?>" alt="">
			</div>
		<?php } ?>
	</section>

	<section>
		<form role="search" method="get" id="searchform" class="form-search clearfix" action="<?php echo home_url('/'); ?>">
			<label class="visuallyhidden" for="s">Search for:</label>
			<input type="text" value="Search + Enter" name="s" id="s" class="search-query" onmouseout="if (this.value == '') {this.value = 'Search + Enter';}" onmouseover="if (this.value == 'Search + Enter') {this.value = '';} this.focus();">
			<input type="submit" id="searchsubmit" value="<?php _e('Search', 'roots'); ?>" class="btn">
		</form>
	</section>

	<section>
		<h3>Navigation</h3>
		<ul>
			<?php wp_list_pages('orderby=name&title_li='); ?>
		</ul>
	</section>

	<section>
		<h3>Categories</h3>
		<ul>
			<?php wp_list_categories('orderby=name&hide_empty=0&title_li='); ?>
		</ul>
	</section>

	<section>
		<h3>Archives</h3>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</section>

	<section>
		<h3>Contact</h3>
		<ul>
			<li><a href="mailto:<?php echo get_settings('admin_email');?>">Email</a></li>
		</ul>
	</section>

	<?php endif; ?>

	<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>

</aside>

<?php
