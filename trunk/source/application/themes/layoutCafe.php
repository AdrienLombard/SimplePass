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
                
                <!-- menu dynamique - todo: générer en fonction de l'état -->
                <nav>
					<a href="<?php echo site_url('utilisateur/index'); ?>">Accueil</a>
					<?php if($CI_login): ?>
                    <a href="<?php echo site_url('evenement/index'); ?>">Evènements</a>
					<a href="<?php echo site_url('accreditation/index'); ?>">Accréditations</a>
					<a href="<?php echo site_url('zone/index'); ?>">Zones</a>
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
        
    </body>
</html>
