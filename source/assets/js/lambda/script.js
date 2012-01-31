$(function() {
	
	$('#evenement').change(function() {
		var idGroupe = $("select[name='evenement'] option:selected").val();

		$('#lienLambda').attr('href', 'http://localhost/courchevel_src/index.php/accreditationL/ajouter/'+idGroupe);
		
		$('#lienEquipe').attr('href', 'http://localhost/courchevel_src/index.php/accreditationL/ajouterEquipe/'+idGroupe);
	})
	
});