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

<div id="content">
	<div class="wrap">
		
	<h1>Demande d'accréditation</h1>
	
	<div class="box-small">
		
		<span class="info"><h4>Inscription :</h4> Groupe</span><br>
		<span class="info"><h4>Evènement :</h4> <?php echo $infoEvenement[0]->libelleevenement; ?></span><br>
	
		<br><br>
		<span class="info">* champs obligatoire</span><br>
		<form method="post" action="<?php echo site_url('inscription/exeGroupe/' . $idEvenement); ?>">
			
			<input type="hidden" name="evenement" value="<?php echo $infoEvenement[0]->idevenement; ?>" />
			
			<h2>Groupe</h2>
			
			<label>Nom*</label>
			<input type="text" value="<?php if($values) echo $values->groupe; ?>" name="groupe" />
			
			<label>Pays*</label>
			<select  id="pays" name="pays" class="select">
				<?php foreach($listePays as $pays): ?>
				<option VALUE="<?php echo $pays->idpays; ?>" <?php if($values && $values->pays==$pays->idpays) echo 'selected="selected"'; ?> >
					<?php echo $pays->nompays; ?>
				</option>
				<?php endforeach; ?>
			</select>
			
			<br><br>
			<h2>Responsable</h2>
			
			<label>Nom*</label>
			<input type="text" value="<?php if($values) echo $values->nom; ?>" name="nom" />
			
			<label>Prénom*</label>
			<input type="text" value="<?php if($values) echo $values->prenom; ?>" name="prenom" />	
			
			<label>Télephone</label>
			<input type="text" value="<?php if($values) echo $values->tel; ?>" name="tel" />

			<label>Mail*</label>
			<input type="text" value="<?php if($values) echo $values->mail; ?>" name="mail" />
			
			<div>
			<label>Catégorie</label>
			<select  id="categorie" name="categorie[]" class="select dyn-selector">
				<option value="-1">Je ne sais pas encore</option>
				<?php foreach($listeSurCategorie as $categorie): ?>
				<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
				<?php endforeach; ?>
			</select>
			</div>
		
			<div class="sous-categories"></div>	
								
			<label>Voulez-vous spécifier une fonction ?</label>
			<div class="encadrer" >
			<input type=radio class="choixFonction" name="choixFonction" value="Non" <?php echo set_radio('choixFonction', 'Non', TRUE); ?> >Non
			<input type=radio class="choixFonction" name="choixFonction" value="Oui" <?php echo set_radio('choixFonction', 'Oui'); ?> >Oui
			</div>
			<input type="text" value="<?php echo set_value('fonction'); ?>" id="fonction" name="fonction" />
			
			<br>
			
			<input type="submit"/>
			<div class="clear"></div>
			
		</form>
		
	</div>
	
	</div>
</div>