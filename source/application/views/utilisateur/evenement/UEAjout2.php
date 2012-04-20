<h1>Evènements</h1>

<div class="wrap">
	
	<div class="tabs">
        <a href="<?php echo site_url('evenement/liste'); ?>" >Liste</a>
        <a href="<?php echo site_url('evenement/ajouter'); ?>" class="current">Ajouter</a>
    </div>
	
	<div class="box-full">

		<div id="main" class="nomargin">			
			
			<form action="<?php echo site_url('evenement/exeDonnees/' . $id); ?>" method="post">
			
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
						<td class="titreCodeDeLaZone">Code de la zone :</td>
						<?php foreach($listeZones as $zone): ?>
							<td>
								<input type="text" 
									   maxlength="3" 
									   name="<?php echo 'code_' . $zone->idzone; ?>" 
									   zone="<?php echo $zone->idzone; ?>" 
									   class="codeZone" 
									   <?php if($modeleEvenement) echo 'value="' . $zone->codezone . '"'; ?> />
							</td>
						<?php endforeach; ?>
					</tr>
					
					
					<?php if(isset($listeCategorie)): ?>
						<?php foreach ($listeCategorie as $categorie): ?>
						<tr class="ligneChoixZoneCat">

							<td>
								<?php repeat('- ', $categorie['depth']) ?> <?php echo $categorie['db']->libellecategorie; ?>
								<input type="hidden" 
									   value="<?php echo $categorie['db']->idcategorie; ?>" 
									   name="name[]" />
 							</td>

							<?php foreach($listeZones as $zone): ?>
								
								<?php if(isset($listeCatgorieZone[$categorie['db']->idcategorie][$zone->idzone])): ?>
									
									<td>
										<input type="checkbox"
											   name="<?php echo $categorie['db']->idcategorie . '_' . $zone->idzone; ?>"
											   cat="<?php echo $categorie['db']->idcategorie; ?>"
											   zone="<?php echo $zone->idzone; ?>"
											   checked="checked"/>
									</td>
								
								<?php else: ?>
								
									<td>
										<input type="checkbox"
											   name="<?php echo $categorie['db']->idcategorie . '_' . $zone->idzone; ?>"
											   cat="<?php echo $categorie['db']->idcategorie; ?>"
											   zone="<?php echo $zone->idzone; ?>" />
									</td>
								
								<?php endif; ?>

							<?php endforeach; ?>

						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					
				</tbody>
			</table>
			
			<input type="submit" name="valider" value="Sauvegarder" />
			
			</form>
			
			
			
			
		</div>

		<div class="clear"></div>

	</div>

</div>