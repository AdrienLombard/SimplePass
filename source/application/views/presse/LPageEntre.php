
<div class="wrap">
	
	<h1><?php echo lang('demandeAccred'); echo " Presse"; ?></h1>
	
	<a href="<?php echo site_url('inscription/changerLangage/fra/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/fra.gif'); ?>" alt="fra" /></a>
	<a href="<?php echo site_url('inscription/changerLangage/gbr/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/gbr.gif'); ?>" alt="gbr" /></a>
	
	<div class="box-small">
		
		<span class="info"><?php echo lang('bienvenue'); ?></span>
		
		<br><br>
		
		<label><?php echo lang('evenement'); ?></label>
		<select id="evenement" name="evenement" class="select">
			<?php foreach($events as $event): ?>
				<option value="<?php echo $event->idevenement; ?>"> <?php echo $event->libelleevenement; ?> </option>
			<?php endforeach; ?>
		</select><br>
       
  
		    
		<label> Choisissez votre catégorie</label>
		<select  id="categorie"  name="categorie" class="select dyn-selector" >
			<option value="0"> Autre </option>
			<option value="<?php echo $idcategorie; ?>">Presse</option>
		</select>

		<div class="center">
			<a id="lienLambda"
			   href="<?php echo site_url('inscription/ajouter/' . $events[0]->idevenement); ?>"
			   class="button"><?php echo lang('demandeIndiv'); ?></a>
			<?php echo lang('ou'); ?>
			<a id="lienEquipe"
			   href="<?php echo site_url('inscription/groupe/' . $events[0]->idevenement); ?>"
			   class="button"><?php echo lang('demandeGroupe'); ?></a>
		</div>

	</div>
		


</div>