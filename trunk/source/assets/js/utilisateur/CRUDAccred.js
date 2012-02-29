$(document).ready(function(){
	
	$("form.editAccred").hide();
	$("div.detailZones").hide();
	
	$(".ligneAccred .fixe").live('click', function(){
		$(this).parent().toggleClass('close');
		$(this).next().slideToggle('fast');
	});
	
		
	/*
	 * Recherche de personne dans 'ajouter'
	 */
	$('.flowSearch input').keyup(function(){
		
		var val = $(this).val().toLowerCase();
		$('.itemFlowSearch').hide();
		if(val.length >= 2) 
			$('.itemFlowSearch[username*='+val+']').show();

	});
	
	
	/*
	 * Modifier le formulaire du client en place
	 */
	
	$("form.infos input[type=submit]").hide();
	
	$('a.editClient').live('click', function(){
		$('form.infos input, form.infos select').removeAttr('readonly').removeAttr('disabled');
		$("form.infos input[type=submit]").show();
	});

	$("select.pays").change(function(){
		$(this).attr('style', 'background: url(http://localhost/courchevel_src/assets/images/drapeaux/' + $(this).val().toLowerCase() + '.gif) no-repeat left;');
	});
	
});