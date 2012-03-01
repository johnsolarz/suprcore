<?php 

// comments and pingbacks template
if ( ! function_exists( 'custom_comment' ) ) :
function custom_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="pingback">
		<p><span class="pingback-title"><?php _e( 'Pingback', 'suprcore' ); ?></span> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'suprcore' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">


			<?php printf(__('<cite class="comment-author">%s</cite>'), get_comment_author_link()) ?><?php echo get_comment_text(); ?>

			<footer class="comment-meta">
			<div class="vcard">
				<?php
					$avatar_size = 30;
					if ( '0' != $comment->comment_parent )
						$avatar_size = 30;

					echo get_avatar( $comment, $avatar_size, $default='<path_to_url>' );
					
					/* translators: 1: comment author, 2: date and time */
					printf( __( '%1$s', 'suprcore' ),
						sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'suprcore' ), get_comment_date(), get_comment_time() )
						)
					);				
				
				?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'suprcore' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				<?php edit_comment_link( __( 'Edit', 'suprcore' ), '<span class="edit-link">', '</span>' ); ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<span class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'suprcore' ); ?></span>
				<?php endif; ?>
				</div><!-- .vcard -->
			</footer><!-- .comment-meta -->
			
		</article><!-- #comment-## -->
	<!-- </li> is added by wordpress automatically -->
	<?php
			break;
	endswitch;
}
endif; // ends check for custom_comment()

// Modify default WordPress comment form
// http://ottopress.com/2010/wordpress-3-0-theme-tip-the-comment-form/
function custom_form_default_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$fields = array(
		'author' => '<label for="author">' . __( 'Name' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input type="text" id="author" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '" />',
		'email' => '<label for="email">' . __( 'Email' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input type="text" id="email" name="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" />',
		'url' => '<label for="url">' . __( 'Website' ) . '</label><input type="text" id="url" name="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" />',
	);
	return $fields;
}
add_filter( 'comment_form_default_fields', 'custom_form_default_fields' );

function custom_form_defaults ( $defaults ) {
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" aria-required="true"></textarea>',
		//'must_log_in'          => '<p class="must-log-in">...',
		//'logged_in_as'         => '<p class="logged-in-as">...',
		//'comment_notes_before' => '<p class="comment-notes">...',
		'comment_notes_after'  => '',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Add your comment' ),
		'title_reply_to'       => __( 'Leave a reply to %s' ),
		'cancel_reply_link'    => __( 'Cancel' ),
		'label_submit'         => __( 'Post' ),
	);
	return $defaults;
}
add_filter( 'comment_form_defaults', 'custom_form_defaults' );