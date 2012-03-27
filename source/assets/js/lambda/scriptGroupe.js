$(document).ready(function(){
	
	// ouvrir le formulaire de la ligne pour la modifier
	$('div.ligne h3').live('click', function(){
		$(this).next('div.form').slideDown('fast');
		$(this).parent().attr('etat', false);
	})
	
	
	// valider la ligne du groupe
	$('#validerLigne').live('click', function(){
		
		// récupère le parent : div.form
		var parent = $(this).parent().parent();
		
		// récupère le nom
		var nom = parent.find('#ligneNom');
		
		// récupère le prenom
		var prenom = parent.find('#lignePrenom');
		
		// récupère la catégorie
		var listeCategorie = parent.find('.dyn-selector');
		alert(listeCategorie);
		
		// récupère le rôle
		var fonction = parent.find('#ligneFonction');
		
		var erreur = false;
		if(nom.val() == '') {
			erreur = true;
			nom.addClass('erreur');
		}
		if(prenom.val() == '') {
			erreur = true;
			prenom.addClass('erreur');
		}
		if(categorie.val() == '') {
			erreur = true;
			categorie.addClass('erreur');
		}
		
		if(!erreur) {
			// enlever la class erreur
			nom.removeClass('erreur');
			prenom.removeClass('erreur');
			categorie.removeClass('erreur');
			
			// ferme le div.form
			parent.slideUp('fast');
			
			// valider l'etat de la ligne
			parent.parent().attr('etat', true);

			// met à jours le h3 avec les infos des inputs
			parent.parent().find('h3').html(nom.val() + ' ' + prenom.val() + ' - ' + categorie.val() + ' (' + fonction.val() + ')' + '<span class="modifier">modifier</span>');
		} else {
			// refuser l'etat de la ligne
			parent.parent().attr('etat', false);
		}
		
	});
	
	// supprimer la ligne
	$('#supprimerLigne').live('click', function(){
		// récupère le parent : div.form
		var parent = $(this).parent().parent().parent().remove();
	})
	
	
	// ajout une ligne
	var nbLigne = 1;
	$('#ajouterLigne').click(function(){
		var pattern = $('#pattern').html().replace(/nbLigne/g, nbLigne);
		$('#insererLigne').append(pattern);
		nbLigne++;
	})
	
	// tout verifer avant de tout valider
	$("#inscriptionGroupe").bind("submit", function(){
		
		var bool = true;
		
		$('#insererLigne .ligne').each(function(){
			if($(this).attr('etat') == 'false')
				bool = false;
		})
		
		if(bool == false)
			alert('Merci de valider chaque membre avant de soumettre votre demande.');
		
		return bool;
	});
	
});