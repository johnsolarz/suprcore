<?php get_header(); ?>

<div id="main" class="eight column">
<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
