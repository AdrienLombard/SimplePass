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
			$('.itemFlowSearch').hide();
			var tab = val.split(' ');
			var request = "";
			for(var i=0; i<tab.length; i++)
			    request += '[username*=' + tab[i] + ']';
			$('.itemFlowSearch' + request).show();
		} else
		    $('.itemFlowSearch').hide();

	});
	
	
	/*
	 * Modifier le formulaire du client en place
	 */
	
	$("form.infos input[type=submit]").hide();
	$("form.infos.nouveau input[type=submit]").show();
	$("form.infos.groupee input[type=submit]").show();
	$('.optionPhoto').hide();
	
	$('a.editClient').live('click', function(){
		$('form.infos input, form.infos select, form.infos textarea').removeAttr('readonly').removeAttr('disabled');
		$("form.infos input[type=submit]").show();
		$('.optionPhoto').show();
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
	$('select[id=categorieSimple]').change(function(){
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
     * Auto check des zones a la coche de la catégorie all accees pour les groupes.
     */
    $('.allGroupe').change( function() {
        var id = $(this).attr('data');
        $('.contientZones[data='+id+'] .checkzone').removeClass('on').find('input').removeAttr('checked');
        if($(this).attr('checked') == 'checked') {
            $('.contientZones[data='+id+'] .checkzone').toggleClass('on').find('input').attr('checked', 'checked');
        }
        else {
            var zones = $('select[data='+id+']').find('option:selected').attr('zone').split('-');
            $.each(zones, function(k, v){
                $('.contientZones[data='+id+'] .checkzone[id='+v+']').toggleClass('on').find('input').attr('checked', 'checked');
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
		$('#editAccredRealTime textarea').removeAttr('readonly');
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

	
	/*
	 *	Gestion de l'affichage des drapeaux
	 */
	 
	$('.drapeau').hide();
	 
	var pays = $('select.pays').val();
	
	$('#'+pays).toggle();
	
	$('select.pays').change(function() {
		$('.drapeau').hide();
	 
		var pays = $('select.pays').val();
	
		$('#'+pays).toggle();
		
	});
	
	
	
	
	
	/*
	 * filtres listes
	 */
	$('.supra-checkbox').live('click', function(){
	    
	    // toggle sur la checkbox
	    $(this).find('input').attr('checked', !$(this).find('input').is(':checked'));
	    
	    // changement de class
	    $(this).toggleClass('checked');
	    
	    // affichage des lignes
	    $('table.liste tbody tr').hide().each(function(){
		
		var data = $(this).attr('data').split(':');
		var access = true;
		
		$.each(data, function(k, v){
		    if(!$('.supra-checkbox[data=' + v + ']').hasClass('checked'))
			access = false;
		});

		if(access)
		    $(this).show();
		else
		    $(this).hide();
		
	    });
	    
	    // actualisation de l'url d'export
	    urlExport();
	    
	});
	
	
	
	
});
