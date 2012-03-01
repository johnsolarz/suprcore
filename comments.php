<?php // Comments template ?>

<section id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="no-password"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'suprcore' ); ?></p>
	</section><!-- #comments -->
<?php
	/* Stop the rest of comments.php from being processed,
	 * but don't kill the script entirely -- we still have
	 * to fully load the template.
	 */
		return;
	endif;
?>

<?php if ( have_comments() ) : ?>
	<h1 id="comments-title">
		<?php
			printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'suprcore' ),
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
		?>
	</h1>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'suprcore' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'suprcore' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'suprcore' ) ); ?></div>
		</nav>
	<?php endif; // check for comment navigation ?>

	<ol class="comment-list">
		<?php
			/* Loop through and list the comments. Tell wp_list_comments()
			 * to use suprcore_comment() to format the comments.
			 * If you want to overload this in a child theme then you can
			 * define suprcore_comment() and that will be used instead.
			 * See suprcore_comment() in suprcore/functions.php for more.
			 */
			wp_list_comments( array( 'callback' => 'custom_comment' ) );
		?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'suprcore' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'suprcore' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'suprcore' ) ); ?></div>
		</nav>
	<?php endif; // check for comment navigation ?>

	<?php elseif ( comments_open() ) : // this is displayed if there are no comments so far ?>
		
		<h1 id="comments-title">No one has anything to say about this.</h1>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'suprcore' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</section><!-- #comments -->
