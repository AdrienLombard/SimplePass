
<div class="wrap">
	
	<h1>Demande d'accréditation</h1>
	<form action="<?php echo site_url('presse/inscription/'); ?>" method="POST" enctype="multipart/form-data">
        <div class="box-small">
		    
		     <label> Choisissez votre catégorie</label>
		        <select  id="categorie"  name="categorie" class="select dyn-selector" >
		     	<option value="0"> Autre </option>
			    <!--<//?//php foreach($listeSurCategorie as $categorie): ?>
			    <option VALUE="</?php echo $categorie->idcategorie; ?>" <//?php echo set_select('categorie', $categorie->libellecategorie); ?> ><//?php echo $categorie->libellecategorie; ?></option>
			    <//?php endforeach; ?>-->
		       <option value="1">Presse</option>
				</select>
		</div>
			<input type="submit" name="inscrire"  value="s'inscrire"/>
	  
	</form>
	
</div>