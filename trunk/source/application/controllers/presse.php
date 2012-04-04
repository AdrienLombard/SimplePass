<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presse extends Chocolat{
	
	public function __construct() {
		
		parent::__construct();
		
		// Chargement des modeles.
		$this->load->model('modelclient');
		$this->load->model('modelpays');
		$this->load->model('modelaccreditation');
		$this->load->model('modelevenement');
		$this->load->model('modelcategorie');
		$this->load->model('modelzone');
		$this->load->model('modellambda');
		
		$this->layout->ajouter_css('jquery.Jcrop');
		$this->layout->ajouter_js('jquery.Jcrop.min');
		
		// Chargement des librairie.
		$this->load->library('form_validation');
		
       // Chargement du fichier de langue
		$this->load->helper('language');
		$this->chargerLangue();
	}

	public function index() {

		redirect('inscription');

	}

	/**
	 * Méthode pour le choix d'une inscription individuelle ou par équipe et de l'évènement.
	 */
	public function lambda( $categorie ) {
		$this->layout->ajouter_js('lambda/script');

		$data['events'] 	= $this->modelevenement->getEvenementEnCours();
		$data['categorie']	= $categorie;

		$this->layout->view('presse/LAccueilPress', $data);
	}


   public function changerLangage($langage, $url) {
		
		if($langage === 'fra') {
			$this->session->set_userdata('lang', 'fra');
		}
		else if($langage === 'gbr') {
			$this->session->set_userdata('lang', 'gbr');
		}
		$urlOk = str_replace(':', '/', $url);
		redirect($urlOk);
		
	}
	
	public function chargerLangue() {
		
		if($this->session->userdata('lang')) {
		
			if($this->session->userdata('lang') == 'fra') {
				$this->config->set_item('language', 'french'); 
				$this->lang->load('fr');
			}
			else if($this->session->userdata('lang') == 'gbr') {
				$this->config->set_item('language', 'english'); 
				$this->lang->load('en');
			}
		}
		else {
			$this->config->set_item('language', 'french'); 
			$this->lang->load('fr');
		}
	}
	public function ajouter($event='',$categorie='') {
		// Chargement du js.
	   $this->layout->ajouter_js('lambda/script'); 
	 
	
		// variable pour transmettre des données à la vue.
		$data = Array();
		
		// On regle les paramètres du formulaire.
		$this->form_validation->set_message('required', $this->lang->line('champRequis'));
		$this->form_validation->set_message('valid_email', $this->lang->line('emailValide'));
		$this->form_validation->set_error_delimiters('<p class="error_message" > *', '</p>');
		
		// On définie les règles de validation du formulaire.
		$config = array(
			array(
				'field'   => 'nom',
				'label'   => $this->lang->line('nom'), 
				'rules'   => 'required'
			),
			array(
				'field'   => 'prenom',
				'label'   => $this->lang->line('prenom'), 
				'rules'   => 'required'
			),
			array(
				'field'   => 'pays',
				'label'   => $this->lang->line('pays'), 
				'rules'   => ''
			),
			array(
				'field'   => 'adresse',
				'label'   => 'Adresse',
				'rules'   => 'required',
			),
			array(
				'field'   => 'tel',
				'label'   => $this->lang->line('tel'),
				'rules'   => 'required'
			),
		    array(
				'field'   => 'numr_carte',
				'label'   => 'Numero carte de presse',
				'rules'   => 'required'
			),
			array(
				'field'   => 'titre',
				'label'   => $this->lang->line('titre'), 
				'rules'   => 'required'
			),
			array(
				'field'   => 'fonction',
				'label'   => $this->lang->line('fonction'), 
				'rules'   => ''
			),
			array(
				'field'   => 'categorie',
				'label'   => $this->lang->line('categorie'), 
				'rules'   => ''
			),
			array(
				'field'   => 'mail',
				'label'   => $this->lang->line('mail'), 
				'rules'   => 'required|valid_email'
			)
		);
		
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == false) {
			
			$data['event_id'] = $event;
			
			$data['event_info'] = $this->modelevenement->getEvenementParId($event);
			
			$data['listePays'] = $this->modellambda->listePays();
			
		    $data['listeSurCategorie'] 	= $this->modelcategorie->getSousCategorie($categorie);
			
			$data['listeCategorie'] = $this->modelcategorie->getCategories();

			$data['categorie'] = $categorie;
			
			$this->layout->view('presse/LPresseindividuelle', $data);
		
		}
		else {

			// On vérifie si une accréditation a deja été faite.
			$verification = $this->modelaccreditation->verificationAccred(
					$event, 
					strtoupper($this->input->post('nom')), 
					$this->input->post('prenom'),
					$this->input->post('pays')
 			);

			// Si aucune accréditation on ajoute celle-ci.
			if(!$verification) {
				$values = Array (
					'nom' 			=> strtoupper($this->input->post('nom')),
					'prenom' 		=> $this->input->post('prenom'),
					'pays' 			=> $this->input->post('pays'),
					'mail' 			=> $this->input->post('mail'),
					'tel'			=> $this->input->post('tel'),
					'adresse'		=> $this->input->post('adresse'),
					'organisme'		=> $this->input->post('titre')
				);

				// On gère les champs facultatif.
				$categories = $this->input->post('categorie');
				$categorie = end($categories);

				//Insertion dans la base.
				$idClient = $this->modelclient->ajouter($values);

				// On construit l'accréditation.
				$accredData = Array(
					'idcategorie'		=> $categorie,
					'idevenement'		=> $event,
					'idclient'			=> $idClient,
					'etataccreditation'	=> ACCREDITATION_A_VALIDE,
					'dateaccreditation' => time(),
					'numeropresse'		=> $this->input->post('numr_carte'),
					'fonction'			=> $this->input->post('fonction')
				);


				$this->modelaccreditation->ajouter($accredData);


				$data['titre']		= $this->lang->line('titreConfirmeDemande');
				$data['message']	= $this->lang->line('confirmeDemande');
				
			}
			else {
				$data['titre']		= $this->lang->line('titreDemandeNon');
				$data['message']	= $this->lang->line('demandeNon');
				
			}
			
			if($_FILES['photo_file']['size'] != 0)
				$this->upload($idClient);
			
			$this->layout->view('lambda/LMessage', $data); 
		}
	}
	/**
	 * Méthode pour le formulaire pour la saisie du responsable d'une équipe.
	 */
	public function groupe($evenement, $categorie, $info=false) {
		// Chargement du js.
		$this->layout->ajouter_js('lambda/script');

		$data['idEvenement']	= $evenement;
		$data['infoEvenement'] 	= $this->modelevenement->getEvenementParId($evenement);
		$data['listePays'] 		= $this->modellambda->listePays();
		$data['listeCategorie'] = $this->modelcategorie->getCategories();
		$data['listeSurCategorie'] 	= $this->modelcategorie->getSousCategorie($categorie);
		$data['values'] = $info;
		$data['cate'] = $categorie;
		
		$this->layout->view('presse/LPresseGroupe', $data);
			
	}
	
	
	/**
	 * Méthode de traitement pour la saisie du responsable.
	 */
	public function exeGroupe( $categorie ) {
				
		$idEvenement = $this->input->post('evenement');
		$categorie=$this->session->userdata('categorie');
	    echo $categorie;
		// On regle les paramètres du formulaire.
		$this->form_validation->set_message('required', 'Le champ %s est obligatoire.');
		$this->form_validation->set_message('valid_email', 'Veuillez rentrer un mail valide.');
		$this->form_validation->set_error_delimiters('<p class="error_message" > *', '</p>');
		
		// On définie les règles de validation du formulaire.
		$config = array(
			array(
				'field'   => 'groupe',
				'label'   => $this->lang->line('nomGroupe'), 
				'rules'   => 'required'
			),
			array(
				'field'   => 'nom',
				'label'   => $this->lang->line('nom'), 
				'rules'   => 'required'
			),
			array(
				'field'   => 'prenom',
				'label'   => $this->lang->line('prenom'), 
				'rules'   => 'required'
			),
			array(
				'field'   => 'adresse',
				'label'   => 'Adresse',
				'rules'   => 'required',
			),
			array(
				'field'   => 'tel',
				'label'   => $this->lang->line('tel'),
				'rules'   => 'required'
			),
		    array(
				'field'   => 'numr_carte',
				'label'   => 'Numero carte de presse',
				'rules'   => 'required'
			),
			array(
				'field'   => 'titre',
				'label'   => $this->lang->line('titre'), 
				'rules'   => 'required'
			),
			array(
				'field'   => 'fonction',
				'label'   => $this->lang->line('fonction'), 
				'rules'   => ''
			),
			array(
				'field'   => 'tel',
				'label'   => $this->lang->line('tel'), 
				'rules'   => ''
			),
			array(
				'field'   => 'mail',
				'label'   => $this->lang->line('mail'), 
				'rules'   => 'required|valid_email'
			)
		);
		
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == false) {
			$values = "";
			$values->groupe 	= $this->input->post('groupe');
			$values->pays 		= $this->input->post('pays');
			$values->nom 		= strtoupper($this->input->post('nom'));
			$values->prenom 	= $this->input->post('prenom');
			$values->fonction 	= $this->input->post('fonction');
			$values->mail 		= $this->input->post('mail');
			$values->tel 		= $this->input->post('tel');
			$values->adresse    = $this->input->post('adresse');
			$values->numr_carte = $this->input->post('numr_carte');
			$values->categorie 	= $this->input->post('categorie');
			
			$this->groupe($idEvenement, $categorie, $values);
			
		}
		else {
			
			$data['groupe'] 			= $this->input->post('groupe');
			$data['pays'] 				= $this->input->post('pays');	
			$data['nom'] 				= $this->input->post('nom');
			$data['prenom'] 			= $this->input->post('prenom');
			$data['fonction'] 			= $this->input->post('fonction');
			$data['tel'] 				= $this->input->post('tel');
			$data['mail'] 				= $this->input->post('mail');
			$data['numr_carte']         = $this->input->post('numr_carte');
			$data['adresse ']           = $this->input->post('adresse ');
			$data['evenement'] 			= $this->input->post('evenement');
			$data['listeCategorie'] 	= $this->modelcategorie->getCategories();
			$data['listeSurCategorie'] 	= $this->modelcategorie->getCategorieMere();
			
			// Gestion pour les catégorie.
			$tab = $this->input->post('categorie');
			$temp = -1;
			while($temp == -1) {
				$temp = array_pop($tab);
			}
			$data['categorie'] = $temp;

			$this->ajouterGroupe($data, $categorie);
		}
		
	}

	/**
	 * Méthode pour l'ajout de tous les membres d"une équipe.
	 */
	public function ajouterGroupe($data) {
		$this->layout->ajouter_js('lambda/scriptGroupe');

		$this->layout->view('presse/LPresseGroupeDetails', $data);
	}


}