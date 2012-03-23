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
			$data['evenement'] = $this->modelevenement->getLastEvenement()->libelleevenement;
			$this->layout->view('utilisateur/UWelcome', $data);
		}
		else {
			$data['message'] = $message;
			$this->layout->ajouter_css('utilisateur/login');
			$this->layout->view('utilisateur/ULogin', $data);
		}
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
					
					$this->load->model('modelevenement');
					$this->session->set_userdata('idEvenementEnCours', $this->modelevenement->getLastEvenement()->idevenement);
					$this->session->set_userdata('libelleEvenementEnCours', $this->modelevenement->getLastEvenement()->libelleevenement);
					
					$data['evenement'] = $this->modelevenement->getLastEvenement()->libelleevenement;

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
	
	
	public function change($event, $url) {
		
		$this->session->set_userdata('idEvenementEnCours', $event);
		
		$this->load->model('modelevenement');
		$e = $this->modelevenement->getEvenementParId($event);
		$this->session->set_userdata('libelleEvenementEnCours', $e[0]->libelleevenement);
		
		$this->load->helper('url');
		redirect(str_replace('__', '/', $url));
		
	}

	public function test() {
		
		$this->layout->ajouter_js('test');
		
		$this->layout->view('test.php');
	}
	
	
}

/* End of file utilisateur.php */
/* Location: ./application/controllers/utilisateur.php */
