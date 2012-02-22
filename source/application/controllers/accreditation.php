<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accreditation extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('modelaccreditation');
		
		$this->layout->ajouter_css('utilisateur/accreditation');
		
	}


	public function index() {
		
		$data['accreds'] = $this->modelaccreditation->getAccreditationsParEvenement(1);
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	public function demandes() {
		
		$data['accreditations'] = $this->modelaccreditation->getAccreditations();
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	public function voir() {
		
		$this->layout->view('utilisateur/accreditation/UAVoir');
		
	}
	
	public function ajouter() {
		
		$this->layout->view('utilisateur/accreditation/UAAjout');
		
	}
	
	public function ajouterClient() {
		
	}
	
	public function exeAjouterClient() {
		
	}
	
	public function ajouterAccreditation() {
		
	}
	
	public function exeAjouterAccreditation() {
		
	}

}