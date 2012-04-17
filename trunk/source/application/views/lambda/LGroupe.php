<script type="text/javascript">
	
	$(document).ready(function(){
		
		var tabCat = new Array();
		
		<?php $i = 0; ?>
		<?php foreach($listeCategorie as $cat): ?>
			tabCat[<?php echo $i; ?>] = [<?php echo $cat->idcategorie ?>, <?php echo $cat->surcategorie ?>, "<?php echo $cat->libellecategorie ?>"];
			<?php $i++; ?>
		<?php endforeach; ?>

		$("select.dyn-selector").live("change",function(){
			
			var id = $(this).find("option:selected").val();
			var count = 0;
			
			var newSelect = "<select name='categorie[]' class='select dyn-selector'>";
			newSelect += "<option value='-1'><?php echo lang('neSaisPas'); ?></option>";
			for(var i=0; i<tabCat.length; i++) {
				if(tabCat[i][1] == id) {
					newSelect += "<option value='" + tabCat[i][0] + "'>" + tabCat[i][2] + "</option>";
					count++;
				}
			}
			newSelect += "</select>";
			
			$(this).nextAll().remove();
			
			if(count != 0)
				$(newSelect).insertAfter(this);
			
		});

	});
	
</script>

<div id="content">
	<div class="wrap">
		
	<h1><?php echo lang('demandeAccred'); ?></h1>
	
	<input id="lang" type="hidden" value="<?php echo $lang; ?>" />
	
	<div class="box-small">
		
		<span class="info"><h4><?php echo lang('inscription'); ?></h4> <?php echo lang('groupe'); ?></span><br>
		<span class="info"><h4><?php echo lang('evenement'); ?></h4> <?php echo $infoEvenement[0]->libelleevenement; ?></span><br>
	
		<br><br>
		<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
		<form method="post" action="<?php echo site_url('inscription/exeGroupe/' . $idEvenement); ?>">
			
			<input type="hidden" name="evenement" value="<?php echo $infoEvenement[0]->idevenement; ?>" />
			
			<h2><?php echo lang('groupe'); ?></h2>
			
			<label><?php echo lang('nomGroupe'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->groupe; ?>" name="groupe" />
			<?php echo form_error('groupe'); ?>
			
			<label><?php echo lang('pays'); ?>*</label>
			<select  id="pays" name="pays" class="select">
				<?php foreach($listePays as $pays): ?>
	            <option value="<?php echo $pays->idpays; ?>" <?php echo ($pays->idpays == 'FRA')? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($pays->idpays).'.gif'); ?>) no-repeat left;"><?php echo $pays->nompays; ?></option><?php endforeach; ?> 
			</select>
			
			<br><br>
			<h2><?php echo lang('responsable'); ?></h2>
			
			<label><?php echo lang('nom'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->nom; ?>" name="nom" style="text-transform: uppercase"/>
			<?php echo form_error('nom'); ?>
			
			<label><?php echo lang('prenom'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->prenom; ?>" name="prenom" />
			<?php echo form_error('prenom'); ?>
			
			<label><?php echo lang('tel'); ?></label>
			<input type="text" value="<?php if($values) echo $values->tel; ?>" name="tel" />

			<label><?php echo lang('mail'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->mail; ?>" name="mail" />
			<?php echo form_error('mail'); ?>
			
			<div>
			<label><?php echo lang('categorie'); ?></label>
			<select  id="categorie" name="categorie[]" class="select dyn-selector">
				<option value="-1"><?php echo lang('neSaisPas'); ?></option>
				<?php foreach($listeSurCategorie as $categorie): ?>
				<option VALUE="<?php  echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php if($categorie->idcategorie!=1) {echo $categorie->libellecategorie;} ?></option>
				<?php endforeach; ?>
			</select>
			</div>
		
			<div class="sous-categories"></div>	
								
			<label><?php echo lang('demandeAjoutFonction'); ?></label>
			<input type="text" value="<?php echo set_value('fonction'); ?>" id="fonction" name="fonction" />
			
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