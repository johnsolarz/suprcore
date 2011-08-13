<?php
/**
 * Default page template
 */

get_header(); ?> 
 
<div id="main" class="grid_8 alpha">
    
<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="grid_8 alpha omega">

			<div class="grid_2 alpha">
				<span class="post_category"><?php the_category(', ') ?></span>
					<?php echo get_the_date(); ?>
			</div>
			<div class="grid_6 omega comments">
				<span class="post_comment"><a href="<?php the_permalink(); ?>#comments" title="<?php the_permalink(); ?>">Comments (<?php comments_number('0', '1', '%'); ?>)</a></span>
					<?php the_tags(__('', '') . ' ', ', ', '<br />'); ?>
			</div>

			<div class="clear"></div>	

			<h1 class="post_title"><?php the_title(); ?></h1>

		</header>
				
		<div class="entry grid_8 alpha omega">

			<?php the_content(); ?>

		</div>
		
		<footer class="grid_8 alpha omega">

			<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="<?php the_title();?>" data-count="none" <?php if (your_twitter_username()) { ?>data-via="<?php echo your_twitter_username();?>"<?php } ?>>Tweet</a>
			<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				
			<?php if (use_facebook_like()) { ?>
				<iframe allowTransparency="true" frameborder="0" src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;layout=button_count&amp;show_faces=false&amp;width=375&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=36" style="border:none; overflow:hidden; width:375px; height:36px;"></iframe>
			<?php } ?>
			
		</footer>

		<div class="clear"></div>

	</article>

	<?php endwhile; ?>

	<?php comments_template(); ?>

<?php endif; ?>
  
</div> 
 
<?php get_sidebar(); ?>
 
<?php get_footer(); ?> 