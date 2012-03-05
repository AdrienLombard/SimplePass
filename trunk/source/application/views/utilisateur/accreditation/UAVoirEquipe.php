<script type="text/javascript">

	$(document).ready(function(){

		var tabCat = new Array();

		<?php $i = 0; ?>
		<?php foreach($categories as $cat): ?>
			tabCat[<?php echo $i; ?>] = [<?php echo $cat->idcategorie ?>, <?php echo $cat->surcategorie ?>, "<?php echo $cat->libellecategorie ?>"];
			<?php $i++; ?>
		<?php endforeach; ?>

		$("select.dyn-selector").live("change",function(){

			var id = $(this).find("option:selected").val();
			var count = 0;

			var newSelect = "<select name='categorie[]' class='select dyn-selector'>";
			newSelect += "<option value='-1'>Je ne sais pas encore</option>";
			for(var i=0; i<tabCat.length; i++) {
				if(tabCat[i][1] == id) {
					newSelect += "<option value='" + tabCat[i][0] + "'>" + tabCat[i][2] + "</option>";
					count++;
				}
			}
			newSelect += "</select>";

			$(this).next().remove();

			if(count != 0)
				$(newSelect).insertAfter(this);

		});

	});

</script>

<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="<?php echo site_url('accreditation/ajout'); ?>">Ajouter</a>
		<a href="#" class="current">Voir</a>
    </div>

    <div class="box-full">

        <aside>
           
            <b>Options :</b>
			<ul>
				<li>Modifier</li>
				<li>Retour</li>
			</ul>
			
			<b>Actions :</b>
			<ul>
				<li>Ajouter</li>
			</ul>

        </aside>
		
		<div id="main" class="accred">
			<form method="post" action="<?php echo site_url('accreditation/exeModifierGroupe'); ?>" >
				<h2 class="infos">Référent du groupe</h2><br/>
	        	
				<div class="client">
					
					<div class="groupe">
						
						<b> Groupe </b>
						
					</div>
						
						<input type="hidden" name="idRef" value="<?php echo $client->idclient; ?>" />
						<input type="hidden" name="idAccredRef" value="<?php echo $accreditation[0]->idaccreditation; ?>" />
						<input type="text" class="nom" id="nomRef" init="<?php echo $client->nom; ?>" value="<?php echo $client->nom; ?>">
						<input type="text" class="prenom" id="prenomRef" init="<?php echo $client->prenom; ?>" value="<?php echo $client->prenom; ?>">
						
						<select class="pays" id="paysRef" init="<?php echo $client->pays; ?>"
								style="background: url(<?php echo img_url('drapeaux/'.strtolower($client->pays).'.gif'); ?>) no-repeat left; padding-left: 15px">
							
						<?php foreach($pays as $p): ?>
							<option value="<?php echo $p->idpays; ?>" style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ?>><?php echo $p->nompays; ?></option>
						<?php endforeach; ?>
						
						</select>
					
						<input type="text" class="organisme" id="organismeRef" init="<?php echo $client->organisme; ?>" value="<?php echo $client->organisme; ?>">
						<input type="text" class="role" id="fonctionRef" init="<?php echo $accreditation[0]->fonction; ?>" value="<?php echo $accreditation[0]->fonction; ?>">
						
						<input type="text" class="tel" id="telRef" init="<?php echo $client->tel; ?>" value="<?php echo $client->tel; ?>">
						<input type="text" class="email" id="mailRef" init="<?php echo $client->mail; ?>" value="<?php echo $client->mail; ?>">
						
						<input type="submit" class="valideInfos" value="Enregistrer les modifications" />
					
					<div class="clear"></div>
					
				</div>
				
				<div class="listeAccred">
					
					<h3>Membres du groupe</h3>
					
					<?php if(count($accredAttente)==0) echo '<br/>Aucune demande en cours.' ?>
					
					<?php foreach($accredAttente as $demande): ?>
					
					<div class="ligneAccred close">
						<div class="fixe">
							<input type="hidden" id="idClient" name="groupe[nbLigne][idClient]" value="<?php echo $demande->idclient; ?>" />
							<input type="hidden" id="idAccreditation" name="groupe[nbLigne][idAccreditation]" value="<?php echo $demande->idaccreditation; ?>" />
							<input type="hidden" id="groupe" name="groupe[nbLigne][groupe]" value="<?php echo $demande->groupe; ?>" />
							<span class="nomprenom" name="groupe[nbLigne][nom]" ><?php echo $demande->nom.' '.$demande->prenom.'    '; ?></span>
							<span class="date"><?php echo display_date($demande->dateaccreditation); ?></span>
							<span class="categorie"><?php echo $demande->libellecategorie; ?></span>
						</div>
						<div class="editAccred" >
							<div class="client">
							
								<div class="groupe">
	
	
									<b> Groupe </b>
	
	
								</div>
	
								<div>
									<label for="fonction">Fonction : </label>
									<input type="text" id="ligneFonction" name="groupe[nbLigne][fonction]" value="<?php echo $demande->fonction; ?>"/>
									<label for="categorie">Catégorie : </label>
									<select  id="categorie" name="groupe[nbLigne][categorie]" class="select dyn-selector">
										<option value="-1">Je ne sais pas encore</option>
										<?php foreach($categories as $categorie): ?>
										<option value="<?php echo $categorie->idcategorie; ?>" <?php if($categorie->idcategorie == $demande->idcategorie) { echo "selected='selected'"; } echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
	
								<table class="choixZones">
									<thead>
										<tr>
											<?php foreach($zones as $zone) {if(!empty($zone->idzone)) echo "<td>" . $zone->idzone . "</td>\n";}?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<?php foreach($zones as $zone) :
												if(!empty($zone->idzone)) {
													echo "<td><input type='checkbox' id='" . $zone->idzone ."' name='groupe[nbLigne][" . $zone->idzone . "]' "; 
													if(isset($listeZonesAccred[$accredMembre->idcategorie][$zone->idzone]) && $listeZonesAccred[$accredMembre->idcategorie][$zone->idzone]) {
														echo "checked='checked'";
													} 
													echo "/></td>\n";			
												}
											endforeach; ?>
										</tr>
									</tbody>
								</table>
	
								<div class="clear"></div>
							</div>
							
						</div>
						
					</div>
					
					<?php endforeach; ?>
					
				</div>
				
				<input type="submit" class="button" value="Enregistrer les modifications" />
			</form>
        </div>

        <div class="clear"></div>

    </div>

</div>