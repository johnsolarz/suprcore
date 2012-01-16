<?php
/**
 * Search Results template
 */

get_header(); ?>

<div id="main" class="grid_12" role="main">

	<?php if ( have_posts() ) : ?>
		<p><strong><?php printf( __( 'Search Results for \'%s\'', 'suprcore' ), '<span>' . get_search_query() . '</span>' ); ?></strong></p>

	<?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<?php the_excerpt(); ?>
		</article>

	<?php endwhile; ?>

	<?php else : ?>
		<p><strong><?php _e( 'Nothing Found', 'suprcore' ); ?></strong><br>
		<?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'suprcore' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>

</div>
<script type="text/javascript">
	// focus on search field after it has loaded
	document.getElementById('s') && document.getElementById('s').focus();
</script>

<?php get_footer(); ?>