<h1>Zones</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('zone/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('zone/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Modifier</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
				<?php if($libelle): ?>
					<a href="<?php echo site_url('zone/voir/'.$id); ?>">Retour</a>
				<?php else: ?>
					<a href="<?php echo site_url('zone/liste'); ?>">Retour</a>
				<?php endif; ?>
        </aside>

        <div id="main">
			<?php if($libelle): ?>
				<form action="<?php echo site_url('zone/exeModifier/'.$id); ?>" method="post">
					<h2><?php echo $libelle; ?></h2>

					<label>Nom</label>
					<input type="text" value="<?php echo $libelle; ?>" name="libelle"/>

					<input type="submit" name="valider" />
				</form>
			<?php else: ?>
				Cette zone n'existe pas.
			<?php endif; ?>
        </div>

        <div class="clear"></div>

    </div>

</div>