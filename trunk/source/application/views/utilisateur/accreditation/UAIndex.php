<h1>Accréditation</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('accreditation/index'); ?>" class="current">Liste des demandes</a>
    </div>

    <div class="box-full">

        <div id="main" class="nomargin">
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Nom</th>
						<th>Prénom</th>
						<th>pays</th>
						<th>Catégorie</th>
					</tr>
					
                </thead>
                <tbody>
					
                    <?php foreach ($accreditations as $accreditation): ?>
					<tr>
						<td><?php echo $accreditation->nom ?></td>
                        <td><?php echo $accreditation->prenom ?></td> 
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