<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenements/index'); ?>">Liste</a>
        <a href="<?php echo site_url('evenements/ajout'); ?>">Ajouter</a>
		<a href="#" class="current">Modifier</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
            <ul>
                <li><a href="<?php echo site_url('evenements/index'); ?>">Retour</a></li>
            </ul>

        </aside>

        <div id="main">
			
			<form action="" method="post">
				 <?php foreach ($resultats as $resultat):?>
				<h2><?php echo $resultat->libelleevenement?></h2>
				
				<label>Nom</label>
				<input type="text" value="<?php echo $resultat->libelleevenement?>" name="nom"/>
				
				<label>Date début</label>
				<input type="text" value="<?php echo display_date($resultat->datedebut)?>" name="datedebut"/>
				
				<label>Date fin</label>
				<input type="text" value="<?php echo display_date($resultat->datefin)?>" name="datefin"/>
				
				<input type="submit" name="valider" />
				<?php  endforeach; ?>
			</form>
			
        </div>

        <div class="clear"></div>

    </div>

</div>