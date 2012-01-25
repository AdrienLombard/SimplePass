<h1>Evènements</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('evenements/index'); ?>">Liste</a>
        <a href="#" class="current">Ajouter</a>
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
				
				<h2>Nouvel évènement</h2>
				
				<label>Nom</label>
				<input type="text"/>
				
				<label>Date début</label>
				<input type="text"/>
				
				<label>Date fin</label>
				<input type="text"/>
				
				<input type="submit"/>
				
			</form>
			
        </div>

        <div class="clear"></div>

    </div>

</div>