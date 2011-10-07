<?php 
/**
 * Single post template
 */
 
get_header(); ?> 
 
<div id="main" class="grid_8 alpha">
    
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="clearfix">

			<div class="grid_2 alpha">
				<span class="post-category"><?php the_category(', '); ?></span>
				<?php echo get_the_date(); ?>
			</div>
			<div class="grid_6 omega comments">
				<span class="post-comment"><a href="<?php the_permalink(); ?>#comments" title="<?php the_permalink(); ?>">Comments (<?php comments_number('0', '1', '%'); ?>)</a></span>
					<?php the_tags(__('', '') . ' ', ', ', '<br />'); ?>
			</div>

			<div class="clear"></div>	

			<h1><?php the_title(); ?></h1>

		</header>

		<?php the_content(); ?>
		
		<footer class="clearfix">

			<ul class="social-links">
			
				<li>
					<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" <?php if (your_twitter_username()) { ?>data-via="<?php echo your_twitter_username(); ?>"<?php } ?> data-text="<?php the_title();?>">Tweet</a>		
				</li>
				
				<?php if (use_google_plus()) { ?>				
				<li class="g-plusone">
					<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
				</li>		
				<?php } ?>	
				
				<?php if (use_facebook_like()) { ?>
					<li>
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="400" data-show-faces="false" data-colorscheme="light" data-font="arial"></div>
					</li>
				<?php } ?>

			</ul>

		</footer>

	</article>

	<?php endwhile; ?>

	<?php comments_template(); ?>

<?php endif; ?>
  
</div> 
 
<?php get_sidebar(); ?>
 
<?php get_footer(); ?> 