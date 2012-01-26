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
			
			<form action="#" method="post">
				
				<h2>Coupe du monde de ski hiver</h2>
				
				<label>Nom</label>
				<input type="text" value="Coupe du monde de ski hiver"/>
				
				<label>Date début</label>
				<input type="text" value="12 Janvier 2012"/>
				
				<label>Date fin</label>
				<input type="text" value="22 Janvier 2012"/>
				
				<input type="submit"/>
				
			</form>
			
        </div>

        <div class="clear"></div>

    </div>

</div>