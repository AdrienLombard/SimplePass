<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('accreditation/index'); ?>">Recherche</a>
		<a href="<?php echo site_url('accreditation/index'); ?>" class="current">Liste</a>
		<a href="<?php echo site_url('accreditation/index'); ?>">Ajout</a>
		<a href="<?php echo site_url('accreditation/index'); ?>">Demandes</a>
    </div>

    <div class="box-full">

        <div id="main" class="nomargin">
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Personne</th>
						<th>Pays</th>
						<th>Catégorie</th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($accreditations as $accreditation): ?>
					<tr>
						<td><?php echo $accreditation->nom . ' ' . $accreditation->prenom ?></td>
						<td><?php echo $accreditation->pays ?></td>
                        <td><?php echo $accreditation->libellecategorie ?> </td>
					</tr>
                    <?php endforeach; ?>
					
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>