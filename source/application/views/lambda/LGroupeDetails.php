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
			var nbLigne = $(this).parent().parent().parent().attr('data');
			var count = 0;
			
			var newSelect = "<select name='groupe["+ nbLigne +"][categorie][]' class='select dyn-selector'>";
			newSelect += "<option value='-1' libelle=' '><?php echo lang('neSaisPas'); ?></option>";
			for(var i=0; i<tabCat.length; i++) {
				if(tabCat[i][1] == id) {
					newSelect += "<option value='" + tabCat[i][0] + "' libelle='" + tabCat[i][2] + "' >" + tabCat[i][2] + "</option>";
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
	<div class="wrap2">
		
		<h1><?php echo lang('titreListeMembres'); ?></h1>
	
	<!--
	<a href="<?php //echo site_url('inscription/changerLangage/fra/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/fra.gif'); ?>" alt="fra" /></a>
	<a href="<?php //echo site_url('inscription/changerLangage/gbr/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/gbr.gif'); ?>" alt="gbr" /></a>
	-->
	
		<div class="box-small">
			
			<form id="inscriptionGroupe" method="post" action="<?php echo site_url('inscription/exeAjouterGroupe'); ?>">
				
				<input type="hidden" name="ref[nom]" value="<?php echo $nom; ?>" />
				<input type="hidden" name="ref[prenom]" value="<?php echo $prenom; ?>" />
				<input type="hidden" name="ref[categorie]" value="<?php echo $categorie; ?>" />
				<input type="hidden" name="ref[fonction]" value="<?php echo $fonction; ?>" />
				<input type="hidden" name="ref[tel]" value="<?php echo $tel; ?>" />
				<input type="hidden" name="ref[mail]" value="<?php echo $mail; ?>" />
				<input type="hidden" name="ref[groupe]" value="<?php echo $groupe; ?>" />
				<input type="hidden" name="ref[pays]" value="<?php echo $pays; ?>" />
				
				<input type="hidden" name="evenement" value="<?php echo $evenement; ?>" />
				
				<span class="info"><h4><?php echo lang('groupe'); ?> :</h4> <?php echo $groupe; ?></span><br>
				<span class="info"><h4><?php echo lang('responsable'); ?> :</h4> <?php echo $nom; ?> <?php echo $prenom; ?></span><br>
	
				<br><br>
				<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
				
				<div id="insererLigne"></div>
				
				<span class="button" id="ajouterLigne">+ <?php echo lang('ajoutNouveauMembre'); ?></span>
				
				<input type="submit" value="<?php echo lang('toutEnvoyer'); ?>" />
				
				<div class="clear"></div>
				
			</form>
			
		</div>
	
	</div>
	
</div>


<div class="hidden" id="pattern">
	<div class="ligne" data="nbLigne" etat="false">
		<h3><?php echo lang('nouveauMembre'); ?> <span class="modifier"><?php echo lang('modifier'); ?></span></h3>
		<div class="form">
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
			<div class="webcam"></div>
			<input type="file" name="photo_file" id="photo_file" />
			<div class="split">
				<label for=""><?php echo lang('nom'); ?>*</label>
				<input type="text" id="ligneNom" name="groupe[nbLigne][nom]" />
			</div>
			<div class="split">
				<label for=""><?php echo lang('prenom'); ?>*</label>
				<input type="text" id="lignePrenom" name="groupe[nbLigne][prenom]" />
			</div>
			
			<div class="split">
				<label for=""><?php echo lang('categorie'); ?></label>
				<select  id="categorie" name="groupe[nbLigne][categorie][]" class="select dyn-selector">
					<option value="-1" libelle=" " ><?php echo lang('neSaisPas'); ?></option>
					<?php foreach($listeSurCategorie as $categorie): ?>
					<option VALUE="<?php echo $categorie->idcategorie; ?>" libelle="<?php echo $categorie->libellecategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="split">
				<label><?php echo lang('fonction'); ?> </label>
				<input type="text" id="ligneFonction" name="groupe[nbLigne][fonction]" />
			</div>
			<div class="clear"></div>
			<div class="split splitRight">
				<a href="#" class="button" id="validerLigne"><?php echo lang('valider'); ?></a>
			</div>
			<div class="split splitRight">
				<a href="#" class="button" id="supprimerLigne"><?php echo lang('supprimer'); ?></a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>