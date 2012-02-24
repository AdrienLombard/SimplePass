$(document).ready(function(){
	
	$("form.editAccred").hide();
	$("div.detailZones").hide();
	
	$("div.ligneAccred").live('click', function(){
		$(this).toggleClass('close');
		$(this).find("form.editAccred").slideDown('fast');
		$(this).find("div.detailZones").slideDown('fast');
	});
	
	$(".valideInfos").hide();
	
	$("form.infos input[type=text]").blur(function(){
		if($(this).val() != $(this).attr('init'))
			$("form.infos input[type=submit]").show();
	});

	$("select.pays").change(function(){
		$(this).attr('style', 'background: url(http://localhost/courchevel_src/assets/images/drapeaux/' + $(this).val().toLowerCase() + '.gif) no-repeat left; padding-left: 15px;');
		$("form.infos input[type=submit]").show();
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
	
	
});