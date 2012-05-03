<h1>Zones</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('zone/liste'); ?>" class="current">Liste</a>
    </div>

    <div class="box-full">
		
		<!-- menu de gauche -->
		<aside>
			<a href="#" class="afficheNouvelleZone">Nouvelle Zone</a>
        </aside>
		
		<!-- Liste centrale -->
        <div id="main" >
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Nom</th>
						<th colspan="2" > </th>
					</tr>
					
                </thead>
                <tbody>
					<!-- système caché pour ajouter une nouvelle zone -->
					<tr class="nouvelleZone hide" >
						<td>
						<form action="<?php echo site_url('zone/exeAjouter'); ?>" method="POST" class="gestionZone" >
							Nom de la zone : 
							<input type="text" name="libelle" /> 
							<input type="submit" value="ajouter" />
							<input type="submit" value="annuler" />
						</form>
						</td>
						
						<td>
						</td>
					</tr>
					
                    <?php foreach ($resultats as $zone): ?>
					<tr>
					
						<td>
							<form action="<?php echo site_url('zone/exeModifier/'.$zone->idzone); ?>" method="POST" data="<?php echo $zone->idzone; ?>" class="gestionZone" disabled>
								<input type="text" readonly value="<?php echo $zone->libellezone; ?>" name="libelle" />
								<input class="hide" type="submit" value="enregistrer" />
							</form>
						</td>
						
						<td class="icon">
							<div class="modifZone icons update" data="<?php echo $zone->idzone; ?>"></div>
						</td>
						
						<td class="icon">
						<a 
							href="<?php echo site_url('zone/exeSupprimer/'.$zone->idzone); ?>" 
							class="icons delete"
							confirm='Êtes-vous sûr de vouloir supprimer cette zone ?'
						></a>
						</td>
						
				  </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>