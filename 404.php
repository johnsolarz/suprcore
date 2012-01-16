<?php
/**
 * 404 template
 */

get_header(); ?>
 
<div id="main" class="grid_12" role="main">
    
	<p><strong><?php _e('Just when it was going so well &hellip;', 'suprcore'); ?></strong><br>
	<?php _e('Sorry, but the page you requested could not be found.', 'suprcore'); ?></p>
	<?php get_search_form(); ?>

</div> 
<script type="text/javascript">
	// focus on search field after it has loaded
	document.getElementById('s') && document.getElementById('s').focus();
</script>
	 
<?php get_footer(); ?> 