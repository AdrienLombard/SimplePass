<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accreditation extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('modelaccreditation');
		
		$this->layout->ajouter_css('utilisateur/accreditation');
		$this->layout->ajouter_js('utilisateur/CRUDAccred');
		
	}


	public function index() {
		
		$data['accreds'] = $this->modelaccreditation->getAccreditationsParEvenement(1);
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	public function demandes() {
		
		$data['accreditations'] = $this->modelaccreditation->getAccreditations();
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	public function voir($idClient) {
		
		$this->load->model('modelclient');
		
		$data['client'] = $this->modelclient->getClientParId($idClient);
		
		$this->layout->view('utilisateur/accreditation/UAVoir', $data);
		
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