<h1>Evènements</h1>

<div class="wrap">
	
	<div class="tabs">
        <a href="<?php echo site_url('evenement/liste'); ?>" >Liste</a>
        <a href="<?php echo site_url('evenement/ajouter'); ?>" class="current">Ajouter</a>
    </div>
	
	<div class="box-full">

		<div id="main" class="nomargin">

			<table class="listeZoneEvent">
				<tbody>
					
					<?php $compteur = 1; ?>
					
					<?php foreach ($listeZones as $zone): ?>
					<tr>
						
						<td><?php echo $compteur; ?>

						<td><?php echo $zone->libellezone?></td>

						<td><input type="text"  name="<?php echo $zone->idzone; ?>" size="4" value="<?php if(isset($zone->codezone)) echo $zone->codezone; ?>" /></td> 

						<td><input type="checkbox" name="<?php echo $zone->idzone; ?>" <?php if(isset($zone->codezone)) echo 'checked="checked"'; ?>/></td>

					</tr>
					
					<?php $compteur++; ?>
					
					<?php endforeach; ?>
					
				</tbody>
			</table>
			
			
			<table class="listeCategorieEvent">
				<thead>
					<?php $compteur = 1; ?>
					<th>--</th>
					<?php foreach($listeZones as $zone): ?>
					
						<th> <?php echo $compteur; ?> </th>
						
						<?php $compteur++; ?>
						
					<?php endforeach; ?>
				
				</thead>
				
				<tbody>
					
					
					<?php if(isset($listeCategorie)): ?>
						<?php foreach ($listeCategorie as $categorie): ?>
						<tr>

							<td><?php echo $categorie->libellecategorie?></td>

							<?php foreach($listeZones as $zone): ?>
								
								<?php if(isset($listeCatgorieZone[$categorie->idcategorie][$zone->idzone])): ?>
									
									<td><input type="checkbox"  name="<?php echo $categorie->idcategorie . '_' . $zone->idzone; ?>" checked="checked"/></td>
								
								<?php else: ?>
								
									<td><input type="checkbox"  name="<?php echo $categorie->idcategorie . '_' . $zone->idzone; ?>" /></td>
								
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