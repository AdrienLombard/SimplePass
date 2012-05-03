<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenement/liste'); ?>" class="current">Liste</a>
        <a href="<?php echo site_url('evenement/ajouter'); ?>">Ajouter</a>
    </div>

    <div class="box-full">

        <div id="main" class="nomargin">
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Nom</th>
						<th>Début</th>
						<th>Fin</th>
						<th></th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($resultats as $evenement): ?>
					<tr>
			
						<td><?php echo $evenement->libelleevenement?></td>
                        
                        <td><?php echo display_date($evenement->datedebut)?> </td> 
						
                        <td><?php echo display_date($evenement->datefin)?> </td>

						<td><a href="<?php echo site_url('evenement/voir/'.$evenement->idevenement ); ?>">Voir</a></td>
				   
				  </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>