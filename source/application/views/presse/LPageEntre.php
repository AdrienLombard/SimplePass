
<div class="wrap">
	
	<h1><?php echo lang('demandeAccred'); ?></h1>
	
	<a href="<?php echo site_url('inscription/changerLangage/fra/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php echo img_url('drapeaux/fra.gif'); ?>" alt="fra" /></a>
	<a href="<?php echo site_url('inscription/changerLangage/gbr/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php echo img_url('drapeaux/gbr.gif'); ?>" alt="gbr" /></a>
	
	<input id="lang" type="hidden" value="<?php echo $lang; ?>" />
	
	<div class="box-small">
		
		<span class="info"><?php echo lang('bienvenue'); ?></span>
		
		<br><br>

		<input id="baseURL" type="hidden" value="<?php echo $baseUrl; ?>" />
		
		<?php if(!empty($events)): ?>
		
		<label><?php echo lang('evenement'); ?></label>
		<select id="evenement" name="evenement" class="select">
			<?php foreach($events as $event): ?>
				<option value="<?php echo $event->idevenement; ?>"> <?php echo $event->libelleevenement; ?> </option>
			<?php endforeach; ?>
		</select><br>
		
		<br />
		<input type="hidden" id="idPresse" value="<?php echo $idcategorie; ?>" />
		
		<input type="checkbox" id="checkPresse" /><?php echo lang('choixCat'); ?>
		
		<br />
		<div class="center">
			<a id="lienLambda"
			   href="<?php echo site_url('inscription/ajouter/' . $events[0]->idevenement); ?>"
			   class="button"><?php echo lang('demandeIndiv'); ?></a>
			<?php echo lang('ou'); ?>
			<a id="lienEquipe"
			   href="<?php echo site_url('inscription/groupe/' . $events[0]->idevenement); ?>"
			   class="button"><?php echo lang('demandeGroupe'); ?></a>
		</div>
		<?php else: ?>
		<p>Il n'y a actuellement aucun évènement en cours pour lequel vous pouvez vous inscrire</p>
		<?php endif; ?>

	</div>
		


</div>