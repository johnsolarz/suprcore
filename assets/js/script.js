// Remove placeholder text on hover

$('.search').hover(function() {
	if ($(this).val() == 'Search + Enter') $(this).val('');
	$(this).focus();
}, function() {
	if ($(this).val() == '') $(this).val('Search + Enter');
	$(this).blur();
});

