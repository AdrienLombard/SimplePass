<h1>Zones</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('zone/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('zone/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Détails</a>
    </div>

    <div class="box-full">
		
		<aside>
			<?php if($resultats): ?>
				<a href="<?php echo site_url('zone/modifier/'.$id); ?>">Modifier</a>
				<a href="<?php echo site_url('zone/supprimer/'.$id);?>" confirm="Êtes-vous sûr de vouloir supprimer cet zone ?">Supprimer</a>
			<?php endif; ?>
			<a href="<?php echo site_url('zone'); ?>">Retour</a>
        </aside>

        <div id="main">
			<?php if($resultats): ?>
				<?php foreach ($resultats as $resultat): ?>
					<h2><?php echo $resultat->libellezone; ?></h2>
				<?php endforeach; ?>
			<?php else: ?>
				Cette zone n'éxiste pas.
			<?php endif; ?>
			
			<?php
			// <table class="details">
			// </table>
			?>
        </div>

        <div class="clear"></div>

    </div>

</div>