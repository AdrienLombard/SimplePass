<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenement/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('evenement/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Détails</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
            <ul>
				<a href="<?php echo site_url('evenement/modifier/'.$id); ?>">Modifier</a>
				<a href="<?php echo site_url('evenement/supprimer/'.$id);?>" confirm="Êtes-vous sûr de vouloir supprimer cet évènement ?">Supprimer</a>
				<a href="<?php echo site_url('evenement/liste'); ?>">Retour</a>
			</ul>

        </aside>

        <div id="main">
            <?php foreach ($resultats as $resultat):{?>
			<h2><?php echo $resultat->libelleevenement?></h2>
			
			<table class="details">
				<tr>
					<th>Date début</th>
					<td><?php echo display_date($resultat->datedebut)?></td>
				</tr>
				<tr>
					<th>Date fin</th>
					<td><?php echo display_date($resultat->datefin)?></td>
				</tr>
				<?php } endforeach; ?>
			</table>
			
			<table class="listeCategorieEvent">
				<thead>
					<th></th>
					<?php foreach($listeZones as $zone): ?>
					
						<th class="rotate">
							<div class="itemRotate" zone="<?php echo $zone->idzone; ?>"><?php echo $zone->libellezone; ?></div>
						</th>
						
					<?php endforeach; ?>

						<th class="rotate">
							<div class="itemRotate"></div>
						</th>
				
				</thead>
				
				<tbody>
					
					<tr class="ligneCodeZone">
						<td class="titreCodeDeLaZone">code de la zone :</td>
						<?php foreach($listeZones as $zone): ?>
							<td>
								<input type="text" 
									   maxlength="3" 
									   name="<?php echo 'code_' . $zone->idzone; ?>" 
									   zone="<?php echo $zone->idzone; ?>" 
									   class="codeZone"
									   value="<?php echo $zone->codezone; ?>"
									   disabled="disabled" />
							</td>
						<?php endforeach; ?>
					</tr>
					
					<?php if(isset($listeCategorie)): ?>
						<?php foreach ($listeCategorie as $categorie): ?>
						<tr class="ligneChoixZoneCat">

							<td style="padding-left: <?php echo ($categorie['depth'] * 20) + 10; ?>px">
								<?php echo $categorie['db']->libellecategorie?>
							</td>

							<?php foreach($listeZones as $zone): ?>
								
								<?php if(isset($listeCatgorieZone[$categorie['db']->idcategorie][$zone->idzone])): ?>
									
									<td>
										<input type="checkbox"
											   name="<?php echo $categorie['db']->idcategorie . '_' . $zone->idzone; ?>"
											   cat="<?php echo $categorie['db']->idcategorie; ?>"
											   zone="<?php echo $zone->idzone; ?>"
											   checked="checked"
											   disabled="disabled" />
									</td>
								
								<?php else: ?>
								
									<td>
										
									</td>
								
								<?php endif; ?>

							<?php endforeach; ?>

						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					
				</tbody>
			</table>
			
        </div>

        <div class="clear"></div>

    </div>

</div>