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
				
				<input type="submit" name="valider" />
				
			</form>
			 
        </div>

        <div class="clear"></div>

    </div>

</div>