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


<div class="wrap">
	
	<h1><?php echo lang('demandeAccred'); ?></h1>
	<!--
	<a href="<?php //echo site_url('inscription/changerLangage/fra/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/fra.gif'); ?>" alt="fra" /></a>
	<a href="<?php //echo site_url('inscription/changerLangage/gbr/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/gbr.gif'); ?>" alt="gbr" /></a>
	-->
	<div class="box-small">
	
	<span class="info"><h4><?php echo lang('inscription'); ?></h4> <?php echo lang('individuelle'); ?></span><br>
	<span class="info"><h4><?php echo lang('evenement'); ?></h4> <?php echo $event_info[0]->libelleevenement; ?></span><br>
	
	<br><br>
	<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
	<form action="<?php echo site_url('inscription/ajouter/' . $event_id); ?>" method="POST" >
		
		<input type="hidden" id="evenement" name="evenement" value="<?php echo $event_id; ?>" />
		
		<label><?php echo lang('nom'); ?>*</label>
		<input type="text" value="<?php echo set_value('nom'); ?>" id="nom" name="nom" />
		<?php echo form_error('nom'); ?>
		
		<label><?php echo lang('prenom'); ?>*</label>
		<input type="text" value="<?php echo set_value('prenom'); ?>" id="prenom" name="prenom" />
		<?php echo form_error('prenom'); ?>
		
		<label><?php echo lang('pays'); ?>*</label>
		<select  id="pays" name="pays" class="select">
			<?php foreach($listePays as $pays): ?>
            <option value="<?php echo $pays->idpays; ?>" <?php echo ($pays->idpays == 'FRA')? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($pays->idpays).'.gif'); ?>) no-repeat left;"><?php echo $pays->nompays; ?></option><?php endforeach; ?> 
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
			<?php foreach($listeSurCategorie as $categorie): ?>
			<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
			<?php endforeach; ?>
		</select>
		</div>
		
		<div class="sous-categories"></div>	
		
		<label>Qu'elle est votre fonction ?</label>
		
		<label><?php echo lang('demandeAjoutFonction'); ?></label>

		<input type="text" value="<?php echo set_value('fonction'); ?>" id="fonction" name="fonction" />
				
		<div class="photo">
			<fieldset class="encadrePhoto">
				<legend><?php echo lang('photo'); ?></legend>
				<div class="optionPhoto">
					<a href="#" class="uploadFichier"><?php echo lang('fichier'); ?></a>
				</div>
				<div class="optionPhoto">
					<a href="#" class="startWebcam"><?php echo lang('camera'); ?></a>
				</div>
			</fieldset>
		</div>
		<div class="webcam"></div>
		<input type="file" name="photo_file" id="photo_file" />		<div class="clear"></div>
		
		<input type="submit" name="valider" id="valider" value="<?php echo lang('valider'); ?>"/>
		
		<div class="clear"></div>
	</form>

	</div>
	
</div>