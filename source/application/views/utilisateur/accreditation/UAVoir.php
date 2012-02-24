<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="<?php echo site_url('accreditation/ajout'); ?>">Ajouter</a>
		<a href="#" class="current">Voir</a>
    </div>

    <div class="box-full">

        <aside>
           
            <a href="#">Modifier la personne</a>
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
					
					<input type="text" name="nom" class="nom" init="<?php echo $client->nom; ?>" value="<?php echo $client->nom; ?>">
					<input type="text" name="prenom" class="prenom" init="<?php echo $client->prenom; ?>" value="<?php echo $client->prenom; ?>">

					<select class="pays" name="pays" init="<?php echo $client->pays; ?>"
							style="background: url(<?php echo img_url('drapeaux/'.strtolower($client->pays).'.gif'); ?>) no-repeat left; padding-left: 15px">
						
					<?php foreach($pays as $p): ?>
						<option value="<?php echo $p->idpays; ?>" style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ?>><?php echo $p->nompays; ?></option>
					<?php endforeach; ?>
					
					</select>
					
					<input type="text" name="tel" class="tel" init="<?php echo $client->tel; ?>" value="<?php echo $client->tel; ?>">
					<input type="text" name="mail" class="email" init="<?php echo $client->mail; ?>" value="<?php echo $client->mail; ?>">
					
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
					<span class="date"><?php echo display_date($demande->dateaccreditation); ?></span>
					<span class="categorie"><?php echo $demande->libellecategorie; ?></span>
					<span class="evenement"><?php echo $demande->libelleevenement; ?></span>
					
					<form class="editAccred">
						
						<div>
							<select name="evenement">
								<?php foreach($evenements as $evenement): ?>
								<option value="<?php echo $evenement->idevenement; ?>"><?php echo $evenement->libelleevenement; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div>
							<input type="text" />
							<select>
								<?php foreach($categories as $categorie): ?>
								<option value="<?php echo $categorie->idcategorie; ?>"><?php echo $categorie->libellecategorie; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<table class="choixZones">
							<thead>
								<tr>
									<td>01</td>
									<td>02</td>
									<td>03</td>
									<td>04</td>
									<td>05</td>
									<td>06</td>
									<td>07</td>
									<td>08</td>
									<td>09</td>
									<td>10</td>
									<td>11</td>
									<td>12</td>
									<td>13</td>
									<td>14</td>
									<td>15</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
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
						<span class="date"><?php echo $accred->dateaccreditation; ?></span>
						<span class="categorie"><?php echo $accred->libellecategorie; ?></span>
						<span class="evenement"><?php echo $accred->libelleevenement; ?></span>
						<div class="detailZones">
							Zones : 
							<?php foreach($listeZonesAccred[$accred->idaccreditation] as $zone => $value): ?>
								<?php echo $zone . ','; ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
				
			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>