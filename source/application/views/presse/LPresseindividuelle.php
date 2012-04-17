<script type="text/javascript">
	
	$(document).ready(function(){
		
		var tabCat = new Array();
		
		<?php $i = 0; ?>
		<?php foreach($listeCategorie as $cat): ?>
			tabCat[<?php echo $i; ?>] = [<?php echo $cat->idcategorie ?>, <?php echo $cat->surcategorie ?>, "<?php echo $cat->libellecategorie ?>"];
			<?php $i++; ?>
		<?php endforeach; ?>

		//remplissage de la 1ere box des sous-catégorie de presse au chargement.
		var id = $("#categorie").find("option:selected").val();
		var count = 0;
		var newSelect = "<select name='categorie[]' class='select dyn-selector'>";
		for(var i=0; i<tabCat.length; i++) {
			if(tabCat[i][1] == id) {
				newSelect += "<option value='" + tabCat[i][0] + "'>" + tabCat[i][2] + "</option>";
				count++;
			}
		}
		newSelect += "</select>";
		$("#categorie").nextAll().remove();
		if(count != 0)
			$(newSelect).insertAfter("#categorie");

		$("select.dyn-selector").live("change",function(){
			
			var id = $(this).find("option:selected").val();
			var count = 0;
			
			var newSelect = "<select name='categorie[]' class='select dyn-selector'>";
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
	
	<h1><?php echo lang('demandeAccred'); echo " Presse" ?></h1>
	
	<a href="<?php echo site_url('inscription/changerLangage/fra/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/fra.gif'); ?>" alt="fra" /></a>
	<a href="<?php echo site_url('inscription/changerLangage/gbr/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/gbr.gif'); ?>" alt="gbr" /></a>
	
	<div class="box-small">
	
		<span class="info"><h4><?php echo lang('inscription'); ?></h4> <?php echo lang('individuelle'); ?></span><br>
		<span class="info"><h4><?php echo lang('evenement'); ?></h4> <?php echo $event_info[0]->libelleevenement; ?></span><br>

		<br><br>
		<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
		<form action="<?php echo site_url('presse/ajouter/'.$event_id.'/'.$categorie); ?>" method="POST" enctype="multipart/form-data">

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
				<option value="<?php echo $pays->idpays; ?>" <?php echo ($pays->idpays == 'FRA')? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($pays->idpays).'.gif'); ?>)no-repeat left;"><?php echo $pays->nompays; ?></option><?php endforeach; ?>
			</select>

			 <label> Adresse* </label>
			<textarea rows="5" cols="73" name="adresse" ><?php echo set_value('adresse'); ?></textarea>
			<?php echo form_error('adresse'); ?>

			 <div class="tel">
				<label> Téléphone* : </label>
				<input  type="radio" value="<?php echo FIXE ?>" 		id="tel_fixe" 		name="tel_type" checked />Fixe
				<input  type="radio" value="<?php echo PORTABLE ?>" 	id="tel_portable" 	name="tel_type" />Portable
				<input  type="radio" value="<?php echo DIRECT ?>" 		id="tel_direct" 	name="tel_type" />Ligne directe

				<input  type="text" value="<?php echo set_value('tel'); ?>" id="tel" name="tel" />
			 </div>

			<label> Numero de carte de presse* : </label>
			<input type="text" name="numr_carte" value="<?php echo set_value('numr_carte');?>"/>
			<?php echo form_error('numr_carte'); ?>

			<label><?php echo lang('mail'); ?>*</label>
			<input type="text" value="<?php echo set_value('mail'); ?>" id="mail" name="mail" />
			<?php echo form_error('mail'); ?>

			<label><?php echo lang('societe'); ?>*</label>
			<input type="text" value="<?php echo set_value('titre'); ?>" id="titre" name="titre" />
			<?php echo form_error('titre'); ?>


			<label>Fonction* : </label>
			<select id="fonction" name="fonction" class="select" >
				<option name="op1" value="1">Rédacteur en chef</option>
				<option name="op2" value="2">Journaliste</option>
				<option name="op3" value="3">Caméramen</option>
				<option name="op4" value="4">Preneur de son</option>
				<option name="op5" value="5">Photographe</option>
				<option name="op6" value="6">Technecien</option>
			</select>
			<div>

			<label><?php echo lang('categorie'); ?></label>
			<select  id="categorie" name="categorie[]" class="select dyn-selector">
				<?php foreach($listeSurCategorie as $categorie): ?>
				<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
				<?php endforeach; ?>
			</select>
			</div>
		<!--
			<label>Souhaitez vous une place de parking ? </label>
			<input name ="parcking" type="checkbox" value="Oui"/>Oui
			<input name ="parcking" type="checkbox" value="Non"/>Non


			<label> Souhaitez vous recevoir les informations sur courchevel ? </label>
			<input type="checkbox" name="comp_sportive" value="1"/>Compétitions sportives
			<input type="checkbox" name="sport" value="2"/>Sports
			<input type="checkbox" name="tourisme" value="3"/>Tourisme
			<div   class="sous-categories" ></div>
		-->
			<input type="file" name="photo_file" id="photo_file" />

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

			</div> <!-- fin du bloc de photo -->
			<div class="clear"></div>

		</div> <!-- fin du bloc small-box -->
		<div class="clear"></div>

		
		<input type="submit" name="valider" id="valider" value="<?php echo lang('valider'); ?>"/>
		
		<div class="clear"></div>
	</form>

	</div>
	
</div>