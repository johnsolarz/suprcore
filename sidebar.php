<aside id="sidebar" class="four column" role="complementary">

	<?php if ( ! dynamic_sidebar('custom-sidebar') ) : ?>

	<section class="clearfix">
		<div class="three column alpha">
			<h3><?php bloginfo('title');?></h3>
			<?php bloginfo('description');?>
			<?php if (twitter_username()) { ?>
				<a class="twitter-link" href="http://twitter.com/<?php echo twitter_username();?>">Follow <?php echo twitter_username();?> on Twitter (<?php echo twitter_followers_counter();?>)</a>
			<?php } ?>
		</div>
		<?php if (twitter_username()) { ?>
			<div class="one column omega twitter-icon">
				<img src="<?php echo twitter_icon(); ?>" alt="">
			</div>
		<?php } ?>
	</section>

	<form class="clearfix" role="search" method="get" action="<?php echo home_url('/'); ?>">
		<label class="visuallyhidden" for="s">Search for:</label>
		<input type="search" class="search" onmouseout="if (this.value == '') {this.value = 'Search + Enter';} this.blur();" onmouseover="if (this.value == 'Search + Enter') {this.value = '';} this.focus();" value="Search + Enter" name="s" id="s">
		<input type="submit" value="Search">
	</form>

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

</aside>

