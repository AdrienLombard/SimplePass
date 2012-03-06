$(function(){
	
	// confirmation de l'action du lien, surtout utilisé pour la confirmation de suppression
	$('a').click(function(){
		
		var confirmation = true;
		
		if($(this).attr('confirm') != '' && $(this).attr('confirm') != null)
			confirmation = confirm($(this).attr('confirm'));

		return confirmation;
		
	});
	
	// gestion des evenements
	// todo
	
});