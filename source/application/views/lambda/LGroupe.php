<div id="content">
	<div class="wrap">
		
	<h1>Demande d'accréditation</h1>
	
	<div class="box-small">
		
		<span class="info">Evènement : <?php echo $evenement[0]->libelleevenement; ?></span>
		
		<br><br>
		
		<form method="post" action="<?php echo site_url('inscription/exeGroupe'); ?>">
			
			<input type="hidden" name="evenement" value="<?php echo $evenement[0]->idevenement; ?>" />
			
			<h2>Groupe</h2>
			
			<label>Nom</label>
			<input type="text" value="Nom du groupe" name="groupe" />
			
			<label>Pays</label>
			<select  id="pays" name="pays" class="select">
				<?php foreach($listePays as $pays): ?>
				<option VALUE="<?php echo $pays->idpays; ?>" <?php echo set_select('pays', $pays->idpays); ?> ><?php echo $pays->nompays; ?></option>
				<?php endforeach; ?>
			</select>
			
			<br><br>
			<h2>Responsable</h2>
			
			<label>Nom</label>
			<input type="text" value="nom" name="nom" />
			
			<label>Prénom</label>
			<input type="text" value="prenom" name="prenom" />
			
			<label>Catégorie</label>
			<select  id="categorie" name="categorie" class="select">
				<?php foreach($listeCategorie as $categorie): ?>
				<option VALUE="<?php echo $categorie->libellecategorie; ?>" <?php echo set_select('pays', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
				<?php endforeach; ?>			
			</select>
			
			<label>Rôle</label>
			<input type="text" value="role" name="role" />

			<label>Télephone</label>
			<input type="text" value="0123456789" name="tel" />

			<label>Mail</label>
			<input type="text" value="nom.prenom@mail.com" name="mail" />
			
			<br>
			
			<input type="submit"/>
			<div class="clear"></div>
			
		</form>
		
	</div>
	
	</div>
</div>