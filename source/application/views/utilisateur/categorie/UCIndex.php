<h1>Catégories</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('categorie/liste'); ?>" class="current">Liste</a>
    </div>

    <div class="box-full">
		
		<aside>
			<a href="#" class="afficheNouvelleCatMere">Nouvelle catégorie mère</a>
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
					
					<tr class="nouvelleCatMere">
			
						<td colspan="3">
							
							<form method="post" action="<?php echo site_url('categorie/exeAjouter') ?>" data="-1">
								
								<input type="hidden" name="surcategorie" value="-1" />
								
								Nouvelle catégorie mère : <input type="text" name="nom" class="required" />
								
								<span class="colorpicker" init="" colorId="-1" >
									<input type="hidden" name="couleur" />
									&nbsp;
								</span>
								
								<div class="hide picker" colorId="-1">
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
						<a href="#" class="icons delete deleteNouvelleCatMere"></a>
						</td>
						
					</tr>
					
                    <?php foreach ($resultats as $categorie): ?>
					
					<?php if($categorie['depth'] == 0): ?>
					<tr><td colspan="4"></td></tr>
					<?php endif; ?>
					
					<tr>
			
						<td style="border-left: 2px solid #<?php echo $categorie['db']->couleur?>">
							<?php if($categorie['depth'] != 0): ?>
								&nbsp;&nbsp;<?php echo repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $categorie['depth']-1); ?><span class="arbo">&#9492;</span>
							<?php endif; ?>
							<form method="post" action="<?php echo site_url('categorie/exeModifier'); ?>" class="disabled" data="<?php echo $categorie['db']->idcategorie?>">
								
								<input type="hidden" name="id" value="<?php echo $categorie['db']->idcategorie ?>" />
								<input type="hidden" name="surcategorie" value="<?php echo $categorie['db']->surcategorie?>" />
								
								<input type="text" class="required" name="nom" init="<?php echo $categorie['db']->libellecategorie?>" value="<?php echo $categorie['db']->libellecategorie?>" readonly />
								
								<?php if($categorie['db']->surcategorie == null): ?>
								<span class="colorpicker" init="" colorId="<?php echo $categorie['db']->idcategorie?>" style="background: #<?php echo $categorie['db']->couleur; ?>" >
									<input type="hidden" name="couleur" value="<?php echo $categorie['db']->couleur; ?>" />
									&nbsp;
								</span>
								
								<div class="hide picker" colorId="<?php echo $categorie['db']->idcategorie?>" >
									<span ref="FF0000" style="background: #FF0000">&nbsp;</span>
									<span ref="32CD32" style="background: #32CD32">&nbsp;</span>
									<span ref="C71585" style="background: #C71585">&nbsp;</span>
									<span ref="FF4500" style="background: #FF4500">&nbsp;</span>
									<span ref="FFD700" style="background: #FFD700">&nbsp;</span>
									<span ref="808000" style="background: #808000">&nbsp;</span>
									<span ref="008B8B" style="background: #008B8B">&nbsp;</span>
									<span ref="4169E1" style="background: #4169E1">&nbsp;</span>
									<span ref="4682B4" style="background: #4682B4">&nbsp;</span>
									<span ref="F4A460" style="background: #F4A460">&nbsp;</span>
									<span ref="A52A2A" style="background: #A52A2A">&nbsp;</span>
									<span ref="696969" style="background: #696969">&nbsp;</span>
									<span ref="BDB76B" style="background: #BDB76B">&nbsp;</span>
									<span ref="CD5C5C" style="background: #CD5C5C">&nbsp;</span>
									<span ref="9ACD32" style="background: #9ACD32">&nbsp;</span>
								</div>
								<?php else: ?>
								<input type="hidden" name="couleur" value="<?php echo $categorie['db']->couleur; ?>" />
								<?php endif; ?>
								
								<input type="submit" value="valider" />
							</form>
						</td>
						
						<td class="icon">
							<div class="addCat icons add" data="<?php echo $categorie['db']->idcategorie?>"></div>
						</td>
						
						<td class="icon">
							<div class="modifCat icons update" data="<?php echo $categorie['db']->idcategorie?>"></div>
						</td>
						
						<td class="icon">
<a href="<?php echo site_url('categorie/exeSupprimer/'.$categorie['db']->idcategorie ); ?>" class="icons delete"
confirm='Êtes-vous sûr de vouloir supprimer cette catégorie ?
Cela entrainera la suppression de toutes ses sous-catégories.'></a>
						</td>
				   
				  </tr>
				  
				  <tr class="nouvelleSousCat" data="<?php echo $categorie['db']->idcategorie?>">
					  
					  <td colspan="3">
							
						&nbsp;&nbsp;<?php echo repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $categorie['depth']); ?><span class="arbo">&#9492;</span>	
						  <form method="post" action="<?php echo site_url('categorie/exeAjouter') ?>" data="<?php echo $categorie['db']->idcategorie?>">
								
								<input type="hidden" name="surcategorie" value="<?php echo $categorie['db']->idcategorie?>" />
								<input type="hidden" name="couleur" value="<?php echo $categorie['db']->couleur ?>" />
								<input type="text" name="nom" class="required" />
								<input type="submit" value="valider" />
								
							</form>
							
						</td>
						
						<td class="icon">
						<a href="#" class="icons delete removeCat" data="<?php echo $categorie['db']->idcategorie?>"></a>
						</td>
					  
				  </tr>
				  
                  <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>