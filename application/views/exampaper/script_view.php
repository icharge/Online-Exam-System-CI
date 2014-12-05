function goToByScroll(elem){
	$('html,body').animate({
		scrollTop: $(elem).offset().top},
		300);
}

$('.exampapergroup .panel a[href="#next"]').click(function(e) {
	e.preventDefault();
	var elemparent = $(this).parent().parent().parent().parent().parent();
	var nextpage = elemparent.next().find('a');
	nextpage.trigger('click');
	goToByScroll(elemparent);
});