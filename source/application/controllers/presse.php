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
		$this->layout->ajouter_js('jpegcam/webcam');
		
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
			
			$data['listeCategorie'] = $this->listeCategoriePresse( $event );

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
				
				$cat = $this->modelcategorie->getCategorieMereid($accredData['idcategorie']);
				
				$evenement = $this->modelevenement->getEvenementParId($event);
				
				// Préparation et envoi du mail de confirmation
				$this->email->from(MAIL_EXPEDITEUR, NOM_EXPEDITEUR); // L'adresse qui enverra le mail
				$this->email->to($values['mail']); // Le destinataire du mail
				$this->email->bcc(MAIL_COPIE); // Placer ici l'adresse de Courchevel qui recevra une copie du mail
				
				// Le sujet du mail
				$this->email->subject(OBJET_MAIL);
				
				// Le contenu du mail
				$contenuMail = 	'<html>' .
									'<head></head>' .
									'<body>' .
										'<p>' . CHER . $values['prenom'] . ' ' . $values['nom'] . ' / ' . DEAR . $values['prenom'] . ' ' . $values['nom'] . ', </p>' . 
										INTRO_MAIL .
										'<table>' .
											'<tr>' .
												'<td>NOM / LASTNAME</td><td>' . $values['nom'] . '</td>' .
											'</tr>' .
											'<tr>' .
												'<td>PRENOM / FIRSTNAME</td><td>' . $values['prenom'] . '</td>' .
											'</tr>' .
											'<tr>' .
												'<td>PAYS / COUNTRY</td><td>' . $values['pays'] . '</td>' .
											'</tr>' .
											'<tr>' .
												'<td>ADRESSE / ADDRESS</td><td>' . $values['adresse'] . '</td>' .
											'</tr>' .
											'<tr>' .
												'<td>NUMERO DE CARTE PRESSE / PRESS CARD NUMBER</td><td>' . $accredData['numeropresse'] . '</td>' .
											'</tr>' ;
											if(isset($values['tel']) && !empty($values['tel'])) {
				$contenuMail .=					'<tr>' .
													'<td>TELEPHONE / PHONE NUMBER</td><td>' . $values['tel'] . '</td>' .
												'</tr>' ;
											}
											else {
				$contenuMail .=					'<tr>' .
													'<td>TELEPHONE / PHONE NUMBER</td><td>Pas de numéro de téléphone / No phone number</td>' .
												'</tr>' ;
											}
				$contenuMail .=				'<tr>' .
												'<td>MAIL</td><td>' . $values['mail'] . '</td>' .
											'</tr>' ;
											if(isset($cat) && !empty($cat)) {
				$contenuMail .=					'<tr>' .
													'<td>CATEGORIE / CATEGORY</td><td>' . $cat[0]->libellecategorie . '</td>' .
												'</tr>' ;
											}
											else {
				$contenuMail .=					'<tr>' .
													'<td>CATEGORIE / CATEGORY</td><td>Pas de catégorie définie / No defined category</td>' .
												'</tr>' ;
											}
				$contenuMail .=				'<tr>' .
												'<td>ORGANISME / COMPANY</td><td>' . $values['organisme'] . '</td>' .
											'</tr>' ;
											if(isset($accredData['fonction']) && !empty($accredData['fonction'])) {
				$contenuMail .=					'<tr>' .
													'<td>FONCTION / FUNCTION</td><td>' . $accredData['fonction'] . '</td>' .
												'</tr>' ;
											}
											else {
				$contenuMail .=					'<tr>' .
													'<td>FONCTION / FUNCTION</td><td>Pas de fonction définie / No defined function</td>' .
												'</tr>' ;
											}
				$contenuMail .=				'<tr>' .
												'<td>DATE D\'ENREGISTREMENT / REGISTRATION DATE</td><td>' . display_date($accredData['dateaccreditation']) . '</td>' .
											'</tr>' .
										'</table>' .
										TRAITEMENT_MAIL;
				
				if($evenement[0]->textmail != '')
					$contenuMail .=		'<p>' . nl2br($evenement[0]->textmail) . '</p>';
				
				$contenuMail .=		SIGNATURE_MAIL .
									'</body>' .
								'</html>';
				
				// Inclusion du contenu dans le mail
				$this->email->message($contenuMail);
				
				// Envoi du mail
				$this->email->send();

				$data['titre']		= $this->lang->line('titreConfirmeDemande');
				$data['message']	= $this->lang->line('confirmeDemande');
				
			}
			else {
				$data['titre']		= $this->lang->line('titreDemandeNon');
				$data['message']	= $this->lang->line('demandeNon');
				
			}
			
			//upload ou webcam
			$webcam = $this->input->post('photo_webcam');
			if($webcam != null)
			    rename('./assets/images/' . $webcam, UPLOAD_DIR . $idClient . '.jpg');
			
			if($_FILES['photo_file']['size'] != 0)
			    $this->upload($idClient);
			
			$this->layout->view('lambda/LMessage', $data); 
		}
	}
	
	
	private function listeCategoriePresse( $event ) {
		$newCate = $this->modelcategorie->getCategorieDansEvenementToutBien();
		
		$presse = array();
		$presse[] = $this->modelcategorie->getIdPresse();
		
		$infoCategorie = array();
		
		foreach($newCate as $cate) {
			if($cate['db']->idcategorie == $presse[0]) {
				$infoCategorie[] = $cate;
			}
		}
		
		Do {
			$find = false;
			$categorie = $newCate;
			$newCate = array();
			foreach($categorie as $cate) {
				if(in_array($cate['db']->surcategorie, $presse)) {
					$presse[] = $cate['db']->idcategorie;
					$infoCategorie[] = $cate;
					$find = true;
				}
				else {
					$newCate[] = $cate;
				}
			}
		}
		while($find);
		
		$listeAllCategorie = $infoCategorie;
		$listeCategorieEvent = $this->modelcategorie->getCategorieDansEvenement($event);
		$listeCategories = array();
		foreach($listeCategorieEvent as $cate) {
			$listeCategories[] = $cate->idcategorie;
		}
		$categories = array();
		foreach($listeAllCategorie as $cate) {
			if(in_array($cate['db']->idcategorie, $listeCategories)) {
				$categories[] = $cate;
			}
		}
		
		return $categories;
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
		$this->layout->ajouter_js('jpegcam/webcam');

		$data['lang'] = $this->session->userdata('lang');
		
		$data['idEvenement']		= $evenement;
		$data['infoEvenement'] 		= $this->modelevenement->getEvenementParId($evenement);
		$data['listePays'] 			= $this->modellambda->listePays();
		$data['listeCategorie'] 	= $this->listeCategoriePresse($evenement);
		$data['values'] 			= $info;
		$data['cate'] 				= $categorie;
		
		//var_dump($data['listeCategorie']);
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
				'field'   => 'numr_carte',
				'label'   => 'Numero carte de presse',
				'rules'   => 'required'
			),
			array(
				'field'   => 'titre',
				'label'   => $this->lang->line('societe'), 
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
				'rules'   => 'required'
			),
			array(
				'field'   => 'mail',
				'label'   => $this->lang->line('mail'), 
				'rules'   => 'required|valid_email'
			)
		);
		
		$this->form_validation->set_rules($config);
		
		$groupe = $this->modelaccreditation->getGroupeExist( $this->input->post('groupe') );
		
		if ($this->form_validation->run() == false or $groupe) {
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
			
			if($groupe)
			
			$values->error_groupe='Le groupe existe déjà';
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
			$data['adresse']           = $this->input->post('adresse');
			$data['evenement'] 			= $this->input->post('evenement');
			$data['organisme']          = $this->input->post('titre');
			$data['listeCategorie'] 	= $this->listeCategoriePresse($idEvenement);
			$data['webcam_ref']         = $this->input->post('photo_webcam');

			// Gestion pour les catégorie.
			$tab = $this->input->post('categorie');
			$temp = -1;
			while($temp == -1) {
				$temp = array_pop($tab);
			}
			$data['categorie'] = $temp;
			
			// upload tmp du fichier
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != '') {
			    $file = $_FILES['photo_file'];
			    $unik = time();
			    if(!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . 'tmp/' . $unik . '.jpg'))
				    die('Echec de l\'upload temporaire (inscription.php:exeGroupe) : ' . $_FILES['photo_file']['error']);
			    $data['photo_file'] = UPLOAD_DIR . 'tmp/' . $unik . '.jpg';
			}

			$webcam = $this->input->post('photo_webcam');
			if($webcam != null)
				$data['photo_webcam'] = './assets/images/' . $webcam;


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
		$this->layout->ajouter_js('jpegcam/webcam');
		
		$this->layout->ajouter_css('lambda/webcam-overlay');

		$this->layout->view('presse/LPresseGroupeDetails', $data);
	}
/**
	 * Méthode pour le traitement de l'ajout des membres d'une équipe.
	 */
	public function exeAjouterGroupe() {		
		// ajout du référent
		$ref = $data = $this->input->post('ref');
		$ref['nom'] = strtoupper($ref['nom']);
		unset($ref['categorie']);
		unset($ref['fonction']);
		unset($ref['numeropresse']);
		unset($ref['groupe']);
		
		// webcam
		$webcam = $ref['photo_webcam'];
		unset($ref['photo_webcam']);

		// file
		$file = $ref['photo_file'];
		unset($ref['photo_file']);
		
		$id = $this->modelclient->ajouter($ref);
		
		// ajout photo webcam
		if($webcam != null)
			rename($webcam, UPLOAD_DIR . $id . '.jpg');

		// upload fichier
		if($file != null) {
			rename(UPLOAD_DIR . 'tmp/' . $file . '.jpg', UPLOAD_DIR . $id . '.jpg');
			$this->load->helper('image');
			resizeWidthRatio(UPLOAD_DIR . $id.".jpg", 160, 240);
		}
		
		$msg['lang'] = $this->session->userdata('lang');
		
		// création de l'accreditation pour le referent
		$accred = null;
		$accred['idcategorie'] = $data['categorie'];
		$accred['idevenement'] = $this->input->post('evenement');
		$accred['idclient'] = $id;
		$accred['etataccreditation'] = ACCREDITATION_A_VALIDE;
		$accred['fonction'] = $data['fonction'];
		$accred['numeropresse'] = $data['numeropresse'];
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
						'<p>' . CHER . $ref['prenom'] . ' ' . $ref['nom'] . ' / ' . DEAR . $ref['prenom'] . ' ' . $ref['nom'] . ', </p>' .
						INTRO_MAIL .
						'<p>Membres du groupe "' . $accred['groupe'] . '" : <br />' .
						'"' . $accred['groupe'] . '" group members : </p>' .
						'<ul title="Referent" >' .
						'<li>' . $ref['prenom'] . ' ' . $ref['nom'];
						
		$cat = $this->modelcategorie->getCategorieMereid($accred['idcategorie']);
						
		if(isset($cat) && !empty($cat) && $cat[0]->libellecategorie != '') {
			$contenuMail .= ' - ' . $cat[0]->libellecategorie;
		}
		else {
			$contenuMail .= ' - Pas de catégorie définie / No category defined';
		}
		
		if(isset($accred['fonction']) && !empty($accred['fonction']) && $accred['fonction'] != '') {
			$contenuMail .= ' (' . $accred['fonction'] . ') - <strong>Référent(e) du groupe / Group referent</strong></li>';
		}
		else {
			$contenuMail .= ' (Pas de fonction définie / No function defined) - <strong>Référent(e) du groupe / Group referent</strong></li>';
		}
		
		// Ajout des membres
		
		$gr = $this->input->post('groupe');
		
		if($gr) {
			foreach($gr as $ligne) {
				// création du client
				$membre = null;
				$membre['nom']     		= strtoupper($ligne['nom']);
				$membre['prenom']  		= $ligne['prenom'];
				$membre['adresse'] 		= $ligne['adresse_membre'];
				$membre['tel']     		= $ligne['tel_membre'];
				$membre['mail']			= $ligne['mail_membre'];
				$membre['organisme']	= $data['organisme'];
				$membre['pays'] 		= $data['pays'];
				$idNewClient = $this->modelclient->ajouter($membre);

				// ajout photo webcam
				if($ligne['webcam'] != null)
					rename('./assets/images/' . $ligne['webcam'], UPLOAD_DIR . $idNewClient . '.jpg');

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
				
				// Gestion du mail.
				$contenuMail .= '<li>' . $membre['prenom'] . ' ' . $membre['nom'];
				
				$accred['idcategorie'] = array_pop($ligne['categorie']);

				$cat = null;
				
				$cat = $this->modelcategorie->getCategorieMereid($accred['idcategorie']);
				
				if(isset($cat) && !empty($cat) && $cat[0]->libellecategorie != '') {
					$contenuMail .= ' - ' . $cat[0]->libellecategorie;
				}
				else {
					$contenuMail .= ' - Pas de catégorie définie / No category defined';
				}
				
				if(isset($accred['fonction']) && !empty($accred['fonction']) && $accred['fonction'] != '') {
					$contenuMail .= ' (' . $accred['fonction'] . ')</li>';
				}
				else {
					$contenuMail .= ' (Pas de fonction définie / No function defined)</li>';
				}
				
				$idNewAccred = $this->modelaccreditation->ajouter($accred);
				
				
				$this->AssociationZoneAccred($idNewAccred, $accred['idcategorie'], $this->input->post('evenement'));
			}
		}
		
		// Préparation et envoi du mail de confirmation
		$this->email->from(MAIL_EXPEDITEUR, NOM_EXPEDITEUR); // L'adresse qui enverra le mail
		$this->email->to($ref['mail']); // Le destinataire du mail
		$this->email->bcc(MAIL_COPIE); // L'adresse de Courchevel qui recevra une copie du mail
		
		// Le sujet du mail
		$this->email->subject(OBJET_MAIL);
		
		// Le contenu du mail
		$contenuMail .= 	'</ul>' .
							TRAITEMENT_MAIL;	
		
		if($evenement[0]->textmail != '')
			$contenuMail .=		'<p>' . nl2br($evenement[0]->textmail) . '</p>';
			
		$contenuMail .= 		SIGNATURE_MAIL .
							'</body>' .
						'</html>';
		
		// Inclusion du contenu dans le mail
		$this->email->message($contenuMail);
		
		// Envoi du mail
		$this->email->send();
		
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
		
		$img = imagecreatefrom(UPLOAD_DIR . $data['file_name']);
		
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
	
	private function listeCategorieToDisplay( $event ) {
		// Gestion pour les catégorie.
		$listeAllCategorie = $this->modelcategorie->getCategorieDansEvenementToutBien();
		$listeCategorieEvent = $this->modelcategorie->getCategorieDansEvenement($event);
		$listeCategories = array();
		foreach($listeCategorieEvent as $categorie) {
			$listeCategories[] = $categorie->idcategorie;
		}
		$categories = array();
		foreach($listeAllCategorie as $cate) {
			if(in_array($cate['db']->idcategorie, $listeCategories)) {
				$categories[] = $cate;
			}
		}
		
		return $categories;
	}



}