<?php

class Chocolat extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
		
		// debug
		//$this->output->enable_profiler(true);
		
		$this->layout->set_theme('layoutChocolat');
        
        $this->layout->ajouter_css('app/app');
        $this->layout->ajouter_css('app/forms');
        
        $this->layout->set_titre('Accreditations Courchevel');
        
		$this->layout->ajouter_js('jquery-1.7.1.min');
		
        $this->layout->ajouter_css('lambda/lambda');
        
    }
    
}

?>
