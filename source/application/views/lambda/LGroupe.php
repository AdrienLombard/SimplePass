<div id="content">
	<div class="wrap">
		
	<h1>Demande d'accréditation</h1>
	
	<div class="box-small">
		
		<span class="info">Evènement : <?php echo $infoEvenement[0]->libelleevenement; ?></span>
		
		<br><br>
		
		<form method="post" action="<?php echo site_url('inscription/exeGroupe/' . $idEvenement); ?>">
			
			<input type="hidden" name="evenement" value="<?php echo $infoEvenement[0]->idevenement; ?>" />
			
			<h2>Groupe</h2>
			
			<label>Nom</label>
			<input type="text" value="<?php if($values) echo $values->groupe; ?>" name="groupe" />
			
			<label>Pays</label>
			<select  id="pays" name="pays" class="select">
				<?php foreach($listePays as $pays): ?>
				<option VALUE="<?php echo $pays->idpays; ?>" <?php if($values && $values->pays==$pays->idpays) echo 'selected="selected"'; ?> >
					<?php echo $pays->nompays; ?>
				</option>
				<?php endforeach; ?>
			</select>
			
			<br><br>
			<h2>Responsable</h2>
			
			<label>Nom</label>
			<input type="text" value="<?php if($values) echo $values->nom; ?>" name="nom" />
			
			<label>Prénom</label>
			<input type="text" value="<?php if($values) echo $values->prenom; ?>" name="prenom" />
			
			<label>Catégorie</label>
			<select  id="categorie" name="categorie" class="select">
				<?php foreach($listeCategorie as $categorie): ?>
				<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php if($values && $values->categorie==$categorie->idcategorie) echo 'selected="selected"'; ?> >
					<?php echo $categorie->libellecategorie; ?>
				</option>
				<?php endforeach; ?>			
			</select>
			
			<label>Rôle</label>
			<input type="text" value="<?php if($values) echo $values->role; ?>" name="role" />

			<label>Télephone</label>
			<input type="text" value="<?php if($values) echo $values->tel; ?>" name="tel" />

			<label>Mail</label>
			<input type="text" value="<?php if($values) echo $values->mail; ?>" name="mail" />
			
			<br>
			
			<input type="submit"/>
			<div class="clear"></div>
			
		</form>
		
	</div>
	
	</div>
</div>