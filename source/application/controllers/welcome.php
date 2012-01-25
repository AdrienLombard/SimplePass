<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Cafe {
	
	
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('user_model');
	}
	
	
	public function index()
	{
            $this->layout->ajouter_css('utilisateur/login');
            $this->layout->view('utilisateur/uLogin');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */