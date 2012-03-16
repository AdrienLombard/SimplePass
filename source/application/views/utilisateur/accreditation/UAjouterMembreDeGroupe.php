<script type="text/javascript">

	$(document).ready(function(){

	var nbLigne = 1;
	$('a.ajoutNbPersonne').click(function(){
		var pattern = $('#zoneNouvellesPersonnes').html().replace(/nbLigne/g, nbLigne);
		var tableau = $('#tableau').html().replace(/nbLigne/g, nbLigne);
		if(nbLigne==1)
			{
				
				$('#insererligne').append('<Label>Référent</Label>');
				$('#insererligne').append(tableau);
			}
			else{
		          $('#insererligne').append(pattern);
			    }
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
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="<?php echo site_url('accreditation/demandes'); ?>">Demandes</a>
		<a href="#" class="current">Ajouter</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="#">Retour</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/AjouterGroupeUtilisateur'); ?>">
					
					<input type="hidden" name="evenement" value="<?php echo $this->session->userdata('idEvenementEnCours'); ?>"/>

					<div class="photo">

						<div class="simulPhoto"></div>

						<div class="optionPhoto">
							<a href="#">FICHIER</a>
							<a href="#">WEBCAM</a>
						</div>
 
					</div>
                   
                   <div class="inputs">
					
						<h2> Informations générales </h2>
						
						<div>
							<label>Nom de la société : </label>
							<input type="text" name="nomsociete" value="" class="nom" value="" style="text-transform: uppercase" />
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="tel" class="tel" value=""  />
						</div>
						
						
						<div>
							
							<label>Pays : </label>
							<select class="pays" name="pays" style="padding-left: 0px;">

							<?php foreach($pays as $p): ?>
								<option value="<?php echo $p->idpays; ?>" <?php echo ($p->idpays == 'FRA')? 'selected' : '' ;?> style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;"><?php echo $p->nompays; ?></option>
							<?php endforeach; ?>

							</select>
						</div>
						
                        <div>
							<label>Nombre des personnes : </label>			
							<input type="text" name="nbpersonne" class="personne"  />
						</div>
                         
						
						<br><br>
						
						<h2>Accréditation</h2>

						<div>
							<label>Fonction : </label>
							<input type="text" name="fonction"/>
						</div>

						<div>
							<label>Catégorie : </label>
							<select name="categorie">
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
					
		<div class="hidden" id="zoneNouvellesPersonnes">
			<div class="ligne" data="nbLigne" etat="false">
				<div id="toggle1"><h4> Nouvelle personne</h4></div>
				    <table id="tableau">
						<tr>
							<th>
								<label>Nom: </label>
							</th>
							<th>
								<label>Prenom: </label>
							</th>
							
						</tr>
						<tr>
							<td>
								<input style="height:20px; width:150px" type="text" id="nom" name="nompersonne[nbLigne][nom]"  />
							</td>
							<td>
								<input style="height:20px; width:150px" type="text" id="prenom" name="prenompersonne[nbLigne][prenom]" />
							</td>
						</tr>
					</table>	
						 </div>
					</div>
				<div id="insererligne"></div>
				<a href="#" class ="button ajoutNbPersonne">+Ajouter une nouvelle personne </a>
				</form>
		<a href="<?php echo site_url('impression/index'); ?>" class ="button imprimer">Imprimer </a>		

			</div>
	
        <div class="clear"></div>

    </div>
		
</div>