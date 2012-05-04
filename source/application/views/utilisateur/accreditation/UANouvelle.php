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
	    $('.input_image_upload').attr('src', '<?php echo base_url(); ?>assets/images/' + msg);
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

<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Individuelles</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" >Groupes</a>
		<a href="#" class="current">Nouvelle accréditation</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/voir/'.$client->idclient); ?>">Retour</a>
		</aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeNouvelle'); ?>">
				    
					<input type="file" name="photo_file" id="photo_file" accept="image/jpeg" />
					<input type="hidden" name="photo_webcam" id="photo_webcam" />

					<div class="photo">

						<div class="simulPhoto" id="simulPhoto">
						
							<div class="webcamWrapper">
								<a href="#" class="closeCam">x</a>
								<br>
								<div class="webcam"></div>
								<br>
								<a href="#" class="captureCam">Prendre une photo</a>
							</div>

							<div class="photoMessage"></div>

							<?php $url = (img_url('photos/'.$client->idclient.'.jpg') != NULL)? site_url('image/generate/' . $client->idclient) : ''; ?>
							<img class="input_image_upload" src="<?php echo $url; ?>" />

						</div>

						<div class="optionPhoto visible">
							<a href="#" class="uploadFichier">FICHIER</a>
							<a href="#" class="startWebcam">WEBCAM</a>
						</div>

					</div>
					
					<div class="inputs">

						<h2>Personne</h2>
						
						<input type="hidden" name="idClient" value="<?php echo $client->idclient; ?>" />
						
						<div>
							<label>Nom : </label>
							<input type="text" name="nom" class="nom" value="<?php echo $client->nom; ?>" style="text-transform: uppercase" />
						</div>

						<div>
							<label>Prénom : </label>
							<input type="text" name="prenom" class="prenom" value="<?php echo $client->prenom; ?>" />
						</div>

						<div>
							<label>Pays : 
							<?php foreach($pays as $p): ?>
								<span id="<?php echo $p->idpays; ?>" class="drapeau" style="display:none;" ><?php echo img('drapeaux/' . strtolower($p->idpays) . '.gif'); ?></span>
							<?php endforeach; ?>
							</label>
							<select class="pays" name="pays" style="padding-left: 0px;">

							<?php foreach($pays as $p): ?>
								<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ;?> ><?php echo $p->nompays; ?></option>
							<?php endforeach; ?>

							</select>
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="tel" class="tel" value="<?php echo $client->tel; ?>">
						</div>

						<div>
							<label>Mail : </label>
							<input type="text" name="mail" class="email" value="<?php echo $client->mail; ?>">
						</div>
						
						<div>
							<label>Organisme : </label>
							<input type="text" name="organisme" class="societe" init="<?php echo $client->organisme; ?>" value="<?php echo $client->organisme; ?>">
						</div>
						
						<br><br>
						
						<h2>Accréditation</h2>

						<div>
							<label>Fonction : </label>
							<input type="text" name="fonction" />
						</div>

						<div>
							<label>Catégorie : </label>
							<select name="categorie" id="categorieSimple" >
								<option value="-1">---</option>
								<?php foreach($categories as $cate): ?>
							<option
								value="<?php echo $cate['cat']['db']->idcategorie; ?>"
								zone="<?php echo $cate['zones']; ?>"
								<?php if(isset($re->accred['idcategorie']) && $re->accred['idcategorie'] == $cate['cat']['db']['cat']->idcategorie) echo 'selected'; ?>
								>
								<?php for($i=0; $i<$cate['cat']['depth']; $i++) echo '&#160;&#160;'; ?>
								<?php echo $cate['cat']['db']->libellecategorie; ?>
							</option>
						<?php endforeach; ?>
							</select>
						</div>

						<div class="contientZones">
							<label>Zones : </label>
							<div>
								<?php foreach($zones as $zone): ?>
								<div class="checkzone" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->idzone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" />
								</div>
								<?php endforeach; ?>
							</div>
						</div>
						
						<div class="allaccess" >
							<label>All-Access : </label>
							<input type="checkbox" id="all" name="allAccess" value="1" <?php if(isset($re->accred['allaccess']) && $re->accred['allaccess'] == 1) echo 'checked'; ?> />
						</div>

						<div class="clear"></div>
						
					</div>

					<input type="submit" class="button" value="Enregistrer" />

				</form>

			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>