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
				
				<div class="photo">
					
					<div class="simulPhoto"></div>
					
					<div class="optionPhoto">
						<a href="#">UPLOAD</a>
						<a href="#">PRENDRE</a>
					</div>
					
				</div>
				
				<form class="infos">
					
					<input type="text" class="nom" init="M. ASSIER Aymeric" value="M. ASSIER Aymeric">
					<select class="pays" init="FRA" style="background: url(<?php echo img_url('drapeaux/fra.gif'); ?>) no-repeat left; padding-left: 15px">
						<option value="FRA" style="background: url(<?php echo img_url('drapeaux/fra.gif'); ?>) no-repeat left;" selected>FRA</option>
						<option value="DEU" style="background: url(<?php echo img_url('drapeaux/deu.gif'); ?>) no-repeat left;">DEU</option>
						<option value="ITA" style="background: url(<?php echo img_url('drapeaux/ita.gif'); ?>) no-repeat left;">ITA</option>
					</select>
					
					<input type="text" class="organisme" init="Entreprise beta" value="Entreprise beta">
					<input type="text" class="role" init="CEO" value="CEO">
					
					<input type="text" class="tel" init="+33 (0)6 87 07 27 25" value="+33 (0)6 87 07 27 25">
					<input type="text" class="email" init="aymeric.assier@gmail.com" value="aymeric.assier@gmail.com">
					
					<input type="submit" class="valideInfos" value="Enregistrer les modifications" />
					
				</form>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="listeAccred">
				
				<h3>En cours</h3>
				
				<form class="accredForm">
					
				</form>
				
				<div class="ligneAccred close">
					<span class="date">2012-02-16</span>
					<span class="categorie">Press TV</span>
					<span class="evenement">Coupe du monde de saut à ski</span>
					<span class="etat">Demande</span>
					
					<form class="editAccred">
						
						<div>
							<select>
								<option>Choisir un évènement </option>
							</select>
						</div>
						
						<div>
							<input type="text" />
							<select>
								<option>Choisir une catégorie </option>
							</select>
						</div>
						
						<table class="choixZones">
							<thead>
								<tr>
									<td>01</td>
									<td>02</td>
									<td>03</td>
									<td>04</td>
									<td>05</td>
									<td>06</td>
									<td>07</td>
									<td>08</td>
									<td>09</td>
									<td>10</td>
									<td>11</td>
									<td>12</td>
									<td>13</td>
									<td>14</td>
									<td>15</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
									<td><input type="checkbox" /></td>
								</tr>
							</tbody>
						</table>
						
						<input type="submit" value="Enregistrer" />
						
						<div class="clear"></div>
						
					</form>
					
				</div>
				
				
				<h3>Historique</h3>
				
				<div class="ligneAccred close">
					<span class="date">2011-05-21</span>
					<span class="categorie">Press TV</span>
					<span class="evenement">Coupe du monde de saut à ski</span>
					<span class="etat">Validée</span>
					<div class="detailZones">Zones : 1, 2, 3, 4, 8, 10, 11</div>
				</div>
				
			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>