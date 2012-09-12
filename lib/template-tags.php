<?php

// Return post entry meta information
function core_entry_meta() {
  echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('%s', 'suprcore'), get_the_date()) .'</time>';
  echo '<span class="byline author vcard">'. __(' by', 'suprcore') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a></span>';
}

// Display navigation to next/previous pages when applicable
// http://dimox.net/wordpress-pagination-without-a-plugin-wp-pagenavi-alternative/
function core_page_navigation() {
  global $wp_query, $wp_rewrite;
  $pages = '';
  $max = $wp_query->max_num_pages;
  if (!$current = get_query_var('paged')) $current = 1;
  $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
  $a['total'] = $max;
  $a['current'] = $current;

  $total = 1; //1 - display the text "Page N of N", 0 - not display
  $a['mid_size'] = 2; //how many links to show on the left and right of the current
  $a['end_size'] = 1; //how many links to show in the beginning and end
  $a['prev_text'] = '&laquo; Previous'; //text of the "Previous page" link
  $a['next_text'] = 'Next &raquo;'; //text of the "Next page" link

  if ($max > 1) echo '<nav class="pagination">';
  if ($total == 1 && $max > 1) $pages = '<span class="page-current">Page ' . $current . ' of ' . $max . '</span>'."\r\n";
  echo $pages . paginate_links($a);
  if ($max > 1) echo '</nav>';
}
