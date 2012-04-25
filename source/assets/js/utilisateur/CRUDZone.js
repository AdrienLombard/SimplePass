$("document").ready( function() {

	/**
	 * Action a faire en 1er lieu.
	 */
	$('.hide').hide();
	
	var newZone = false;
	var updateZone = false;

	
	/**
	 * Ajouter une nouvelle zone.
	 */
	$('.afficheNouvelleZone').live('click', function(){
		if(newZone == false){
			$('.nouvelleZone').show().find('input[type=text]').focus();
			newZone = true;
		}
	});

	/**
	 * Modifier une zone.
	 */
	$('.modifZone').live('click', function(){
		if(updateZone == false) {
			var id = $(this).attr('data');
			$('form[data='+id+']').removeClass('disabled').find('input[type=text]').removeAttr('readonly').addClass('modif').focus();
			$('form[data='+id+']').find('input[type=submit]').show();
			updateZone = true;
		}
	});
	
	
	


});