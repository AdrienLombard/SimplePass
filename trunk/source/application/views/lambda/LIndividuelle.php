
<?php echo validation_errors(); ?>

<div class="wrap">
	
	<h1>Demande d'accréditation</h1>
	
	<div class="box-small">
	
	<span class="info">Inscription : individuelle</span><br>
	<span class="info">Evènement : Coupe du monde été 2012</span>
	
	<br><br>
	
	<form action="<?php echo site_url('inscription/ajouter'); ?>" method="POST" >
		
		<input type="hidden" id="evenement" name="evenement" value="<?php echo $event; ?>" />
		
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
		<input type="text" value="<?php echo set_value('pays'); ?>" id="pays" name="pays" />
		
		<label>Télephone</label>
		<input type="text" value="<?php echo set_value('tel'); ?>" id="tel" name="tel" />
		
		<label>Mail</label>
		<input type="text" value="<?php echo set_value('mail'); ?>" id="mail" name="mail" />
		
		<label>Societe, Organime ou Publication</label>
		<input type="text" value="<?php echo set_value('titre'); ?>" id="titre" name="titre" />
		
		<label>Rôle</label>
		<input type="text" value="<?php echo set_value('role'); ?>" id="role" name="role" />
		
		<label>Categorie</label>
		<select  id="categorie" name="categorie" class="select">
			<option VALUE="Benevole" <?php echo set_select('categorie', 'Benevole', true); ?> >Bénévole</option>
			<option VALUE="Equipe" <?php echo set_select('categorie', 'Equipe'); ?> >Equipe</option>
			<option VALUE="journaliste" <?php echo set_select('categorie', 'journaliste'); ?> >Journaliste</option>
			<option VALUE="VIP" <?php echo set_select('categorie', 'VIP'); ?> >VIP PACC</option>
		</select>
			
		
		<label>Photo</label>
		<?php echo img('ombre.jpg'); ?>
		
		<div class="clear"></div>
		
		<input type="submit" name="valider" id="valider" />
		
		<div class="clear"></div>
	</form>

	</div>
	
</div>