<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" class="current">Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>">Ajouter individuel</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>">Ajouter groupe</a>
    </div>

    <div class="box-full">

        <aside>  
			<a href="<?php echo site_url('export/accreds/'.$this->session->userdata('idEvenementEnCours')); ?>">Exporter</a>
			<input type="checkbox" id="simple" checked />Simple </br>
			<input type="checkbox" id="groupe" checked />Groupe </br>
			<input type="checkbox" id="valide" checked />Validé </br>
			<input type="checkbox" id="demande" checked />Demande </br>
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
					<tr class="<?php 
						if($accred->groupe == null) echo "simple "; else echo "groupe ";
						if($accred->etataccreditation == ACCREDITATION_VALIDE) echo " valide"; else echo " demande"; 
						?>" >
						<td><?php echo $accred->nom . ' ' . $accred->prenom ?></td>
						<td><?php if (isset($accred->groupe) && !empty($accred->groupe) && $accred->groupe != "") echo $accred->groupe; else echo " - "; ?></td>
						<td><?php echo $accred->pays ?></td>
                        <td><?php echo display_date($accred->dateaccreditation); ?></td>
						<td><?php echo $accred->libellecategorie; ?></td>
						<td><?php if($accred->etataccreditation == 0) echo "validée"; else echo "demande"; ?></td>
						<td><?php if($accred->groupe == null): ?>
							<a href="<?php echo site_url('accreditation/voir/' . $accred->idclient); ?>">Voir</a></td>
							<?php else: ?>
							<a href="<?php echo site_url('accreditation/voirEquipe/' . $accred->groupe); ?>">Voir Groupe</a></td>
							<?php endif; ?>
					</tr>
                    <?php endforeach; ?>
					
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>