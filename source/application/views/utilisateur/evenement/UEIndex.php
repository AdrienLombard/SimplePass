<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="" class="current">Liste</a>
        <a href="<?php echo site_url('evenements/ajout'); ?>">Ajouter</a>
    </div>

    <div class="box-full">

        <aside>

            <b>Filtres :</b>
            <ul>
                <li><a href="#">Tous</a></li>
                <li><a href="#">A valider</a></li>
                <li><a href="#">Validé</a></li>
            </ul>

            <br><br>

            <b>Rechercher :</b><br>
            <input type="text" class="search">

        </aside>

        <div id="main">
            <table class="liste" cellspacing="0">
                <thead>
					<tr>
						<th>Nom</th>
						<th>Début</th>
						<th>Fin</th>
						<th></th>
					</tr>
                </thead>
                <tbody>
					
                    <?php foreach ($resultats as $evenement):{  ?>
					<tr>
			
						<td><?php echo $evenement->libelleevenement?></td>
                        
                        <td><?php echo $evenement->datedebut?> </td> 
						
                        <td><?php echo $evenement->datefin?> </td>
					    <input type="hidden" value="<?php echo $evenement->idevenement; ?>" name="id" />
						<td><a href="<?php echo site_url('evenements/voir/'.$evenement->idevenement ); ?>">Voir<a></td>
				   
				  </tr>
                    <?php } endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>