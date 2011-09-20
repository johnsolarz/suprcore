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

			<ul class="social_links">
			
				<li>
				<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
				<a href="http://twitter.com/share?url=<?php the_permalink(); ?><?php if (your_twitter_username()) { ?>&amp;via=<?php echo your_twitter_username();?><?php } ?>&amp;text=<?php the_title();?>" class="twitter-share-button">Tweet</a>
				</li>
				
				<li>
					<div class="g-plusone"></div>
					<script type="text/javascript">
					  (function() {
					    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					    po.src = 'https://apis.google.com/js/plusone.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
				</li>		
				
				<?php if (use_facebook_like()) { ?>
					<li>
						<div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) {return;}
						  js = d.createElement(s); js.id = id;
					  	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>

						<div class="fb-like" data-href="?php the_permalink(); ?>" data-send="false" data-layout="standard" data-width="400" data-show-faces="false" data-font="arial"></div>
					</li>
				<?php } ?>
	
			</ul>

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