$(document).ready(function(){
	
	/*
	 * Activation/Désactivation de la colonne en fonction du nombre de case cochée
	 */
	$('input[type=checkbox]').live('click', function(){
		
		var zone = $(this).attr('zone');
		var nb = $('input[type=checkbox][zone='+zone+']:checked').length;
		
		if(nb == 0) {
			$('input[type=text][zone='+zone+'].codeZone').attr('disabled', 'disabled').css('background', '#CCC').val('').fadeTo(0, 0.5);
			$('input[type=checkbox][zone='+zone+']').fadeTo(0, 0.5);
			$('div[zone='+zone+']').css('color', '#CCC');
		} else {
			$('input[zone='+zone+'].codeZone').removeAttr('disabled').css('background', '#FFF').fadeTo(0, 1);
			$('input[type=checkbox][zone='+zone+']').fadeTo(0, 1);
			$('div[zone='+zone+']').css('color', '#000');
		}
		
	});
	
});