<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" class="current">Liste</a>
		<a href="<?php echo site_url('accreditation/index'); ?>">Demandes</a>
		<a href="<?php echo site_url('accreditation/ajout'); ?>">Ajouter</a>
    </div>

    <div class="box-full">

        <aside>
           
            <b>Recherche :</b>
			<input type="text" class="search" />
			
			<b>Evènement :</b><br />
            <select class="select">
				<option>Tous</option>
				<option>Champignon de mario</option>
			</select>

        </aside>
		
		<div id="main">
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Personne</th>
						<th>Pays</th>
						<th colspan="2">Dernière accréditation</th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($clients as $client): ?>
					<tr>
						<td><?php echo $client->nom . ' ' . $client->prenom ?></td>
						<td><?php echo $client->pays ?></td>
                        <td>Date</td>
						<td><?php echo ($client->etataccreditation == 1)? 'Demande' : $client->libellecategorie ?> </td>
					</tr>
                    <?php endforeach; ?>
					
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>