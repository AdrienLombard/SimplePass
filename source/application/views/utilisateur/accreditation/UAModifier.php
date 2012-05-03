<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Ajouter individuel</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>">Ajouter groupe</a>
		<a href="#" class="current">Modifier</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/voir/'.$accred->idclient); ?>">Retour</a>
			<br>
			<a href="#" class="startEditAccred">Modifier</a>
			<?php if($accred->etataccreditation == ACCREDITATION_A_VALIDE): ?>
			<a href="<?php echo site_url('accreditation/valider/'.$accred->idaccreditation); ?>">Valider la demande</a>
			<?php else: ?>
			<a id="imprimer" target="_blank" href="<?php echo site_url('impression/index/'.$accred->idclient.'/'.$accred->idaccreditation.'/'.$accred->idevenement); ?>">Imprimer</a>
			<a id="imprimerCarte" target="_blank" href="<?php echo site_url('impression/impcarte/'.$accred->idclient.'/'.$accred->idaccreditation.'/'.$accred->idevenement); ?>">Imprimer carte</a>
			<?php endif; ?>
			<br>
			<a href="<?php echo site_url('accreditation/supprimer/'.$accred->idaccreditation.'/'.$accred->idclient); ?>" confirm="Êtes-vous sûr de vouloir supprimer cette accréditation ?">Supprimer</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" id="editAccredRealTime" method="post" action="<?php echo site_url('accreditation/exeModifier'); ?>" enctype="multipart/form-data">

					<input type="file" name="photo_file" id="photo_file" accept="image/jpeg" />
					<input type="hidden" name="photo_webcam" id="photo_webcam" />

					<div class="photo">

						<div class="simulPhoto">

							<div class="webcamWrapper">
								<a href="#" class="closeCam">x</a>
								<span>Placer votre visage au centre de l'image :</span>
								<div class="webcam"></div>
								<a href="#" class="captureCam">Prendre une photo</a>
							</div>

							<canvas id="canvas" width="160" height="204"></canvas> 

							<div class="photoMessage"></div>

							<?php if(img_url('photos/'.$accred->idclient.'.jpg') != NULL): ?>
							<img src="<?php echo site_url('image/generate/' . $accred->idclient); ?>" />
							<?php endif; ?>

						</div>

						<div class="clear"></div>

						<div class="optionPhoto">
							<a href="#" class="uploadFichier">FICHIER</a>
							<a href="#" class="startWebcam">WEBCAM</a>
						</div>

					</div>
					
					<div class="inputs">

						<h2>Personne</h2>
						
						<input type="hidden" name="idClient" value="<?php echo $accred->idclient; ?>" />
						
						<div>
							<label>Nom : </label>
							<input readonly type="text" name="nom" class="nom" value="<?php echo $accred->nom; ?>" style="text-transform: uppercase" />
						</div>

						<div>
							<label>Prénom : </label>
							<input readonly type="text" name="prenom" class="prenom" value="<?php echo $accred->prenom; ?>" />
						</div>

						<div>
							<label>Pays : 
								<?php foreach($pays as $p): ?>
									<span id="<?php echo $p->idpays; ?>" class="drapeau" style="display:none;" ><?php echo img('drapeaux/' . strtolower($p->idpays) . '.gif'); ?></span>
								<?php endforeach; ?>
							</label>
							<select disabled class="pays" name="pays" style="padding-left: 0px;">

							<?php foreach($pays as $p): ?>
								<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == $accred->pays)? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>)no-repeat left;"><?php echo $p->nompays; ?></option>
							<?php endforeach; ?>

							</select>
						</div>

						<div>
							<label>Tel : </label>
							<input readonly type="text" name="tel" class="tel" value="<?php echo $accred->tel; ?>">
						</div>

						<div>
							<label>Mail : </label>
							<input readonly type="text" name="mail" class="email" value="<?php echo $accred->mail; ?>">
						</div>
						
						<div>
							<label>Organisme : </label>
							<input readonly type="text" name="organisme" class="organisme" value="<?php echo $accred->organisme; ?>" >
						</div>
						
						<?php if(isset($accred->adresse) && !empty($accred->adresse)): ?>
						<br/>
						<div>
							<label>Adresse : </label>
							<textarea readonly name="adresse" cols="40" rows="3"><?php if(isset($accred->adresse)) echo $accred->adresse; ?></textarea>
						</div>
						<?php endif; ?>
						
						<br><br>
						
						<h2>Accréditation</h2>
						
						<input type="hidden" name="idAccred" value="<?php echo $accred->idaccreditation; ?>" />

						<div>
							<label>Fonction : </label>
							<?php if(isset($accred->fonction) && !empty($accred->numeropresse)): ?>
							<select name="fonction" id="fonctionref" disabled>
								<option name="redacChef" 	value="Rédacteur en chef"	<?php if(isset($accred->fonction) && $accred->fonction == 'Rédacteur en chef') echo 'selected'; ?> >Rédacteur en chef</option>
								<option name="journaliste" 	value="journaliste" <?php if(isset($accred->fonction) && $accred->fonction == 'Journaliste') echo 'selected'; ?> >Journaliste</option>
								<option name="cameraman" 	value="Caméraman" <?php if(isset($accred->fonction) && $accred->fonction == 'Caméraman') echo 'selected'; ?> >Caméraman</option>
								<option name="preneurSon" 	value="Preneur de son" <?php if(isset($accred->fonction) && $accred->fonction == 'Preneur de son') echo 'selected'; ?> >Preneur de son</option>
								<option name="photographe" 	value="Photographe" <?php if(isset($accred->fonction) && $accred->fonction == 'Photographe') echo 'selected'; ?> >Photographe</option>
								<option name="technicien" 	value="Technicien" <?php if(isset($accred->fonction) && $accred->fonction == 'Technicien') echo 'selected'; ?>>Technicien</option>
							</select>
							<?php else: ?>
							<input readonly type="text" name="fonction" value="<?php echo $accred->fonction; ?>" />
							<?php endif; ?>
						</div>

						<div>
							<label>Catégorie : </label>
							<select disabled class="pays" name="categorie" id="categorieSimple" >
								<option value="" <?php if(empty($accred->idcategorie)) echo 'selected'; ?> >---</option>
								<?php foreach($categories as $cate): ?>
								<option
									value="<?php echo $cate['cat']['db']->idcategorie; ?>"
									zone="<?php echo $cate['zones']; ?>"
									<?php if(isset($accred->idcategorie) && $accred->idcategorie == $cate['cat']['db']->idcategorie) echo 'selected'; ?>
									>
									<?php for($i=0; $i<$cate['cat']['depth']; $i++) echo '&#160;&#160;'; ?>
									<?php echo $cate['cat']['db']->libellecategorie; ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<?php if(isset($accred->numeropresse) && !empty($accred->numeropresse)): ?>
							<div>
								<label>Num presse : </label>
								<input type="text" id="numeroref" name="numeropresse" value="<?php if(isset($accred->numeropresse)) echo $accred->numeropresse; ?>" readonly/>
							</div>
						<?php endif; ?>

						<div class="contientZones readonly">
							<label>Zones : </label>
							<div>
								<?php foreach($zones as $zone): ?>
								<div class="checkzone <?php echo in_array($zone->idzone, $zonesAccred)? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" <?php echo in_array($zone->idzone, $zonesAccred)? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
						</div>
						
						<div class="allaccess">
							<label>All-Access : </label>
							<input type="checkbox" id="all" name="allAccess" disabled <?php if($accred->allaccess == 1) echo 'checked'; ?>/>
						</div>

						<div class="clear"></div>
						
					</div>

					<input type="submit" class="button" id="saveAccred" value="Enregistrer" />
				</form>

			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>