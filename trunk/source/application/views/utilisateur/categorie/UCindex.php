<h1>Catégories</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('categorie/liste'); ?>" class="current">Liste</a>
    </div>

    <div class="box-full">
		
		<aside>
			<a href="#">Nouvelle catégorie mère</a>
        </aside>

        <div id="main">
        	
			<table class="liste categorieAllInOne">
                <thead>
					
					<tr>
						<th>Catégories</th>
						<th colspan="3">Actions</th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($resultats as $categorie): ?>
					<tr>
			
						<td>
							<?php echo repeat('- ', $categorie['depth']); ?> 
							<form method="post" action="#" class="disabled" data="<?php echo $categorie['db']->idcategorie?>">
								<input type="hidden" name="id" value="<?php echo $categorie['db']->idcategorie?>" />
								<input type="text" name="libelle" value="<?php echo $categorie['db']->libellecategorie?>" readonly />
								<input type="submit" value="valider" />
							</form>
						</td>
						
						<td class="little"><a href="#">Ajouter sous-catégorie</a></td>
						
						<td class="icon"><a href="#" class="modifCat" data="<?php echo $categorie['db']->idcategorie?>"><?php echo img('b_edit.png', 'Modifier'); ?></a></td>
						
						<td class="icon">
<a href="<?php echo site_url('categorie/supprimer/'.$categorie['db']->idcategorie ); ?>"
confirm='Êtes-vous sûr de vouloir supprimer cette catégorie ?
Cela entrainera la suppression de toutes ses sous-catégories.'><?php echo img('b_drop.png', 'Supprimer'); ?></a>
						</td>
				   
				  </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>