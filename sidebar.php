<aside class="sidebar grid_4 omega" role="complementary">

	<?php 
	
	if ( ! dynamic_sidebar( 'primary-widget' ) ) : ?>

    <ul>
		<li>
			<p class="widget_title">Info</p>
			<div class="grid_3 alpha">	     		
				<?php bloginfo('description');?>
				<?php if (your_twitter_username()) { ?>
					<a class="twitter_link" href="http://twitter.com/<?php echo your_twitter_username();?>">Follow <?php echo your_twitter_username();?> on Twitter (<?php echo twitter_followers_counter();?>)</a>
		     	<?php } ?>
			</div>
			<?php if (your_twitter_username()) { ?>
			<div class="grid_1 omega twitter_icon">
				<img src="<?php echo your_twitter_icon(); ?>" alt="">
			</div>
			<?php } ?>
			
			<div class="clear"></div>
		     		
		</li>
	</ul>

	<form role="search" method="get" class="searchform" action="<?php echo home_url( '/' ); ?>">
		<div>
			<label class="visuallyhidden" for="s">Search for:</label>
			<input type="search" class="search" value="Search + Enter" name="s" id="s" />
			<input type="image" src="<?php bloginfo('stylesheet_directory'); ?>/assets/img/arrow_sbr.gif" id="searchsubmit" alt="" />
		</div>
	</form>

	<div class="grid_4 alpha"> 

		<p class="widget_title">Pages</p>
		<ul>
			<?php wp_list_pages('orderby=name&title_li='); ?> 
		</ul>
  	       
		<p class="widget_title">Categories</p>
		<ul>
			<?php wp_list_categories('orderby=name&hide_empty=0&title_li='); ?> 
		</ul>

		<p class="widget_title">Archives</p>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>

		<p class="widget_title">Contact</p>
		<ul>
			<li><a href="mailto:<?php echo get_settings('admin_email');?>">E-mail</a></li>
		</ul>	

	</div>

    <?php endif; ?>	

</aside>

