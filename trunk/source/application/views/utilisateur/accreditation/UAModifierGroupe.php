<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Individuelles</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" class="current" >Groupes</a>
    </div>

    <div class="box-full">
		
		<aside>
			<a href="<?php echo site_url('accreditation/index'); ?>">Retour</a>
			<br/>	
			<a href="<?php echo site_url('accreditation/ajoutMembreGroupe/'.$ref->groupe); ?>" >Ajouter membre</a>
			<br>
			<a href="<?php echo site_url('accreditation/supprimerGroupe/'.$ref->groupe); ?>" confirm="Êtes-vous sûr de vouloir supprimer ce groupe ?">Supprimer groupe</a>
		</aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeModifierGroupe'); ?>" enctype="multipart/form-data">
                   
                   <div class="inputs no-margin">
						<h2> Informations générales </h2>
						<div>
							<label>Groupe : </label>
							<input type="text" name="info[groupe]" init="<?php echo $ref->groupe; ?>" value="<?php echo $ref->groupe; ?>" class="nom"/>
						</div>
						
						<div>
							<label>Société : </label>
							<input type="text" name="info[societe]" value="<?php echo $ref->organisme; ?>" class="nom"/>
						</div>

						
						<div>
							<label>Pays : 
								<?php foreach($pays as $p): ?>
									<span id="<?php echo $p->idpays; ?>" class="drapeau" style="display:none;" ><?php echo img('drapeaux/' . strtolower($p->idpays) . '.gif'); ?></span>
								<?php endforeach; ?>
							</label>
							<select class="pays" name="info[pays]">
								<?php foreach($pays as $p): ?>
									<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == $ref->pays)? 'selected' : '' ;?> > <?php echo $p->nompays; ?></option>
								<?php endforeach; ?>
								
							</select>
						</div>
						
						<!-- champ pour l'adresse du client -->
						
						<div class="clear"></div>
						
					</div>
					<br/><br/>
					<h2>Référent</h2>
					<div class="referent">
						<input type="hidden"  name="pers[0][idclient]"  value="<?php echo $ref->idclient; ?>">
						<input type="hidden"  name="pers[0][idaccreditation]"  value="<?php echo $ref->idaccreditation; ?>">
						<div class="photo">
							<?php if(img_url('photos/'.$ref->idclient.'.jpg') != NULL): ?>
								<img src="<?php echo site_url('image/generate/' . $ref->idclient); ?>" />
							<?php endif; ?>
						</div>
						<div>
							<label>Nom : </label><input type="text" id="nom" class="champ" style="text-transform: uppercase; width:130px;" name="pers[0][nom]" value="<?php echo $ref->nom; ?>"/>
							<label>Prénom : </label><input type="text" id="prenom" class="champ2" style="width:130px;" name="pers[0][prenom]" value="<?php echo $ref->prenom; ?>"/>
						</div>
						<div>
							<label>Catégorie : </label>
							<select data="0" name="pers[0][categorie]" class="champ categorieSelect" style="width:152px">
								<?php foreach($categories as $cate): ?>
									<option
										value="<?php echo $cate['cat']['db']->idcategorie; ?>"
										zone="<?php echo $cate['zones']; ?>"
										<?php if(isset($ref->idcategorie) && $ref->idcategorie == $cate['cat']['db']->idcategorie) echo 'selected'; ?>
										>
										<?php for($i=0; $i<$cate['cat']['depth']; $i++) echo '&#160;&#160;'; ?>
										<?php echo $cate['cat']['db']->libellecategorie; ?>
									</option>
								<?php endforeach; ?>
							</select>
							
							<label>Fonction : </label>
							<?php if(isset($ref->numeropresse) && !empty($ref->numeropresse)): ?>
							<select name="pers[0][fonction]" id="fonctionref" style="width:180px;" >
								<option name="redacChef" 	value="Rédacteur en chef"	<?php if(isset($ref->fonction) && $ref->fonction == 'Rédacteur en chef') echo 'selected'; ?> >Rédacteur en chef</option>
								<option name="journaliste" 	value="Journaliste" <?php if(isset($ref->fonction) && $ref->fonction == 'Journaliste') echo 'selected'; ?> >Journaliste</option>
								<option name="cameraman" 	value="Caméraman" <?php if(isset($ref->fonction) && $ref->fonction == 'Caméraman') echo 'selected'; ?> >Caméraman</option>
								<option name="preneurSon" 	value="Preneur de son" <?php if(isset($ref->fonction) && $ref->fonction == 'Preneur de son') echo 'selected'; ?> >Preneur de son</option>
								<option name="photographe" 	value="Photographe" <?php if(isset($ref->fonction) && $ref->fonction == 'Photographe') echo 'selected'; ?> >Photographe</option>
								<option name="technicien" 	value="Technicien" <?php if(isset($ref->fonction) && $ref->fonction == 'Technicien') echo 'selected'; ?>>Technicien</option>
							</select>
							<?php else: ?>
							<input type="text" id="fonction" class="champ2" style="width:130px;" name="pers[0][fonction]" value="<?php echo $ref->fonction; ?>"/>
							<?php endif; ?>
						</div>
						<div>
							<label>Image : </label>
							<input type="file" name="photo_file0"  />
						</div>
						
						<?php if(isset($ref->numeropresse) && !empty($ref->numeropresse)): ?>
							<div>
								<label> Num presse : </label>
								<input type="text" id="numeroref" class="champ" style="" name="pers[0][numeropresse]" value="<?php if(isset($ref->numeropresse)) echo $ref->numeropresse; ?>" />
							</div>
						<?php endif; ?>
						
						<div>
							<label>Tel : </label>
							<input type="text" name="pers[0][tel]" class="tel" value="<?php echo $ref->tel; ?>"/>
						</div>
						
						<div>
							<label>Mail : </label>
							<input type="text" name="pers[0][mail]" class="mail" value="<?php echo $ref->mail; ?>"/>
						</div>
						<?php if(isset($ref->numeropresse) && !empty($ref->numeropresse)): ?>
						<div>
							<label>Adresse : </label>
							<textarea name="pers[0][adresse]" cols="65" rows="7"><?php if(isset($ref->adresse)) echo $ref->adresse; ?></textarea>
						</div>
						<?php endif; ?>
						
						<div  data="0" class="contientZones" >
							<label>Zones : </label>
							<div>
								<?php foreach($zonesEvent as $zone): ?>
								<div class="checkzone <?php echo (isset($ref->zonesAccred) && in_array($zone->idzone, $ref->zonesAccred))? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="pers[0][zone][<?php echo $zone->idzone; ?>]" <?php echo (isset($ref->zonesAccred) && in_array($zone->idzone, $ref->zonesAccred))? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
						</div>

						<div class="allaccess">
							<label>All-Access : </label>
							<input data="0" type="checkbox" class="allGroupe" name="pers[0][allaccess]" value="1" <?php if(isset($ref->allaccess) && $ref->allaccess == 1) echo 'checked'; ?> />
						</div>
					
					<br><br>
					<div class="clear"></div>
					<h2>Personnes</h2>
					<?php $nb = 1; ?>
					<?php foreach($personnes as $p): ?>
						<input type="hidden"  name="pers[<?php echo $nb; ?>][idclient]"  value="<?php echo $p->idclient; ?>">
						<input type="hidden"  name="pers[<?php echo $nb; ?>][idaccreditation]"  value="<?php echo $p->idaccreditation; ?>">
						<div class="photo">
							<?php if(img_url('photos/'.$p->idclient.'.jpg') != NULL): ?>
								<img src="<?php echo site_url('image/generate/' . $p->idclient); ?>" />
							<?php endif; ?>
						</div>
						<div>
							<label>Nom : </label><input type="text"  class="champ" style="text-transform: uppercase; width:130px;" name="pers[<?php echo $nb; ?>][nom]" value="<?php echo $p->nom; ?>"/>
							<label>Prénom : </label><input type="text"  class="champ2" style="width:130px;" name="pers[<?php echo $nb; ?>][prenom]" value="<?php echo $p->prenom; ?>"/>
							<a href="<?php echo site_url('accreditation/supprimerMembreGroupe/'.$p->idaccreditation.'/'.$ref->groupe); ?>" class="icons delete deleteNouvelleCatMere" confirm="Êtes-vous sûr de vouloir supprimer ce membre du groupe ?"></a>
						</div>
						<div class="ligne">
							<label>Catégorie : </label>
							<select data="<?php echo $nb; ?>" name="pers[<?php echo $nb; ?>][categorie]" class="champ categorieSelect" style="width:152px">
								<?php foreach($categories as $cate): ?>
								<option
									value="<?php echo $cate['cat']['db']->idcategorie; ?>"
									zone="<?php echo $cate['zones']; ?>"
									<?php if(isset($p->idcategorie) && $p->idcategorie == $cate['cat']['db']->idcategorie) echo 'selected'; ?>
									>
									<?php for($i=0; $i<$cate['cat']['depth']; $i++) echo '&#160;&#160;'; ?>
									<?php echo $cate['cat']['db']->libellecategorie; ?>
								</option>
								<?php endforeach; ?>
							</select>
							
							<label>Fonction : </label>
							<?php if(isset($p->numeropresse) && !empty($p->numeropresse)): ?>
							<select name="pers[<?php echo $nb; ?>][fonction]" id="fonctionref" style="width:180px;" >
								<option name="redacChef" 	value="Rédacteur en chef"	<?php if(isset($p->fonction) && $p->fonction == 'Rédacteur en chef') echo 'selected'; ?> >Rédacteur en chef</option>
								<option name="journaliste" 	value="Journaliste" <?php if(isset($p->fonction) && $p->fonction == 'Journaliste') echo 'selected'; ?> >Journaliste</option>
								<option name="cameraman" 	value="Caméraman" <?php if(isset($p->fonction) && $p->fonction == 'Caméraman') echo 'selected'; ?> >Caméraman</option>
								<option name="preneurSon" 	value="Preneur de son" <?php if(isset($p->fonction) && $p->fonction == 'Preneur de son') echo 'selected'; ?> >Preneur de son</option>
								<option name="photographe" 	value="Photographe" <?php if(isset($p->fonction) && $p->fonction == 'Photographe') echo 'selected'; ?> >Photographe</option>
								<option name="technicien" 	value="Technicien" <?php if(isset($p->fonction) && $p->fonction == 'Technicien') echo 'selected'; ?>>Technicien</option>
							</select>
							<?php else: ?>
							<input type="text"  class="champ2" style="width:130px;" name="pers[<?php echo $nb; ?>][fonction]" value="<?php echo $p->fonction; ?>"/>
							<?php endif; ?>
						</div>
						<div>
							<label>Image : </label>
							<input type="file" name="photo_file<?php echo $nb; ?>"  />
						</div>
						
						<?php if(isset($p->numeropresse) && !empty($p->numeropresse)): ?>
							<div>
								<label>Num presse : </label>
								<input type="text" id="numeroref" class="champ" style="" name="pers[<?php echo $nb; ?>][numeropresse]" value="<?php if(isset($p->numeropresse)) echo $p->numeropresse; ?>" />
							</div>
						<?php endif; ?>
						
						<div>
							<label>Mail : </label>
							<input type="text" name="pers[<?php echo $nb; ?>][mail]" class="mail" value="<?php echo $p->mail; ?>"/>
						</div>
						<div>
							<label>Tel : </label>
							<input type="text" name="pers[<?php echo $nb; ?>][tel]" class="mail" value="<?php echo $p->tel; ?>"/>
						</div>
						<?php if(isset($p->numeropresse) && !empty($p->numeropresse)): ?>
						<div>
							<label>Adresse : </label>
							<textarea name="pers[<?php echo $nb; ?>][adresse]" cols="65" rows="7"><?php if(isset($p->adresse)) echo $p->adresse; ?></textarea>
						</div>
						<?php endif; ?>
						<div class="contientZones" data="<?php echo $nb; ?>">
							<label>Zones : </label>
							<div>
								<?php foreach($zonesEvent as $zone): ?>
								<div class="checkzone <?php echo (isset($p->zonesAccred) && in_array($zone->idzone, $p->zonesAccred))? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="pers[<?php echo $nb; ?>][zone][<?php echo $zone->idzone; ?>]" <?php echo (isset($p->zonesAccred) && in_array($zone->idzone, $p->zonesAccred))? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
						</div>
                        
						
						<div class="allaccess">
							<label>All-Access : </label>
							<input data="<?php echo $nb; ?>" type="checkbox" class="allGroupe" name="pers[<?php echo $nb; ?>][allaccess]" value="1" <?php if(isset($p->allaccess) && $p->allaccess == 1) echo 'checked'; ?> />
						</div>
						
					<?php $nb++; ?>
					<div class="clear"><h2></h2></div>
					<?php endforeach; ?>
					
					<input type="submit" class="button" value="Valider" />
				</form>

			</div>
	
        <div class="clear"></div>

    </div>
		
</div>
