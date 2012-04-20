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
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeAjoutMembreGroupe'); ?>" enctype="multipart/form-data">
					<input type="hidden" name="evenement" value="<?php echo $this->session->userdata('idEvenementEnCours'); ?>"/>
					<input type="hidden" name="groupe" value="<?php echo $info->groupe; ?>"/>
					<input type="hidden" name="pays" value="<?php echo $info->pays; ?>"/>
					<input type="hidden" name="organisme" value="<?php echo $info->organisme; ?>"/>
					<input type="hidden" name="tel" value="<?php echo $info->tel; ?>"/>
					<input type="hidden" name="mail" value="<?php echo $info->mail; ?>"/>
					<input type="hidden" name="referent" value="<?php echo $info->referent; ?>"/>
					
					<h2>Information du membre</h2>

					<div>
						<label>Nom : </label><input type="text" id="nom" class="champ" style="text-transform: uppercase; width:180px;" name="nom" value=""/>
						<label>Prénom : </label><input type="text" id="prenom" class="champ2" style="width:180px;" name="prenom" value=""/>
					</div>
					<div class="ligne">
						<label>Catégorie : </label><select name="categorie" class="champ" style="width:202px">
														<?php foreach($categories as $cate): ?>
														<option 
															value="<?php echo $cate['db']->idcategorie; ?>" 
															<?php if(isset($re->info['categorie']) and $cate['db']->idcategorie == $re->info['categorie']) echo 'selected'?>
														>
															<?php for($i=0; $i<$cate['depth']; $i++) echo '&#160;&#160;'; ?>
															<?php echo $cate['db']->libellecategorie; ?>
														</option>
														<?php endforeach; ?>
													</select>
						<label>Fonction : </label><input type="text" id="fonction" class="champ2" style="width:180px;" name="fonction" value=""/>
					</div>
					<div>
							<label>Image : </label>
							<input type="file" name="photo_file"  />
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
					<div>
						<label> Mode All-Accees : </label>
						<input type="checkbox" id="all" name="allAccess" value="1" <?php if(isset($re->accred['allaccess']) && $re->accred['allaccess'] == 1) echo 'checked'; ?>/>
					</div>
					<input type="submit" class="button" value="Valider" />
				</form>
			</div>
		</div>
        <div class="clear"></div>

    </div>
		
</div>