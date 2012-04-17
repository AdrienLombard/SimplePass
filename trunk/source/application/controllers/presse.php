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
		
		// Charge la librairie mail
		$this->load->library('email');
		
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
	 * @param $categorie
	 */
	public function lambda( $categorie ) {
	
		$this->session->set_userdata('lang', 'fra');
		
		$this->layout->ajouter_js('lambda/script');

		$data['listeSurCategorie'] 	= $this->modelcategorie->getCategorieMere();

		$data['lang'] = $this->session->userdata('lang');
		
		$this->layout->view('presse/LPageEntre', $data);
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
	
	
	public function ajouter($event='', $IDcategorie='') {

		// variable pour transmettre des données à la vue.
		$data = Array();
		$data['lang'] = $this->session->userdata('lang');
	
		// Chargement du js.
	 	$this->layout->ajouter_js('lambda/script');
		
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
			
		    $data['listeSurCategorie'] 	= $this->modelcategorie->getSousCategorie($IDcategorie);
			
			$data['listeCategorie'] = $this->modelcategorie->getCategories();

			$data['categorie'] = $IDcategorie;

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
				$newAccred = $this->modelaccreditation->ajouter($accredData);

				$this->AssociationZoneAccred($newAccred, $categorie, $event);

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
	 * @param      $evenement
	 * @param      $categorie
	 * @param bool $info
	 */
	public function groupe($evenement, $categorie, $info=false) {
		// Chargement du js.
		$this->layout->ajouter_js('lambda/script');

		$data['lang'] = $this->session->userdata('lang');
		
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
	 * @param $idevent
	 * @param $cate
	 */
	public function exeGroupe( $idevent, $cate ) {
	
		$msg['lang'] = $this->session->userdata('lang');

		$idEvenement = $this->input->post('evenement');
		
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
			
			$this->groupe($idEvenement, $cate, $values);
			
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
			$data['adresse ']           = $this->input->post('adresse');
			$data['evenement'] 			= $this->input->post('evenement');
			$data['organisme']          = $this->input->post('titre');
			$data['listeCategorie'] 	= $this->modelcategorie->getCategories();
			$data['listeSurCategorie'] 	= $this->modelcategorie->getSousCategorie($cate);
			
			// Gestion pour les catégorie.
			$tab = $this->input->post('categorie');
			$temp = -1;
			while($temp == -1) {
				$temp = array_pop($tab);
			}
			$data['categorie'] = $temp;

			$this->ajouterGroupe($data, $cate);
		}
		
	}

	/**
	 * Méthode pour l'ajout de tous les membres d"une équipe.
	 * @param $data
	 */
	public function ajouterGroupe($data) {
	
		$data['lang'] = $this->session->userdata('lang');
	
		$this->layout->ajouter_js('lambda/scriptGroupePresse');

		$this->layout->view('presse/LPresseGroupeDetails', $data);
	}
/**
	 * Méthode pour le traitement de l'ajout des membres d'une équipe.
	 */
	public function exeAjouterGroupe() {		
		// ajout du référent
		$ref = $data = $this->input->post('ref');
		unset($ref['categorie']);
		unset($ref['fonction']);
		unset($ref['groupe']);
		$id = $this->modelclient->ajouter($ref);
		
		$msg['lang'] = $this->session->userdata('lang');
		
		// création de l'accreditation pour le referent
		$accred = null;
		$accred['idcategorie'] = $data['categorie'];
		$accred['idevenement'] = $this->input->post('evenement');
		$accred['idclient'] = $id;
		$accred['etataccreditation'] = ACCREDITATION_A_VALIDE;
		//
		//$accred['organisme'] = $this->input->post('organisme');
	    $accred['numeropresse']=$this->input->post('numr_carte');
		$accred['groupe'] = $data['groupe'];
		$accred['dateaccreditation'] = time();
		$newAccred = $this->modelaccreditation->ajouter($accred);

		// Association zones/accred pour le referent.
		$this->AssociationZoneAccred($newAccred, $accred['idcategorie'], $this->input->post('evenement'));


		// Generation du debut du mail de confirmation.
		$evenement = $this->modelevenement->getEvenementParId($accred['idevenement']);
		$contenuMail = 	'<html>' .
					'<head></head>' .
					'<body>' .
						'<p>Cher(e) ' . $ref['prenom'] . ' ' . $ref['nom'] . ', </p>' .
						'<p>Votre accréditation pour l\'évènement ' . $evenement[0]->libelleevenement . ' a bien été prise en compte.</p>' .
						'<p>Cette accréditation est valable pour les personnes suivantes : </p>' .
						'<ul title="listeMembres" >';
		
		// Ajout des membres

		foreach($this->input->post('groupe') as $ligne) {
			// création du client
			$membre = null;
			$membre['nom']     		= $ligne['nom'];
			$membre['prenom']  		= $ligne['prenom'];
			$membre['adresse'] 		= $ligne['adresse_membre'];
			$membre['tel']     		= $ligne['tel_membre'];
			$membre['mail']			= $ligne['mail_membre'];
			$membre['organisme']	= $data['organisme'];
			$membre['pays'] 		= $data['pays'];
			$idNewClient = $this->modelclient->ajouter($membre);


			// création de l'accreditation de son accreditation.
			$accred = null;
			$accred['groupe'] 			 = $data['groupe'];
			$accred['idevenement']		 = $this->input->post('evenement');
			$accred['idclient'] 		 = $idNewClient;
			$accred['fonction'] 		 = $ligne['fonction'];
			$accred['numeropresse']		 = $ligne['numr_carte_membre'];
			$accred['referent'] 		 = $id;
			$accred['etataccreditation'] = ACCREDITATION_A_VALIDE ;
			$accred['dateaccreditation'] = time();
			$tab = $ligne['categorie'];
			$temp = -1;
			while($temp == -1) {
				$temp = array_pop($tab);
			}
			$accred['idcategorie'] = $temp;
			$idNewAccred = $this->modelaccreditation->ajouter($accred);

			// on continue le mail.
			if($accred['fonction'] != '') {
				$contenuMail .= '<li>' . $membre['prenom'] . ' ' . $membre['nom'] . ' - ' . $accred['fonction'] . '</li>';
			}
			else {
				$contenuMail .= '<li>' . $membre['prenom'] . ' ' . $membre['nom'] . ' - Pas de fonction définie</li>';
			}
			if(isset($accred['categorie']))
				$this->AssociationZoneAccred($idNewAccred, $accred['idcategorie'], $this->input->post('evenement'));
		}
		/*		
		// Préparation et envoi du mail de confirmation
		$this->email->from('accreditations@courchevel.com', 'Accréditations Courchevel'); // L'adresse qui enverra le mail
		$this->email->to($values['mail']); // Le destinataire du mail
		$this->email->bcc(MAIL_COPIE); // L'adresse de Courchevel qui recevra une copie du mail
		
		// Le sujet du mail
		$this->email->subject('Votre accréditation groupée pour l\'évènement ' . $evenement[0]->libelleevenement);
		
		// Le contenu du mail
		$contenuMail = 			'</ul>' .
								'<p>Merci pour votre pré-enregistrement.</p>' .
								'<p>Le club des sports de Courchevel</p>' .
							'</body>' .
						'</html>';
		
		// Inclusion du contenu dans le mail
		$this->email->message($contenuMail);
		
		// Envoi du mail
		//$this->email->send();
		*/
		$msg['titre']	= $this->lang->line('titreConfirmeDemandeGroupe');
		$msg['message']	= $this->lang->line('confirmeDemandeGroupe');
		
		$this->layout->view('lambda/LMessage', $msg);
		 
		 
	}
	
	public function upload($id)
	{
	
		$data['lang'] = $this->session->userdata('lang');
	
		$client = $this->modelclient->getClientParId($id);
		
		$config['upload_path'] = UPLOAD_DIR;
		$config['allowed_types'] = 'jpg';
		$config['max_size']	= '4000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		//$config['file_name'] = urlencode($client->nom . '_' . $client->prenom . '_' . $id.".jpg");
		$config['file_name'] = $id.".jpg";
		$config['overwrite'] = true;
		
		$this->load->library('upload', $config);
		$this->upload->do_upload('photo_file');
		echo $this->upload->display_errors();
		$data = $this->upload->data();
		
		$img = imagecreatefromjpeg(UPLOAD_DIR . $data['file_name']);
		
		$this->load->helper('image');
		
		if($data['image_width'] == IMG_WIDTH && $data['image_height'] == IMG_HEIGHT) {
			$data['titre']		= $this->lang->line('titreConfirmeDemande');
			$data['message']	= $this->lang->line('confirmeDemande');
			$this->layout->view('lambda/LMessage', $data);
		} elseif($data['image_width'] > IMG_WIDTH && $data['image_height'] > IMG_HEIGHT) {
			if($data['image_width'] > 940)
				resizeWidthRatio($data['full_path'], 940);
			redirect('inscription/crop/' . $id);
		} else
			die('Image trop petite.');
	}


	/**
	 * Fonction qui sert a créer les entrée entre des zones accéssible et une accréditation.
	 * @param $idAccred
	 * @param $idCategorie
	 * @param $idEvenement
	 */
	private function AssociationZoneAccred( $idAccred, $idCategorie, $idEvenement ) {

		// On récupère les zones de la catégorie pour cette évènement.
		$zones = $this->modelzone->getZoneParCategorieEtEvenement( $idCategorie, $idEvenement);

		// On construit notre array de couple zone/idAccreditation
		$zonesAcccred = array();
		foreach($zones as $zone) {
			$zonesAcccred[] = array(
				'idaccreditation' 	=> $idAccred,
				'idzone'			=> $zone->idzone
			);
		}

		// On lie ces zones à cette accréditation.
		$this->modelzone->ajouterZonesAccreditation( $zonesAcccred );
	}


}