<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Ajouter individuel</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" >Ajouter groupe</a>
		<a href="<?php echo site_url('accreditation/voirEquipe/' . $ref->groupe); ?>" class="current" >Groupe</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/index'); ?>">Retour</a>
			<br/>
			<a href="<?php echo site_url('accreditation/modifierGroupe/'.$ref->groupe); ?>">Modifier</a>
			<?php if($ref->etataccreditation == ACCREDITATION_A_VALIDE): ?>
				<a href="<?php echo site_url('accreditation/validergroupe/'.$ref->groupe); ?>">Valider la demande</a>
			<?php else: ?>
				<a target="_blank" href="<?php echo site_url('impression/impgroupe/'.$ref->groupe); ?>">Imprimer</a>
				<a target="_blank" href="<?php echo site_url('impression/impcartegroupe/'.$ref->groupe); ?>">Imprimer carte</a>
			<?php endif; ?>
			<br/>
			<a href="<?php echo site_url('accreditation/supprimerGroupe/'.$ref->groupe); ?>" confirm="Êtes-vous sûr de vouloir supprimer ce groupe ?">Supprimer groupe</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeAjoutGroupe'); ?>">
                   
                   <div class="inputs no-margin">
						<h2> Informations générales </h2>
						<div>
							<label>Groupe : </label>
							<input type="text" name="info[groupe]" init="<?php echo $ref->groupe; ?>" value="<?php echo $ref->groupe; ?>" class="nom" readonly/>
						</div>
						
						<div>
							<label>Société : </label>
							<input type="text" name="info[societe]" value="<?php echo $ref->organisme; ?>" class="nom" readonly/>
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="info[tel]" class="tel" value="<?php echo $ref->tel; ?>" readonly/>
						</div>
						
						<div>
							<label>Mail : </label>
							<input type="text" name="info[mail]" class="mail" value="<?php echo $ref->mail; ?>"  readonly/>
						</div>
				
						<div>
							<label>Pays : 
								<?php foreach($listePays as $p): ?>
									<span id="<?php echo $p->idpays; ?>" class="drapeau" style="display:none;" ><?php echo img('drapeaux/' . strtolower($p->idpays) . '.gif'); ?></span>
								<?php endforeach; ?>
							</label>
							<select class="pays" name="info[pays]" disabled>
								<option value="<?php echo $ref->pays; ?>"><?php echo $pays->nompays; ?></option>
							</select>
						</div>
						
						<!-- champ pour l'adresse du client -->
						<?php if(isset($ref->numeropresse) && !empty($ref->numeropresse)): ?>
						<div>
							<label>Adresse : </label>
							<textarea readonly name="adresse" cols="65" rows="3"><?php if(isset($ref->adresse)) echo $ref->adresse; ?></textarea>
						</div>
						<?php endif; ?>
					
						<div class="clear"></div>
						
					</div>
					<br/><br/>
					<h2>Référent</h2>
					
					<div class="referent">
						<div class="photo">
							<?php if(img_url('photos/'.$ref->idclient.'.jpg') != NULL): ?>
								<img src="<?php echo site_url('image/generate/' . $ref->idclient); ?>" />
							<?php else: ?>
								<?php echo img('photos/0.jpg'); ?>
							<?php endif; ?>
						</div>
						<div>
							<label>Nom : </label><input type="text" id="nomref" class="champ" style="text-transform: uppercase; width:130px;" name="ref[nom]" value="<?php echo $ref->nom; ?>" readonly/>
							<label>Prénom : </label><input type="text" id="prenomref" class="champ2" style="width:130px;" name="ref[prenom]" value="<?php echo $ref->prenom; ?>" readonly/>
						</div>
						
						<div>
							<label>Catégorie : </label>
							<input type="text" id="categorieref" class="champ" style="width:130px;" name="ref[categorie]" value="<?php echo $ref->libellecategorie; ?>" readonly/>
							
							<label>Fonction : </label>
							<?php if(isset($ref->numeropresse) && !empty($ref->numeropresse)): ?>
							<select class="pays" name="ref[fonction]" id="fonctionref" style="width:180px;" disabled>
								<option name="redacChef" 	value="Rédacteur en chef"	<?php if(isset($ref->fonction) && $ref->fonction == 'Rédacteur en chef') echo 'selected'; ?> >Rédacteur en chef</option>
								<option name="journaliste" 	value="journaliste" <?php if(isset($ref->fonction) && $ref->fonction == 'Journaliste') echo 'selected'; ?> >Journaliste</option>
								<option name="cameraman" 	value="Caméraman" <?php if(isset($ref->fonction) && $ref->fonction == 'Caméraman') echo 'selected'; ?> >Caméraman</option>
								<option name="preneurSon" 	value="Preneur de son" <?php if(isset($ref->fonction) && $ref->fonction == 'Preneur de son') echo 'selected'; ?> >Preneur de son</option>
								<option name="photographe" 	value="Photographe" <?php if(isset($ref->fonction) && $ref->fonction == 'Photographe') echo 'selected'; ?> >Photographe</option>
								<option name="technicien" 	value="Technicien" <?php if(isset($ref->fonction) && $ref->fonction == 'Technicien') echo 'selected'; ?>>Technicien</option>
							</select>
							<?php else: ?>
							<input type="text" id="fonctionref" class="champ2" style="width:130px;" name="ref[fonction]" value="<?php echo $ref->fonction; ?>" readonly/>
							<?php endif; ?>
						</div>
						
						<?php if(isset($ref->numeropresse) && !empty($ref->numeropresse)): ?>
							<div>
								<label>Num presse : </label>
								<input type="text" id="numeroref" class="champ" style="" name="ref[numeropresse]" value="<?php if(isset($ref->numeropresse)) echo $ref->numeropresse; ?>" readonly/>
							</div>
						<?php endif; ?>
						
						<div class="contientZones readonly">
							<label>Zones : </label>
							<div>
								<?php foreach($zonesEvent as $zone): ?>
								<div class="checkzone <?php echo (isset( $ref->zonesAccred) && in_array($zone->idzone, $ref->zonesAccred))? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" <?php echo (isset($ref->zonesAccred) && in_array($zone->idzone, $ref->zonesAccred))? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
							<div class="allaccess">
								<label> All-Access : </label>
								<input type="checkbox" disabled style="margin-top:14px;" name="allAccess" value="1" <?php if(isset($re->accred['allaccess']) && $re->accred['allaccess'] == 1) echo 'checked'; ?> />
							</div>
						</div>
					
					<br><br>
					<div class="clear">
					<h2>Personnes</h2>
					<?php foreach($personnes as $p): ?>
						<div class="photo">
							<?php if(img_url('photos/'.$p->idclient.'.jpg') != NULL): ?>
								<img src="<?php echo site_url('image/generate/' . $p->idclient); ?>" />
							<?php else: ?>
								<?php echo img('photos/0.jpg'); ?>
							<?php endif; ?>
						</div>
						<div>
							<label>Nom : </label><input type="text" id="nom" class="champ" style="text-transform: uppercase; width:130px;" name="ref[nom]" value="<?php echo $p->nom; ?>" readonly/>
							<label>Prénom : </label><input type="text" id="prenom" class="champ2" style="width:130px;" name="ref[prenom]" value="<?php echo $p->prenom; ?>" readonly/>
						</div>
						<div class="ligne">
							<label>Catégorie : </label><input type="text" id="categorie" class="champ" style="width:130px;" name="ref[categorie]" value="<?php echo $p->libellecategorie; ?>" readonly/>
							
							<?php if(isset($p->numeropresse) && !empty($p->numeropresse)): ?>
							<select class="pays" name="ref[fonction]" id="fonctionref" style="width:180px;" disabled>
								<option name="redacChef" 	value="redacChef"	<?php if(isset($p->fonction) && $p->fonction == 'Rédacteur en chef') echo 'selected'; ?> >Rédacteur en chef</option>
								<option name="journaliste" 	value="journaliste" <?php if(isset($p->fonction) && $p->fonction == 'Journaliste') echo 'selected'; ?> >Journaliste</option>
								<option name="cameraman" 	value="cameraman" <?php if(isset($p->fonction) && $p->fonction == 'Caméraman') echo 'selected'; ?> >Caméraman</option>
								<option name="preneurSon" 	value="preneurSon" <?php if(isset($p->fonction) && $p->fonction == 'Preneur de son') echo 'selected'; ?> >Preneur de son</option>
								<option name="photographe" 	value="photographe" <?php if(isset($p->fonction) && $p->fonction == 'Photographe') echo 'selected'; ?> >Photographe</option>
								<option name="technicien" 	value="technicien" <?php if(isset($p->fonction) && $p->fonction == 'Technicien') echo 'selected'; ?>>Technicien</option>
							</select>
							<?php else: ?>
							<label>Fonction : </label><input type="text" id="fonction" class="champ2" style="width:130px;" name="ref[fonction]" value="<?php echo $p->fonction; ?>" readonly/>
							<?php endif; ?>
						</div>
						
						<?php if(isset($p->numeropresse) && !empty($p->numeropresse)): ?>
							<div>
								<label>Num presse : </label>
								<input type="text" id="numeroref" class="champ" style="" name="ref[numeropresse]" value="<?php if(isset($p->numeropresse)) echo $p->numeropresse; ?>" readonly/>
							</div>
						<?php endif; ?>
						
						
						<div class="contientZones readonly">
							<label>Zones : </label>
							<div>
								<?php foreach($zonesEvent as $zone): ?>
								<div class="checkzone <?php echo (isset($p->zonesAccred) &&in_array($zone->idzone, $p->zonesAccred))? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" <?php echo (isset($p->zonesAccred) &&in_array($zone->idzone, $p->zonesAccred))? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="allaccess">
							<label> All-Access : </label>
							<input type="checkbox"  disabled name="allAccess" value="1" <?php if(isset($re->accred['allaccess']) && $re->accred['allaccess'] == 1) echo 'checked'; ?> readonly/>
						</div>
					<div class="clear"><h2></h2></div>
					<?php endforeach; ?>

				
				</form>

			</div>
	
        <div class="clear"></div>

    </div>
		
</div>
		    
</div>