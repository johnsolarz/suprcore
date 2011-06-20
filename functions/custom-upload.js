jQuery(document).ready(function() {
 
 jQuery('#supr_upload_photo_button').click(function() {
  window.send_to_editor = function(html) {
   imgurl = jQuery('img',html).attr('src');
   jQuery('#supr_photo').val(imgurl);
   tb_remove();
  }
 
  tb_show('', 'media-upload.php?post_id=1&amp;type=image&amp;TB_iframe=true');
  return false;
 });
 
});