<div class="wrap">
	<h1>Demande d'accréditation</h1>
	<div class="box-small">
		<span class="info">Bienvenu sur le site de demande d'accréditation</span><br>
		<br><br>
		<form>
			<label>Evenement:</label>
			<select id="evenement" name="evenement" class="select">
				<option value="1"> Saut a ski été 2012 </option>
				<option value="2"> Course de Velo Septembre 2012 </option>
			</select><br>
			<label>Type de demande</label>
			<div class="encadrer">
				<a id="lienLambda" href="<?php echo site_url('accreditationL/ajouter/1'); ?>">Individuelle</a> 
				ou par 
				<a id="lienEquipe" href="LEquipe1.html"> équipe</a>
			</div>
		</form>
	</div>
</div>