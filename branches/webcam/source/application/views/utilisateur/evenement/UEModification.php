<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenement/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('evenement/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Modifier</a>
    </div>

    <div class="box-full">
		
		<aside>

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
					<input type="text" value="<?php echo $nom; ?>" name="nom" style="width: 80%"/>
					<?php if(isset($info->erreurNom)) echo '<span class="erreurMessage" >* ' . $info->erreurNom . '</span>'; ?>

					<label>Date début</label>
					<input type="text" value="<?php echo display_date ($datedebut) ;?>" id="datepicker-debut" name="datedebut" READONLY="READONLY" />

					<label>Date fin</label>
					<input type="text" value="<?php echo display_date ($datefin) ;?>" id="datepicker-fin" name="datefin" READONLY="READONLY" />
					<?php if(isset($info->erreurDate)) echo '<span class="erreurMessage" >* ' . $info->erreurDate . '</span>'; ?>
					
					<label>Texte à ajouter au mail de confirmation (Facultatif)</label>
					<textarea cols="80" rows="5" wrap="soft" name="textmail" ><?php echo $textmail; ?></textarea>
		</div>
		
		<div class="clear"></div>
		
		<br><br>

		<table class="listeCategorieEvent">

			<thead>
				<th></th>
				<?php foreach($listeZones as $zone): ?>
				<th class="rotate">
					<div class="itemRotate" zone="<?php echo $zone->idzone; ?>" <?php echo is_null($zone->enable)? 'style="color: #CCC;"':''; ?>>
						<?php echo $zone->libellezone; ?>
					</div>
				</th>
				<?php endforeach; ?>
				<th class="rotate"><div class="itemRotate"></div></th>
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
							   <?php if($modeleEvenement) echo 'value="' . $zone->codezone . '"'; ?>
							   <?php echo is_null($zone->enable)? 'disabled value="" style="background: #CCC; opacity: 0.5;"':''; ?> />
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

						<?php if(isset($listeCategorieZone[$categorie['db']->idcategorie][$zone->idzone])): ?>
							<td>
								<input type="checkbox"
									   <?php echo is_null($zone->enable)? 'style="opacity: 0.5;"':''; ?>
									   name="<?php echo $categorie['db']->idcategorie . '_' . $zone->idzone; ?>"
									   cat="<?php echo $categorie['db']->idcategorie; ?>"
									   zone="<?php echo $zone->idzone; ?>"
									   checked="checked"/>
							</td>
						<?php else: ?>
							<td>
								<input type="checkbox"
									   <?php echo is_null($zone->enable)? 'style="opacity: 0.5;"':''; ?>
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

				<input type="submit" class="button" style="float: right; margin-top: 20px;" name="valider" value="Enregistrer" />
			</form>
		<?php else: ?>
			Cette évènement n'existe pas.
		<?php endif; ?>

	<div class="clear"></div>

</div>