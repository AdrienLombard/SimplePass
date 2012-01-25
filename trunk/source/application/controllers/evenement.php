<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evenement extends Cafe {
	
	
    public function __construct() {
            parent::__construct();
    }


    public function index() {
        $this->layout->ajouter_css('utilisateur/liste');
        $this->layout->view('utilisateur/evenement/UEIndex');
    }
    
    public function voir() {
        $this->layout->ajouter_css('utilisateur/details');
		$this->layout->view('utilisateur/evenement/UEVoir');
    }
    
    public function ajout() {
        $this->layout->view('utilisateur/evenement/UEAjout');
    }
    
    public function modification() {
        $this->layout->view('utilisateur/evenement/UEModification');
    }
    
    public function suppression() {
        $this->layout->view('utilisateur/evenement/UESuppression');
    }
}