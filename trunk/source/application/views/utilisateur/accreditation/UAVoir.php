<script language="JavaScript">

    $(document).ready(function(){
        $('#waitOverlay').hide();
    });
    
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

        $('#doAjout').attr('disabled', 'disabled');
        $('#waitOverlay').show();

        var tries = 10;
        var myInterval = setInterval(
            function(){

                console.log('Tentative sur ' + msg + ' : ' + tries);

                $.ajax({
                    url: "<?php echo base_url(); ?>assets/js/jpegcam/exists.php?file=" + msg
                }).success(function(res) {
                        if(res == 1)
                        {
                            var reg = /^photos\/tmp\/[0-9a-zA-Z]{13}[-][0-9]*.jpg$/;
                            if( reg.test( msg ))
                            {
                                $('.input_image_upload').attr('src', '<?php echo base_url(); ?>assets/images/' + msg);
                                $('#photo_webcam').val(msg);
                                $('#doAjout').removeAttr('disabled');
                            }
                            clearInterval(myInterval);
                            $('#waitOverlay').hide();
                        }
                    });

                tries--;
                if(tries == 0)
                {
                    clearInterval(myInterval);
                    $('#waitOverlay').hide();
                    alert('Problème durant le transfert :)');
                }

            }, 1000
        );

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

<div id="waitOverlay">
    <div class="box">
        <span>Transfert en cours</span>
        <?php echo img('wait.gif'); ?>
    </div>
</div>

<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Individuelles</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" >Groupes</a>
		<a href="#" class="current">Personne</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/index/'); ?>">Retour</a>
			<br>
            <a href="#" class="editClient">Modifier la personne</a>
			<a href="<?php echo site_url('accreditation/nouvelle/'.$client->idclient); ?>">Nouvelle accréditation</a>

        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client">
				
				<form class="infos" method="post" action="<?php echo site_url('accreditation/exeModifierClient'); ?>" enctype="multipart/form-data">
					
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
					
					<div class="clear"></div>
					
					<div class="optionPhoto">
						<a href="#" class="uploadFichier">FICHIER</a>
						<a href="#" class="startWebcam">WEBCAM</a>
					</div>
										
				</div>
					
					<input type="hidden" name="id" value="<?php echo $client->idclient; ?>" />
					
					<div>
						<input type="text" name="nom" style="text-transform: uppercase" class="nom" init="<?php echo $client->nom; ?>" value="<?php echo $client->nom; ?>" readonly>
					</div>
					
					<div>
						<input type="text" name="prenom" class="prenom" init="<?php echo $client->prenom; ?>" value="<?php echo $client->prenom; ?>" readonly>
					</div>
					
					<br>

					<div>
						<label class="short">Pays : 
							<?php foreach($pays as $p): ?>
								<span id="<?php echo $p->idpays; ?>" class="drapeau" style="display:none;" ><?php echo img('drapeaux/' . strtolower($p->idpays) . '.gif'); ?></span>
							<?php endforeach; ?>
						</label>
						<select class="pays" name="pays" init="<?php echo $client->pays; ?>" style="padding-left: 0px;" disabled="disabled">
						
						<?php foreach($pays as $p): ?>
							<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ?>><?php echo $p->nompays; ?></option>
						<?php endforeach; ?>

						</select>
					</div>
					
					<div>
						<label class="short">Tel : </label>
						<?php echo '+'.$indicatif; ?><input type="text" name="tel" class="tel" init="<?php echo $client->tel; ?>" value="<?php echo $client->tel; ?>" readonly>
					</div>
					
					<div>
						<label class="short">Mail : </label>
						<input type="text" name="mail" class="email" init="<?php echo $client->mail; ?>" value="<?php echo $client->mail; ?>" readonly>
					</div>
					
					<div>
						<label class="shortOrganisme">Organisme :</label>
						<input type="text" name="organisme" class="societe" init="<?php echo $client->organisme; ?>" value="<?php echo $client->organisme; ?>" readonly>
					</div>
					
					<!-- champ pour l'adresse du client -->
					<?php if(isset($client->adresse) && !empty($client->adresse)): ?>
					<br/>
					<div>
						<label class="shortAdresse">Adresse : </label>
						<textarea readonly name="adresse" cols="45" rows="3" class="adresse" ><?php if(isset($client->adresse)) echo $client->adresse; ?></textarea>
					</div>
					<?php endif; ?>
				
					<input type="submit" class="valideInfos" value="Enregistrer les modifications" />
				</form>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="listeAccred">
				
				<h3>Accréditation en cours</h3>
				
				<?php if(count($accredAttente)==0) echo '<br/>Aucune demande en cours.' ?>
				
				<?php foreach($accredAttente as $demande): ?>
				
				<div class="ligneAccred close">
					
					<a href="<?php echo site_url('accreditation/modifier/'.$demande['accred']->idaccreditation); ?>">
						<div class="fixe">
							<span class="date"><?php echo display_date($demande['accred']->dateaccreditation); ?></span>
							<span class="categorie">- <?php echo $demande['accred']->libellecategorie; ?></span>
							<span class="evenement">- <?php echo $demande['accred']->libelleevenement; ?></span>
							<span class="etat">- <?php if($demande['accred']->etataccreditation == 0) echo 'Val';
														else echo 'Dem'?></span>
						</div>
					</a>
					
				</div>
				
				<?php endforeach; ?>
				
				
				<h3>Historique des accréditations</h3>
				
				<?php if(count($accredValide)==0) echo '<br/>Aucune accréditation.' ?>
				
				<?php foreach($accredValide as $accred): ?>
					<div class="ligneAccred close">
						
						<div class="fixe">
							<span class="date"><?php echo display_date($accred['accred']->dateaccreditation); ?></span>
							<span class="categorie"><?php echo $accred['accred']->libellecategorie; ?></span>
							<span class="evenement"><?php echo $accred['accred']->libelleevenement; ?></span>
						</div>
						
						<div class="detailZones">
							Zones :
							
							<?php foreach($accred['zones'] as $z): ?>
								<?php echo $z->codezone; ?> 
							<?php endforeach; ?>
							
						</div>
					</div>
				<?php endforeach; ?>
				
			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>