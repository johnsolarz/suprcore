<span class="post-category"><?php the_category(', '); ?></span>
<time class="updated" datetime="<?php echo get_the_time('c'); ?>" pubdate><?php echo sprintf(__('%s at %s', 'roots'), get_the_date(), get_the_time()); ?></time>
<span class="byline author vcard"><?php echo __('by', 'roots'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></span>
<?php if (!get_comments_number()==0) : ?>
  <a class="post-comment" href="<?php the_permalink(); ?>#comments" title="<?php the_permalink(); ?>">(<?php comments_number(); ?>)</a>
<?php endif; ?>
