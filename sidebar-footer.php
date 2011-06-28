<?php

	if ( ! is_active_sidebar( 'footer-widget-1' )
		&& ! is_active_sidebar( 'footer-widget-2' )
		&& ! is_active_sidebar( 'footer-widget-3' )
		&& ! is_active_sidebar( 'footer-widget-4' )
	)
		return;

?>

<aside class="grid_12 alpha omega" role="complementary">

<?php if ( is_active_sidebar( 'footer-widget-1' ) ) : ?>
	<ul class="grid_3 alpha">
		<?php dynamic_sidebar( 'footer-widget-1' ); ?>
	</ul>
<?php endif; ?>

<?php if ( is_active_sidebar( 'footer-widget-2' ) ) : ?>
	<ul class="grid_3">
		<?php dynamic_sidebar( 'footer-widget-2' ); ?>
	</ul>
<?php endif; ?>

<?php if ( is_active_sidebar( 'footer-widget-3' ) ) : ?>
	<ul class="grid_3">
		<?php dynamic_sidebar( 'footer-widget-3' ); ?>
	</ul>
<?php endif; ?>

<?php if ( is_active_sidebar( 'footer-widget-4' ) ) : ?>
	<ul class="grid_3 omega">
		<?php dynamic_sidebar( 'footer-widget-4' ); ?>
	</ul>
<?php endif; ?>

</aside>