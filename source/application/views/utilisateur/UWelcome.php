<h1>Accueil</h1>

<div class="wrap">
	
	<div class="tabs">
        <a href="#" class="current">Bienvenue</a>
    </div>

    <div class="box-full">

        <div id="main" class="nomargin">
			
			<div class="intro">
				
				<div class="desc">

					Avec <strong>SimplePass Accréditation</strong>, vous pouvez <strong>gagner
					du temps</strong> : en <strong>quelques clics</strong>, vous pouvez
					<strong>préparer</strong> vos évènements, <strong>gérer</strong> vos accréditations et <strong>générer</strong> vos
					pass.
					<br/><br>
					Le tout, en une seule interface.
				</div>
				
				<div class="suggestion">

					<?php if($evenement != null): ?>

						Evénement en cours :<br/>
						<strong><?php echo $this->session->userdata('libelleEvenementEnCours'); ?></strong>.
						<br><br>					
						Actuellement : 
						<li><a href="#">156 accréditation(s)</a></li>
						<li><a href="#">123 demande(s)</a> en attente.<br/></li>

						<?php if($evenement->datefin - time() <= 60*60*24*20): ?>
						<span class="alert">Attention !<br/>Il ne vous reste que <?php echo floor(($evenement->datefin - time()) / 60 / 60 / 24); ?> jours pour valider vos demandes !</span>
						<?php endif; ?>

						<br>
						<div class="actions">
						<a href="<?php echo site_url('evenement/modifier/' . $this->session->userdata('idEvenementEnCours')); ?>" class="button">Modifier cet évènement</a> ou <a href="<?php echo site_url('accreditation'); ?>" class="button">Gérer les accréditations</a>
						</div>

					<?php elseif($evenement == null && $nb > 0): ?>

						Vous n'avez pas d'évènement en cours... Voulez-vous en <strong>créer un nouveau</strong> afin de démarrer une nouvelle activité ?<br/>

						<div class="actions">
							<a href="<?php echo site_url('evenement/ajouter'); ?>" class="button">Créer un nouvel évènement</a>
						</div>

						Vous pouvez également personnaliser votre jeu de <strong>zones</strong> et de <strong>catégories</strong> via le menu de gestion en haut à droite.

					<?php else: ?>

						Afin de vous aider à <strong>commencer</strong> votre activité, <strong>SimplePass</strong>
						vous propose de <strong>créer</strong> et de <strong>personnaliser</strong>, suivant vos besoins, un nouvel évènement :

						<div class="actions">
							<a href="<?php echo site_url('evenement/ajouter'); ?>" class="button">Créer un nouvel évènement</a>
						</div>

						Vous pouvez également personnaliser votre jeu de <strong>zones</strong> et de <strong>catégories</strong> via le menu de gestion en haut à droite.

					<?php endif; ?>
				
				</div>
			
			</div>
			
        </div>

        <div class="clear"></div>
		
		<br><br><br>

    </div>

</div>