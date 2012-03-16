<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="#" class="current">Ajouter</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/index'); ?>">Retour</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeAjouter'); ?>">
					
					<input type="hidden" name="evenement" value="<?php echo $this->session->userdata('idEvenementEnCours'); ?>"/>

				
					
					<div class="inputs">

						<h2>Personne</h2>
						
						<div>
							<label>Nom : </label>
							<input type="text" name="nom" class="nom" value="<?php echo $nom; ?>" style="text-transform: uppercase" />
						</div>

						<div>
							<label>Prénom : </label>
							<input type="text" name="prenom" class="prenom" value="<?php echo $prenom; ?>" />
						</div>

						<div>
							<label>Pays : </label>
							<select class="pays" name="pays" style="padding-left: 0px;">

							<?php foreach($pays as $p): ?>
								<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == 'FRA')? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;"><?php echo $p->nompays; ?></option>
							<?php endforeach; ?>

							</select>
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="tel" class="tel">
						</div>

						<div>
							<label>Mail : </label>
							<input type="text" name="mail" class="email">
						</div>
						
						<br><br>
						
						<h2>Accréditation</h2>

						<div>
							<label>Fonction : </label>
							<input type="text" name="fonction"/>
						</div>

						<div>
							<label>Catégorie : </label>
							<select name="categorie">
								<option value="">---</option>
								<?php foreach($categories as $categorie): ?>
								<option value="<?php echo $categorie['cat']->idcategorie; ?>" zone="<?php echo $categorie['zones']; ?>">
									<?php echo $categorie['cat']->libellecategorie; ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="contientZones">
							<label>Zones : </label>
							<div>
								<?php foreach($zones as $zone): ?>
								<div class="checkzone" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->idzone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" />
								</div>
								<?php endforeach; ?>
							</div>
						</div>
												
						<div>
							<label> Mode All-Accees : </label>
							<input type="checkbox" id="all" name="allAccess" />
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