<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="<?php echo site_url('accreditation/demandes'); ?>">Demandes</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>">Ajouter</a>
		<a href="#" class="current">Voir</a>
    </div>

    <div class="box-full">

        <aside>
           
            <a href="#" class="editClient">Modifier la personne</a>
			<a href="<?php echo site_url('accreditation/nouvelle/'.$client->idclient); ?>">Nouvelle accréditation</a>

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
						<input type="text" name="nom" style="text-transform: uppercase" class="nom" init="<?php echo $client->nom; ?>" value="<?php echo $client->nom; ?>" readonly>
					</div>
					
					<div>
						<input type="text" name="prenom" class="prenom" init="<?php echo $client->prenom; ?>" value="<?php echo $client->prenom; ?>" readonly>
					</div>

					<div>
						<label class="short">Pays : </label>
						<select class="pays" name="pays" init="<?php echo $client->pays; ?>" style="padding-left: 0px;" disabled="disabled">

						<?php foreach($pays as $p): ?>
							<option value="<?php echo $p->idpays; ?>" style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ?>><?php echo $p->nompays; ?></option>
						<?php endforeach; ?>

						</select>
					</div>
					
					<div>
						<label class="short">Tel : </label>
						<?php echo '+'.$indicatif; ?><input type="text" name="tel" class="tel" init="<?php echo $client->tel; ?>" value="<?php echo $client->tel; ?>" readonly>
					</div>
					
					<div>
						<label class="short">Mail : </label>
						<input type="text" name="mail" class="email" init="<?php echo $client->mail; ?>" value="<?php echo $client->mail; ?>" readonly>
					</div>
					
					<input type="submit" class="valideInfos" value="Enregistrer les modifications" />
					
				</form>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="listeAccred">
				
				<h3>Demandes en cours</h3>
				
				<?php if(count($accredAttente)==0) echo '<br/>Aucune demande en cours.' ?>
				
				<?php foreach($accredAttente as $demande): ?>
				
				<div class="ligneAccred close">
					
					<a href="<?php echo site_url('accreditation/modifier/'.$demande['accred']->idaccreditation); ?>">
						<div class="fixe">
							<span class="date"><?php echo display_date($demande['accred']->dateaccreditation); ?></span>
							<span class="categorie"><?php echo $demande['accred']->libellecategorie; ?></span>
							<span class="evenement"><?php echo $demande['accred']->libelleevenement; ?></span>
						</div>
					</a>
					
				</div>
				
				<?php endforeach; ?>
				
				
				<h3>Historique des accréditations</h3>
				
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