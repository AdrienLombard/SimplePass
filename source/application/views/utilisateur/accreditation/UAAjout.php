<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" class="current" >Ajouter personne</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>">Ajouter groupe</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/index'); ?>">Retour</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeAjouter'); ?>">
					
					<input type="hidden" name="evenement" value="<?php echo $this->session->userdata('idEvenementEnCours'); ?>"/>

					<input type="file" name="photo_file" id="photo_file" />
				<input type="hidden" name="photo_webcam" id="photo_webcam" />
				
				<div class="photo">
					
					<div style="float: left">

						<div class="simulPhoto">

							<div class="webcamWrapper">
								<a href="#" class="closeCam">x</a>
								<span>Placer votre visage au centre de l'image :</span>
								<div class="webcam"></div>
								<a href="#" class="captureCam">Prendre une photo</a>
							</div>

							<canvas id="canvas" width="160" height="204"></canvas> 

							<div class="photoMessage"></div>

						</div>
						
						<div class="optionPhoto visible">
							<a href="#" class="uploadFichier">FICHIER</a>
							<a href="#" class="startWebcam">WEBCAM</a>
						</div>
						
					</div>
						

					<div class="inputs">

						<h2>Personne</h2>
						
						<div>
							<label>Nom : </label>
							<input type="text" 
								name="nom" 
								class="nom" 
								value="<?php if(isset($re->client['nom'])) echo $re->client['nom']; else echo $nom; ?>" 
								style="text-transform: uppercase" 
							/>
							<?php if(isset($re->erreurNom)) echo '<label>-</label><span class="erreurMessage" >* ' . $re->erreurNom . '</span>'; ?>
						</div>

						<div>
							<label>Prénom : </label>
							<input type="text" 
								name="prenom" 
								class="prenom" 
								value="<?php if(isset($re->client['prenom'])) echo $re->client['prenom']; else echo $prenom; ?>" 
							/>
							<?php if(isset($re->erreurPrenom)) echo '<label>-</label><span class="erreurMessage" >* ' . $re->erreurPrenom . '</span>'; ?>
						</div>

						<div>
							<label>Pays : </label>
							<select class="pays" name="pays" style="padding-left: 0px;">

							<?php foreach($pays as $p): ?>
								<option value="<?php echo $p->idpays; ?>"  <?php if(isset($re->client['pays']) && $re->client['pays'] == $p->idpays) echo 'selected'; ?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;"><?php echo $p->nompays; ?></option>
							<?php endforeach; ?>

							</select>
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="tel" class="tel" value="<?php if(isset($re->client['tel'])) echo $re->client['tel']; ?>" >
						</div>

						<div>
							<label>Mail : </label>
							<input type="text" name="mail" class="email" value="<?php if(isset($re->client['mail'])) echo $re->client['mail']; ?>" >
						</div>
						
						<br><br>
						
						
						<h2>Accréditation</h2>

						<div>
							<label>Fonction : </label>
							<input type="text" name="fonction" value="<?php if(isset($re->accred['fonction'])) echo $re->accred['fonction']; ?>" />
						</div>

						<div>
							<label>Catégorie : </label>
							<select name="categorie">
								<option value="" <?php if(empty($re->accred['categorie'])) echo 'selected'; ?> >---</option>
								<?php foreach($categories as $categorie): ?>
								<option value="<?php echo $categorie['cat']->idcategorie; ?>" 
									zone="<?php echo $categorie['zones']; ?>" 
									<?php if(isset($re->accred['idcategorie']) && $re->accred['idcategorie'] == $categorie['cat']->idcategorie) echo 'selected'; ?>
								>
									<?php echo $categorie['cat']->libellecategorie; ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="contientZones">
							<label>Zones : </label>
							<div>
								<?php foreach($zones as $zone): ?>
								<div class="checkzone <?php if(isset($re->zones[$zone->idzone])) echo 'on'; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->idzone; ?>
									<input type="checkbox" 
										name="zone[<?php echo $zone->idzone; ?>]"
										value="<?php echo $zone->idzone; ?>" 
										<?php if(isset($re->zones[$zone->idzone])) echo 'checked'; ?>
									/>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
												
						<div>
							<label> Mode All-Accees : </label>
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