<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="<?php echo site_url('accreditation/ajout'); ?>">Ajouter</a>
		<a href="#" class="current">Voir</a>
    </div>

    <div class="box-full">

        <aside>
           
            <b>Options :</b>
			<ul>
				<li>Modifier</li>
				<li>Retour</li>
			</ul>
			
			<b>Actions :</b>
			<ul>
				<li>Ajouter</li>
			</ul>

        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client">
				
				<div class="photo">
					
					<div class="simulPhoto"></div>
					
					<div class="optionPhoto">
						<a href="#">UPLOAD</a>
						<a href="#">PRENDRE</a>
					</div>
					
				</div>
				
				<form class="infos">
					
					<input type="text" class="nom" init="<?php echo $client->nom.' '.$client->prenom; ?>" value="<?php echo $client->nom.' '.$client->prenom; ?>">
					
					<select class="pays" init="<?php echo $client->pays; ?>"
							style="background: url(<?php echo img_url('drapeaux/'.strtolower($client->pays).'.gif'); ?>) no-repeat left; padding-left: 15px">
						
					<?php foreach($pays as $p): ?>
						<option value="<?php echo $p->idpays; ?>" style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ?>><?php echo $p->nompays; ?></option>
					<?php endforeach; ?>
					
					</select>
					
					<input type="text" class="organisme" init="<?php echo $client->organisme; ?>" value="<?php echo $client->organisme; ?>">
					<input type="text" class="role" init="<?php echo $client->role; ?>" value="<?php echo $client->role; ?>">
					
					<input type="text" class="tel" init="<?php echo $client->tel; ?>" value="<?php echo $client->tel; ?>">
					<input type="text" class="email" init="<?php echo $client->mail; ?>" value="<?php echo $client->mail; ?>">
					
					<input type="submit" class="valideInfos" value="Enregistrer les modifications" />
					
				</form>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="listeAccred">
				
				<h3>En cours</h3>
				
				<form class="accredForm">
					
				</form>
				
				<div class="ligneAccred close">
					<span class="date">2012-02-16</span>
					<span class="categorie">Press TV</span>
					<span class="evenement">Coupe du monde de saut à ski</span>
					<span class="etat">Demande</span>
					
					<form class="editAccred">
						
						<div>
							<select>
								<option>Choisir un évènement </option>
							</select>
						</div>
						
						<div>
							<input type="text" />
							<select>
								<option>Choisir une catégorie </option>
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
				
				
				<h3>Historique</h3>
				
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