<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evenements extends Cafe {
	
	
    public function __construct() {
            parent::__construct();
    }


    public function index() {
        // TODO
		$this->layout->ajouter_css('utilisateur/liste');
        $this->layout->view('utilisateur/evenement/UEIndex');
    }
    
    public function voir() {
        // TODO
		$this->layout->ajouter_css('utilisateur/details');
		$this->layout->view('utilisateur/evenement/UEVoir');
    }
    
    public function ajout() {
        // TODO
		$this->layout->view('utilisateur/evenement/UEAjout');
    }
    
    public function modification() {
        // TODO
		$this->layout->view('utilisateur/evenement/UEModification');
    }
    
    public function suppression() {
        // TODO
    }
}