$(document).ready(function(){
	
	// ouvrir le formulaire de la ligne pour la modifier
	$('div.ligne h3').live('click', function(){
		$(this).next('div.form').slideDown('fast');
		$(this).parent().attr('etat', false);
	});
	
	/**
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
	
	// valider la ligne du groupe
	$('#validerLigne').live('click', function(){
		
		// r�cup�re le parent : div.form
		var parent = $(this).parent().parent();
		
		// Gstion du nom
		var nom = parent.find('#ligneNom');
		
		// Gestion du prenom
		var prenom = parent.find('#lignePrenom');
		
		// Gestion du t�l�phone.
		var tel = parent.find('#ligneTel');
		
		// Gestion du numero de carte de presse.
		var numero = parent.find('#ligneNumero');
		
		// Gestion de l'dresse postale.
		var adresse = parent.find('#ligneAdresse');
		
		// Gestion de la cat�gorie
		var listeCategorie = parent.find('#categorie').find('option:selected');
		var categorie = listeCategorie.text();
		
		// Gestion du mail.
		var mail = parent.find('#ligneMail');
		
		// Gestion de la fonction.
		var fonction = parent.find('#ligneFonction').find('option:selected').attr('libelle');
		
		
		// recherche d'une erreur dans le formulaire.
		// enlever la class erreur
		nom.removeClass('erreur');
		prenom.removeClass('erreur');
		tel.removeClass('erreur');
		numero.removeClass('erreur');
		adresse.removeClass('erreur');
		mail.removeClass('erreur');
		
		var erreur = false;
		var regexMail = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/;
		
		if(nom.val() == '') {
			erreur = true;
			nom.addClass('erreur');
		}
		if(prenom.val() == '') {
			erreur = true;
			prenom.addClass('erreur');
		}
		if(tel.val() == '') {
			erreur = true;
			tel.addClass('erreur');
		}
		if(numero.val() == '') {
			erreur = true;
			numero.addClass('erreur');
		}
		if(adresse.val() == '') {
			erreur = true;
			adresse.addClass('erreur');
		}
		if(mail.val() == '' || regexMail.test(mail.val()) ) {
			erreur = true;
			mail.addClass('erreur');
		}
		
		// R�cuperation de la langue courante
		var lang = $('#lang').val();
		
		// traitement en cas d'erreur sur le formulaire.
		if(!erreur) {
			// enlever la class erreur
			nom.removeClass('erreur');
			prenom.removeClass('erreur');
			tel.removeClass('erreur');
			numero.removeClass('erreur');
			adresse.removeClass('erreur');
			mail.removeClass('erreur');
			
			// ferme le div.form
			parent.slideUp('fast');
			
			// valider l'etat de la ligne
			parent.parent().attr('etat', true);

			// met � jours le h3 avec les infos des inputs
			if(lang == 'fra' || lang == '')
				parent.parent().find('h3').html(nom.val() + ' ' + prenom.val() + ' - ' + categorie + ' (' + fonction + ')' + '<span class="modifier">Modifier</span>');
			else
				parent.parent().find('h3').html(nom.val() + ' ' + prenom.val() + ' - ' + categorie + ' (' + fonction + ')' + '<span class="modifier">Modify</span>');
		} else {
			// refuser l'etat de la ligne
			parent.parent().attr('etat', false);
		}
		
	});
	
	// supprimer la ligne
	$('#supprimerLigne').live('click', function(){
		// r�cup�re le parent : div.form
		var parent = $(this).parent().parent().parent().remove();
	});
	
	
	// ajouter une ligne
	var nbLigne = 1;
	$('#ajouterLigne').click(function(){
		var pattern = $('#pattern').html().replace(/nbLigne/g, nbLigne);
		$('#insererLigne').append(pattern);
		nbLigne++;
	});
	
	// tout verifer avant de tout valider
	$("#inscriptionGroupe").bind("submit", function(){
		
		var bool = true;
		
		$('#insererLigne .ligne').each(function(){
			if($(this).attr('etat') == 'false')
				bool = false;
		});
		
		// R�cuperation de la langue courante
		var lang = $('#lang').val();
		
		if(bool == false) {
			if(lang == 'fra' || lang == '')
				alert('Merci de valider chaque membre avant de soumettre votre demande.');
			else
				alert('Please validate every member before submitting your request.');
		}
		
		return bool;
	});
	
	
	/**
	 * Gestion de la photo : webcam + crop.
	 */
	
	/*
	 * upload fichier
	 */
	$('#photo_file').css('opacity', 0).css('position', 'absolute');
	$('.uploadFichier').live('click', function(){
		$('#photo_file').trigger('click');
	});
	
});