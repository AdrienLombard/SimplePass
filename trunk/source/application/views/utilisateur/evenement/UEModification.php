<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenements/voir'); ?>">Liste</a>
        <a href="<?php echo site_url('evenements/ajouter'); ?>">Ajouter</a>
		<a href="#" class="current">Modifier</a>
    </div>

    <div class="box-full">
		
		<aside>

            <b>Options :</b>
            <ul>
                <li><a href="<?php echo site_url('evenements/voir/'.$id); ?>">Retour</a></li>
            </ul>

        </aside>

        <div id="main">
			
			<form action="<?php echo site_url('evenements/exeModifier/'.$id); ?>" method="post">
				<h2><?php echo $nom?></h2>
				
				<label>Nom</label>
				<input type="text" value="<?php echo $nom; ?>" name="nom"/>
				
				<label>Date début</label>
				<input type="text" id="datepicker-debut" name="datedebut" READONLY="READONLY" />
				
				<label>Date fin</label>
				<input type="text" id="datepicker-fin" name="datedebut" READONLY="READONLY" />
				
				<input type="submit" name="valider" />
			</form>
			
        </div>

        <div class="clear"></div>

    </div>

</div>