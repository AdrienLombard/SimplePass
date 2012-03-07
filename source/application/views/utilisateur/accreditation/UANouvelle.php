<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="<?php echo site_url('accreditation/demandes'); ?>">Demandes</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>">Ajouter</a>
		<a href="#" class="current">Nouvelle</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/voir/'.$client->idclient); ?>">Retour</a>
		</aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeNouvelle'); ?>">

					<div class="photo">

						<div class="simulPhoto"></div>

						<div class="optionPhoto">
							<a href="#">FICHIER</a>
							<a href="#">WEBCAM</a>
						</div>

					</div>
					
					<div class="inputs">

						<h2>Personne</h2>
						
						<input type="hidden" name="idClient" value="<?php echo $client->idclient; ?>" />
						
						<div>
							<label>Nom : </label>
							<input type="text" name="nom" class="nom" value="<?php echo $client->nom; ?>" style="text-transform: uppercase" />
						</div>

						<div>
							<label>Prénom : </label>
							<input type="text" name="prenom" class="prenom" value="<?php echo $client->prenom; ?>" />
						</div>

						<div>
							<label>Pays : </label>
							<select class="pays" name="pays" style="padding-left: 0px;">

							<?php foreach($pays as $p): ?>
								<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;"><?php echo $p->nompays; ?></option>
							<?php endforeach; ?>

							</select>
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="tel" class="tel" value="<?php echo $client->tel; ?>">
						</div>

						<div>
							<label>Mail : </label>
							<input type="text" name="mail" class="email" value="<?php echo $client->mail; ?>">
						</div>
						
						<br><br>
						
						<h2>Accréditation</h2>

						<div>
							<label>Fonction : </label>
							<input type="text" name="fonction" />
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

						<div class="clear"></div>
						
					</div>

					<input type="submit" class="button" value="Enregistrer" />

				</form>

			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>