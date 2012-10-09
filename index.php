<?php get_header(); ?>

<div id="main" class="eight column">
<?php get_template_part('templates/page', 'header'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header class="clearfix">
			<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<?php get_template_part('templates/entry-meta'); ?>
		</header>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<footer class="clearfix">
			<?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags('', ', '); ?></p><?php } ?>
			<?php if (function_exists('core_social_sharing')) core_social_sharing(); ?>
		</footer>
	</article>
	<?php endwhile; ?>
	<?php if (function_exists('core_page_navigation')) core_page_navigation(); ?>
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
