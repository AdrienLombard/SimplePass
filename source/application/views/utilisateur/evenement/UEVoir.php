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
                
				<li><a href="<?php echo site_url('evenement/modifier/'.$id); ?>">Modifier</a></li>
                <li><a href="<?php echo site_url('evenement/supprimer/'.$id);?>" confirm="Êtes-vous sûr de vouloir supprimer cet évènement ?">Supprimer</a></li>
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
			
        </div>

        <div class="clear"></div>

    </div>

</div>