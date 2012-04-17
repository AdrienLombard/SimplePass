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
        <!-- page vue chocolat -->
        <header>
            <a href="<?php echo site_url('inscription/'); ?>" ><?php echo img('s5_seg_logo.png'); ?></a>
		</header>
        
        <div id="content">
            
            <!-- output -->
            <?php echo $output; ?>
            <!-- /output -->
            
        </div>
        
    </body>
</html>
