<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href=" ">Liste</a>
        <a href="" class="current">Ajouter</a>
    </div>

    <div class="box-full">
		
		<aside>
           
            <b>Options :</b>
            <ul>
				
				<?php if(isset($ajoute)):?>
				<div calss="ajoute"><?php echo $ajoute; ?></div>
				<?php endif; ?>
				
                <li><a href="<?php echo site_url('evenements/index'); ?>">Retour</a></li>
            </ul>

        </aside>

        <div id="main">
			
			<form action="<?php echo site_url('evenements/ajout'); ?>" method="post">
				
				<h2>Nouvel évènement</h2>
				
				<label>Nom</label>
				<input type="text" name="nom" />
				
				<label>Date début</label>
				<input type="text" name="datedebut"/>
				
				<label>Date fin</label>
				<input type="text" name="datefin"/>
				
				<input type="submit"/>
				
			</form>
			 
        </div>

        <div class="clear"></div>

    </div>

</div>