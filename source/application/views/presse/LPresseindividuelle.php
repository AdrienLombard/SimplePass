<script language="JavaScript">
    
	<?php $key = uniqid() . '-' . rand() * 10; ?>
	webcam.set_api_url( '<?php echo base_url(); ?>/assets/js/jpegcam/test.php?key=<?php echo $key; ?>');
	webcam.set_key('<?php echo $key; ?>');
	webcam.set_swf_url( '<?php echo base_url(); ?>/assets/js/jpegcam/webcam.swf' );
	webcam.set_stealth( true ); // enable stealth mode
	
	webcam.set_hook( 'onComplete', 'my_completion_handler' );

	function take_snapshot() {
	    webcam.snap();
	}

	function my_completion_handler(msg) {
	    $('#photo_webcam').val(msg);
	}
	
	$(document).ready(function(){
	
	    $('.webcam').html(webcam.get_html(272, 362));
	
	    $('.startWebcam').click(function(){
		$('.webcamWrapper').show();
	    });
	    
	    $('.captureCam').click(function(){
		take_snapshot();
		$('.webcamWrapper').hide();
	    });
	    
	    $('.closeCam').click(function(){
		$('.webcamWrapper').hide();
	    });
	    
	});

</script>


<div class="wrap">
	
	<h1><?php echo lang('demandeAccredPresse'); ?></h1>
	
	
	<div class="box-small">
	
		<span class="info"><h4><?php echo lang('inscription'); ?></h4> <?php echo lang('individuelle'); ?></span><br>
		<span class="info"><h4><?php echo lang('evenement'); ?></h4> <?php echo $event_info[0]->libelleevenement; ?></span><br>

		<br><br>
		<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
		<form action="<?php echo site_url('presse/ajouter/'.$event_id.'/'.$categorie); ?>" method="POST" enctype="multipart/form-data">

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
			</label>
			<select  id="pays" name="pays" class="select">
				<?php foreach($listePays as $pays): ?>
				<option value="<?php echo $pays->idpays; ?>" <?php echo ($pays->idpays == 'FRA')? 'selected' : '' ;?> ><?php echo $pays->nompays; ?></option><?php endforeach; ?>
			</select>

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
			<input type="hidden" name="photo_webcam" id="photo_webcam" />

			<div class="photo">

			    <div class="webcamWrapper">
				<a href="#" class="closeCam">x</a>
				<br>
				<div class="webcam"></div>
				<br>
				<a href="#" class="captureCam">Prendre une photo</a>
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
		</div> <!-- fin du bloc small-box -->
		
		<div class="clear"></div>
	</form>

	</div>
	