<!DOCTYPE html>
<html>
    <head>
        
        <title><?php echo $titre; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <?php foreach($css as $url): ?>
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
        <?php endforeach; ?>

        <?php foreach($js as $url): ?>
            <script type="text/javascript" src="<?php echo $url; ?>"></script> 
        <?php endforeach; ?>

        <?php 
		if(!empty($redirect['url'])) {
			echo '<meta http-equiv="refresh" content="' . $redirect['tempo'] . '; URL=' . site_url($redirect['url']) . '">';
		}
		?>
        
    </head>
    <body>
        <header>
            
            <div class="wrap-h">
                
                <div id="logo">
					<span>SIMPLE</span><b>PASS</b>
					<span class="subtitle">accreditation</span>
				</div>

				<?php if($CI_login): ?>
				<span class="switchMenu" id="topMenuEvenements">
					<span id="libelleEvenementEnCours">&raquo; <?php echo $this->session->userdata('libelleEvenementEnCours'); ?></span>
					<div class="toggleMenu">
						<?php foreach($topMenuEvenements as $tme): ?>
						<?php if($tme->idevenement != $this->session->userdata('idEvenementEnCours')): ?>
						<a href="<?php echo site_url('utilisateur/change/'.$tme->idevenement.'/'.str_replace('/', '__', $this->uri->uri_string())); ?>">
							&raquo; <?php echo $tme->libelleevenement; ?>
						</a>
						<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</span>
				<?php endif; ?>
                
                <!-- menu dynamique -->
                <nav>
					<a href="<?php echo site_url('utilisateur/index'); ?>">Accueil</a>
					<?php if($CI_login): ?>
					<span class="switchMenu">
						Gestion
						<div class="toggleMenu">
							<a href="<?php echo site_url('evenement/index'); ?>">Evènements</a>
							<a href="<?php echo site_url('accreditation/index'); ?>">Accréditations</a>
							<a href="<?php echo site_url('categorie/liste'); ?>">Catégories</a>
							<a href="<?php echo site_url('zone/index'); ?>">Zones</a>
						</div>
					</span>
					<a href="<?php echo site_url('utilisateur/deconnexion'); ?>">Déconnexion</a>
					<?php endif; ?>
                </nav>
                <!-- /menu dynamique -->
                
            </div>
            
        </header>
        
        <div id="content">
			
			<!-- output -->
            <?php echo $output; ?>
            <!-- /output -->
            
        </div>
		
		<footer>
			SimplePass Accreditation 2012 : Gestion des accréditations - <a href="<?php echo site_url('welcome/about'); ?>">À propos</a>
		</footer>
        
    </body>
</html>
