<?php
/**
 * 404 template
 */

get_header(); ?>
 
<div id="main" class="grid_12 alpha omega">
    
	<h2><?php _e('Just when it was going so well &hellip;', 'suprcore'); ?></h2>
	<p><?php _e('Sorry, but the page you requested could not be found.', 'suprcore'); ?></p>
	<?php get_search_form(); ?>

</div> 
<script type="text/javascript">
	// focus on search field after it has loaded
	document.getElementById('s') && document.getElementById('s').focus();
</script>
	 
<?php get_footer(); ?> 