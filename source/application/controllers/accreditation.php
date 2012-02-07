<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accreditation extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('modelAccreditation');
		
	}


	public function index() {
		
		$data['accreditations'] = $this->modelAccreditation->getAccreditation();
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}

}