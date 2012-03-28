<h1>Accréditations</h1>

<div class="wrap">

    <div class="tabs">
		<a href="#" class="current">Redimensionner</a>
    </div>

    <div class="box-full">
		
		<div id="main" class="accred nomargin">
				
				<form method="post" action="<?php echo site_url('accreditation/exeCrop'); ?>" enctype="multipart/form-data">

					<div class="cropper">
						
						<img src="<?php echo site_url('image/generate/' . $client->idclient); ?>" />
						
					</div>
					
					<input type="hidden" name="id" value="<?php echo $client->idclient; ?>" />
					<input type="hidden" name="x" value="10" />
					<input type="hidden" name="y" value="10" />
					<input type="hidden" name="w" value="160" />
					<input type="hidden" name="h" value="204" />
					
					<input type="submit" value="Valider" />
					
				</form>
				
				<div class="clear"></div>

			</div>
			
        </div>

        <div class="clear"></div>

    </div>

</div>