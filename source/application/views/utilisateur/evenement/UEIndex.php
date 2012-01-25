<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
        <a href="#" class="current">Liste</a>
        <a href="<?php echo site_url('evenements/ajout'); ?>">Ajouter</a>
    </div>

    <div class="box-full">

        <aside>

            <b>Filtres :</b>
            <ul>
                <li><a href="#">Tous</a></li>
                <li><a href="#">A valider</a></li>
                <li><a href="#">Validé</a></li>
            </ul>

            <br><br>

            <b>Rechercher :</b><br>
            <input type="text" class="search">

        </aside>

        <div id="main">
            <table class="liste" cellspacing="0">
                <thead>
					<tr>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Société</th>
						<th>Pays</th>
						<th>Catégorie</th>
						<th>Email</th>
						<th></th>
					</tr>
                </thead>
                <tbody>
                    <?php for($i=0;$i<6;$i++): ?>
					<tr>
                        <td>Assier</td>
                        <td>Aymeric</td>
                        <td>TrollEtCompagnie</td>
                        <td>Savoy</td>
                        <td>All Access</td>
                        <td>plop@plop.plop</td>
						<td><a href="<?php echo site_url('evenements/voir'); ?>">Voir<a></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>

    </div>

</div>