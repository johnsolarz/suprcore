<?php get_header(); ?>

<div id="main" class="eight column">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header>
			<h1 class="post-title"><?php the_title(); ?></h1>
		</header>

		<?php the_content(); ?>

		<footer class="clearfix">
			<?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
		</footer>

	</article>

	<?php endwhile; ?>

<?php endif; ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
