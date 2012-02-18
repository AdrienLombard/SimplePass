<h1>Zones</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('zone/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('zone/ajouter'); ?>" class="current">Ajouter</a>
    </div>

    <div class="box-full">
		
		<aside>
           
            <b>Options :</b>
            <ul>
                <li><a href="<?php echo site_url('zone/liste'); ?>">Retour</a></li>
            </ul>

        </aside>

        <div id="main">
			
			<form action="<?php echo site_url('zone/exeAjouter'); ?>" method="post">
				
				<h2>Nouvelle zone</h2>
				
				<label>Nom</label>
				<input type="text" name="libelle" value="<?php if($info) echo $info->libelle; ?>" />
				
				<input type="submit" name="valider" />
				
			</form>
			 
        </div>

        <div class="clear"></div>

    </div>

</div>