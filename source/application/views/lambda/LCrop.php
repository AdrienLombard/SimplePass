<script type="text/javascript">
	
	$(document).ready(function(){
		
		/*
		 * Crop d'image
		 */
		$('.cropper img').Jcrop({
			onChange:		changeCoords,
			aspectRatio:	160 / 240,
			minSize:		[160, 204],
			setSelect:		[10, 10, 160, 204]
		});
		
		function changeCoords(c) {
			$('input[name=x]').val(c.x);
			$('input[name=y]').val(c.y);
			$('input[name=w]').val(c.w);
			$('input[name=h]').val(c.h);
		}

	});
	
</script>

<div class="wrap" style="width: 980px;">
	
	<h1><?php echo lang('demandeAccred'); ?></h1>
	
	<a href="<?php echo site_url('inscription/changerLangage/fra/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php echo img_url('drapeaux/fra.gif'); ?>" alt="fra" /></a>
	<a href="<?php echo site_url('inscription/changerLangage/gbr/' . str_replace('/', ':', uri_string())); ?>" ><img src="<?php echo img_url('drapeaux/gbr.gif'); ?>" alt="gbr" /></a>
	
	<div class="box-small">

		<form method="post" action="<?php echo site_url('inscription/exeCrop'); ?>" enctype="multipart/form-data">

			<div class="cropper">
				<img src="<?php echo site_url('image/generate/' . $client->idclient); ?>" />
			</div>

			<input type="hidden" name="id" value="<?php echo $client->idclient; ?>" />
			<input type="hidden" name="x" value="10" />
			<input type="hidden" name="y" value="10" />
			<input type="hidden" name="w" value="160" />
			<input type="hidden" name="h" value="204" />

			<input type="submit" value="Valider les nouvelles dimensions" />
			
			<div class="clear"></div>

		</form>

	</div>
	
</div>