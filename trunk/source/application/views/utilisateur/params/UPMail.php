<h1>Parametrage de l'application</h1>

<div class="wrap">

    <div class="tabs">
        <a href="<?php echo site_url('utilisateur/configAccred'); ?>" >Accreditations</a>
        <a href="<?php echo site_url('utilisateur/configMail'); ?>" class="current">Mail de confirmation</a>
    </div>

    <div class="box-full">

        <div id="main">
			<form action="<?php echo site_url('utilisateur/configMail'); ?>" method="post">
			
				<label>Adresse mail de l'expéditeur</label><input type="text" size="50" value="<?php echo set_value('mail_expediteur', $mail['mail_expediteur']); ?>" name="mail_expediteur" />
				<label>Nom de l'expéditeur</label><input type="text" size="50" value="<?php echo set_value('nom_expediteur', $mail['nom_expediteur']); ?>" name="nom_expediteur" />
				<label>Adresse mail qui recevra une copie</label><input type="text" size="50" value="<?php echo set_value('mail_copie', $mail['mail_copie']); ?>" name="mail_copie" />
				<label>Objet du mail</label><input type="text" size="50" value="<?php echo set_value('objet_mail', $mail['objet_mail']); ?>" name="objet_mail" />
				<label>"Cher(e)"</label><input type="text" size="50" value="<?php echo set_value('cher', $mail['cher']); ?>" name="cher" />
				<label>"Dear"</label><input type="text" size="50" value="<?php echo set_value('dear', $mail['dear']); ?>" name="dear" />
				<label>Introduction du mail</label><textarea name="intro_mail" rows="10" cols="90" ><?php echo set_value('intro_mail', $mail['intro_mail']); ?></textarea>
				<label>Suite du mail (après les infos d'accréditation)</label><textarea name="traitement_mail" rows="10" cols="90" ><?php echo set_value('traitement_mail', $mail['traitement_mail']); ?></textarea>
				<label>Signature du mail</label><textarea name="signature_mail" rows="10" cols="90" ><?php echo set_value('signature_mail', $mail['signature_mail']); ?></textarea>
				
				<input type="submit" class="button" style="float: right; margin-top: 20px;" name="valider" value="Enregistrer" />
			</form>
		
		<div class="clear"></div>

    </div>

</div>

<br />