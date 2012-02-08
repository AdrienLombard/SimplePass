<?php

class Cafe extends CI_Controller {
    
    private $autorisations;
	private $login = false;
	
	public function __construct() {
        
        parent::__construct();
		
		//$this->output->enable_profiler(true);
		
		$this->layout->set_theme('layoutCafe');
		
		$this->login = ($this->session->userdata('login'))? true : false;
		$this->layout->set_login($this->login);
        
        $this->layout->set_titre('Courchevel');
		
        $this->layout->ajouter_css('jquery-ui-1.8.17.custom');
        
		$this->layout->ajouter_css('app/app');
        $this->layout->ajouter_css('app/forms');
        
        $this->layout->ajouter_css('utilisateur/box');
        $this->layout->ajouter_css('utilisateur/content');
        
		
		$this->layout->ajouter_js('jquery-1.7.1.min');
		$this->layout->ajouter_js('jquery-ui-1.8.17.min');
        $this->layout->ajouter_js('app/main');
		
		$this->layout->ajouter_css('utilisateur/cafe');
        
    }
	
	public function securise($array) {
		$this->autorisations = $array;
	}
	/*
	public function __call($method, $args) {
		echo $method;
		
		if( (in_array($method, $this->autorisations) && $this->login) || !in_array($method, $this->autorisations)) {
			$this->$method($args);
		}
		else echo 'plop ! pas le droit hahahaha !';
	}
    */
}

?>
