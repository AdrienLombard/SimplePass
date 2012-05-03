<h1>Catégories</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('categorie/liste'); ?>" class="current">Liste</a>
        <a href="<?php echo site_url('categorie/ajouter'); ?>">Ajouter</a>
    </div>

    <div class="box-full">

        <div id="main" class="nomargin">
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Catégorie mère</th>
						<th></th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($resultats as $categorie): ?>
					<tr>
			
						<td><?php echo $categorie->libellecategorie?></td>
						<td><a href="<?php echo site_url('categorie/voir/'.$categorie->idcategorie ); ?>">Voir</a></td>
				   
				  </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>