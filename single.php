<?php get_header(); ?>

<div id="main" class="eight column">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header>
			<h1 class="post-title"><?php the_title(); ?></h1>
			<time class="updated" datetime="<?php echo get_the_time('c'); ?>" pubdate><?php echo get_the_date(); ?></time>
			<p class="byline author vcard"><?php echo __('By', 'roots'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></p>
		</header>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<footer class="clearfix">
			<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'suprcore'), 'after' => '</p></nav>')); ?>
			<?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags('', ', '); ?></p><?php } ?>
			<?php if (function_exists('core_social_sharing')) core_social_sharing(); ?>
		</footer>
		<?php comments_template(); ?>
	</article>
	<?php endwhile; ?>

	<?php else : ?>
	<div class="page-header">
		<h1><?php _e('Not Found', ''); ?></h1>
	</div>
	<div class="alert alert-block fade in">
	  <a class="close" data-dismiss="alert">&times;</a>
	  <p><?php _e('Sorry, but the page you were trying to view does not exist.', ''); ?></p>
	</div>
	<?php get_search_form(); ?>
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
