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
                
                <div id="logo"><?php echo img('logo_seul.png'); ?></div>
                
                <!-- menu dynamique - todo: générer en fonction de l'état -->
                <nav>
                    <a href="#">Accréditations</a>
                    <a href="<?php echo site_url('evenements/index'); ?>">Evènements</a>
                    <a href="#">Catégories</a>
                    <a href="#">Zones</a>
                    <a href="#">Utilisateurs</a>
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
