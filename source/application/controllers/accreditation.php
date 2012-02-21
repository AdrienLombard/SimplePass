<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accreditation extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('modelaccreditation');
		
	}


	public function index() {
		
		$this->load->model('modelclient');
		$data['clients'] = $this->modelclient->getClientsAvecAccred();
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	public function demandes() {
		
		$data['accreditations'] = $this->modelaccreditation->getAccreditations();
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	public function ajout() {
		
		$this->layout->view('utilisateur/accreditation/UAAjout');
		
	}

}