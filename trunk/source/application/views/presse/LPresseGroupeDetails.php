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
		
		<input id="lang" type="hidden" value="<?php echo $lang; ?>" />
		
		<div class="box-small">
			
			<form id="inscriptionGroupe" method="post" action="<?php echo site_url('presse/exeAjouterGroupe'); ?>">
				
				<input type="hidden" name="ref[nom]" value="<?php echo $nom; ?>" />
				<input type="hidden" name="ref[prenom]" value="<?php echo $prenom; ?>" />
				<input type="hidden" name="ref[categorie]" value="<?php echo $categorie; ?>" />
				<input type="hidden" name="ref[fonction]" value="<?php echo $fonction; ?>" />
				<input type="hidden" name="ref[tel]" value="<?php echo $tel; ?>" />
				<input type="hidden" name="ref[mail]" value="<?php echo $mail; ?>" />
				<input type="hidden" name="ref[groupe]" value="<?php echo $groupe; ?>" />
				<input type="hidden" name="ref[pays]" value="<?php echo $pays; ?>" />
				<input type="hidden" name="ref[organisme]" value="<?php echo $organisme; ?>" />

				
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
			
			<!-- gestion du nom -->
			<div class="split">
				<label ><?php echo lang('nom'); ?>*</label>
				<input type="text" id="ligneNom" name="groupe[nbLigne][nom]" />
			</div>
			
			<!-- gestion du prenom -->
			<div class="split">
				<label><?php echo lang('prenom'); ?>*</label>
				<input type="text" id="lignePrenom" name="groupe[nbLigne][prenom]" />
			</div>
			<br>
			
			<!-- gestion du téléphone -->
			<div class="split">
				<label id='ligneTypeTel' ><?php echo lang('tel'); ?>* : 
				<input  type="radio" value="<?php echo FIXE ?>" 		id="tel_fixe" 		name="tel_type" checked /><?php echo lang('telFixe'); ?>
				<input  type="radio" value="<?php echo PORTABLE ?>" 	id="tel_portable" 	name="tel_type" /><?php echo lang('telMobile'); ?>
				<input  type="radio" value="<?php echo DIRECT ?>" 		id="tel_direct" 	name="tel_type" /><?php echo lang('ligneDirecte'); ?>
				</label>
				<input  type="text" id="ligneTel" value="<?php echo set_value('tel_membre'); ?>" id="tel" name="groupe[nbLigne][tel_membre]" />
			</div>
			
			<!-- gestion du numero de carte presse -->
			<div class="split">
				<label><?php echo lang('cartePresse'); ?>* : </label>
				<input type="text" id="ligneNumero" name="groupe[nbLigne][numr_carte_membre]" value="<?php echo set_value('numr_carte_membre');?>"/>
			</div>
			
			<!-- gestion de l'adresse postale -->
			<div class="split"> 
				<label><?php echo lang('adresse'); ?>* </label>
				<textarea rows="5" cols="73" id="ligneAdresse" name="groupe[nbLigne][adresse_membre]" ><?php echo set_value('adresse_membre'); ?></textarea>
			</div>
			
			<!-- gestion du mail -->
			<div class="split">
			<label><?php echo lang('mail'); ?>*</label>
			<input type="text" id="ligneMail" value="<?php echo set_value('mail_membre'); ?>" id="mail" name="groupe[nbLigne][mail_membre]" />
			<?php echo form_error('mail'); ?>
			</div>
			
			<!-- gestion de la catégorie -->
			<div class="split">
				<label ><?php echo lang('categorie'); ?></label>
				<select  id="categorie" name="groupe[nbLigne][categorie][]" class="select dyn-selector">
					<option value="-1" libelle=" " ><?php echo lang('neSaisPas'); ?></option>
					<?php foreach($listeSurCategorie as $categorie): ?>
						<option VALUE="<?php echo $categorie->idcategorie; ?>" 
							libelle="<?php echo $categorie->libellecategorie; ?>" 
							<?php echo set_select('categorie', $categorie->libellecategorie); ?> >
							<?php echo $categorie->libellecategorie; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<!-- gestion de la fonction -->
			<div class="split">
				<label><?php echo lang('fonction'); ?>*</label>
				<select id="ligneFonction" name="groupe[nbLigne][fonction]" class="select" >
					<option value="1" libelle="rédacteur en chef" ><?php echo lang('redacChef'); ?></option> 
					<option value="2" libelle="journaliste" ><?php echo lang('journaliste'); ?></option>
					<option value="3" libelle="caméramen" ><?php echo lang('cameraman'); ?></option>
					<option value="4" libelle="preneur de son" ><?php echo lang('preneurSon'); ?></option>
					<option value="5" libelle="photographe" ><?php echo lang('photographe'); ?></option>
					<option value="6" libelle="technecien" ><?php echo lang('technicien'); ?></option>
				</select>
			</div>
			
			<!-- Boutons de validation du formulaire. -->
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