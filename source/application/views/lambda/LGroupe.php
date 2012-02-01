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
			<input type="text" value="Pays" name="pays" />
			
			<br><br>
			<h2>Responsable</h2>
			
			<label>Nom</label>
			<input type="text" value="+33 612345678" name="nom" />
			
			<label>Prénom</label>
			<input type="text" value="+33 612345678" name="prenom" />
			
			<label>Catégorie</label>
			<input type="text" value="+33 612345678" name="categorie" />
			
			<label>Rôle</label>
			<input type="text" value="+33 612345678" name="role" />

			<label>Télephone</label>
			<input type="text" value="+33 612345678" name="tel" />

			<label>Mail</label>
			<input type="text" value="nom.prenom@mail.com" name="mail" />
			
			<br>
			
			<input type="submit"/>
			<div class="clear"></div>
			
		</form>
		
	</div>
	
	</div>
</div>