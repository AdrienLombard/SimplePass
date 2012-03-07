<script type="text/javascript">
	
	$(document).ready(function(){
		
		var tabCat = new Array();
		
		<?php $i = 0; ?>
		<?php foreach($listeCategorie as $cat): ?>
			tabCat[<?php echo $i; ?>] = [<?php echo $cat->idcategorie ?>, <?php echo $cat->surcategorie ?>, "<?php echo $cat->libellecategorie ?>"];
			<?php $i++; ?>
		<?php endforeach; ?>

		$("select.dyn-selector").live("change",function(){
			
			var id = $(this).find("option:selected").val();
			var nbLigne = $(this).parent().parent().parent().attr('data');
			var count = 0;
			
			var newSelect = "<select name='groupe["+ nbLigne +"][categorie][]' class='select dyn-selector'>";
			newSelect += "<option value='-1'>Je ne sais pas encore</option>";
			for(var i=0; i<tabCat.length; i++) {
				if(tabCat[i][1] == id) {
					newSelect += "<option value='" + tabCat[i][0] + "'>" + tabCat[i][2] + "</option>";
					count++;
				}
			}
			newSelect += "</select>";
			
			$(this).nextAll().remove();
			
			if(count != 0)
				$(newSelect).insertAfter(this);
			
		});

	});
	
</script>

<div id="content">
	<div class="wrap2">
		
		<h1>Liste des membres de l'equipe</h1>

		<div class="box-small">
			
			<form id="inscriptionGroupe" method="post" action="<?php echo site_url('inscription/exeAjouterGroupe'); ?>">
				
				<input type="hidden" name="ref[nom]" value="<?php echo $nom; ?>" />
				<input type="hidden" name="ref[prenom]" value="<?php echo $prenom; ?>" />
				<input type="hidden" name="ref[categorie]" value="<?php echo $categorie; ?>" />
				<input type="hidden" name="ref[fonction]" value="<?php echo $fonction; ?>" />
				<input type="hidden" name="ref[tel]" value="<?php echo $tel; ?>" />
				<input type="hidden" name="ref[mail]" value="<?php echo $mail; ?>" />
				<input type="hidden" name="ref[groupe]" value="<?php echo $groupe; ?>" />
				<input type="hidden" name="ref[pays]" value="<?php echo $pays; ?>" />
				
				<input type="hidden" name="evenement" value="<?php echo $evenement; ?>" />
				
				<span class="info"><h4>Groupe :</h4> <?php echo $groupe; ?></span><br>
				<span class="info"><h4>Responsable :</h4> <?php echo $nom; ?> <?php echo $prenom; ?></span><br>
	
				<br><br>
				<span class="info">* champs obligatoire</span><br>
				
				<div id="insererLigne"></div>
				
				<span class="button" id="ajouterLigne">+ Ajouter un nouveau membre</span>
				
				<input type="submit" value="Tout envoyer" />
				
				<div class="clear"></div>
				
			</form>
			
		</div>
	
	</div>
	
</div>

<div class="hidden" id="pattern">
	<div class="ligne" data="nbLigne" etat="false">
		<h3>Nouveau membre <span class="modifier">modifier</span></h3>
		<div class="form">
			<div class="split">
				<label for="">Nom*</label>
				<input type="text" id="ligneNom" name="groupe[nbLigne][nom]" />
			</div>
			<div class="split">
				<label for="">Prénom*</label>
				<input type="text" id="lignePrenom" name="groupe[nbLigne][prenom]" />
			</div>
			<div class="clear"></div>
			<div class="split">
				<label for="">Catégorie</label>
				<select  id="categorie" name="groupe[nbLigne][categorie][]" class="select dyn-selector">
					<option value="-1">Je ne sais pas encore</option>
					<?php foreach($listeSurCategorie as $categorie): ?>
					<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="split">
				<label>fonction </label>
				<input type="text" id="ligneFonction" name="groupe[nbLigne][fonction]" />
			</div>
			<div class="split splitRight">
				<a href="#" class="button" id="validerLigne">Valider</a>
			</div>
			<div class="split splitRight">
				<a href="#" class="button" id="supprimerLigne">Supprimer</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>