<script type="text/javascript">
</script>


<div class="wrap">
	
	<h1><?php echo lang('demandeAccred'); ?></h1>
	
	<input id="lang" type="hidden" value="<?php echo $lang; ?>" />
	
	<div class="box-small">
	
	<span class="info"><h4><?php echo lang('inscription'); ?></h4> <?php echo lang('individuelle'); ?></span><br>
	<span class="info"><h4><?php echo lang('evenement'); ?></h4> <?php echo $event_info[0]->libelleevenement; ?></span><br>
	
	<br><br>
	<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
	<form action="<?php echo site_url('inscription/ajouter/' . $event_id); ?>" method="POST" enctype="multipart/form-data">
		
		<input type="hidden" id="evenement" name="evenement" value="<?php echo $event_id; ?>" />
		
		<label><?php echo lang('nom'); ?>*</label>
		<input type="text" value="<?php echo set_value('nom'); ?>" id="nom" name="nom" style="text-transform: uppercase"/>
		<?php echo form_error('nom'); ?>
		
		<label><?php echo lang('prenom'); ?>*</label>
		<input type="text" value="<?php echo set_value('prenom'); ?>" id="prenom" name="prenom" />
		<?php echo form_error('prenom'); ?>
		
		<label><?php echo lang('pays'); ?>*
			<?php foreach($listePays as $p): ?>
				<span id="<?php echo $p->idpays; ?>" class="drapeau" ><?php echo img('drapeaux/' . $p->idpays . '.gif'); ?></span>
			<?php endforeach; ?>
			<?php echo '::'.img('drapeaux/' . $listePays[0]->idpays . '.gif').'::'; ?>
		</label>
		<select  id="pays" name="pays" class="select">
			<?php foreach($listePays as $pays): ?>
            <option value="<?php echo $pays->idpays; ?>" <?php echo ($pays->idpays == 'FRA')? 'selected' : '' ;?> ><?php echo $pays->nompays; ?></option><?php endforeach; ?> 
		</select>
		
		<label><?php echo lang('tel'); ?></label>
		
		<input type="text" value="<?php echo set_value('tel'); ?>" id="tel" name="tel" />
		
		<label><?php echo lang('mail'); ?>*</label>
		<input type="text" value="<?php echo set_value('mail'); ?>" id="mail" name="mail" />
		<?php echo form_error('mail'); ?>
		
		<label><?php echo lang('societe'); ?></label>
		<input type="text" value="<?php echo set_value('titre'); ?>" id="titre" name="titre" />
		
		<div>
		<label><?php echo lang('categorie'); ?></label>
		<select  id="categorie" name="categorie[]" class="select dyn-selector">
			<option value="-1"><?php echo lang('neSaisPas'); ?></option>
			<?php foreach($listeCategorie as $cate): ?>
			<option value="<?php echo $cate['db']->idcategorie; ?>" >
				<?php for($i=0; $i<$cate['depth']; $i++) echo '&#160;&#160;'; ?>
				<?php echo $cate['db']->libellecategorie; ?>
			</option>
			<?php endforeach; ?>
		</select>
		</div>
		
		<div class="sous-categories"></div>	
		
		<label><?php echo lang('demandeAjoutFonction'); ?></label>

		<input type="text" value="<?php echo set_value('fonction'); ?>" id="fonction" name="fonction" />
				
		<input type="file" name="photo_file" id="photo_file" />
		<input type="hidden" name="photo_webcam" id="photo_webcam" />
		
		<div class="photo">
			
			<canvas id="canvas" width="160" height="204" style="display:none;"></canvas>
			
			<div class="webcamWrapper">
				<a href="#" class="closeCam">x</a>
				<span style="color:black"><?php echo lang('centreWebcam').' :'; ?></span>
				<div class="webcam"></div>
				<a href="#" class="captureCam"><?php echo lang('prendrePhoto'); ?></a>
			</div>
			
			<fieldset class="encadrePhoto">
				<legend><?php echo lang('photo'); ?></legend>
				<div class="optionPhoto">
					<span class="uploadFichier"><?php echo lang('fichier'); ?></span>
				</div>
				<div class="optionPhoto">
					<span class="startWebcam"><?php echo lang('camera'); ?></span>
				</div>
			</fieldset>

		</div>

		<div class="clear"></div>
		<input type="submit" name="valider" id="valider" value="<?php echo lang('valider'); ?>"/>
		<div class="clear"></div>
		</div>	
		
		<div class="clear"></div>
	</form>

	</div>
	
</div>