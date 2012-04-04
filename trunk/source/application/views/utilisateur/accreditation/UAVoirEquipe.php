<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Ajouter personne</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" class="current" >Ajouter groupe</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/modifierGroupe/'.$ref[0]->groupe); ?>">Modifier</a>
			<a href="<?php echo site_url('impression/impgroupe'); ?>">Imprimer</a>
			<a href="<?php echo site_url('impression/impcartegroupe'); ?>">Imprimer Carte</a>
			<a href="<?php echo site_url('accreditation/index'); ?>">Retour</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeAjoutGroupe'); ?>">
                   
                   <div class="inputs no-margin">
						<h2> Informations générales </h2>
						<div>
							<label>Groupe : </label>
							<input type="text" name="info[groupe]" init="<?php echo $ref[0]->groupe; ?>" value="<?php echo $ref[0]->groupe; ?>" class="nom" readonly/>
						</div>
						
						<div>
							<label>Société : </label>
							<input type="text" name="info[societe]" value="<?php echo $ref[0]->organisme; ?>" class="nom" readonly/>
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="info[tel]" class="tel" value="<?php echo $ref[0]->tel; ?>" readonly/>
						</div>
						
						<div>
							<label>Mail : </label>
							<input type="text" name="info[mail]" class="mail" value="<?php echo $ref[0]->mail; ?>"  readonly/>
						</div>
						
						
						<div>
							<label>Pays : </label>
							<select class="pays" name="pays" value="<?php echo $ref[0]->pays; ?>" disabled>
								<option value="<?php echo $ref[0]->pays; ?>"><?php echo $pays->nompays; ?></option>
							</select>
						</div>
					
						<div class="clear"></div>
						
					</div>
					<br/><br/>
					<h2>Référent</h2>
					
					<div class="referent">
						<div>
							<label>Nom : </label><input type="text" id="nom" class="champ" style="text-transform: uppercase; width:180px;" name="ref[nom]" value="<?php echo $ref[0]->nom; ?>" readonly/>
							<label>Prénom : </label><input type="text" id="prenom" class="champ2" style="width:180px;" name="ref[prenom]" value="<?php echo $ref[0]->prenom; ?>" readonly/>
						</div>
						<div>
							<label>Catégorie : </label><input type="text" id="categorie" class="champ" style="width:180px;" name="ref[categorie]" value="<?php echo $ref[0]->libellecategorie; ?>" readonly/>
							<label>Fonction : </label><input type="text" id="fonction" class="champ2" style="width:180px;" name="ref[fonction]" value="<?php echo $ref[0]->fonction; ?>" readonly/>
						</div>
						<div class="contientZones readonly">
							<label>Zones : </label>
							<div>
								<?php foreach($zonesEvent as $zone): ?>
								<div class="checkzone <?php echo in_array($zone->idzone, $ref[0]->zonesAccred)? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" <?php echo in_array($zone->idzone, $ref[0]->zonesAccred)? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					
					<br><br>
					
					<h2>Personnes</h2>
					<?php foreach($personnes as $p): ?>
						<div>
							<label>Nom : </label><input type="text" id="nom" class="champ" style="text-transform: uppercase; width:180px;" name="ref[nom]" value="<?php echo $p->nom; ?>" readonly/>
							<label>Prénom : </label><input type="text" id="prenom" class="champ2" style="width:180px;" name="ref[prenom]" value="<?php echo $p->prenom; ?>" readonly/>
						</div>
						<div class="ligne">
							<label>Catégorie : </label><input type="text" id="categorie" class="champ" style="width:180px;" name="ref[categorie]" value="<?php echo $p->libellecategorie; ?>" readonly/>
							<label>Fonction : </label><input type="text" id="fonction" class="champ2" style="width:180px;" name="ref[fonction]" value="<?php echo $p->fonction; ?>" readonly/>
						</div>
						<div class="contientZones readonly">
							<label>Zones : </label>
							<div>
								<?php foreach($zonesEvent as $zone): ?>
								<div class="checkzone <?php echo in_array($zone->idzone, $p->zonesAccred)? 'on' : '' ; ?>" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" <?php echo in_array($zone->idzone, $p->zonesAccred)? 'checked' : '' ; ?> />
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					<div class="clear"><h2></h2></div>
					<?php endforeach; ?>

				
				</form>

			</div>
	
        <div class="clear"></div>

    </div>
		
</div>
