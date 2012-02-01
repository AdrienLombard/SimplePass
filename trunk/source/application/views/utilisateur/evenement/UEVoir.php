<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenements/index'); ?>">Liste</a>
        <a href="<?php echo site_url('evenements/ajout'); ?>">Ajouter</a>
		<a href="#" class="current">Détails</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
            <ul>
                
				<li><a href="<?php echo site_url('evenements/modification/'.$id); ?>">Modifier</a></li>
                <li><a href="<?php   echo site_url('evenements/supprimer/'.$id);?>">Supprimer</a></li>
            </ul>

        </aside>

        <div id="main">
            <?php foreach ($resultats as $resultat):{?>
			<h2><?php echo $resultat->libelleevenement?></h2>
			
			<table class="details">
				<tr>
					<th>Date début</th>
					<td><?php echo $resultat->datedebut?></td>
				</tr>
				<tr>
					<th>Date fin</th>
					<td><?php echo $resultat->datefin?></td>
				</tr>
				<?php } endforeach; ?>
			</table>
			
        </div>

        <div class="clear"></div>

    </div>

</div>