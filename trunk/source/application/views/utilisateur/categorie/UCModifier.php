<h1>Catégories</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('categorie/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('categorie/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Modifier</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
				<?php if($nom): ?>
					<a href="<?php echo site_url('categorie/voir/'.$id); ?>">Retour</a>
				<?php else: ?>
					<a href="<?php echo site_url('categorie/liste'); ?>">Retour</a>
				<?php endif; ?>
        </aside>

        <div id="main">
			<?php if($nom): ?>
				<form action="<?php echo site_url('categorie/exeModifier/'.$id); ?>" method="post">
					<h2><?php echo $nom?></h2>	
					<label>Nom catégorie</label>
					<input type="text" value="<?php echo $nom; ?>" name="nom"/>
					<input type="submit" name="valider" />
				</form>
			<?php else: ?>
				Cette catégorie n'existe pas.
			<?php endif; ?>
			
        </div>

        <div class="clear"></div>

    </div>

</div>