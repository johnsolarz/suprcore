<aside class="sidebar grid_4 omega" role="complementary">

	<?php 
	
	if ( ! dynamic_sidebar('Sidebar') ) : ?>

	<section> 
		<h3>Info</h3>
		<div class="grid_3 alpha">	     		
			<?php bloginfo('description');?>
			<?php if (your_twitter_username()) { ?>
				<a class="twitter-link" href="http://twitter.com/<?php echo your_twitter_username();?>">Follow <?php echo your_twitter_username();?> on Twitter (<?php echo twitter_followers_counter();?>)</a>
			<?php } ?>
		</div>
		<?php if (your_twitter_username()) { ?>
			<div class="grid_1 omega twitter-icon">
				<img src="<?php echo your_twitter_icon(); ?>" alt="">
		</div>
		<?php } ?>
			
		<div class="clear"></div>
	</section>

	<form role="search" method="get" action="<?php echo home_url('/'); ?>">
		<div>
			<label class="visuallyhidden" for="s">Search for:</label>
			<input type="search" class="search" onmouseout="if (this.value == '') {this.value = 'Search + Enter';} this.blur();" onmouseover="if (this.value == 'Search + Enter') {this.value = '';} this.focus();" value="Search + Enter" name="s" id="s" />
			<input type="submit" value="Search" id="search-submit" />
		</div>
	</form>

	<section> 
		<h3>Pages</h3>
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
			<li><a href="mailto:<?php echo get_settings('admin_email');?>">E-mail</a></li>
		</ul>	
	</section>

	<?php endif; ?>	

</aside>

