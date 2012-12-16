<h1>Parametrage de l'application</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('utilisateur/configAccred'); ?>" class="current">Accreditations</a>
        <a href="<?php echo site_url('utilisateur/configMail'); ?>" >Mail de confirmation</a>
    </div>

    <div class="box-full">

        <div id="main">
			<form action="<?php echo site_url('utilisateur/configAccred'); ?>" method="post">
				
				<p>Les valeurs ci-dessous sont exprimées en millimètres</p>
				
				<br />
				
				<h2>Accréditation classique</h2>
				<div style="margin: 0 15px;">
					<img src="<?php echo img_url('accreds/accred.png'); ?>" alt="Accréditation classique" width="297" height="300" style="float: right;vertical-align: middle;" />
					<table>
						<tr>
							<td>
								<label style="margin-top: 50px;">1 </label><input type="text" size="4" value="<?php echo set_value('Ximage', $dim['Ximage']); ?>" name="Ximage" style="margin-right: 30px;"/>
								<label>3 </label><input type="text" size="4" value="<?php echo set_value('Xinfo', $dim['Xinfo']); ?>" name="Xinfo" style="margin-right: 30px;"/>
								<label>5 </label><input type="text" size="4" value="<?php echo set_value('Xzones', $dim['Xzones']); ?>" name="Xzones" style="margin-right: 30px;"/>
							</td>
							<td>
								<label style="margin-top: 50px;">2 </label><input type="text" size="4" value="<?php echo set_value('Yimage', $dim['Yimage']); ?>" name="Yimage" />
								<label>4 </label><input type="text" size="4" value="<?php echo set_value('Yinfo', $dim['Yinfo']); ?>" name="Yinfo" />
								<label>6 </label><input type="text" size="4" value="<?php echo set_value('Yzones', $dim['Yzones']); ?>" name="Yzones" />
							</td>
						</tr>
					</table>
					<div class="clear"></div>
				</div>
				
				<br />
				
				<h2>Accréditation format carte</h2>
				<div style="margin: 0 15px;">
					<img src="<?php echo img_url('accreds/accredCarte.png'); ?>" alt="Accréditation carte" width="300" height="140" style="float: right;vertical-align: middle;" />
					<table>
						<tr>
							<td>
								<label style="margin-top: 30px;">1 </label><input type="text" size="4" value="<?php echo set_value('Ximagec', $dim['Ximagec']); ?>" name="Ximagec" style="margin-right: 30px;"/>
								<label>3 </label><input type="text" size="4" value="<?php echo set_value('Xinfoc', $dim['Xinfoc']); ?>" name="Xinfoc" style="margin-right: 30px;"/>
								<label>5 </label><input type="text" size="4" value="<?php echo set_value('Xzonesc', $dim['Xzonesc']); ?>" name="Xzonesc" style="margin-right: 30px;"/>
							</td>
							<td>
								<label style="margin-top: 30px;">2 </label><input type="text" size="4" value="<?php echo set_value('Yimagec', $dim['Yimagec']); ?>" name="Yimagec" />
								<label>4 </label><input type="text" size="4" value="<?php echo set_value('Yinfoc', $dim['Yinfoc']); ?>" name="Yinfoc" />
								<label>6 </label><input type="text" size="4" value="<?php echo set_value('Yzonesc', $dim['Yzonesc']); ?>" name="Yzonesc" />
							</td>
						</tr>
					</table>
					<div class="clear"></div>
				</div>
				
				<input type="submit" class="button" style="float: right; margin-top: 20px;" name="valider" value="Enregistrer" />
			</form>
		
		<div class="clear"></div>

    </div>
	
</div>

<br />