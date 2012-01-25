<?php

class Chocolat extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
		
		$this->layout->set_theme('layoutChocolat');
        
        $this->layout->ajouter_css('app/app');
        $this->layout->ajouter_css('app/forms');
        
        $this->layout->set_titre('Courchevel');
        
        $this->layout->ajouter_css('lambda/lambda');
        
    }
    
}

?>
