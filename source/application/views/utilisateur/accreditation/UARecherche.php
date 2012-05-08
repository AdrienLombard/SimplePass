<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="<?php echo site_url('accreditation/index'); ?>">Liste</a>
		<a href="<?php echo site_url('accreditation/rechercher'); ?>" class="current">Individuelles</a>
		<a href="<?php echo site_url('accreditation/ajouterGroupe'); ?>" >Groupes</a>
    </div>

    <div class="box-full">

        <div id="main" class="nomargin">
			
			<form class="rechercheClient" method="post" action="<?php echo site_url('accreditation/ajouter/'); ?>">
        	
				<div class="flowSearch">
					<label>Nom de la personne :</label>
					<input type="text" name="username" />
				</div>
				
				<div class="listeTempsReel">
					
					<?php foreach($clients as $client): ?>
					<a href="<?php echo site_url('accreditation/voir/'.$client->idclient); ?>">
						<div username="<?php echo strtolower($client->nom. ' ' .$client->prenom); ?>" class="itemFlowSearch">
							<span class="username"><?php echo $client->nom. ' ' .$client->prenom; ?></span>
							<span class="email">- <?php echo $client->mail; ?></span>
							<span class="pays"><?php echo $client->pays; ?></span>
						</div>
					</a>
					<?php endforeach; ?>
					
				</div>
				
				<input type="submit" value="Personne ne correspond ? Créer une nouvelle personne " />
				
			</form>
			
        </div>

        <div class="clear"></div>

    </div>

</div>