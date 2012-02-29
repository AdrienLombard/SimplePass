<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inscription extends Chocolat {
	
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct() {
		parent::__construct();
		
		// Charge la librairie de validation de formulaire
		$this->load->library('form_validation');
		
		// Chargement du css.
		
		
		// Chargement du modele.
		$this->load->model('modelaccreditation');
		$this->load->model('modelevenement');
		$this->load->model('modelcategorie');
		$this->load->model('modellambda');
		$this->load->model('modelclient');
	}
	
	
	public function index() {
		
		$this->lambda();
		
	}
	
	
	/**
	 * Méthode pour le choix d'une inscription individuelle ou par équipe et de l'évènement.
	 */
	public function lambda() {
		$this->layout->ajouter_js('lambda/script');
		
		$data['events'] = $this->modelevenement->getEvenementEnCours();
		
		$this->layout->view('lambda/LAccueil', $data);
	}
	
	
	/**
	 * Méthode pour afficher le formulaire pour l'ajout individuelle.
	 * Comprend également le traitement complet.
	 */
	public function ajouter($event='') {
		// Chargement du js.
		$this->layout->ajouter_js('lambda/script');
		
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
				'rules'   => ''
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
		
		
		if ($this->form_validation->run() == false) {
			
			$data['event_id'] = $event;
			
			$data['event_info'] = $this->modelevenement->getEvenementParId($event);
			
			$data['listePays'] = $this->modellambda->listePays();
			
			$data['listeSurCategorie'] = $this->modelcategorie->getCategorieMere();
			
			$data['listeCategorie'] = $this->modelcategorie->getCategories();
			
			$this->layout->view('lambda/LIndividuelle', $data);
		
		}
		else {
			
			$verification = $this->modelaccreditation->verificationAccred(
					$event, 
					strtoupper($this->input->post('nom')), 
					$this->input->post('prenom'),
					$this->input->post('pays')
			);
			
			if(!$verification) {
				$values = Array (
					'nom' 		=> strtoupper($this->input->post('nom')),
					'prenom' 	=> $this->input->post('prenom'),
					'pays' 		=> $this->input->post('pays'),
					'civilite' 	=> $this->input->post('civilite'),
					'mail' 		=> $this->input->post('mail')
				);

				// On gère les champs facultatif.
				$tel = $this->input->post('tel');
				if(isset($tel) && !empty($tel)) {
					$values['tel'] = $tel;
				}

				$organisme = $this->input->post('titre');
				if(isset($organisme) && !empty($organisme)) {
					$values['organisme'] = $organisme;
				}

				$categories = $this->input->post('categorie');
				$categorie = null;
				foreach($categories as $cat) {
					if($cat != "-1")
						$categorie = $cat;
				}

				//Insertion dans la base.
				$idClient = $this->modelclient->ajouter($values);


				$accredData = Array(
					'idcategorie'		=> $categorie,
					'idevenement'		=> $event,
					'idclient'			=> $idClient,
					'etataccreditation'	=> ACCREDITATION_A_VALIDE,
					'dateaccreditation' => time()
				);

				$role = $this->input->post('choixRole');
				if($role == 'Oui') {
					$role = $this->input->post('role');
					if(isset($role) && !empty($role)) {
						$accredData['fonction'] = $role;
					}
				}

				$this->modelaccreditation->ajouter($accredData);


				$data['titre']		= 'Confirmation de demande';
				$data['message']	= 'Votre demande a bien été prise en compte.<br>Merci de votre pré-enregistrement.';
				
			}
			else {
				$data['titre']		= 'Information';
				$data['message']	= 'Vous avez déjà une demande d\'accréditation enregistré pour cette évènement.';
				
			}
			
			
			
			$this->layout->view('lambda/LMessage', $data);
			 
		
		}
		
	}
	
	
	/**
	 * Méthode pour le formulaire pour la saisie du responsable d'une équipe.
	 */
	public function groupe($evenement, $info=false) {
		// Chargement du js.
		$this->layout->ajouter_js('lambda/script');
		
		$data['idEvenement']	= $evenement;
		$data['infoEvenement'] 	= $this->modelevenement->getEvenementParId($evenement);
		$data['listePays'] 		= $this->modellambda->listePays();
		$data['listeCategorie'] = $this->modelcategorie->getCategories();
		$data['listeSurCategorie'] = $this->modelcategorie->getCategoriesMere();
		$data['values'] = $info;
		
		$this->layout->view('lambda/LGroupe', $data);
			
	}
	
	
	/**
	 * Méthode de traitement pour la saisie du responsable.
	 */
	public function exeGroupe() {
				
		$idEvenement = $this->input->post('evenement');
		
		// On regle les paramètres du formulaire.
		$this->form_validation->set_message('roequired', 'Le champ %s est obligatoire.');
		$this->form_validation->set_message('valid_email', 'Veuillez rentrer un mail valide.');
		$this->form_validation->set_error_delimiters('<p class="error_message" >', '<p>');
		
		// On définie les règles de validation du formulaire.
		$config = array(
			array(
				'field'   => 'groupe',
				'label'   => 'Nom du groupe', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'nom',
				'label'   => 'Nom', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'prenom',
				'label'   => 'Prénom', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'role',
				'label'   => 'Rôle', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'tel',
				'label'   => 'Téléphone', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'mail',
				'label'   => 'Mail', 
				'rules'   => 'required|valid_email'
			)
		);
		
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == false) {
			
			$values->groupe 	= $this->input->post('groupe');
			$values->pays 		= $this->input->post('pays');
			$values->nom 		= strtoupper($this->input->post('nom'));
			$values->prenom 	= $this->input->post('prenom');
			$values->role 		= $this->input->post('role');
			$values->mail 		= $this->input->post('mail');
			$values->tel 		= $this->input->post('tel');
			$values->categorie 	= $this->input->post('categorie');
			
			$this->groupe($idEvenement, $values);
			
		}
		else {
			
			$data['groupe'] 	= $this->input->post('groupe');
			$data['pays'] 		= $this->input->post('pays');	
			$data['nom'] 		= $this->input->post('nom');
			$data['prenom'] 	= $this->input->post('prenom');
			$data['categorie'] 	= $this->input->post('categorie');
			$data['role'] 		= $this->input->post('role');
			$data['tel'] 		= $this->input->post('tel');
			$data['mail'] 		= $this->input->post('mail');
			$data['evenement'] 	= $this->input->post('evenement');
			$data['listeSurCategorie'] = $this->modellambda->listeSurCategorie();
			$data['listeCategorie'] = $this->modellambda->listeCategorie();
			
			$this->ajouterGroupe($data);
		}
		
	}
	
	
	/**
	 * Méthode pour l'ajout de tous les membres d"une équipe.
	 */
	public function ajouterGroupe($data) {
		$data['listeCategorie'] = $this->modelcategorie->getCategories();
		$this->layout->ajouter_js('lambda/scriptGroupe');
		$this->layout->view('lambda/LGroupeDetails', $data);
	}
	
	
	/**
	 * Méthode pour le traitement de l'ajout des membres d'une équipe.
	 */
	public function exeAjouterGroupe() {		
		// ajout du référent
		$ref = $data = $this->input->post('ref');
		unset($ref['categorie']);
		$id = $this->modelclient->ajouter($ref);
		
		// création de l'accreditation pour le referent
		$accred = null;
		$accred['idcategorie'] = $data['categorie'];
		$accred['idevenement'] = $this->input->post('evenement');
		$accred['idclient'] = $id;
		$accred['etataccreditation'] = 1;
		$this->modelaccreditation->ajouter($accred);
		
		// ajout des membres
		foreach($this->input->post('groupe') as $ligne) {
			// création du client
			$membre = null;
			$membre['nom'] = $ligne['nom'];
			$membre['prenom'] = $ligne['prenom'];
			$membre['role'] = $ligne['role'];
			$membre['pays'] = $data['pays'];
			$membre['groupe'] = $data['groupe'];
			$membre['referent'] = $id;
			$idNewClient = $this->modelclient->ajouter($membre);

			// création de l'accreditation
			$accred = null;
			$accred['idcategorie'] = $ligne['categorie'];
			$accred['idevenement'] = $this->input->post('evenement');
			$accred['idclient'] = $idNewClient;
			$accred['etataccreditation'] = 1;
			$this->modelaccreditation->ajouter($accred);
		}
		
		$msg['titre']	= 'Confirmation de demande';
		$msg['message']	= 'Vos demandes ont bien été prises en compte.<br>Merci de votre pré-enregistrement.';
		$this->layout->view('lambda/LMessage', $msg);
	}
	
}

/* End of file inscription.php */
/* Location: ./application/controllers/inscription.php */