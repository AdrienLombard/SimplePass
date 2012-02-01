<div id="content">
	<div class="wrap">
		
	<h1>Demande d'accréditation</h1>
	
	<div class="box-small">
		
		<span class="info">Inscription : Groupe</span><br>
		<span class="info">Evènement : Coupe du monde été 2012</span>
		
		<br><br>
		
		<form method="post" action="<?php echo site_url('inscription/ajouterGroupe'); ?>">
			
			<label>Nom d'équipe</label>
			<input type="text" value="Equipe"/>
			
			<label>Pays</label>
			<input type="text" value="Pays"/>

			<label>Télephone du responsable</label>
			<input type="text" value="+33 612345678"/>

			<label>Mail du responsable</label>
			<input type="text" value="nom.prenom@mail.com"/>
			
			<br>
			
			<input type="submit"/>
			<div class="clear"></div>
			
		</form>
		
	</div>
	
	</div>
</div>