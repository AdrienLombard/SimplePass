<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('user_model');
		
		$this->layout->ajouter_css('design');
	}
	
	
	public function index()
	{
		$this->layout->view('acceuil/welcome_message');
	}

	public function listingUser() {
		
		$resultat = $this->user_model->getUtilisateur();
		
		$data['users'] = $resultat;
		
		$this->layout->view('user_list', $data);
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */