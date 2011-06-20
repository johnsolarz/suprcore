/* Author: 

*/

// Remove placeholder text on search hover
$('.search').mouseenter(function () {
	if ($(this).val() == 'Search + Enter') $(this).val('');
	$(this).focus();
})
$('.search').mouseleave(function () {
	if ($(this).val() == '') {
		$(this).val('Search + Enter');
		$(this).blur();
	}
}) 





















