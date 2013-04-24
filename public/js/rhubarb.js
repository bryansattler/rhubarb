$('li.movieCardInfo a').click(function() {
	$('.browse').load('details.php .single-movie');
});