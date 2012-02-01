	

$(document).ready(function(){
	
	$('#evenement').change(function() {
		var idGroupe = $("select[name='evenement'] option:selected").val();

		$('#lienLambda').attr('href', 'http://localhost/courchevel_src/index.php/inscription/ajouter/'+idGroupe);
		
		$('#lienEquipe').attr('href', 'http://localhost/courchevel_src/index.php/inscription/groupe/'+idGroupe);
	});
	
	$("input[name=role]").hide();
	$("input.choixRole").change(function() {
		$("input[name=role]").toggle();
		
	});
		
	
});