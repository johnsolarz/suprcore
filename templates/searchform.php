<form role="search" method="get" id="searchform" class="form-search clearfix" action="<?php echo home_url('/'); ?>">
  <label class="visuallyhidden" for="s"><?php _e('Search for:', 'roots'); ?></label>
  <input type="text" value="Search + Enter" name="s" id="s" class="search-query" onmouseout="if (this.value == '') {this.value = 'Search + Enter';}" onmouseover="if (this.value == 'Search + Enter') {this.value = '';} this.focus();">
  <input type="submit" id="searchsubmit" value="<?php _e('Search', 'roots'); ?>" class="btn">
</form>


