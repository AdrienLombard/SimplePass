<div class="wrap">
	<h1><?php echo $titre; ?></h1>
	<!--
	<a href="<?php //echo site_url('inscription/changerLangage/fra/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/fra.gif'); ?>" alt="fra" /></a>
	<a href="<?php //echo site_url('inscription/changerLangage/gbr/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php //echo img_url('drapeaux/gbr.gif'); ?>" alt="gbr" /></a>
	-->
	<div class="box-small">
		<?php echo $message; ?>
		
		<a id="lienLambda" href="<?php echo site_url('inscription'); ?>" class="button"><?php echo lang('continuer'); ?></a>
	</div>
</div>