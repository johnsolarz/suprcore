<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	$oddcomment = 'class="alt" ';
?>


<?php if ($comments) : ?>

<div id="comments" class="grid_8 alpha comment-container">
	
	<?php foreach ($comments as $comment) : ?>
	<?php $comment_type = get_comment_type(); ?>
	<?php if($comment_type == 'comment') { ?>
    
    <div id="comment-<?php comment_ID(); ?>">
		<div class="grid_2 alpha avatar push"><?php echo get_avatar($comment, 30); ?></div>
		<div class="grid_6 omega push"><div class="comment_meta"><?php comment_author_link() ?> on <?php comment_date('m/d/y') ?></div>
		<?php if ($comment->comment_approved == '0') : ?>
			<em>Your comment is awaiting moderation.</em>
		<?php endif; ?>
		<?php comment_text() ?>
	</div>
		<div class="clear"></div>
	</div>
	
	<?php
		/* Changes every other comment to a different class */
		$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
	?>
	
	<?php } else { $trackback = true; } /* End of is_comment statement */ ?>
	
	<?php endforeach; /* end for each comment */ ?>

 	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
	<div class="grid_8 alpha comment-container">
		<div class="no_comment"><p>No comments yet, be the first!</p>
	</div>
		

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
	<div class="grid_8 alpha comment-container">
		<p class="nocomments">Comments are closed.</p>
	</div>

	<?php endif; ?>
<?php endif; ?>


	<?php if ($trackback == true) { ?>
	<div class="">
	<h6>Trackbacks</h6>
	<ul>
		<?php foreach ($comments as $comment) : ?>
		<?php $comment_type = get_comment_type(); ?>
		<?php if($comment_type != 'comment') { ?>
		<li><?php comment_author_link() ?></li>
		<?php } ?>
		<?php endforeach; ?>
	</ul>
	</div>
	<?php } ?>


<?php if ('open' == $post->comment_status) : ?>

<div class="clear"></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>
<strong>Leave a comment</strong>

<div id="logged_in">
	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>
</div>

<div class="grid_2 alpha">	
	Comment
</div>


<div class="grid_6 omega push">

	<textarea name="comment" id="comment" rows="5" tabindex="4"></textarea>

</div>

<p class="submit_admin"><input name="submit" type="submit" id="submit" value="Submit comment" tabindex="5" />

<?php else : ?>

<div class="grid_8 alpha push comment-container">
	<strong>Leave a comment</strong>
</div>

<div class="grid_2 alpha">
	Name <?php if ($req) echo "(required)"; ?>
</div>

<div class="grid_6 omega push">	
	<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
</div>


<div class="grid_2 alpha">
	Mail <?php if ($req) echo "(required)"; ?>
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

<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

</div>

<?php endif; ?>

<?php endif; ?>
