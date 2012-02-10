<div class="wrap">
	
	<h1>Demande d'accréditation</h1>
	
	<div class="box-small">
		
		<span class="info">Bienvenue sur le site de demande d'accréditation</span>
		
		<br><br>
		
		<label>Evenement:</label>
		<select id="evenement" name="evenement" class="select">
			<?php foreach($events as $event): ?>
				<option value="<?php echo $event->idevenement; ?>"> <?php echo $event->libelleevenement; ?> </option>
			<?php endforeach; ?>
		</select><br>

		<br>

		<div class="center">
			<a id="lienLambda" href="<?php echo site_url('inscription/ajouter/1'); ?>" class="button">Demande individuelle</a>
			ou
			<a id="lienEquipe" href="<?php echo site_url('inscription/groupe/1'); ?>" class="button">Demandes groupées</a>
		</div>
		
	</div>
</div>