<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" class="current">Liste</a>
		<a href="#">Demandes</a>
		<a href="<?php echo site_url('accreditation/ajouter'); ?>">Ajouter</a>
    </div>

    <div class="box-full">

        <aside>
           
            <b>Recherche :</b>
			<input type="text" class="search" />

        </aside>
		
		<div id="main">
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Personne</th>
						<th>Pays</th>
						<th>Date</th>
						<th>Catégorie</th>
						<th>Etat</th>
						<th></th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($accreds as $accred): ?>
					<tr>
						<td><?php echo $accred->nom . ' ' . $accred->prenom ?></td>
						<td><?php echo $accred->pays ?></td>
                        <td></td>
						<td><?php echo $accred->libellecategorie; ?></td>
						<td><?php echo ($accred->etataccreditation == 1)? 'Demande' : 'Validée' ?> </td>
						<td><a href="<?php echo site_url('accreditation/voir/' . $accred->idclient); ?>">Voir</a></td>
					</tr>
                    <?php endforeach; ?>
					
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>