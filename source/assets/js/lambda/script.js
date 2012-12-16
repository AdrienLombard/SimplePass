
function change_link_lambda() {
    var idGroupe = $("select[name='evenement'] option:selected").val();
    var cate = $("#idPresse").val();
    var base = $("#baseURL").val();
	
	if($('#checkPresse').is(':checked')) {
		$('#lienLambda').attr('href', base+'index.php/presse/ajouter/'+idGroupe+'/'+cate);
		$('#lienEquipe').attr('href', base+'index.php/presse/groupe/'+idGroupe+'/'+cate);
	}
	else {
		$('#lienLambda').attr('href', base+'index.php/inscription/ajouter/'+idGroupe);
		$('#lienEquipe').attr('href', base+'index.php/inscription/groupe/'+idGroupe);
	}
	
}


$(document).ready(function(){


    /**
     * Changement dynamique des liens pour le point d'accés web.
     */
	$('#evenement').change(function() {
		change_link_lambda();
	});

    $('#checkPresse').change( function() {
        change_link_lambda();
    });
	
	//$("input[name=fonction]").hide();
	$("input.choixFonction").change(function() {
		$("input[name=fonction]").toggle();
		
	});
	
	/*
	 *	Gestion de l'affichage des drapeaux
	 */
	 
	$('.drapeau').hide();
	 
	var pays = $('#pays').val();
	
	$('#'+pays).toggle();
	
	$('#pays').change(function() {
		$('.drapeau').hide();
		var pays = $('#pays').val();
	
		$('#'+pays).toggle();
		
	});
	
	/*
	 * upload fichier
	 */
	$('#photo_file').css('opacity', 0).css('position', 'absolute');
	$('.uploadFichier').live('click', function(){
		$('#photo_file').trigger('click');
	});

    /*
     * Groupname limit
     */
    $('input[name=groupe]').keyup(function(e){
        var value = $(this).val();
        value = value.replace(/[^a-zA-Z0-9-_ ]/gi, '');
        $(this).val(value);
    });
	
});