$(document).ready(function(){
	
	$(".editAccred").hide();
	$("div.detailZones").hide();
	
	$(".ligneAccred .fixe").live('click', function(){
		$(this).parent().toggleClass('close');
		$(this).next().slideToggle('fast');
	});
	
	/*
	 * Popup pour l'impression.
	 */
	$('#imprimer').click(function() {
		if($('#facultatif').find('input').attr('value').length > 0) {
			$(this).attr('href', $(this).attr('href')+'/'+$('#facultatif').find('input').attr('value'));
		}
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
	$("form.infos.groupee input[type=submit]").show();
	
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
	 * Auto check des zones a la coche de la catégorie all accees.
	 */
	$('#all').change( function() {
		$('.checkzone').removeClass('on').find('input').removeAttr('checked');
		if($('#all').attr('checked') == 'checked') {
			$('.checkzone').toggleClass('on').find('input').attr('checked', 'checked');
		}
		else {
			var zones = $('select[name=categorie]').find('option:selected').attr('zone').split('-');
			$.each(zones, function(k, v){
				$('.checkzone[id='+v+']').toggleClass('on').find('input').attr('checked', 'checked');
			});
		}
	});
	
	/*
	 * Auto check des zone au changement de catégorie pour l'accréditation des groupes
	 */
	$('select[id=categorieGroupe]').change(function(){
		var zones = $(this).find('option:selected').attr('zone').split('-');
		var id = $(this).attr('data');
		$('.contientZones[data='+id+'] .checkzone').removeClass('on').find('input').removeAttr('checked');
		$.each(zones, function(k, v){
			$('.contientZones[data='+id+'] .checkzone[id='+v+']').toggleClass('on').find('input').attr('checked', 'checked');
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
		$('#editAccredRealTime input[type=checkbox]').removeAttr('disabled');
	});
	
	
	
	
	
});