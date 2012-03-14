

<h1>Catégories</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('categorie/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('categorie/ajouter'); ?>" class="current">Ajouter</a>
    </div>

    <div class="box-full">
		
		<aside>
			<a href="<?php echo site_url('categorie/liste'); ?>">Retour</a>
        </aside>

        <div id="main">
			
			<form action="<?php echo site_url('categorie/exeAjouter'); ?>" method="post">
				
				<h2>Nouvelle catégorie</h2>
				
				<label for="nom">Nom</label>
				<input type="text" name="nom" value="<?php if($info) echo $info->nom; ?>" />
				<label for="categories">Catégorie mère</label>
				<select name="categories">
					<option value="-1">Aucune</option> 
				<?php 
				  foreach ($categories as $categorie):{?>
				 	<option value="<?php echo $categorie['db']->idcategorie?> ">
				 		<?php for($i=0; $i<$categorie['depth']; $i++) echo '&#xA0;&#xA0;'; ?>
				 		<?php echo $categorie['db']->libellecategorie?>
				 	</option>
				<?php } endforeach; ?>
				</select>
				<br>
				
				<input type="submit" name="valider" />
			</form>
			 
        </div>

        <div class="clear"></div>

    </div>

</div>