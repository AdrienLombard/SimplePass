<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenement/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('evenement/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Modifier</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
			<?php if(isset($nom)): ?>
				<a href="<?php echo site_url('evenement/voir/'.$id); ?>">Retour</a>
			<?php else: ?>
				<a href="<?php echo site_url('evenement/liste'); ?>">Retour</a>
			<?php endif; ?>

        </aside>

        <div id="main">
			<?php if(isset($nom)): ?>
				<form action="<?php echo site_url('evenement/exeModifier/'.$id); ?>" method="post">
					<h2><?php echo $nom?></h2>

					<label>Nom</label>
					<input type="text" value="<?php echo $nom; ?>" name="nom"/>

					<label>Date début</label>
					<input type="text" value="<?php echo display_date ($datedebut) ;?>" id="datepicker-debut" name="datedebut" READONLY="READONLY" />

					<label>Date fin</label>
					<input type="text" value="<?php echo display_date ($datefin) ;?>" id="datepicker-fin" name="datefin" READONLY="READONLY" />

					<br/><hr/><br/>
		</div>
		<div class="clear"></div>
		
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
											   <?php if($modeleEvenement) echo 'value="' . $zone->codezone . '"'; ?> />
									</td>
								<?php endforeach; ?>
							</tr>


							<?php if(isset($listeCategorie)): ?>
								<?php foreach ($listeCategorie as $categorie): ?>
								<tr class="ligneChoixZoneCat">

									<td style="padding-left: <?php echo ($categorie['depth'] * 20) + 10; ?>px">
										<?php echo $categorie['db']->libellecategorie; ?>
										<input type="hidden" 
											   value="<?php echo $categorie['db']->idcategorie; ?>" 
											   name="name[]" />
									</td>

									<?php foreach($listeZones as $zone): ?>

										<?php if(isset($listeCategorieZone[$categorie['db']->idcategorie][$zone->idzone])): ?>

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

					<input type="submit" name="valider" />
				</form>
			<?php else: ?>
				Cette évènement n'existe pas.
			<?php endif; ?>
			
        </div>

        <div class="clear"></div>

</div>