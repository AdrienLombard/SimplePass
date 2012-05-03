<h1><?php echo $titre; ?></h1>

<div class="wrap">

    <div class="tabs">
        <a href="#" class="current">Message</a>
    </div>
	
	<div class="box-full">

        <div id="main" class="nomargin">
            
			<?php echo $message; ?><br/>
			<a href="<?php echo site_url($redirect); ?>" class="button">Continuer</a>
			
        </div>

        <div class="clear"></div>

    </div>

</div>