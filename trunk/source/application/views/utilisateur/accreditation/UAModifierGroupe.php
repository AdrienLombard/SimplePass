<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Ajouter individuel</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" class="current" >Ajouter groupe</a>
    </div>

    <div class="box-full">
		
		<aside>
		<a href="<?php echo site_url('accreditation/ajoutMembreGroupe/'.$ref->groupe); ?>" >Ajouter membre</a>
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
							<label>Tel : </label>
							<input type="text" name="info[tel]" class="tel" value="<?php echo $ref->tel; ?>"/>
						</div>
						
						<div>
							<label>Mail : </label>
							<input type="text" name="info[mail]" class="mail" value="<?php echo $ref->mail; ?>"/>
						</div>
						
						
						<div>
							<label>Pays : 
								<?php foreach($pays as $p): ?>
									<span id="<?php echo $p->idpays; ?>" class="drapeau" ><?php echo img('drapeaux/' . strtolower($p->idpays) . '.gif'); ?></span>
								<?php endforeach; ?>
							</label>
							<select class="pays" name="info[pays]">
								<?php foreach($pays as $p): ?>
									<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == $ref->pays)? 'selected' : '' ;?> > <?php echo $p->nompays; ?></option>
								<?php endforeach; ?>
								
							</select>
						</div>
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
							<label>Fonction : </label><input type="text" id="fonction" class="champ2" style="width:130px;" name="pers[0][fonction]" value="<?php echo $ref->fonction; ?>"/>
						</div>
						<div>
							<label>Image : </label>
							<input type="file" name="photo_file0"  />
						</div>
						<div  data="0" class="contientZones" >
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

						<div>
							<label> Mode All-Accees : </label>
							<input data="0" type="checkbox" class="allGroupe" name="allAccess" value="1" <?php if(isset($re->accred['allaccess']) && $re->accred['allaccess'] == 1) echo 'checked'; ?> />
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
									<?php if(isset($re->accred['idcategorie']) && $ref->idcategorie == $categorie['cat']->idcategorie) echo 'selected'; ?>
									>
									<?php for($i=0; $i<$cate['cat']['depth']; $i++) echo '&#160;&#160;'; ?>
									<?php echo $cate['cat']['db']->libellecategorie; ?>
								</option>
								<?php endforeach; ?>
							</select>
							<label>Fonction : </label><input type="text"  class="champ2" style="width:130px;" name="pers[<?php echo $nb; ?>][fonction]" value="<?php echo $p->fonction; ?>"/>
						</div>
						<div>
							<label>Image : </label>
							<input type="file" name="photo_file<?php echo $nb; ?>"  />
						</div>
						<div class="contientZones" data="<?php echo $nb; ?>">
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

						<div>
							<label> Mode All-Accees : </label>
							<input data="<?php echo $nb; ?>" type="checkbox" class="allGroupe" name="allAccess" value="1" <?php if(isset($re->accred['allaccess']) && $re->accred['allaccess'] == 1) echo 'checked'; ?> />
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
