<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" class="current">Liste</a>
		<a href="<?php echo site_url('accreditation/demandes'); ?>">Demandes</a>
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
						<th></th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($accreds as $accred): ?>
					<tr>
						<td><?php echo $accred->nom . ' ' . $accred->prenom ?></td>
						<td><?php echo $accred->pays ?></td>
                        <td><?php echo display_date($accred->dateaccreditation); ?></td>
						<td><?php echo $accred->libellecategorie; ?></td>
						<td><a href="<?php echo site_url('accreditation/voir/' . $accred->idclient); ?>">Voir</a></td>
					</tr>
                    <?php endforeach; ?>
					
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>