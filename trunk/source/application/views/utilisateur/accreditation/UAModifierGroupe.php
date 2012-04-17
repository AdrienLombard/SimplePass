<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Ajouter personne</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" class="current" >Ajouter groupe</a>
    </div>

    <div class="box-full">
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeModifierGroupe'); ?>">
                   
                   <div class="inputs no-margin">
						<h2> Informations générales </h2>
						<div class="photo">
							<?php if(img_url('photos/'.$ref->idclient.'.jpg') != NULL): ?>
								<img src="<?php echo site_url('image/generate/' . $ref->idclient); ?>" />
							<?php endif; ?>
						</div>
						<div>
							<label>Groupe : </label>
							<input type="text" name="info[groupe]" init="<?php echo $ref->groupe; ?>" value="<?php echo $ref->groupe; ?>" class="nom"/>
						</div>
						
						<div>
							<label>Société : </label>
							<input type="text" name="info[societe]" value="<?php echo $ref->organisme; ?>" class="nom"/>
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="info[tel]" class="tel" value="<?php echo $ref->tel; ?>"/>
						</div>
						
						<div>
							<label>Mail : </label>
							<input type="text" name="info[mail]" class="mail" value="<?php echo $ref->mail; ?>"/>
						</div>
						
						
						<div>
							<label>Pays : </label>
							<select class="pays" name="info[pays]">
								<?php foreach($pays as $p): ?>
									<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == $ref->pays)? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>)no-repeat left;"><?php echo $p->nompays; ?></option>
								<?php endforeach; ?>
								
							</select>
						</div>
						<div>
							<label>Image : </label>
							<input type="file" name="photo_file"  />
						</div>
						<div class="clear"></div>
						
					</div>
					<br/><br/>
					<h2>Référent</h2>
					<div class="referent">
						<input type="hidden"  name="pers[0][idclient]"  value="<?php echo $ref->idclient; ?>">
						<input type="hidden"  name="pers[0][idaccreditation]"  value="<?php echo $ref->idaccreditation; ?>">
						<div>
							<label>Nom : </label><input type="text" id="nom" class="champ" style="text-transform: uppercase; width:180px;" name="pers[0][nom]" value="<?php echo $ref->nom; ?>"/>
							<label>Prénom : </label><input type="text" id="prenom" class="champ2" style="width:180px;" name="pers[0][prenom]" value="<?php echo $ref->prenom; ?>"/>
						</div>
						<div>
							<label>Catégorie : </label><select name="pers[0][categorie]" class="champ" style="width:202px">
															<?php foreach($categories as $categorie): ?>
															<option value="<?php echo $categorie->idcategorie; ?>" <?php echo ($categorie->idcategorie == $ref->idcategorie)? 'selected' : '' ;?>>
																<?php echo $categorie->libellecategorie; ?>
															</option>
															<?php endforeach; ?>
														</select>
							<label>Fonction : </label><input type="text" id="fonction" class="champ2" style="width:180px;" name="pers[0][fonction]" value="<?php echo $ref->fonction; ?>"/>
						</div>
						<div class="contientZones">
							<label>Zones : </label>
							<div>
								<?php foreach($zonesEvent as $zone): ?>
								<div class="checkzone <?php echo in_array($zone->idzone, $ref->zonesAccred)? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="pers[0][zone][<?php echo $zone->idzone; ?>]" <?php echo in_array($zone->idzone, $ref->zonesAccred)? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					
					<br><br>
					
					<h2>Personnes</h2>
					<?php $nb = 1; ?>
					<?php foreach($personnes as $p): ?>
						<input type="hidden"  name="pers[<?php echo $nb; ?>][idclient]"  value="<?php echo $p->idclient; ?>">
						<input type="hidden"  name="pers[<?php echo $nb; ?>][idaccreditation]"  value="<?php echo $p->idaccreditation; ?>">
						<div>
							<label>Nom : </label><input type="text" id="nom" class="champ" style="text-transform: uppercase; width:180px;" name="pers[<?php echo $nb; ?>][nom]" value="<?php echo $p->nom; ?>"/>
							<label>Prénom : </label><input type="text" id="prenom" class="champ2" style="width:180px;" name="pers[<?php echo $nb; ?>][prenom]" value="<?php echo $p->prenom; ?>"/>
							<a class="button" href="<?php echo site_url('accreditation/supprimerMembreGroupe/'.$p->idaccreditation.'/'.$ref->groupe); ?>" confirm="Êtes-vous sûr de vouloir supprimer ce membre du groupe ?">Supprimer</a>
						</div>
						<div class="ligne">
							<label>Catégorie : </label><select name="pers[<?php echo $nb; ?>][categorie]" class="champ" style="width:202px">
															<?php foreach($categories as $categorie): ?>
															<option value="<?php echo $categorie->idcategorie; ?>" <?php echo ($categorie->idcategorie == $p->idcategorie)? 'selected' : '' ;?>>
																<?php echo $categorie->libellecategorie; ?>
															</option>
															<?php endforeach; ?>
														</select>
							<label>Fonction : </label><input type="text" id="fonction" class="champ2" style="width:180px;" name="pers[<?php echo $nb; ?>][fonction]" value="<?php echo $p->fonction; ?>"/>
						</div>
						<div class="contientZones">
							<label>Zones : </label>
							<div>
								<?php foreach($zonesEvent as $zone): ?>
								<div class="checkzone <?php echo in_array($zone->idzone, $p->zonesAccred)? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="pers[<?php echo $nb; ?>][zone][<?php echo $zone->idzone; ?>]" <?php echo in_array($zone->idzone, $p->zonesAccred)? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
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
