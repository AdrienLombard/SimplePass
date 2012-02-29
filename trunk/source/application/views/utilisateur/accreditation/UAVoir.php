<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="<?php echo site_url('accreditation/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Voir</a>
    </div>

    <div class="box-full">

        <aside>
           
            <a href="#" class="editClient">Modifier la personne</a>
			<a href="#">Nouvelle accréditation</a>

        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client">
				
				<div class="photo">
					
					<div class="simulPhoto"></div>
					
					<div class="optionPhoto">
						<a href="#">FICHIER</a>
						<a href="#">WEBCAM</a>
					</div>
					
				</div>
				
				<form class="infos" method="post" action="<?php echo site_url('accreditation/exeModifierClient'); ?>">
					
					<input type="hidden" name="id" value="<?php echo $client->idclient; ?>" />
					
					<div>
						<input type="text" name="nom" class="nom" init="<?php echo $client->nom; ?>" value="<?php echo $client->nom; ?>" readonly>
					</div>
					
					<div>
						<input type="text" name="prenom" class="prenom" init="<?php echo $client->prenom; ?>" value="<?php echo $client->prenom; ?>" readonly>
					</div>

					<div>
						<label>Pays : </label>
						<select class="pays" name="pays" init="<?php echo $client->pays; ?>" style="padding-left: 0px;" disabled="disabled">

						<?php foreach($pays as $p): ?>
							<option value="<?php echo $p->idpays; ?>" style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ?>><?php echo $p->nompays; ?></option>
						<?php endforeach; ?>

						</select>
					</div>
					
					<div>
						<label>Tel : </label>
						<input type="text" name="tel" class="tel" init="<?php echo $client->tel; ?>" value="<?php echo $client->tel; ?>" readonly>
					</div>
					
					<div>
						<label>Mail : </label>
						<input type="text" name="mail" class="email" init="<?php echo $client->mail; ?>" value="<?php echo $client->mail; ?>" readonly>
					</div>
					
					<input type="submit" class="valideInfos" value="Enregistrer les modifications" />
					
				</form>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="listeAccred">
				
				<h3>En cours</h3>
				
				<form class="accredForm">
					
				</form>
				
				<?php if(count($accredAttente)==0) echo '<br/>Aucune demande en cours.' ?>
				
				<?php foreach($accredAttente as $demande): ?>
				
				<div class="ligneAccred close">
					
					<div class="fixe">
						<span class="date"><?php echo display_date($demande['accred']->dateaccreditation); ?></span>
						<span class="categorie"><?php echo $demande['accred']->libellecategorie; ?></span>
						<span class="evenement"><?php echo $demande['accred']->libelleevenement; ?></span>
					</div>
					
					<form class="editAccred">
						
						<div>
							<select name="evenement">
								<?php foreach($evenements as $evenement): ?>
								<option value="<?php echo $evenement->idevenement; ?>" <?php echo ($demande['accred']->idevenement == $evenement->idevenement)? 'selected' : ''; ?>><?php echo $evenement->libelleevenement; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div>
							
							<input type="text" value="t'es qui toi ?"/>
							
							<select name="categorie">
								<?php foreach($categories as $categorie): ?>
								<option value="<?php echo $categorie['db']->idcategorie; ?>" <?php echo ($demande['accred']->idcategorie == $categorie['db']->idcategorie)? 'selected' : ''; ?>>
									<?php repeat('- ', $categorie['depth']); ?><?php echo $categorie['db']->libellecategorie; ?>
								</option>
								<?php endforeach; ?>
							</select>
							
						</div>
						
						<table class="choixZones">
							<thead>
								<tr>
									<?php foreach($demande['allZones'] as $zone): ?>
									<td><?php echo $zone->codezone; ?></td>
									<?php endforeach; ?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php foreach($demande['allZones'] as $zone): ?>
									<td><input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" <?php echo (zoneIsIn($zone, $demande['zones']))? 'checked': '' ; ?> /></td>
									<?php endforeach; ?>
								</tr>
							</tbody>
						</table>
						
						<input type="submit" value="Enregistrer" />
						
						<div class="clear"></div>
						
					</form>
					
				</div>
				
				<?php endforeach; ?>
				
				
				<h3>Historique</h3>
				
				<?php if(count($accredValide)==0) echo '<br/>Aucune accréditation.' ?>
				
				<?php foreach($accredValide as $accred): ?>
					<div class="ligneAccred close">
						
						<div class="fixe">
							<span class="date"><?php echo display_date($accred['accred']->dateaccreditation); ?></span>
							<span class="categorie"><?php echo $accred['accred']->libellecategorie; ?></span>
							<span class="evenement"><?php echo $accred['accred']->libelleevenement; ?></span>
						</div>
						
						<div class="detailZones">
							Zones :
							
							<?php foreach($accred['zones'] as $z): ?>
								<?php echo $z->idzone; ?> 
							<?php endforeach; ?>
							
						</div>
					</div>
				<?php endforeach; ?>
				
			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>