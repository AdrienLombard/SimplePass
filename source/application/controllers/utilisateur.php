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
		$this->layout->ajouter_css('utilisateur/login');
		$this->layout->view('utilisateur/ULogin', $data);
	}
	 
	
	public function connexion(){
		// On récupère les données entrée par l'utilisateur.
		$login 	= $this->input->post('login');
		$mdp 	= $this->input->post('mdp');
		
		// On regarde dans la base si l'utilisateur existe.
		$donnesUtilisateur = $this->modelUtilisateur->getMDP($login);
		
		if(isset($donnesUtilisateur)){
			if($donnesUtilisateur[0]->mdp == $mdp) {
				$data['nom'] = $donnesUtilisateur[0]->nom . " " . $donnesUtilisateur[0]->prenom;
				$this->layout->view('utilisateur/UWelcome', $data);
			}
			else {
				$message = 'Le mot de passe est incorrect.';
				$this->index($message);
			}
		}
		else {
			$message = "L'utilisateur " . $login . " n'existe pas.";
			$this->index($message);
		}
		
	}
}

/* End of file utilisateur.php */
/* Location: ./application/controllers/utilisateur.php */
