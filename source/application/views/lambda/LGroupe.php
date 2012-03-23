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

<div id="content">
	<div class="wrap">
		
	<h1><?php echo lang('demandeAccred'); ?></h1>
	
	<div class="box-small">
		
		<span class="info"><h4><?php echo lang('inscription'); ?></h4> <?php echo lang('groupe'); ?></span><br>
		<span class="info"><h4><?php echo lang('evenement'); ?></h4> <?php echo $infoEvenement[0]->libelleevenement; ?></span><br>
	
		<br><br>
		<span class="info">* <?php echo lang('mentionChampObligatoire'); ?></span><br>
		<form method="post" action="<?php echo site_url('inscription/exeGroupe/' . $idEvenement); ?>">
			
			<input type="hidden" name="evenement" value="<?php echo $infoEvenement[0]->idevenement; ?>" />
			
			<h2><?php echo lang('groupe'); ?></h2>
			
			<label><?php echo lang('nom'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->groupe; ?>" name="groupe" />
			<?php echo form_error('groupe'); ?>
			
			<label><?php echo lang('pays'); ?>*</label>
			<select  id="pays" name="pays" class="select">
				<?php foreach($listePays as $pays): ?>
				<option VALUE="<?php echo $pays->idpays; ?>" <?php if($values && $values->pays==$pays->idpays) echo 'selected="selected"'; ?> >
					<?php echo $pays->nompays; ?>
				</option>
				<?php endforeach; ?>
			</select>
			
			<br><br>
			<h2><?php echo lang('responsable'); ?></h2>
			
			<label><?php echo lang('nom'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->nom; ?>" name="nom" />
			<?php echo form_error('nom'); ?>
			
			<label><?php echo lang('prenom'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->prenom; ?>" name="prenom" />
			<?php echo form_error('prenom'); ?>
			
			<label><?php echo lang('tel'); ?></label>
			<input type="text" value="<?php if($values) echo $values->tel; ?>" name="tel" />

			<label><?php echo lang('mail'); ?>*</label>
			<input type="text" value="<?php if($values) echo $values->mail; ?>" name="mail" />
			<?php echo form_error('mail'); ?>
			
			<div>
			<label><?php echo lang('categorie'); ?></label>
			<select  id="categorie" name="categorie[]" class="select dyn-selector">
				<option value="-1"><?php echo lang('neSaisPas'); ?></option>
				<?php foreach($listeSurCategorie as $categorie): ?>
				<option VALUE="<?php echo $categorie->idcategorie; ?>" <?php echo set_select('categorie', $categorie->libellecategorie); ?> ><?php echo $categorie->libellecategorie; ?></option>
				<?php endforeach; ?>
			</select>
			</div>
		
			<div class="sous-categories"></div>	
								
			<label><?php echo lang('demandeAjoutFonction'); ?></label>
			<div class="encadrer" >
			<input type=radio class="choixFonction" name="choixFonction" value="Non" <?php echo set_radio('choixFonction', 'Non', TRUE); ?> ><?php echo lang('non'); ?>
			<input type=radio class="choixFonction" name="choixFonction" value="Oui" <?php echo set_radio('choixFonction', 'Oui'); ?> ><?php echo lang('oui'); ?>
			</div>
			<input type="text" value="<?php echo set_value('fonction'); ?>" id="fonction" name="fonction" />
			
			<br>
			
			<input type="submit" value="<?php echo lang('valider'); ?>"/>
			<div class="clear"></div>
			
		</form>
		
	</div>
	
	</div>
</div>