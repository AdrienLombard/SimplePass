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
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" class="current" >Groupes</a>
    </div>

    <div class="box-full">
	
		<aside>
			<a href="<?php echo site_url('accreditation/modifierGroupe/' . $info->groupe); ?>">Retour</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeAjoutMembreGroupe'); ?>" enctype="multipart/form-data">
					<input type="hidden" name="evenement" value="<?php echo $this->session->userdata('idEvenementEnCours'); ?>"/>
					<input type="hidden" name="groupe" value="<?php echo $info->groupe; ?>"/>
					<input type="hidden" name="pays" value="<?php echo $info->pays; ?>"/>
					<input type="hidden" name="organisme" value="<?php echo $info->organisme; ?>"/>
					<input type="hidden" name="tel" value="<?php echo $info->tel; ?>"/>
					<input type="hidden" name="mail" value="<?php echo $info->mail; ?>"/>
					<input type="hidden" name="referent" value="<?php echo $info->referent; ?>"/>
					<input type="file" name="photo_file" id="photo_file" accept="image/jpeg" />
					<input type="hidden" name="photo_webcam" id="photo_webcam" />
					
					<h2>Information du membre</h2>
					<div class="photo">
						<div style="float: left">

								<div class="simulPhoto" id="simulPhoto">
						
									<div class="webcamWrapper">
										<a href="#" class="closeCam">x</a>
										<br>
										<div class="webcam"></div>
										<br>
										<a href="#" class="captureCam">Prendre une photo</a>
									</div>

									<div class="photoMessage"></div>

									<img class="input_image_upload" src="" />

								</div>

								<div class="optionPhoto visible">
									<a href="#" class="uploadFichier">FICHIER</a>
									<a href="#" class="startWebcam">WEBCAM</a>
								</div>

						</div>
					</div>
					<div>
						<label>Nom : </label><input type="text" id="nom" class="champ" style="text-transform: uppercase; width:130px;" name="nom" value=""/>
						<label>Prénom : </label><input type="text" id="prenom" class="champ2" style="width:130px;" name="prenom" value=""/>
					</div>
					<div class="ligne">
						<label>Catégorie : </label><select id="categorieSimple" name="categorie" class="champ" style="width:152px">
						<option value="" <?php if(empty($re->accred['categorie'])) echo 'selected'; ?> >---</option>
						<?php foreach($categories as $cate): ?>
							<option
								value="<?php echo $cate['cat']['db']->idcategorie; ?>"
								zone="<?php echo $cate['zones']; ?>"
								<?php if(isset($re->accred['idcategorie']) && $re->accred['idcategorie'] == $cate['cat']['db']->idcategorie) echo 'selected'; ?>
								>
								<?php for($i=0; $i<$cate['cat']['depth']; $i++) echo '&#160;&#160;'; ?>
								<?php echo $cate['cat']['db']->libellecategorie; ?>
							</option>
						<?php endforeach; ?>
						</select>
						<label>Fonction : </label><input type="text" id="fonction" class="champ2" style="width:130px;" name="fonction" value=""/>
					</div>
					<div class="contientZones">
						<label>Zones : </label>
						<div>
							<?php foreach($zonesEvent as $zone): ?>
							<div class="checkzone" id="<?php echo $zone->idzone; ?>">
								<?php echo $zone->codezone; ?>
								<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" />
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="allaccess">
						<label>All-Access : </label>
						<input type="checkbox" id="all" name="allAccess" value="1" <?php if(isset($re->accred['allaccess']) && $re->accred['allaccess'] == 1) echo 'checked'; ?>/>
					</div>
					<input type="submit" class="button" value="Valider" />
				</form>
			</div>
		</div>
        <div class="clear"></div>

    </div>
		
</div>