<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to suprcore_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage suprcore
 */
?>
  <section id="comments">
  <?php if (post_password_required()) : ?>
    <p><?php _e('This post is password protected. Enter the password to view any comments.', 'suprcore'); ?></p>
  </section>
  <?php
      /* Stop the rest of comments.php from being processed,
       * but don't kill the script entirely -- we still have
       * to fully load the template.
       */
      return;
    endif;
  ?>

  <?php // You can start editing here -- including this comment! ?>

  <?php if (have_comments()) : ?>
    <h1>
      <?php
        printf(_n('One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'suprcore'),
          number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>');
      ?>
    </h1>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
    <nav>
      <h1><?php _e('Comment navigation', 'suprcore'); ?></h1>
      <ul>
        <li><?php previous_comments_link(__('&larr; Older Comments', 'suprcore')); ?></li>
        <li><?php next_comments_link(__('Newer Comments &rarr;', 'suprcore')); ?></li>
      </ul>
    </nav>
    <?php endif; // check for comment navigation ?>

    <ol class="comment-list">
      <?php
        /* Loop through and list the comments. Tell wp_list_comments()
         * to use suprcore_comment() to format the comments.
         * If you want to overload this in a child theme then you can
         * define twentyeleven_comment() and that will be used instead.
         * See twentyeleven_comment() in twentyeleven/functions.php for more.
         */
        wp_list_comments(array('callback' => 'suprcore_comment'));
      ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
    <nav>
      <h1><?php _e('Comment navigation', 'suprcore'); ?></h1>
      <ul>
        <li><?php previous_comments_link(__( '&larr; Older Comments', 'suprcore')); ?></li>
        <li><?php next_comments_link(__('Newer Comments &rarr;', 'suprcore')); ?></li>
      </ul>
    </nav>
    <?php endif; // check for comment navigation ?>

  <?php
    /* If there are no comments and comments are closed, let's leave a little note, shall we?
     * But we don't want the note on pages or post types that do not support comments.
     */
    elseif (! comments_open() && ! is_page() && post_type_supports(get_post_type(), 'comments')) :
  ?>
    <p><?php _e('Comments are closed.', 'suprcore'); ?></p>
  <?php endif; ?>

	<?php if ('open' == $post->comment_status) : ?>

	<div class="clear"></div>

		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
		<?php else : ?>

			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment-form">

			<?php if ( $user_ID ) : ?>
				<div class="grid_7 prefix_1 alpha push">
				<h2>Leave a comment</h2>

					<p class="logged-in">Logged in as <a class="username" href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> <a class="log-out" href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out</a></p>
				</div>

				<div class="grid_1 alpha submit-title">	
					Comment
				</div>

				<div class="grid_7 omega push">
					<textarea name="comment" id="comment" style="width:500px;" cols="28" rows="5" tabindex="4"></textarea>
				</div>

				<div class="clear"></div>

				<p class="submit-button"><input name="submit" type="submit" id="submit" value="Submit" tabindex="5" />

			<?php else : ?>

				<div class="grid_7 prefix_1 alpha push">
					<h2>Leave a comment</h2>
				</div>

				<div class="grid_1 alpha submit-title">
					Name <?php if ($req) echo ""; ?>
				</div>

				<div class="grid_7 omega push">	
					<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
				</div>
				
				<div class="clear"></div>

				<div class="grid_1 alpha submit-title">
					Email <?php if ($req) echo ""; ?>
				</div>

				<div class="grid_7 omega push">	
					<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
				</div>

				<div class="clear"></div>

				<div class="grid_1 alpha submit-title">	
					Website
				</div>

				<div class="grid_7 omega push">	
					<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				</div>

				<div class="clear"></div>
					
				<div class="grid_1 alpha submit-title">	
					Comment
				</div>

				<div class="grid_7 omega push">
					<textarea name="comment" id="comment" style="width:500px;" cols="28" rows="5" tabindex="4"></textarea>
				</div>

				<p class="submit-button"><input name="submit" type="submit" id="submit" value="Submit" tabindex="5" />

			<?php endif; ?>

			<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>

		<?php do_action('comment_form', $post->ID); ?>

		</form>

		<?php endif; ?>

	<?php endif; ?>

  </section>