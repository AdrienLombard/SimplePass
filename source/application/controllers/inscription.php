<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inscription extends Chocolat {
	
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct() {
		parent::__construct();
		
		// Charge la librairie de validation de formulaire
		$this->load->library('form_validation');
		
		// Charge la librairie mail
		$this->load->library('email');
		
		// Chargement du css.
		
		// Chargement du modele.
		$this->load->model('modelaccreditation');
		$this->load->model('modelevenement');
		$this->load->model('modelcategorie');
		$this->load->model('modellambda');
		$this->load->model('modelclient');
		
		// Chargement du fichier de langue
		$this->load->helper('language');
		$this->chargerLangue();
	}
	
	public function index() {

		$this->lambda();
		
	}
	/**
	 * Méthode pour le changement de langue
	 */
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
		$this->layout->ajouter_js('webcam/jquery.webcam');
		
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
				'field'   => 'tel',
				'label'   => $this->lang->line('tel'), 
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
				$this->modelclient->ajouter($values);
				$idClient = $this->modelclient->lastId();

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
				
				if($_FILES['photo_file']['size'] != 0)
					$this->upload($idClient);

				$evenement = $this->modelevenement->getEvenementParId($event);
				
				// Préparation et envoi du mail de confirmation
				$this->email->from('accreditations@courchevel.com', 'Accréditations Courchevel'); // L'adresse qui enverra le mail
				$this->email->to($values['mail']); // Le destinataire du mail
				$this->email->bcc(MAIL_COPIE); // Placer ici l'adresse de Courchevel qui recevra une copie du mail
				
				// Le sujet du mail
				$this->email->subject('Votre accréditation pour l\'évènement ' . $evenement[0]->libelleevenement);
				
				// Le contenu du mail
				$contenuMail = 	'<html>' .
									'<head></head>' .
									'<body>' .
										'<p>Cher(e) ' . $values['prenom'] . ' ' . $values['nom'] . ', </p>' .
										'<p>Votre accréditation pour l\'évènement ' . $evenement[0]->libelleevenement . ' a bien été prise en compte.</p>' .
										'<p>Merci pour votre pré-enregistrement.</p>' .
										'<p>Le club des sports de Courchevel</p>' .
									'</body>' .
								'</html>';
				
				// Inclusion du contenu dans le mail
				$this->email->message($contenuMail);
				
				// Envoi du mail
				//$this->email->send();
				
				$data['titre']		= $this->lang->line('titreConfirmeDemande');
				$data['message']	= $this->lang->line('confirmeDemande');
				
			}
			else {
				$data['titre']		= $this->lang->line('titreDemandeNon');
				$data['message']	= $this->lang->line('demandeNon');
				
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
		$data['listeSurCategorie'] = $this->modelcategorie->getCategorieMere();
		$data['values'] = $info;
		
		$this->layout->view('lambda/LGroupe', $data);
			
	}
	
	
	/**
	 * Méthode de traitement pour la saisie du responsable.
	 */
	public function exeGroupe() {
				
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
	
	
	/**
	 * Méthode pour l'ajout de tous les membres d"une équipe.
	 */
	public function ajouterGroupe($data) {
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
		unset($ref['fonction']);
		unset($ref['groupe']);
		$id = $this->modelclient->ajouter($ref);
		
		// création de l'accreditation pour le referent
		$accred = null;
		$accred['idcategorie'] = $data['categorie'];
		$accred['idevenement'] = $this->input->post('evenement');
		$accred['idclient'] = $id;
		$accred['etataccreditation'] = ACCREDITATION_A_VALIDE;
		$accred['fonction'] = $data['fonction'];
		$accred['groupe'] = $data['groupe'];
		$accred['dateaccreditation'] = time();
		$this->modelaccreditation->ajouter($accred);
		
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
			$membre['nom'] = $ligne['nom'];
			$membre['prenom'] = $ligne['prenom'];
			$membre['pays'] = $data['pays'];
			$idNewClient = $this->modelclient->ajouter($membre);

			// création de l'accreditation
			$accred = null;
			$accred['groupe'] = $data['groupe'];
			$accred['idevenement'] = $this->input->post('evenement');
			$accred['idclient'] = $idNewClient;
			$accred['fonction'] = $ligne['fonction'];
			$accred['referent'] = $id;
			$accred['etataccreditation'] = ACCREDITATION_A_VALIDE;
			$accred['dateaccreditation'] = time();
			
			if($accred['fonction'] != '') {
				$contenuMail .= '<li>' . $membre['prenom'] . ' ' . $membre['nom'] . ' - ' . $accred['fonction'] . '</li>';
			}
			else {
				$contenuMail .= '<li>' . $membre['prenom'] . ' ' . $membre['nom'] . ' - Pas de fonction définie</li>';
			}
			
			$tab = $ligne['categorie'];
			$temp = -1;
			while($temp == -1) {
				$temp = array_pop($tab);
			}
			$accred['idcategorie'] = $temp;
			$this->modelaccreditation->ajouter($accred);
		}
				
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
		
		$msg['titre']	= $this->lang->line('titreConfirmeDemandeGroupe');
		$msg['message']	= $this->lang->line('confirmeDemandeGroupe');
		$this->layout->view('lambda/LMessage', $msg);
	}
	
	public function upload($id)
	{
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
	
	/*
	 * Crop : coupe une image trop grande
	 */
	public function crop($id) {
		
		$data['client'] = $this->modelclient->getClientParId($id);
		
		$this->layout->ajouter_css('jquery.Jcrop');
		$this->layout->ajouter_js('jquery.Jcrop.min');
		
		$this->layout->view('lambda/LCrop', $data);
		
	}
	
	
	/*
	 * ExeCrop : redimensionne l'image avec les paramères passés
	 */
	public function exeCrop() {
		
		$id = $this->input->post('id');
		$x = $this->input->post('x');
		$y = $this->input->post('y');
		$w = $this->input->post('w');
		$h = $this->input->post('h');
		
		$client = $this->modelclient->getClientParId($id);
		
		$this->load->helper('image');
		crop(UPLOAD_DIR . $client->idclient . '.jpg', $x, $y, $w, $h);
		
		$data['titre']		= $this->lang->line('titreConfirmeDemande');
		$data['message']	= $this->lang->line('confirmeDemande');
		$this->layout->view('lambda/LMessage', $data);
	}
	
}

/* End of file inscription.php */
/* Location: ./application/controllers/inscription.php */