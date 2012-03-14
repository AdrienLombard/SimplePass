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
									<span ref="FF0000" style="background: #FF0000">&nbsp;</span>
									<span ref="32CD32" style="background: #32CD32">&nbsp;</span>
									<span ref="C71585" style="background: #C71585">&nbsp;</span>
									<span ref="FF4500" style="background: #FF4500">&nbsp;</span>
									<span ref="FFFF00" style="background: #FFFF00">&nbsp;</span>
									<span ref="808000" style="background: #808000">&nbsp;</span>
									<span ref="008B8B" style="background: #008B8B">&nbsp;</span>
									<span ref="00FFFF" style="background: #00FFFF">&nbsp;</span>
									<span ref="0000FF" style="background: #0000FF">&nbsp;</span>
									<span ref="F4A460" style="background: #F4A460">&nbsp;</span>
									<span ref="A52A2A" style="background: #A52A2A">&nbsp;</span>
									<span ref="696969" style="background: #696969">&nbsp;</span>
									<span ref="BDB76B" style="background: #BDB76B">&nbsp;</span>
									<span ref="CD5C5C" style="background: #CD5C5C">&nbsp;</span>
									<span ref="9ACD32" style="background: #9ACD32">&nbsp;</span>
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