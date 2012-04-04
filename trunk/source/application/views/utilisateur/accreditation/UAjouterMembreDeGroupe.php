<script type="text/javascript">

	$(document).ready(function(){

	var nbLigne = 0;
	
	$('.ajoutNbPersonne').click(function(){
		
		var insert = '<table id="tableauPersonne">';
		insert +=		'<tr>';
		insert +=			'<td>Nom : <input type="text" id="nom" name="personne[nbLigne][nom]"  style="text-transform: uppercase"  /></td>';
		insert +=			'<td>Prénom : <input type="text" id="prenom" name="personne[nbLigne][prenom]" /></td>';
		insert +=			'<td>Fonction : <input type="text" id="fonction" name="personne[nbLigne][fonction]" /></td>';
		insert +=		'</tr>'
		insert +=	'</table>';
		
		var pattern = insert.replace(/nbLigne/g, nbLigne);
		$('#insererligne').append(pattern);
		
		nbLigne++;
		
	});
	
	
	
	
	$('#imprimer').live('click', function(){
		
		// récupère le parent : div.form
		var parent = $(this).parent().parent();
		// récupère le nom
		var nom = parent.find('#nompersonne');
		// récupère le prenom
		var prenom = parent.find('#prenompersonne');
	    var erreur = false;
		if(nom.val() == '') {
			erreur = true;
			nom.addClass('erreur');
		}
		if(prenom.val() == '') {
			erreur = true;
			prenom.addClass('erreur');
		}
	});
   });
	
</script>
<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>" >Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Ajouter personne</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" class="current" >Ajouter groupe</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/index'); ?>">Retour</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeAjoutGroupe'); ?>">
					
					<input type="hidden" name="evenement" value="<?php echo $this->session->userdata('idEvenementEnCours'); ?>"/>
                   
                   <div class="inputs no-margin">
					
						<h2> Informations générales </h2>
						
						<div>
							<label>Groupe : </label>
							<input type="text" name="info[groupe]" value="" class="nom" value="" />
						</div>
						
						<div>
							<label>Société : </label>
							<input type="text" name="info[societe]" value="" class="nom" value="" />
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="info[tel]" class="tel" value=""  />
						</div>
						
						<div>
							<label>Mail : </label>
							<input type="text" name="info[mail]" class="mail" value=""  />
						</div>
						
						
						<div>
							
							<label>Pays : </label>
							<select class="pays" name="info[pays]" style="padding-left: 0px;">

							<?php foreach($pays as $p): ?>
								<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == 'FRA')? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;"><?php echo $p->nompays; ?></option>
							<?php endforeach; ?>

							</select>
						</div>

						
						<div>
							<label>Catégorie : </label>
							<select name="info[categorie]">
								<option value="">---</option>
								<?php foreach($categories as $categorie): ?>
								<option value="<?php echo $categorie['cat']->idcategorie; ?>" zone="<?php echo $categorie['zones']; ?>">
									<?php echo $categorie['cat']->libellecategorie; ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="contientZones">
							<label>Zones : </label>
							<div>
								<?php foreach($zones as $zone): ?>
								<div class="checkzone" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->idzone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" />
								</div>
								<?php endforeach; ?>
							</div>
						</div>

						<div class="clear"></div>
						
					</div>

					<h2>Référent</h2>

					<table id="tableauReferent">
						<tr>
							<td>Nom : <input type="text" id="nom" name="ref[nom]"  style="text-transform: uppercase" /></td>
							<td>Prénom : <input type="text" id="prenom" name="ref[prenom]" /></td>
							<td>Fonction : <input type="text" id="fonction" name="ref[fonction]" /></td>
						</tr>
					</table>
					
					<br><br>
					
					<h2>Personnes</h2>
					
					<div id="insererligne"></div>

					<span class="button ajoutNbPersonne">+</span>
					
					<br>
				
					<div style="text-align: right">
						<input type="submit" value="Valider" />
					</div>
				
				</form>

			</div>
	
        <div class="clear"></div>

    </div>
		
</div>