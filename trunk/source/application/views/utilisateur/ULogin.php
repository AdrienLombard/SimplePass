<div id="login">
    <form method="post" action="<?php echo site_url('utilisateur/connexionUtilisateur'); ?>">
		
        <h2>Authentification</h2>
       
        <label>Nom d'utilisateur</label>
        <input type="text" name="login"/>

        <label>Mot de passe</label>
        <input type="password" name="mdp"/>

        <input type="submit" name="valider"/>
		
		<span class="erreur" ><?php if(isset($message)) echo $message; ?></span>
		
        <div class="clear"></div>

    </form>
</div>