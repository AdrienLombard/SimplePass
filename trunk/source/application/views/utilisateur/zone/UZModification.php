<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('zone/voir'); ?>">Liste</a>
        <a href="<?php echo site_url('zone/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Modifier</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
            <ul>
                <li><a href="<?php echo site_url('zone/voir/'.$id); ?>">Retour</a></li>
            </ul>

        </aside>

        <div id="main">
			
			<form action="<?php echo site_url('zone/exeModifier/'.$id); ?>" method="post">
				<h2><?php echo $libelle; ?></h2>
				
				<label>Nom</label>
				<input type="text" value="<?php echo $libelle; ?>" name="libelle"/>
				
				<input type="submit" name="valider" />
			</form>
			
        </div>

        <div class="clear"></div>

    </div>

</div>