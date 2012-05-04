<script type="text/javascript" >
    
    function urlExport() {

	    var url = "<?php echo site_url('export/accreds/'.$this->session->userdata('idEvenementEnCours')); ?>";
	    var params = '/';

	    params += ($("#simple").attr('checked'))? '1' : '0';
	    params += ($("#groupe").attr('checked'))? '1' : '0';
	    params += ($("#valide").attr('checked'))? '1' : '0';
	    params += ($("#demande").attr('checked'))? '1' : '0';

	    $('.toExport').attr('href',  url + params);

    }
	
</script>

<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" class="current">Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>">Individuelles</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>">Groupes</a>
    </div>

    <div class="box-full">

        <aside>  
	    <a href="<?php echo site_url('export/accreds/'.$this->session->userdata('idEvenementEnCours').'/1111'); ?>"class="toExport">Exporter</a>
        </aside>
		
		<div id="main">
		    
		    <div>
			
			<div class="titre-supra-checkbox">Filtres :</div>
			
			<div class="supra-checkbox checked" data="simple">Individuelles
			    <input type="checkbox" id="simple" checked />
			</div>
			
			<div class="supra-checkbox right checked" data="groupe">Groupes
			    <input type="checkbox" id="groupe" checked />
			</div>
			
			<div class="supra-checkbox checked" data="valide">Validées
			    <input type="checkbox" id="valide" checked />
			</div>
			
			<div class="supra-checkbox right checked" data="demande">Demandes
			    <input type="checkbox" id="demande" checked />
			</div>
			
		    </div>
        	
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
					<?php if(!empty($accreds)): ?>
                    <?php foreach ($accreds as $accred): ?>
					<tr data="<?php echo ($accred->groupe == null)? "simple" : "groupe"; ?>:<?php echo ($accred->etataccreditation == ACCREDITATION_VALIDE)? "valide" : "demande"; ?>" >
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
					<?php else: ?>
					<tr>
						<td colspan="7" class="bddVide" >Pas d'accréditations pour cet évènement</td>
					</tr>
					<?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>