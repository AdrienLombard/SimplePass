<h1>Catégories</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('categorie/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('categorie/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Détails</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
            <ul>
                
				<li><a href="<?php echo site_url('categorie/modifier/'.$id); ?>">Modifier</a></li>
                <li><a href="<?php echo site_url('categorie/supprimer/'.$id);?>" confirm="Êtes-vous sûr de vouloir supprimer cette catégorie et ses sous-catégories ?">Supprimer</a></li>
				<li><a href="<?php echo site_url('categorie/liste/'.$id); ?>">Retour</a></li>
            </ul>

        </aside>

        <div id="main">
			<?php foreach ($nom as $nom1):{?>
			<h2><?php echo $nom1->libellecategorie ?></h2>
			<?php } endforeach; ?>
            <?php foreach ($resultats as $categorie):{?>
			
			<table class="details">
				<tr>
					<th>Sous catégorie </th>
					<td><?php echo $categorie->libellecategorie?></td>
					<td><a href="<?php echo site_url('categorie/voir/'.$categorie->idcategorie ); ?>">Voir</a></td>
				</tr>
				
				<?php } endforeach; ?>
			</table>
			
        </div>

        <div class="clear"></div>

    </div>

</div>