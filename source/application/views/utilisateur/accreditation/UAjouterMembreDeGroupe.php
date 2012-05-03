<script type="text/javascript">

	$(document).ready(function(){

	var nbLigne = 0;
	
	$('.ajoutNbPersonne').click(function(){
		
		var insert = '<table id="tableauPersonne" data="nbLigne">';
		insert +=		'<tr>';
		insert +=			'<td>Nom : <input class="required" type="text" id="nom" name="personne[nbLigne][nom]"  style="text-transform: uppercase"  /></td>';
		insert +=			'<td>Prénom : <input class="required" type="text" id="prenom" name="personne[nbLigne][prenom]" /></td>';
		insert +=			'<td>Fonction : <input class="required" type="text" id="fonction" name="personne[nbLigne][fonction]" /></td>';
		insert +=			'<td><span class="button retirerNbPersonne" id="nbLigne">-</span></td>';
		insert +=		'</tr>'
		insert +=	'</table>';
		
		var pattern = insert.replace(/nbLigne/g, nbLigne);
		$('#insererligne').append(pattern);
		
		nbLigne++;
		
	});
	
	$('.retirerNbPersonne').live('click', function(){
		$('table[data=' + $(this).attr('id') + ']').remove();
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
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" >Individuelles</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" class="current" >Groupes</a>
    </div>

    <div class="box-full">

        <aside>
			<a href="<?php echo site_url('accreditation/index'); ?>">Retour</a>
        </aside>
		
		<div id="main" class="accred">
        	
			<div class="client nouveau">
				
				<form class="infos nouveau" method="post" action="<?php echo site_url('accreditation/exeAjoutGroupe'); ?>" enctype="multipart/form-data">
					
					<input type="hidden" name="evenement" value="<?php echo $this->session->userdata('idEvenementEnCours'); ?>"/>
                   
                   <div class="inputs no-margin">
					
						<h2> Informations générales </h2>
						
						<div>
							<label>Groupe : </label>
							<input class="required" type="text" name="info[groupe]" value="<?php if(isset($re->info['groupe'])) echo $re->info['groupe']; ?>" class="nom" />
						</div>
						
						<div>
							<label>Société : </label>
							<input class="required" type="text" name="info[societe]" value="<?php if(isset($re->info['societe'])) echo $re->info['societe']; ?>" class="nom" />
						</div>

						<div>
							<label>Tel : </label>
							<input type="text" name="info[tel]" class="tel required" value="<?php if(isset($re->info['tel'])) echo $re->info['tel']; ?>"  />
						</div>
						
						<div>
							<label>Mail : </label>
							<input type="text" name="info[mail]" class="mail required" value="<?php if(isset($re->info['mail'])) echo $re->info['mail']; ?>"  />
						</div>
						
						<div>
							<label>Image : </label>
							<input type="file" name="photo_file"  />
						</div>
						
						<div>
							
							<label>Pays : 
								<?php foreach($pays as $p): ?>
								<span id="<?php echo $p->idpays; ?>" class="drapeau" style="display:none;" ><?php echo img('drapeaux/' . strtolower($p->idpays) . '.gif'); ?></span>
							<?php endforeach; ?>
							</label>
							<select class="pays" name="info[pays]" style="padding-left: 0px;">

							<?php foreach($pays as $p): ?>
								<option
									value="<?php echo $p->idpays; ?>" 
									<?php 
									if(isset($re->info['pays'])) { 
										if($re->info['pays'] == $p->idpays) 
											echo 'selected';
									}
									else {
										if('FRA' == $p->idpays) echo 'selected';
									}
									?> 
								>
									<?php echo $p->nompays; ?>
								</option>
							<?php endforeach; ?>

							</select>
						</div>

						
						<div>
							<label>Catégorie : </label>
							<select id="categorieSimple" name="info[categorie]">
								<option value="" <?php if(empty($re->accred['categorie'])) echo 'selected'; ?> >---</option>
								<?php foreach($categories as $cate): ?>
								<option
									value="<?php echo $cate['cat']['db']->idcategorie; ?>"
									zone="<?php echo $cate['zones']; ?>"
									<?php if(isset($re->accred['idcategorie']) && $re->accred['idcategorie'] == $categorie['cat']->idcategorie) echo 'selected'; ?>
									>
									<?php for($i=0; $i<$cate['cat']['depth']; $i++) echo '&#160;&#160;'; ?>
									<?php echo $cate['cat']['db']->libellecategorie; ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="contientZones">
							<label>Zones : </label>
							<div>
								<?php foreach($zones as $zone): ?>
								<div class="checkzone" id="<?php echo $zone->idzone; ?>">
									<?php echo $zone->codezone; ?>
									<input type="checkbox" name="zone[<?php echo $zone->idzone; ?>]" />
								</div>
								<?php endforeach; ?>
							</div>
							<div class="allaccess">
								<label>All-Access : </label>
								<input type="checkbox" style="margin-top:14px;" id="all" name="allAccess"/>
							</div>
						</div>
						
						<div class="clear"></div>
						
					</div>

					<h2>Référent</h2>

					<table id="tableauReferent">
						<tr>
							<td>Nom : <input class="required" type="text" id="nom" name="ref[nom]"  value="<?php if(isset($re->ref['nom'])) echo $re->ref['nom']; ?>" style="text-transform: uppercase" /></td>
							<td>Prénom : <input class="required" type="text" id="prenom" name="ref[prenom]" value="<?php if(isset($re->ref['prenom'])) echo $re->ref['prenom']; ?>" /></td>
							<td>Fonction : <input class="required" type="text" id="fonction" name="ref[fonction]" value="<?php if(isset($re->ref['fonction'])) echo $re->ref['fonction']; ?>" /></td>
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