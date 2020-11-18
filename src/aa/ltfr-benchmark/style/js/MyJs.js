$(document).ready(function() {
	$('input, textarea').placeholder();
	/////////////////////////
	$('.ttip').tooltip({
		html : true
	});
	////////////////////////
	$('input[type="text"]').hover(function() {
		var x = $(this).attr("placeholder");
		$(this).tooltip({
			title : x
		});
		$(this).tooltip('show');

	});
	///////////////////////

});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function callback_login(argument) {
	location.reload();
}

