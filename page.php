<?php get_header(); ?>

<div id="main" class="eight column">
<?php while (have_posts()) : the_post(); ?>
  <div class="page-header">
    <h1 class="post-title"><?php the_title(); ?></h1>
  </div>
  <?php the_content(); ?>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
