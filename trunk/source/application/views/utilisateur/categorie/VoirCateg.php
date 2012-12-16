<h1>Catégories</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('categorie/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('categorie/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Détails</a>
    </div>

    <div class="box-full">
		
		<aside>

			<?php if($nom): ?>
				<a href="<?php echo site_url('categorie/modifier/'.$id); ?>">Modifier</a>
				<a href="<?php echo site_url('categorie/supprimer/'.$id);?>" confirm="Êtes-vous sûr de vouloir supprimer cette catégorie et ses sous-catégories ?">Supprimer</a>
			<?php endif; ?>
			<a href="<?php echo site_url('categorie/liste'); ?>">Retour</a>

        </aside>

        <div id="main">
			
			<?php if($nom): ?>
				<h2><?php echo $nom[0]->libellecategorie ?></h2>

				<table class="details">
					<?php if($resultats): ?>
						<?php foreach ($resultats as $categorie): ?>

							<tr>
								<th><strong> Sous-Catégorie </strong></th>
								<td><?php echo $categorie->libellecategorie?></td>
								<td><a href="<?php echo site_url('categorie/voir/'.$categorie->idcategorie ); ?>">Voir</a></td>
							</tr>

						<?php endforeach; ?>
					<?php else: ?>
							<tr>
								<td>Cette catégorie ne contient aucune sous-catégorie.</td>
							</tr>
					<?php endif; ?>

				</table>
			<?php else: ?>
				Cette catégorie n'existe pas.
			<?php endif; ?>
			
        </div>

        <div class="clear"></div>

    </div>

</div>