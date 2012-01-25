<?php

class Cafe extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->layout->ajouter_css('app/app');
        $this->layout->ajouter_css('app/forms');
        
        $this->layout->ajouter_css('utilisateur/layoutUtilisateur');
        
    }
    
}

?>
