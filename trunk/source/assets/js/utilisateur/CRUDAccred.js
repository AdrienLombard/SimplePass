$(document).ready(function(){
	
	$(".editAccred").hide();
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
		
		if(val.length >= 2) {
			var tab = val.split(' ');
			$('.itemFlowSearch').hide();
			for(var i=0; i<tab.length; i++)
				$('.itemFlowSearch[username*='+tab[i]+']').show();
		}

	});
	
	
	/*
	 * Modifier le formulaire du client en place
	 */
	
	$("form.infos input[type=submit]").hide();
	$("form.infos.nouveau input[type=submit]").show();
	
	$('a.editClient').live('click', function(){
		$('form.infos input, form.infos select').removeAttr('readonly').removeAttr('disabled');
		$("form.infos input[type=submit]").show();
	});

	$("select.pays").change(function(){
		$(this).attr('style', 'background: url(http://localhost/courchevel_src/assets/images/drapeaux/' + $(this).val().toLowerCase() + '.gif) no-repeat left;');
	});
	
	
	/*
	 * Ergonomie des checkzones
	 */
	$('.checkzone').live('click', function(){
		if(!$('.contientZones').hasClass('readonly'))
			$(this).toggleClass('on').find('input').attr('checked', 'checked');
	});
	
	/*
	 * Auto check des zone au changement de catégorie
	 */
	$('select[name=categorie]').change(function(){
		var zones = $(this).find('option:selected').attr('zone').split('-');
		$('.checkzone').removeClass('on').find('input').removeAttr('checked');
		$.each(zones, function(k, v){
			$('.checkzone[id='+v+']').toggleClass('on').find('input').attr('checked', 'checked');
		});
	});
	
	
	/*
	 * Modifier le formulaire d'accred en place
	 */
	$('#editAccredRealTime #saveAccred').hide();
	$('.startEditAccred').live('click', function(){
		$('.contientZones').removeClass('readonly');
		$('#editAccredRealTime input[type=text]').removeAttr('readonly');
		$('#editAccredRealTime select').removeAttr('disabled');
		$('#editAccredRealTime #saveAccred').show();
	});
	
});