<?php get_header(); ?>

<div class="twelve column">
	<?php if ( have_posts() ) : ?>
  <?php get_template_part('templates/page', 'header'); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<header class="clearfix">
			<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<?php get_template_part('templates/entry-meta'); ?>
			</header>
    <div class="entry-content">
      <?php the_excerpt(); ?>
    </div>
			<footer>
				<?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags(__('', '') . 'Tags: ', ', ', ''); ?></p><?php } ?>
			</footer>
		</article>
	<?php endwhile; ?>
	<?php get_search_form(); ?>
	<?php else : ?>
  <div class="page-header">
    <h1><?php printf( __( '"%s" retunred no results', 'suprcore' ), get_search_query()); ?></h1>
  </div>
  <div class="alert alert-block fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <p><?php _e('Please try again with some different keywords or <a href="/contact">contact us</a> for more help.', 'roots'); ?></p>
  </div>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
