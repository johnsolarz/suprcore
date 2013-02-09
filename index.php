<?php get_header(); ?>

<div id="main" class="eight column">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header class="clearfix">
			<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<time class="updated" datetime="<?php echo get_the_time('c'); ?>" pubdate><?php echo get_the_date(); ?></time>
			<p class="byline author vcard"><?php echo __('By', ''); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></p>
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

	<?php if ($wp_query->max_num_pages > 1) : ?>
	  <nav class="post-nav">
	    <ul class="pager">
	      <?php if (get_next_posts_link()) : ?>
	        <li class="previous"><?php next_posts_link(__('&larr; Older posts', '')); ?></li>
	      <?php else: ?>
	        <li class="previous disabled"><a><?php _e('&larr; Older posts', ''); ?></a></li>
	      <?php endif; ?>
	      <?php if (get_previous_posts_link()) : ?>
	        <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', '')); ?></li>
	      <?php else: ?>
	        <li class="next disabled"><a><?php _e('Newer posts &rarr;', ''); ?></a></li>
	      <?php endif; ?>
	    </ul>
	  </nav>
	<?php endif; ?>

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
