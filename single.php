<?php get_header(); ?>

<div id="main" class="eight column">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header>
			<h1 class="post-title"><?php the_title(); ?></h1>
			<span class="post-category"><?php the_category(', '); ?></span>
			<?php if (function_exists('core_entry_meta')) core_entry_meta(); ?>
		</header>

		<?php the_content(); ?>

		<footer class="clearfix">
			<a class="post-comment" href="<?php the_permalink(); ?>#comments" title="<?php the_permalink(); ?>"><?php comments_number('No comments', 'One comment', '% comments'); ?></a> <?php the_tags(__('| ', '') . 'Tags: ', ', ', ''); ?>
			<?php if (function_exists('core_social_sharing')) core_social_sharing(); ?>
		</footer>

	</article>

	<?php endwhile; ?>

	<?php comments_template(); ?>

<?php endif; ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
