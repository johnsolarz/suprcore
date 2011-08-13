<?php 
/**
 * Index template
 */

get_header(); ?> 
 
<div id="main" class="grid_8 alpha">
    
<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="grid_8 alpha omega">

			<div class="grid_2 alpha">
				<span class="post_category"><?php the_category(', ') ?></span>
					<?php echo get_the_date(); ?>
			</div>
			<div class="grid_6 omega comments">
				<span class="post_comment"><a href="<?php the_permalink(); ?>#comments" title="<?php the_permalink(); ?>">Comments (<?php comments_number('0', '1', '%'); ?>)</a></span>
					<?php the_tags(__('', '') . ' ', ', ', '<br />'); ?>
			</div>

			<div class="clear"></div>	

			<h1 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>

		</header>
				
		<div class="entry grid_8 alpha omega">

			<?php the_content(); ?>

		</div>
		
		<footer class="grid_8 alpha omega">

		</footer>

		<div class="clear"></div>

	</article>

	<?php endwhile; ?>

	<?php
	// get total number of pages
	global $wp_query;
	$total = $wp_query->max_num_pages;
	// only bother with the rest if we have more than 1 page!
	if ( $total > 1 ) { 
	?>

	<div class="toolbar grid_8 alpha">

	<?
		// get the current page
		if ( !$current_page = get_query_var('paged') )
			$current_page = 1;
		// structure of format depends on whether we're using pretty permalinks
		$permalink_structure = get_option('permalink_structure');
		$format = empty( $permalink_structure ) ? '&page=%#%' : 'page/%#%/';
		echo paginate_links(array(
			'base' => get_pagenum_link(1) . '%_%',
			'format' => $format,
			'current' => $current_page,
			'total' => $total,
			'mid_size' => 4,
			'type' => 'list',
			'prev_text' => 'previous page',
			'next_text' => 'next page',
		));

	?> 

	</div>

	<?php } ?>

<?php endif; ?>
  
</div> 
 
<?php get_sidebar(); ?>
 
<?php get_footer(); ?> 