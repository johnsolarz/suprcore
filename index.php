<?php 
/**
 * Index template
 */

get_header(); ?> 
 
<div id="main" class="grid_8" role="main">
    
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="clearfix">

			<span class="post-category"><?php the_category(', '); ?></span>				
			<?php if (function_exists('suprcore_entry_meta')) suprcore_entry_meta(); ?>
			<a class="post-comment" href="<?php the_permalink(); ?>#comments" title="<?php the_permalink(); ?>">Comments (<?php comments_number('0', '1', '%'); ?>)</a>
			<span class="post-tags"><?php the_tags(__('', '') . 'Tags: ', ', ', '<br />'); ?></span>
			<hr>

			<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

		</header>

		<?php the_content(); ?>

		<footer class="clearfix">

			<ul class="sharing">
			
				<li>
					<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" <?php if (your_twitter_username()) { ?>data-via="<?php echo your_twitter_username(); ?>"<?php } ?> data-text="<?php the_title();?>">Tweet</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>	
				</li>
				
				<?php if (use_google_plus()) { ?>				
				<li class="g-plusone">
					<div class="g-plusone" data-size="medium" annotation="bubble" data-href="<?php the_permalink(); ?>"></div>
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

	<?php if (function_exists('suprcore_page_nav')) suprcore_page_nav(); ?>

<?php endif; ?>
  
</div> 
 
<?php get_sidebar(); ?>
 
<?php get_footer(); ?> 