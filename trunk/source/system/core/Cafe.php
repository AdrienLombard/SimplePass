<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cafe extends CI_Controller {
    
    private $auth = array();
	
	public function __construct() {
        
        parent::__construct();
		
		// debug
		$this->output->enable_profiler(true);
		
		// theme du layout
		$this->layout->set_theme('layoutCafe');
		
		$this->layout->set_login($this->session->userdata('login'));
        
		$this->layout->set_titre('SimplePass Accreditations - Courchevel');
        
		$this->layout->ajouter_css('app/app');
		$this->layout->ajouter_css('app/forms');
		$this->layout->ajouter_css('utilisateur/box');
		$this->layout->ajouter_css('utilisateur/content');
		
		$this->layout->ajouter_js('jquery-1.7.1.min');
		$this->layout->ajouter_js('app/main');
		$this->layout->ajouter_js('utilisateur/scriptGeneral');
		
		$this->layout->ajouter_css('utilisateur/cafe');
		
		
		// Barre des evenements
		$this->load->model('modelevenement');
		$this->layout->add_var('topMenuEvenements', $this->modelevenement->getEvenementEnCours());
        
    }
	
	public function securise($array) {
		$this->auth = $array;
	}
	
	public function securiseAll() {
		$this->auth = get_class_methods($this);
	}
	
	/*
	 * Remapage de l'URL, permet de vérifier la sécurité en amont
	 * @param $method : nom de la méthode demandée
	 * @param @args 
	 * @auteur : Aymeric hahahahahaha !
	 */
	public function _remap($method, $args = null) {
		// on lance la méthode si : méthode sécurisé & user loggé ou méthode non sécurisé
		if((in_array($method, $this->auth) && $this->session->userdata('login')) || !in_array($method, $this->auth))
			call_user_func_array(array($this, $method), $args);
		else {
			$this->load->helper('url');
			redirect($this->router->routes['default_controller']);
		}
	}
    
}

?>
