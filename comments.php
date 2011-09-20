<div id="comments">

	<?php if ( post_password_required() ) : ?>
	<p class="no_password"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'suprcore' ); ?></p>
</div><!-- #comments -->

	<?php return; endif; ?>

<?php // You can start editing here ?>

<?php if ( have_comments() ) : ?>
	<p><strong><?php printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'suprcore' ),
	number_format_i18n( get_comments_number() ), '' . get_the_title() . '' ); ?></strong></p>

	<ul class="comment_list">
		<?php
			/* Loop through and list the comments. Tell wp_list_comments()
			 * to use suprcore_comment() to format the comments.
			 * If you want to overload this in a child theme then you can
			 * define suprcore_comment() and that will be used instead.
			 * See suprcore_comment() in suprcore/functions.php for more.
			 */
			wp_list_comments( array( 'callback' => 'suprcore_comment' ) );
		?>
	</ul>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<div class="navigation grid_8 alpha omega">
		<div class="nav-previous grid_4 alpha"><?php previous_comments_link( __( '&larr; Older Comments', 'suprcore' ) ); ?>&nbsp;</div>
		<div class="nav-next grid_4 omega">&nbsp;<?php next_comments_link( __( 'Newer Comments &rarr;', 'suprcore' ) ); ?></div>
	</div> <!-- .navigation -->
	<?php endif; // check for comment navigation ?>

	<?php else : // or, if we don't have comments:
		/* If there are no comments and comments are closed,
		 * let's leave a little note, shall we?
		 */
		if ( ! comments_open() ) :
	?>

	<p class="no_comments"><?php _e( 'Comments are closed.', 'suprcore' ); ?></p>

	<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>



<?php if ('open' == $post->comment_status) : ?>

<div class="clear"></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment_form">

	<?php if ( $user_ID ) : ?>
	<strong>Leave a comment</strong>

	<div id="logged_in">
		<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> / <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out</a></p>
	</div>

	<div class="grid_2 alpha">	
		Comment
	</div>

	<div class="grid_6 omega push">
		<textarea name="comment" id="comment" rows="5" tabindex="4"></textarea>
	</div>

	<p class="submit_admin"><input name="submit" type="submit" id="submit" value="Submit comment" tabindex="5" />

	<?php else : ?>

	<div class="grid_8 alpha push">
		<strong>Leave a comment</strong>
	</div>

	<div class="grid_2 alpha">
		Name <?php if ($req) echo "(required)"; ?>
	</div>

	<div class="grid_6 omega push">	
		<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
	</div>

	<div class="grid_2 alpha">
		Email <?php if ($req) echo "(required)"; ?>
	</div>

	<div class="grid_6 omega push">	
		<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
	</div>

	<div class="grid_2 alpha">	
		Website
	</div>

	<div class="grid_6 omega push">	
		<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	</div>
	
	<div class="grid_2 alpha">	
		Comment
	</div>

	<div class="grid_6 omega push">
		<textarea name="comment" id="comment" style="width:440px;" cols="28" rows="5" tabindex="4"></textarea>
	</div>

	<p class="submit"><input name="submit" type="submit" id="submit" value="Submit Comment" tabindex="5" />

	<?php endif; ?>

	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>

<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; ?>

<?php endif; ?>

</div><!-- #comments -->