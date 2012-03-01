<?php // Index template
get_header(); ?> 
 
<div class="eight column">
    
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="clearfix">
			<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			&mdash;
			<span class="post-category"><?php the_category(', '); ?></span>
			<?php if (function_exists('custom_entry_meta')) custom_entry_meta(); ?>
		</header>

		<?php the_content(); ?>

		<footer class="clearfix">
			<p><a class="post-comment" href="<?php the_permalink(); ?>#comments" title="<?php the_permalink(); ?>"><?php comments_number('No comments', 'One comment', '% comments'); ?></a> <?php the_tags(__('| ', '') . 'Tags: ', ', ', ''); ?></p>
			<?php if (function_exists('custom_social_sharing')) custom_social_sharing(); ?>
		</footer>

	</article>

	<?php endwhile; ?>

	<?php if (function_exists('custom_page_navigation')) custom_page_navigation(); ?>

<?php endif; ?>
  
</div> 
 
<?php get_sidebar(); ?>
<?php get_footer(); ?> 