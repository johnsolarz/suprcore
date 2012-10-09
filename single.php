<?php get_header(); ?>

<div id="main" class="eight column">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header class="clearfix">
			<h1 class="post-title"><?php the_title(); ?></h1>
			<?php get_template_part('templates/entry-meta'); ?>
		</header>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<footer class="clearfix">
			<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'suprcore'), 'after' => '</p></nav>')); ?>
			<?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags('', ', '); ?></p><?php } ?>
			<?php if (function_exists('core_social_sharing')) core_social_sharing(); ?>
		</footer>
		<?php comments_template('/templates/comments.php'); ?>
	</article>
<?php endwhile; endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
