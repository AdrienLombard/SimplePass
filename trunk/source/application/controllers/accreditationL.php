<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccreditationL extends Chocolat {
	
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct() {
		parent::__construct();
		
		// Chargement du css.
		
		
		// Chargement du modele.
		$this->load->model('modelLambda');
	}
	
	
	public function index() {
		
		//$this->ajouter();
		
		$this->lambda();
		
	}
	
	public function lambda() {
		
		$this->layout->ajouter_js('lambda/script');
		
		$this->layout->view('inscription/lambda');
		
	}
	
	public function ajouter($event='') {
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
			
			$data['event'] = $event;
			
			$this->layout->view('inscription/inscriptionIndividuelle', $data);
		
		}
		else {
			
			$values = Array (
				'nom' 		=> $this->input->post('nom'),
				'prenom' 	=> $this->input->post('prenom'),
				'pays' 		=> 1,
				'civilite' 	=> $this->input->post('civilite'),
				'mail' 		=> $this->input->post('mail')
			);
			
			// On gère les champs facultatif.
			$tel = $this->input->post('tel');
			if(isset($tel) && !empty($tel)) {
				$values['tel'] = $tel;
			}
			
			$role = $this->input->post('role');
			if(isset($role) && !empty($role)) {
				$values['role'] = $role;
			}
			
			$titre = $this->input->post('tel');
			if(isset($titre) && !empty($titre)) {
				$values['tel'] = $titre;
			}
			
			//Insertion dans la base.
			$this->modelLambda->ajouterClient($values);
		
			
			/*
			$idClient = $this->modelLambda->lastId();
			
			$accredData = Array(
				'icategorie'		=> $this->input->post('categorie'),
				'idevenement'		=> $event,
				'idclient'			=> $idClient,
				'etataccreditation'	=> ACCREDITATION_A_VALIDE
			);
			
			$this->modelLambda->ajouterAccred($accredValues);
			 */
			
			$data['titre']		= 'Confirmation de demande';
			$data['message']	= 'Votre demande a bien été prise en compte.<br>Merci de votre pré-enregistrement.';
			$this->layout->view('inscription/message', $data);
			 
		
		}
		
	}
	
}

/* End of file accreditationL.php */
/* Location: ./application/controllers/accreditationL.php */