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
        	
			<div class="client">
				
				<div class="groupe">
					
					
					<b> Groupe </b>
					
					
				</div>
					
				<form class="infos">
					
					<input type="text" class="nom" init="<?php echo $client->nom.' '.$client->prenom; ?>" value="<?php echo $client->nom.' '.$client->prenom; ?>">
					
					<select class="pays" init="<?php echo $client->pays; ?>"
							style="background: url(<?php echo img_url('drapeaux/'.strtolower($client->pays).'.gif'); ?>) no-repeat left; padding-left: 15px">
						
					<?php foreach($pays as $p): ?>
						<option value="<?php echo $p->idpays; ?>" style="background: url(<?php echo img_url('drapeaux/'.strtolower($p->idpays).'.gif'); ?>) no-repeat left;" <?php echo ($p->idpays == $client->pays)? 'selected' : '' ?>><?php echo $p->nompays; ?></option>
					<?php endforeach; ?>
					
					</select>
				
					<input type="text" class="organisme" init="<?php echo $client->organisme; ?>" value="<?php echo $client->organisme; ?>">
					<input type="text" class="role" init="<?php echo $accreditation[0]->fonction; ?>" value="<?php echo $accreditation[0]->fonction; ?>">
					
					<input type="text" class="tel" init="<?php echo $client->tel; ?>" value="<?php echo $client->tel; ?>">
					<input type="text" class="email" init="<?php echo $client->mail; ?>" value="<?php echo $client->mail; ?>">
					
					<input type="submit" class="valideInfos" value="Enregistrer les modifications" />
					
				</form>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="listeAccred">
				
				<h3>En cours</h3>
				
				<form class="accredForm">
					
				</form>
				
				<?php if(count($accredAttente)==0) echo '<br/>Aucune demande en cours.' ?>
				
				<?php foreach($accredAttente as $demande): ?>
				
				<div class="ligneAccred close">
					<div class="fixe">
						<span class="nomprenom"><?php echo $demande->nom.' '.$demande->prenom.'    '; ?></span>
						<span class="date"><?php echo $demande->dateaccreditation; ?></span>
						<span class="categorie"><?php echo $demande->libellecategorie; ?></span>
						<span class="evenement"><?php echo $demande->libelleevenement; ?></span>
					</div>
					<form class="editAccred" >
						<div class="client">
						
							<div class="groupe">


								<b> Groupe </b>


							</div>

							<div>
								<input type="text" id="fonction" />
								<select  id="categorie" name="categorie[]" class="select dyn-selector">
									<option value="-1">Je ne sais pas encore</option>
									<?php foreach($categories as $categorie): ?>
									<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
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
												echo "<td><input type='checkbox' "; 
												if(isset($listeZonesAccred[$accredMembre->idcategorie][$zone->idzone]) && $listeZonesAccred[$accredMembre->idcategorie][$zone->idzone]) {
													echo "checked='checked'";
												} 
												echo "/></td>\n";			
											}
										endforeach; ?>
									</tr>
								</tbody>
							</table>

							<input type="submit" value="Enregistrer" />

							<div class="clear"></div>
						</div>
					</form>
					
				</div>
				
				<?php endforeach; ?>
				
				
			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>