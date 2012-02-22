

<h1>Catégories</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('categorie/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('categorie/ajouter'); ?>" class="current">Ajouter</a>
    </div>

    <div class="box-full">
		
		<aside>
           
            <b>Options :</b>
            <ul>
				
				<?php if(isset($ajoute)):?>
				<li><span class="ajoute"><?php echo $ajoute; ?></span></li>
				<?php endif; ?>
				
                <li><a href="<?php echo site_url('categorie/liste'); ?>">Retour</a></li>
            </ul>

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
				 	<option value="<?php echo $categorie->idcategorie?> "><?php echo $categorie->libellecategorie?></option>
				<?php } endforeach; ?>
				</select>
				<br>
				
				<input type="submit" name="valider" />
			</form>
			 
        </div>

        <div class="clear"></div>

    </div>

</div>