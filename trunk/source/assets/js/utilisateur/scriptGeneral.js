$(document).ready(function(){
	
	$("select[name=evenements]").hide();
	$("input.choix").change(function() {
		$("select[name=evenements]").toggle();
		
	});
	
});