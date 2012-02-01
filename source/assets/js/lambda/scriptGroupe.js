$(document).ready(function(){
	
	// ouvrir le formulaire de la ligne pour la modifier
	$('div.ligne h3').live('click', function(){
		$(this).next('div.form').slideDown('fast');
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
		var categorie = parent.find('#ligneCategorie');
		
		// récupère le rôle
		var role = parent.find('#ligneRole');
		
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

			// met à jours le h3 avec les infos des inputs
			parent.parent().find('h3').html(nom.val() + ' ' + prenom.val() + ' - ' + categorie.val() + ' (' + role.val() + ')' + '<span class="modifier">modifier</span>');
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
		
		var pattern = '<div class="ligne" data="' + nbLigne + '" etat="false">\n\
					<h3>Nouveau membre <span class="modifier">modifier</span></h3>\n\
					<div class="form">\n\
						<div class="split">\n\
							<label for="">Nom</label>\n\
							<input type="text" id="ligneNom" name="groupe[' + nbLigne + '][nom]" />\n\
						</div>\n\
						<div class="split">\n\
							<label for="">Prénom</label>\n\
							<input type="text" id="lignePrenom" name="groupe[' + nbLigne + '][prenom]" />\n\
						</div>\n\
						<div class="clear"></div>\n\
						<div class="split">\n\
							<label for="">Catégorie</label>\n\
							<input type="text" id="ligneCategorie" name="groupe[' + nbLigne + '][categorie]" />\n\
						</div>\n\
						<div class="split">\n\
							<label for="">Rôle (facultatif)</label>\n\
							<input type="text" id="ligneRole" name="groupe[' + nbLigne + '][role]" />\n\
						</div>\n\
						<div class="split splitRight">\n\
							<a href="#" class="button" id="validerLigne">Valider</a>\n\
						</div>\n\
						<div class="split splitRight">\n\
							<a href="#" class="button" id="supprimerLigne">Supprimer</a>\n\
						</div>\n\
						<div class="clear"></div>\n\
					</div>\n\
				</div>';
		
		$('#insererLigne').append(pattern);
		
		nbLigne++;
	})
	
});