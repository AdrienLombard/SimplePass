<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Cafe {
	
	
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct()
	{
		parent::__construct();
		/* on charge le model user*/
		$this->load->model('modelutilisateur');

	}
	public function index()
	{
    
            $this->layout->ajouter_css('utilisateur/login');
            $this->layout->view('utilisateur/ULogin');

	}
     
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */