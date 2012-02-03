<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class utilisateur extends Cafe {
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('modelUtilisateur');
	}
	
	
	public function index($message='')
	{
		$data['message'] = $message;
		echo $data['message'];
		$this->layout->ajouter_css('utilisateur/login');
		$this->layout->view('utilisateur/ULogin', $data);
	}
	 
	
	public function connexion(){
		$login = $this->input->post('login');
		$mdp = $this->input->post('mdp');
		$mdpBD = $this->modelUtilisateur->getMDP($login);
		if(isset($mdpBD)){
			if($mdpBD[0]->mdp == $mdp) {
				$this->layout->view('utilisateur/UWelcome');
			}
			else {
				$message = 'Le mot de passe est incorrect.';
				echo 'BB'.$message;
				$this->index($message);
			}
		}
		else {
			$message = 'Le login est incorrect.';
			echo 'BB'.$message;
			$this->index($message);
		}
		
	}
}

/* End of file utilisateur.php */
/* Location: ./application/controllers/utilisateur.php */
