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

        <?php if(isset($redirect[1])) header('Refresh: '.$redirect[1].';Url='.site_url($redirect[0])); ?>
        
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
                    <a href="<?php echo site_url('accreditation/index'); ?>">Accréditations</a>
                    <a href="<?php echo site_url('evenement/index'); ?>">Evènements</a>
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
