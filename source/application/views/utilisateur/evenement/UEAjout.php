<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenement/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('evenement/ajouter'); ?>" class="current">Ajouter</a>
    </div>

    <div class="box-full">
		
		<aside>
			
			<a href="<?php echo site_url('evenement/liste'); ?>">Retour</a>

        </aside>

        <div id="main">
			
			<form action="<?php echo site_url('evenement/exeAjouter'); ?>" method="post">
				
				<h2>Nouvel évènement</h2>
				
				<label>Nom</label>
				<input type="text" name="nom" value="<?php if($info) echo $info->nom; ?>" />
				
				<label>Date début</label>
<!-- 				<input type="text" name="datedebut"/> -->
				<input type="text" id="datepicker-debut" name="datedebut" value="<?php if($info) echo $info->dateDebut; ?>" READONLY="READONLY" />
				
				<label>Date fin</label>
				<input type="text" id="datepicker-fin" name="datefin" value="<?php if($info) echo $info->dateFin; ?>" READONLY="READONLY" />

				</br>
				<label>Voulez-vous reprendre les paramètres d'un ancien évènement ?</label>
				</br>

				<div class="encadrer" >
					<input type=radio 
						   class="choix" 
						   name="choix" 
						   value="non"  
						   checked="checked" 
						   <?php if(!$resultats) echo 'disabled="true"'; ?> >Non
					
					<input type=radio 
						   class="choix" 
						   name="choix" 
						   value="oui" 
						   <?php if(!$resultats) echo 'disabled="true"'; ?> >Oui
					
					<?php if(!$resultats) echo ' - Aucun évènement pour servir de modèle.'; ?>
				</div>
				</br>
				<select name="evenements">
					<?php foreach ($resultats as $evenement): { ?>
							<option 
								value="<?php echo $evenement->idevenement; ?>"><?php echo $evenement->libelleevenement; ?>
							</option>
					<?php } endforeach; ?>
				</select>
				<input type="submit" name="suivant" value="Suivant" />
				
			</form>
			 
        </div>

        <div class="clear"></div>

    </div>

</div>