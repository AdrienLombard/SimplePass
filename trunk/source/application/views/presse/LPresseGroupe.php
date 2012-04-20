<script type="text/javascript">

</script>

<div id="content">
	<div class="wrap">
		
	<h1><?php echo lang('demandeAccredPresse'); ?></h1>
	
	<input id="lang" type="hidden" value="<?php echo $lang; ?>" />
	
	<div class="box-small">
		
		<span class="info"><h4><?php echo lang('inscription'); ?></h4> <?php echo lang('groupe'); ?></span><br>
		<span class="info"><h4><?php echo lang('evenement'); ?></h4> <?php echo $infoEvenement[0]->libelleevenement; ?></span><br>
	
		<br><br>
		<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
		<form method="post" action="<?php echo site_url('presse/exeGroupe/' . $idEvenement . '/' . $cate); ?>">
			
			<input type="hidden" name="evenement" value="<?php echo $infoEvenement[0]->idevenement; ?>" />
			
			<h2><?php echo lang('groupe'); ?></h2>
			
			<label><?php echo lang('nomGroupe'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->groupe; ?>" name="groupe" />
			<?php echo form_error('groupe'); ?>
			
			<label><?php echo lang('pays'); ?>*
				<?php foreach($listePays as $p): ?>
					<span id="<?php echo $p->idpays; ?>" class="drapeau" ><?php echo img('drapeaux/' . $p->idpays . '.gif'); ?></span>
				<?php endforeach; ?>
			</label>
			<select  id="pays" name="pays" class="select">
				<?php foreach($listePays as $pays): ?>
	            <option value="<?php echo $pays->idpays; ?>" <?php echo ($pays->idpays == 'FRA')? 'selected' : '' ;?> ><?php echo $pays->nompays; ?></option><?php endforeach; ?> 
			</select>
			
			<br><br>
			<h2><?php echo lang('responsable'); ?></h2>
			
			<label><?php echo lang('nom'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->nom; ?>" name="nom" />
			<?php echo form_error('nom'); ?>
			
			<label><?php echo lang('prenom'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->prenom; ?>" name="prenom" />
			<?php echo form_error('prenom'); ?>
			
			<label><?php echo lang('adresse'); ?>* </label>
			<textarea rows="5" cols="73" name="adresse" ><?php echo set_value('adresse'); ?></textarea>
			<?php echo form_error('adresse'); ?>

		 <div class="tel">
		    <label><?php echo lang('tel'); ?>* : </label>
				<input  type="radio" value="<?php echo FIXE ?>" 		id="tel_fixe" 		name="tel_type" checked /><?php echo lang('telFixe'); ?>
				<input  type="radio" value="<?php echo PORTABLE ?>" 	id="tel_portable" 	name="tel_type" /><?php echo lang('telMobile'); ?>
				<input  type="radio" value="<?php echo DIRECT ?>" 		id="tel_direct" 	name="tel_type" /><?php echo lang('ligneDirecte'); ?>

				<input  type="text" value="<?php echo set_value('tel'); ?>" id="tel" name="tel" />
				<?php echo form_error('tel'); ?>
		 </div>
			<label><?php echo lang('cartePresse'); ?>* : </label>
			<input type="text" name="numr_carte" value="<?php echo set_value('numr_carte');?>"/>
			<?php echo form_error('numr_carte'); ?>

			<label><?php echo lang('mail'); ?>*</label>
			<input type="text" value="<?php echo set_value('mail'); ?>" id="mail" name="mail" />
			<?php echo form_error('mail'); ?>

			<label><?php echo lang('societe'); ?>*</label>
			<input type="text" value="<?php echo set_value('titre'); ?>" id="titre" name="titre" />
			<?php echo form_error('titre'); ?>


			<label><?php echo lang('fonction'); ?>* : </label>
			<select id="fonction" name="fonction" class="select" >
				<option name="<?php echo lang('redacChef'); ?>" value="<?php echo lang('redacChef'); ?>"><?php echo lang('redacChef'); ?></option>
				<option name="<?php echo lang('journaliste'); ?>" value="<?php echo lang('journaliste'); ?>"><?php echo lang('journaliste'); ?></option>
				<option name="<?php echo lang('cameraman'); ?>" value="<?php echo lang('cameraman'); ?>"><?php echo lang('cameraman'); ?></option>
				<option name="<?php echo lang('preneurSon'); ?>" value="<?php echo lang('preneurSon'); ?>"><?php echo lang('preneurSon'); ?></option>
				<option name="<?php echo lang('photographe'); ?>" value="<?php echo lang('photographe'); ?>"><?php echo lang('photographe'); ?></option>
				<option name="<?php echo lang('technicien'); ?>" value="<?php echo lang('technicien'); ?>"><?php echo lang('technicien'); ?></option>
			</select>
			<div>

			<label><?php echo lang('categorie'); ?></label>
			<select  id="categorie" name="categorie[]" class="select dyn-selector">
				<?php foreach($listeCategorie as $cate): ?>
				<option value="<?php echo $cate['db']->idcategorie; ?>" >
					<?php for($i=0; $i<$cate['depth']; $i++) echo '&#160;&#160;'; ?>
					<?php echo $cate['db']->libellecategorie; ?>
				</option>
				<?php endforeach; ?>
			</select>
			</div>
		   
			<div class="sous-categories"></div>				
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
			<input type="file" name="photo_file" id="photo_file" />
			
			<div class="clear"></div>
			<input type="submit" value="<?php echo lang('valider'); ?>"/>
			<div class="clear"></div>
		</form>
		
	</div>
	
	</div>
</div>