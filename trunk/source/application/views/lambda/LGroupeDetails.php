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



<!--
<div id="content">
	<div class="wrap2">
		
		<h1>Liste des membres de l'equipe</h1>
	
		<div class="box-small">
			
			<form>
				
				<table>
					<tr><td>Nom</td><td>Prénom</td><td>Rôle</td><td></td><td></td></tr>
					<tr><td>ASSIER</td><td>Aymeric</td><td>on ce demande encore</td><td><input type="submit" value="modifier"/></td><td><input type="submit" value="supprimer"/></td></tr>
					<tr><td>KRATTINGER</td><td>Thibaut</td><td>Scrum Master</td><td><input type="submit" value="modifier"/></td><td><input type="submit" value="supprimer"/></td></tr>
					<tr><td>LOMBARD</td><td>Adrien</td><td>Chinois de COM</td><td><input type="submit" value="modifier"/></td><td><input type="submit" value="supprimer"/></td></tr>
				</table>
				
				<br>
				
				<input type="submit"/>
				<div class="clear"></div>
				
			</form>
			
		</div>
	
	</div>
	
	<br>
	
	<div class="wrap2">
		
		<h1>Ajouter un membre</h1>

		<div class="box-small">
			<form>
				<div class="wrap3">
				<label>Photo</label>
				<img src="images/ombre.jpg"/><br>
				</div>
				<label>Nom</label>
				<input type="text" value="ARNOULD"/><br>
				<label>Prénom</label>
				<input type="text" value="Mickaël"/><br>
				<label>Rôle</label>
				<input type="text" value="Dieu"/><br>
				<br><br>
				<input type="submit" value="ajouter"/>
				<div class="clear"></div>
			</form>
		</div>
	
	</div>
	
</div>

-->