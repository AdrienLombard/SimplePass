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
	
		$data['listeSurCategorie'] 	= $this->modelcategorie->getCategorieMere();
		$this->layout->view('presse/LPageEntre',$data);
		
	}

   public function inscription(){
	  //$data['listeSurCategorie'] 	= $this->modelcategorie->getSousCategorie($categorie);
	   $this->layout->ajouter_js('lambda/script');
	   $categorie=$this->input->post('categorie');
	   
	   $this->session->set_userdata('categorie',$categorie);
        // $this->session->set_userdata('categorie');
	   $data['categorie']=$categorie;
	   $data['events'] = $this->modelevenement->getEvenementEnCours();
				//$categorie = null;
				
					if($categorie != "1")
					{
					 //$categorie = $cat;
				    $this->layout->view('lambda/LAccueil',$data);
					 
				    }
					else 
						
                    $this->layout->view('presse/LAccueilPress',$data);
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
	
	/**
	 * Méthode pour l'ajout de tous les membres d"une équipe.
	 */
	public function ajouterGroupe($data) {
		$this->layout->ajouter_js('lambda/scriptGroupe');
		$this->layout->view('presse/LPresseGroupeDetails', $data);
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
	public function ajouter($event='',$categorie) {
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
				'field'   => 'tel_fixe',
				'label'   => $this->lang->line('tel_fixe'), 
				'rules'   => ''
			),
			array(
				'field'   => 'tel_portable',
				'label'   => $this->lang->line('tel_portable'), 
				'rules'   => ''
			),
			array(
				'field'   => 'tel_ligne_directe',
				'label'   => $this->lang->line('tel_ligne_directe'), 
				'rules'   => ''
			),
		    array(
				'field'   => 'numr_carte',
				'label'   => $this->lang->line('numr_carte'), 
				'rules'   => ''
			),
			array(
				'field'   => 'titre',
				'label'   => $this->lang->line('titre'), 
				'rules'   => ''
			),
			array(
				'field'   => 'fonction',
				'label'   => $this->lang->line('fonction'), 
				'rules'   => ''
			),
			array(
				'field'   => 'civilite',
				'label'   => $this->lang->line('civilite'), 
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
			
			$this->layout->view('presse/LPresseindividuelle', $data);
		
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
					'mail' 		=> $this->input->post('mail')
				);

				// On gère les champs facultatif.
				$tel_fixe = $this->input->post('tel_fixe');
				if(isset($tel_fixe) && !empty($tel_fixe)) {
					$values['tel_fixe'] = $tel_fixe;
				}
				
                $tel_portable = $this->input->post('tel_portable');
				if(isset($tel_portable) && !empty($tel_portable)) {
					$values['tel_portable'] = $tel_portable;
				}
				
				$tel_ligne_directe = $this->input->post('tel_ligne_directe');
				if(isset($tel_ligne_directe) && !empty($tel_ligne_directe)) {
					$values['tel_ligne_directe'] = $tel_ligne_directe;
				}
				
				$fonction = $this->input->post('fonction');
				if(isset($fonction) && !empty($fonction)) {
					$values['fonction'] = $fonction;
				}
				
				$organisme = $this->input->post('titre');
				if(isset($organisme) && !empty($organisme)) {
					$values['organisme'] = $organisme;
				}
				
               $numr_carte = $this->input->post('numr_carte');
				if(isset($numr_carte) && !empty($numr_carte)) {
					$values['numr_carte'] = $numr_carte;
				}
				$categories = $this->input->post('categorie');
				$categorie = null;
				foreach($categories as $cat) {
					if($cat != "-1")
						$categorie = $cat;
				}

				//Insertion dans la base.
				$idClient = $this->modelpresse->ajouter($values);


				$accredData = Array(
					'idcategorie'		=> $categorie,
					'idevenement'		=> $event,
					'idclient'			=> $idClient,
					'etataccreditation'	=> ACCREDITATION_A_VALIDE,
					'dateaccreditation' => time()
				);

				$fonction = $this->input->post('fonction');
				if(isset($fonction) && !empty($fonction)) {
					$accredData['fonction'] = $fonction;
				}

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
		
		$this->layout->view('presse/LPresseGroupe', $data);
			
	}
	
	
	/**
	 * Méthode de traitement pour la saisie du responsable.
	 */
	public function exeGroupe() {
				
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
			
			$values->groupe 	= $this->input->post('groupe');
			$values->pays 		= $this->input->post('pays');
			$values->nom 		= strtoupper($this->input->post('nom'));
			$values->prenom 	= $this->input->post('prenom');
			$values->fonction 	= $this->input->post('fonction');
			$values->mail 		= $this->input->post('mail');
			$values->tel 		= $this->input->post('tel');
			$values->categorie 	= $this->input->post('categorie');
			
			$this->groupe($idEvenement, $values);
			
		}
		else {
			
			$data['groupe'] 			= $this->input->post('groupe');
			$data['pays'] 				= $this->input->post('pays');	
			$data['nom'] 				= $this->input->post('nom');
			$data['prenom'] 			= $this->input->post('prenom');
			$data['fonction'] 			= $this->input->post('fonction');
			$data['tel'] 				= $this->input->post('tel');
			$data['mail'] 				= $this->input->post('mail');
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
			
			$this->ajouterGroupe($data);
		}
		
	}
	
	
}