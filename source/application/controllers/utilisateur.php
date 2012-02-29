<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class utilisateur extends Cafe {
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('modelutilisateur');
		
		$this->lang->load('test');
	}
	
	
	public function index($message = '')
	{
		if($this->session->userdata('login')) {
			$data['nom'] = $this->session->userdata('login');
			$this->layout->view('utilisateur/UWelcome', $data);
		}
		else {
			$data['message'] = $message;
			$this->layout->ajouter_css('utilisateur/login');
			$this->layout->view('utilisateur/ULogin', $data);
		}
		
		echo $this->lang->line('key');
	}
	 
	
	public function connexion(){
		// On récupère les données entrée par l'utilisateur.
		$login 	= $this->input->post('login');
		$mdp 	= $this->input->post('mdp');
		
		if($login && $mdp) {
			// On regarde dans la base si l'utilisateur existe.
			$donnesUtilisateur = $this->modelutilisateur->getMDP($login);

			if(!empty($donnesUtilisateur)){
				if($donnesUtilisateur[0]->mdp == $mdp) {
					$this->session->set_userdata('login', $donnesUtilisateur[0]->login);
					
					$data['nom'] = $donnesUtilisateur[0]->login;
					
					$this->layout->add_redirect('utilisateur', 0.1);
					
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
		else {
			$message = "Veuillez remplir tous les champs.";
			$this->index($message);
		}

	}
	
	
	public function deconnexion() {
		if($this->session->userdata('login')) {
			$this->session->unset_userdata('login');
		}
		$this->layout->add_redirect('utilisateur', 0.1);
		
		$data['titre']		= 'Déconnexion';
		$data['message']	= 'Vous avez bien été déconnecté.';
		$data['redirect'] 	= 'utilisateur/index';
		$this->layout->view('utilisateur/UMessage', $data);
	}
}

/* End of file utilisateur.php */
/* Location: ./application/controllers/utilisateur.php */
