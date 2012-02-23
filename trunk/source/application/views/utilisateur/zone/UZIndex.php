<h1>Zones</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('zone/liste'); ?>" class="current">Liste</a>
        <a href="<?php echo site_url('zone/ajouter'); ?>">Ajouter</a>
    </div>

    <div class="box-full">

        <div id="main" class="nomargin">
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Nom</th>
						<th> </th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($resultats as $zone): ?>
					<tr>
					
						<td><?php echo $zone->libellezone; ?></td>
						
						<td><a href="<?php echo site_url('zone/voir/'.$zone->idzone ); ?>">Voir</a></td>
				  </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>