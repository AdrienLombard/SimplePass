<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccreditationL extends Chocolat {
	
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct() {
		parent::__construct();
		
		// Chargement du css.
		
		
		// Chargement du modele.
		
	}
	
	
	public function index() {
		
		//$this->ajouter();
		
		$this->lambda();
		
	}
	
	public function lambda() {
		
		$this->layout->view('inscription/remplissageEquipe');
		
	}
	
	public function ajouter() {
		// Charge la librairie de validation de formulaire
		$this->load->library('form_validation');
		
		// variable pour transmettre des données à la vue.
		$data = Array();
		
		// On regle les paramètres du formulaire.
		$this->form_validation->set_message('required', 'Le champ %s est obligatoire.');
		$this->form_validation->set_message('valid_email', 'Veuillez rentrer un e-Mail valide.');
		$this->form_validation->set_error_delimiters('<p class="error_message" >', '<p>');
		
		// On définie les règles de validation du formulaire.
		$config = array(
			array(
				'field'   => 'nom',
				'label'   => 'Nom', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'prenom',
				'label'   => 'Prenom', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'pays',
				'label'   => 'Pays', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'tel',
				'label'   => 'numéro de téléphone', 
				'rules'   => ''
			),
			array(
				'field'   => 'titre',
				'label'   => 'Titre', 
				'rules'   => ''
			),
			array(
				'field'   => 'role',
				'label'   => 'Rôle', 
				'rules'   => ''
			),
			array(
				'field'   => 'civilite',
				'label'   => 'Civilité', 
				'rules'   => ''
			),
			array(
				'field'   => 'categorie',
				'label'   => 'Catégorie', 
				'rules'   => ''
			),
			array(
				'field'   => 'mail',
				'label'   => 'e-Mail', 
				'rules'   => 'required|valid_email'
			)
		);
		
		$this->form_validation->set_rules($config);
		
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->layout->view('inscription/inscriptionIndividuelle');
		
		}
		else {
			
			/*$data['nom'] = $this->input->post('nom');
			$data['prenom'] = $this->input->post('prenom');
			$data['pays'] = $this->input->post('pays');
			$data['tel'] = $this->input->post('tel');
			$data['titre'] = $this->input->post('titre');
			$data['role'] = $this->input->post('role');
			$data['civilite'] = $this->input->post('civilite');
			$data['categorie'] = $this->input->post('categorie');
			$data['mail'] = $this->input->post('mail');*/
			
			//TODO mettre l'insertion dans la base.
		
		}
		
		
	}

}

/* End of file accreditationL.php */
/* Location: ./application/controllers/accreditationL.php */