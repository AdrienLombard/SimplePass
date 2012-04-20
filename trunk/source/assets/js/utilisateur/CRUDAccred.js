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
		// if($('#facultatif').find('input').attr('value').length > 0) {
			// $(this).attr('href', $(this).attr('href')+'/'+$('#facultatif').find('input').attr('value'));
		// }
		var facultatif = prompt("Votre texte pour le champ facultatif : ", "");
		if (facultatif != null) {
			$(this).attr('href', $(this).attr('href')+'/'+facultatif);
		}
		
	});
	
	$('#imprimerCarte').click(function() {
		// if($('#facultatif').find('input').attr('value').length > 0) {
			// $(this).attr('href', $(this).attr('href')+'/'+$('#facultatif').find('input').attr('value'));
		// }
		var facultatif = prompt("Votre texte pour le champ facultatif : ", "");
		if (facultatif != null) {
			$(this).attr('href', $(this).attr('href')+'/'+facultatif);
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
	$('.optionPhoto').hide();
	
	$('a.editClient').live('click', function(){
		$('form.infos input, form.infos select').removeAttr('readonly').removeAttr('disabled');
		$("form.infos input[type=submit]").show();
		$('.optionPhoto').show();
	});

	$("select.pays").change(function(){
		$(this).attr('style', 'background: url(http://localhost/courchevel_src/assets/images/drapeaux/' + $(this).val().toLowerCase() + '.gif) no-repeat left;');
	});
	
	
	/*
	 * Ergonomie des checkzones.
	 */
	$('.checkzone').live('click', function(){
		if(!$('.contientZones').hasClass('readonly')) {
			if($(this).hasClass('on')) {
				$(this).removeClass('on').find('input').removeAttr('checked');
				$('#all').removeAttr('checked');
			}
			else {
				$(this).toggleClass('on').find('input').attr('checked', 'checked');
			}
		}	
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
		$('#all').removeAttr('checked');
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
     * Auto check des zone au changement de catégorie pour l'accréditation des groupes
     */
    $('select.categorieSelect').change(function(){
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
		$('.optionPhoto').show();
	});
	
	
	/*
	 * upload fichier
	 */
	$('#photo_file').css('opacity', 0).css('position', 'absolute').css('top', -500);
	$('.uploadFichier').live('click', function(){
		$('#photo_file').trigger('click');
		$('.photoMessage').show().text('Fichier chargé, enregistrez pour valider ->');
	})
	
	
	/*
	 * Crop d'image
	 */
	$('.cropper img').Jcrop({
		onChange:		changeCoords,
		aspectRatio:	160 / 240,
		minSize:		[160, 204],
		setSelect:		[10, 10, 160, 204]
	});
	function changeCoords(c) {
		$('input[name=x]').val(c.x);
		$('input[name=y]').val(c.y);
		$('input[name=w]').val(c.w);
		$('input[name=h]').val(c.h);
	}
	
	$('.visible').show();
	
	//=============================
	
	$("form").bind("submit", function(){
		
		var bool = true;
		
		$(this).find('input.required').each(function(){
			if($(this).val() == "") {
				bool = false;
				$(this).css('backgroundColor', '#F7D2E1').focus();
			}
		});
		
		return bool;
	});
	
	//==============================
	/* filtre des accreditation. */
	
	$("#simple").change(function() {
		if($(this).attr('checked')) {
			if($("#valide").attr('checked'))
				$("tr.simple.valide").show();
			if($("#demande").attr('checked'))
				$("tr.simple.demande").show();
		}
		else {
			$("tr.simple").hide();
		}
	});
	
	$("#groupe").change(function() {
		if($(this).attr('checked')) {
			if($("#valide").attr('checked'))
				$("tr.groupe.valide").show();
			if($("#demande").attr('checked'))
				$("tr.groupe.demande").show();
		}
		else {
			$("tr.groupe").hide();
		}
	});
	
	$("#valide").change(function() {
		if($(this).attr('checked')) {
			if($("#simple").attr('checked'))
				$("tr.valide.simple").show();
			if($("#groupe").attr('checked'))
				$("tr.valide.groupe").show();
		}
		else {
			$("tr.valide").hide();
		}
	});
	
	$("#demande").change(function() {
		if($(this).attr('checked')) {
			if($("#simple").attr('checked'))
				$("tr.demande.simple").show();
			if($("#groupe").attr('checked'))
				$("tr.demande.groupe").show();
		}
		else {
			$("tr.demande").hide();
		}
	});
	
	
	
	
	
	
});
