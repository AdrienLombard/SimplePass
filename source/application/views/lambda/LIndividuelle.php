
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
			newSelect += "<option value='-1'><?php echo lang('neSaisPas'); ?></option>";
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
	
	<h1><?php echo lang('demandeAccred'); ?></h1>
	
	<div class="box-small">
	
	<span class="info"><h4><?php echo lang('inscription'); ?></h4> <?php echo lang('individuelle'); ?></span><br>
	<span class="info"><h4><?php echo lang('evenement'); ?></h4> <?php echo $event_info[0]->libelleevenement; ?></span><br>
	
	<br><br>
	<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
	<form action="<?php echo site_url('inscription/ajouter/' . $event_id); ?>" method="POST" >
		
		<input type="hidden" id="evenement" name="evenement" value="<?php echo $event_id; ?>" />
		
		<label><?php echo lang('civilite'); ?>*</label>
		<div class="encadrer" >
			<?php echo lang('homme'); ?> : <input type=radio id="civilite" name="civilite" value="M" <?php echo set_radio('civilite', 'M', TRUE); ?> >
			<?php echo lang('femme'); ?> : <input type=radio id="civilite" name="civilite" value="F" <?php echo set_radio('civilite', 'F'); ?> >
		</div>
		
		<label><?php echo lang('nom'); ?>*</label>
		<input type="text" value="<?php echo set_value('nom'); ?>" id="nom" name="nom" />
		<?php echo form_error('nom'); ?>
		
		<label><?php echo lang('prenom'); ?>*</label>
		<input type="text" value="<?php echo set_value('prenom'); ?>" id="prenom" name="prenom" />
		<?php echo form_error('prenom'); ?>
		
		<label><?php echo lang('pays'); ?>*</label>
		<select  id="pays" name="pays" class="select">
			<?php foreach($listePays as $pays): ?>
				<option VALUE="<?php echo $pays->idpays; ?>" <?php echo set_select('pays', $pays->idpays); ?> ><?php echo $pays->nompays; ?></option>
			<?php endforeach; ?>
		</select>
		
		<label><?php echo lang('tel'); ?></label>
		<input type="text" value="<?php echo set_value('tel'); ?>" id="tel" name="tel" />
		
		<label><?php echo lang('mail'); ?>*</label>
		<input type="text" value="<?php echo set_value('mail'); ?>" id="mail" name="mail" />
		<?php echo form_error('mail'); ?>
		
		<label><?php echo lang('societe'); ?></label>
		<input type="text" value="<?php echo set_value('titre'); ?>" id="titre" name="titre" />
		
		<div>
		<label><?php echo lang('categorie'); ?></label>
		<select  id="categorie" name="categorie[]" class="select dyn-selector">
			<option value="-1"><?php echo lang('neSaisPas'); ?></option>
			<?php foreach($listeSurCategorie as $categorie): ?>
			<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
			<?php endforeach; ?>
		</select>
		</div>
				
		<label><?php echo lang('demandeAjoutFonction'); ?></label>
		<div class="encadrer" >
			<input type=radio class="choixFonction" name="choixFonction" value="Non" <?php echo set_radio('choixFonction', 'Non', TRUE); ?> ><?php echo lang('non'); ?>
			<input type=radio class="choixFonction" name="choixFonction" value="Oui" <?php echo set_radio('choixFonction', 'Oui'); ?> ><?php echo lang('oui'); ?>
		</div>
		<input type="text" value="<?php echo set_value('fonction'); ?>" id="fonction" name="fonction" />
		
		<div class="sous-categories"></div>			
		
		<label><?php echo lang('photo'); ?></label>
		<?php echo img('ombre.jpg'); ?>
		<br>
		<input type="file" name="fichier">
		
		<div class="clear"></div>
		
		<input type="submit" name="valider" id="valider" />
		
		<div class="clear"></div>
	</form>

	</div>
	
</div>