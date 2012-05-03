<div id="login">
    <form method="post" action="<?php echo site_url('utilisateur/connexion'); ?>">
		
        <h2>Authentification</h2>
       
        <label>Nom d'utilisateur</label>
        <input type="text" name="login"/>

        <label>Mot de passe</label>
        <input type="password" name="mdp"/>
		
		<?php if(isset($message) && $message != ''): ?>
		<div class="loginErreur" ><?php echo $message; ?></div>
		<?php endif; ?>
		
        <div class="clear"></div>
		
		<input type="submit" name="valider"/>
		
		<div class="clear"></div>

    </form>
</div>