
<?php //echo validation_errors(); ?>

<div class="wrap">
	
	<h1>Demande d'accréditation</h1>
	
	<div class="box-small">
	
	<span class="info">Inscription : individuelle</span><br>
	<span class="info">Evènement : <?php echo $event_info[0]->libelleevenement; ?></span>
	
	<br><br>
	
	<form action="<?php echo site_url('inscription/ajouter/' . $event_id); ?>" method="POST" >
		
		<input type="hidden" id="evenement" name="evenement" value="<?php echo $event_id; ?>" />
		
		<label>Civilité</label>
		<div class="encadrer" >
			Homme : <input type=radio id="civilite" name="civilite" value="M" <?php echo set_radio('civilite', 'M', TRUE); ?> >
			Femme : <input type=radio id="civilite" name="civilite" value="F" <?php echo set_radio('civilite', 'F'); ?> >
		</div>
		
		<label>Nom</label>
		<input type="text" value="<?php echo set_value('nom'); ?>" id="nom" name="nom" />
		
		<label>Prénom</label>
		<input type="text" value="<?php echo set_value('prenom'); ?>" id="prenom" name="prenom" />
		
		<label>Pays</label>
		<select  id="pays" name="pays" class="select">
			<?php foreach($listePays as $pays): ?>
			<option VALUE="<?php echo $pays->idpays; ?>" <?php echo set_select('pays', $pays->idpays); ?> ><?php echo $pays->nompays; ?></option>
			<?php endforeach; ?>
		</select>
		
		<label>Télephone</label>
		<input type="text" value="<?php echo set_value('tel'); ?>" id="tel" name="tel" />
		
		<label>Mail</label>
		<input type="text" value="<?php echo set_value('mail'); ?>" id="mail" name="mail" />
		
		<label>Societe, Organisme ou Publication</label>
		<input type="text" value="<?php echo set_value('titre'); ?>" id="titre" name="titre" />
		
		<label>Voulez-vous spécifier un rôle ?</label>
		<div class="encadrer" >
		<input type=radio class="choixRole" name="choixRole" value="Non" <?php echo set_radio('choixRole', 'Non', TRUE); ?> >Non
		<input type=radio class="choixRole" name="choixRole" value="Oui" <?php echo set_radio('choixRole', 'Oui'); ?> >Oui
		</div>
		<input type="text" value="<?php echo set_value('role'); ?>" id="role" name="role" />
		
		<label>Categorie</label>
		<select  id="categorie" name="categorie" class="select">
			<?php foreach($listeCategorie as $categorie): ?>
			<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('pays', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
			<?php endforeach; ?>
		</select>
			
		
		<label>Photo</label>
		<?php echo img('ombre.jpg'); ?>
		<br>
		<input type="file" name="fichier">
		
		<div class="clear"></div>
		
		<input type="submit" name="valider" id="valider" />
		
		<div class="clear"></div>
	</form>

	</div>
	
</div>