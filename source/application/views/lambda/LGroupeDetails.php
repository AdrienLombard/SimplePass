<div id="content">
	<div class="wrap2">
		
		<h1>Liste des membres de l'equipe</h1>
	
		<div class="box-small">
			
			<form id="inscriptionGroupe" method="post" action="<?php echo site_url('inscription/exeAjouterGroupe'); ?>">
				
				<input type="hidden" name="ref[nom]" value="<?php echo $nom; ?>" />
				<input type="hidden" name="ref[prenom]" value="<?php echo $prenom; ?>" />
				<input type="hidden" name="ref[categorie]" value="<?php echo $categorie; ?>" />
				<input type="hidden" name="ref[role]" value="<?php echo $role; ?>" />
				<input type="hidden" name="ref[tel]" value="<?php echo $tel; ?>" />
				<input type="hidden" name="ref[mail]" value="<?php echo $mail; ?>" />
				<input type="hidden" name="ref[groupe]" value="<?php echo $groupe; ?>" />
				<input type="hidden" name="ref[pays]" value="<?php echo $pays; ?>" />
				
				<input type="hidden" name="evenement" value="<?php echo $evenement; ?>" />
				
				<div id="insererLigne"></div>
				
				<span class="button" id="ajouterLigne">+ Ajouter un nouveau membre</span>
				
				<input type="submit" value="Tout envoyer" />
				
				<div class="clear"></div>
				
			</form>
			
		</div>
	
	</div>
	
</div>

<div class="hidden" id="pattern">
	<div class="ligne" data="nbLigne" etat="false">
		<h3>Nouveau membre <span class="modifier">modifier</span></h3>
		<div class="form">
			<div class="split">
				<label for="">Nom</label>
				<input type="text" id="ligneNom" name="groupe[nbLigne][nom]" />
			</div>
			<div class="split">
				<label for="">Prénom</label>
				<input type="text" id="lignePrenom" name="groupe[nbLigne][prenom]" />
			</div>
			<div class="clear"></div>
			<div class="split">
				<label for="">Catégorie</label>
				<select  id="ligneCategorie" name="groupe[nbLigne][categorie]" class="select">
				<?php foreach($listeCategorie as $categorie): ?>
					<option VALUE="<?php echo $categorie->libellecategorie; ?>" <?php echo set_select('pays', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
				<?php endforeach; ?>			
				</select>
			</div>
			<div class="split">
				<label for="">Rôle (facultatif)</label>
				<input type="text" id="ligneRole" name="groupe[nbLigne][role]" />
			</div>
			<div class="split splitRight">
				<a href="#" class="button" id="validerLigne">Valider</a>
			</div>
			<div class="split splitRight">
				<a href="#" class="button" id="supprimerLigne">Supprimer</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>