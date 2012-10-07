<?php get_header(); ?>

<div id="main" class="eight column">
	<div class="page-header">
	  <h1>
	    <?php
	      if (is_archive()) {
	        $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
	        if ($term) {
	          echo $term->name;
	        } elseif (is_post_type_archive()) {
	          echo get_queried_object()->labels->name;
	        } elseif (is_day()) {
	          printf(__('Daily Archives: %s', 'roots'), get_the_date());
	        } elseif (is_month()) {
	          printf(__('Monthly Archives: %s', 'roots'), get_the_date('F Y'));
	        } elseif (is_year()) {
	          printf(__('Yearly Archives: %s', 'roots'), get_the_date('Y'));
	        } elseif (is_author()) {
	          global $post;
	          $author_id = $post->post_author;
	          printf(__('Author Archives: %s', 'roots'), get_the_author_meta('display_name', $author_id));
	        } else {
	          echo 'Category: '; single_cat_title();
	        }
	      } elseif (is_search()) {
	        printf(__('Search Results for %s', 'roots'), get_search_query());
	      } else {
	        the_title();
	      }
	    ?>
	  </h1>
	</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header>
			<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<span class="post-category"><?php the_category(', '); ?></span>
			<?php get_template_part('templates/entry-meta'); ?>
		</header>
		<?php the_content(); ?>
		<footer class="clearfix">
			<a class="post-comment" href="<?php the_permalink(); ?>#comments" title="<?php the_permalink(); ?>"><?php comments_number('No comments', 'One comment', '% comments'); ?></a>
			<?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags(__('', '') . 'Tags: ', ', ', ''); ?></p><?php } ?>
			<?php if (function_exists('core_social_sharing')) core_social_sharing(); ?>
		</footer>
	</article>
	<?php endwhile; ?>
	<?php if (function_exists('core_page_navigation')) core_page_navigation(); ?>
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
