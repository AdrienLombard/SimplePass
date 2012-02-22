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
				
				<div class="infos">
					
					<div class="nom">M. ASSIER Aymeric</div>
					<div class="pays">FRA</div>
					
					<div class="organisme">Entreprise beta</div>
					<div class="role">CEO</div>
					
					<div class="tel">+33 (0)6 87 07 27 25</div>
					<div class="email">aymeric.assier@gmail.com</div>
					
				</div>
				
				<div class="clear"></div>
				
			</div>
			
			<div class="listeAccred">
				
				<h3>Historique</h3>
				
				<form class="accredForm">
					
				</form>
				
				<div class="ligneAccred">
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
				
				<div class="ligneAccred close">
					<span class="date">2011-05-21</span>
					<span class="categorie">Press TV</span>
					<span class="evenement">Coupe du monde de saut à ski</span>
					<span class="etat">Validée</span>
				</div>
				
			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>