<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" class="current">Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>">Ajouter personne</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>">Ajouter groupe</a>
    </div>

    <div class="box-full">

        <aside>  
		<!--<a href="<?php echo site_url('accreditation/generer'); ?>">Exporter un fichier excel</a>-->	
        </aside>
		
		<div id="main">
        	
			<table class="liste">
                <thead>
					
					<tr>
						<th>Personne</th>
						<th>Groupe</th>
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
						<td><?php if (isset($accred->groupe) && !empty($accred->groupe) && $accred->groupe != "") echo $accred->groupe; else echo " - "; ?></td>
						<td><?php echo $accred->pays ?></td>
                        <td><?php echo display_date($accred->dateaccreditation); ?></td>
						<td><?php echo $accred->libellecategorie; ?></td>
						<td><?php if($accred->etataccreditation == 0) echo "validée"; else echo "demande"; ?></td>
						<td><a href="<?php echo site_url('accreditation/voir/' . $accred->idclient); ?>">Voir</a></td>
					</tr>
                    <?php endforeach; ?>
					
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>