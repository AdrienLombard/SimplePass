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
								<input type="hidden" name="couleur" />
								
								<input type="text" name="libelle" init="<?php echo $categorie['db']->libellecategorie?>" value="<?php echo $categorie['db']->libellecategorie?>" readonly />
								
								<span class="colorpicker" init="">&nbsp;</span>
								
								<div class="hide picker">
									<span ref="ffffff" style="background: #ffff99">&nbsp;</span>
									<span ref="ffffff" style="background: #ff99ff">&nbsp;</span>
									<span ref="ffffff" style="background: #ffffff">&nbsp;</span>
									<span ref="ffffff" style="background: #99ffff">&nbsp;</span>
									<span ref="ffffff" style="background: #9999ff">&nbsp;</span>
									<span ref="ffffff" style="background: #ff9999">&nbsp;</span>
									<span ref="ffffff" style="background: #999999">&nbsp;</span>
									<span ref="ffffff" style="background: #f9f9f9">&nbsp;</span>
								</div>
								
								<input type="submit" value="valider" />
							</form>
						</td>
						
						<td class="icon">
							<div class="icons add"></div>
						</td>
						
						<td class="icon">
							<div class="modifCat icons update" data="<?php echo $categorie['db']->idcategorie?>"></div>
						</td>
						
						<td class="icon">
<a href="<?php echo site_url('categorie/supprimer/'.$categorie['db']->idcategorie ); ?>" class="icons delete"
confirm='Êtes-vous sûr de vouloir supprimer cette catégorie ?
Cela entrainera la suppression de toutes ses sous-catégories.'></a>
						</td>
				   
				  </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>