<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenement/liste'); ?>">Liste</a>
        <a href="<?php echo site_url('evenement/ajouter'); ?>" class="current">Ajouter</a>
    </div>

    <div class="box-full">
		
		<aside>
           
            <b>Options :</b>
            <ul>
				
				<?php if(isset($ajoute)):?>
				<li><span class="ajoute"><?php echo $ajoute; ?></span></li>
				<?php endif; ?>
				
                <li><a href="<?php echo site_url('evenement/liste'); ?>">Retour</a></li>
            </ul>

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
				<label>Voulez-vous télécharger une ancienne évenement ? </label>
				</br>

				<div class="encadrer" >
					<input type=radio class="choix" name="choix" value="Non"  checked="checked" >Non
					<input type=radio class="choix" name="choix" value="Oui"  >Oui
				</div>
				</br>
				<select name="evenements">
					<?php foreach ($resultats as $evenement): { ?>
							<option value="<?php echo $evenement->idevenement ?> "><?php echo $evenement->libelleevenement ?></option>
					<?php } endforeach; ?>
				</select>
				<input type="submit" name="suivant" value="Suivant" />
				
			</form>
			 
        </div>

        <div class="clear"></div>

    </div>

</div>