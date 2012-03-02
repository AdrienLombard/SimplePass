
<?php //echo validation_errors(); ?>

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
			
			$(this).nextAll().remove();
			
			if(count != 0)
				$(newSelect).insertAfter(this);
			
		});

	});
	
</script>


<div class="wrap">
	
	<h1>Demande d'accréditation</h1>
	
	<div class="box-small">
	
	<span class="info"><h4>Inscription :</h4> individuelle</span><br>
	<span class="info"><h4>Evènement :</h4> <?php echo $event_info[0]->libelleevenement; ?></span><br>
	
	<br><br>
	<span class="info">* champs obligatoire</span><br>
	<form action="<?php echo site_url('inscription/ajouter/' . $event_id); ?>" method="POST" >
		
		<input type="hidden" id="evenement" name="evenement" value="<?php echo $event_id; ?>" />
		
		<label>Civilité*</label>
		<div class="encadrer" >
			Homme : <input type=radio id="civilite" name="civilite" value="M" <?php echo set_radio('civilite', 'M', TRUE); ?> >
			Femme : <input type=radio id="civilite" name="civilite" value="F" <?php echo set_radio('civilite', 'F'); ?> >
		</div>
		
		<label>Nom*</label>
		<input type="text" value="<?php echo set_value('nom'); ?>" id="nom" name="nom" />
		
		<label>Prénom*</label>
		<input type="text" value="<?php echo set_value('prenom'); ?>" id="prenom" name="prenom" />
		
		<label>Pays*</label>
		<select  id="pays" name="pays" class="select">
			<?php foreach($listePays as $pays): ?>
				<option VALUE="<?php echo $pays->idpays; ?>" <?php echo set_select('pays', $pays->idpays); ?> ><?php echo $pays->nompays; ?></option>
			<?php endforeach; ?>
		</select>
		
		<label>Télephone</label>
		<input type="text" value="<?php echo set_value('tel'); ?>" id="tel" name="tel" />
		
		<label>Mail*</label>
		<input type="text" value="<?php echo set_value('mail'); ?>" id="mail" name="mail" />
		
		<label>Societe, Organisme ou Publication</label>
		<input type="text" value="<?php echo set_value('titre'); ?>" id="titre" name="titre" />
		
		<div>
		<label>Catégorie</label>
		<select  id="categorie" name="categorie[]" class="select dyn-selector">
			<option value="-1">Je ne sais pas encore</option>
			<?php foreach($listeSurCategorie as $categorie): ?>
			<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
			<?php endforeach; ?>
		</select>
		</div>
				
		<label>Voulez-vous spécifier une fonction ?</label>
		<div class="encadrer" >
			<input type=radio class="choixFonction" name="choixFonction" value="Non" <?php echo set_radio('choixFonction', 'Non', TRUE); ?> >Non
			<input type=radio class="choixFonction" name="choixFonction" value="Oui" <?php echo set_radio('choixFonction', 'Oui'); ?> >Oui
		</div>
		<input type="text" value="<?php echo set_value('fonction'); ?>" id="fonction" name="fonction" />
		
		<div class="sous-categories"></div>			
		
		<label>Photo</label>
		<?php echo img('ombre.jpg'); ?>
		<br>
		<input type="file" name="fichier">
		
		<div class="clear"></div>
		
		<input type="submit" name="valider" id="valider" />
		
		<div class="clear"></div>
	</form>

	</div>
	
</div>