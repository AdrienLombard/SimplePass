<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accreditation extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		
		// Chargement des modeles.
		$this->load->model('modelclient');
		$this->load->model('modelpays');
		$this->load->model('modelaccreditation');
		$this->load->model('modelevenement');
		$this->load->model('modelcategorie');
		$this->load->model('modelzone');
		
		// Chargement des javascript.
		$this->layout->ajouter_css('utilisateur/accreditation');
		$this->layout->ajouter_js('utilisateur/CRUDAccred');
		
		$this->layout->ajouter_css('jquery.Jcrop');
		$this->layout->ajouter_js('jquery.Jcrop.min');
		
		// Chargement des librairie.
		$this->load->library('form_validation');
		
		// Mise en place de la sécurisation.
		$this->securiseAll();
		
	}


	public function index() {
		
		$id = $this->session->userdata('idEvenementEnCours');
		$data['accreds'] = $this->modelaccreditation->getAccreditationsParEvenementSansMembre($id);
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	/**
	 * Fonction pour afficher la liste des demandes en cours.
	 */
	public function demandes() {
		
		$id = $this->session->userdata('idEvenementEnCours');
		$data['accreds'] = $this->modelaccreditation->getAccreditationsEnAttente($id);
		$this->layout->view('utilisateur/accreditation/UADemandes', $data);
		
	}
	
	
	/**
	 * Fonction pour voire les informations précises d'une accréditation.
	 * @param int $idClient : id du client dont on veut voire les accréditation.
	 */
	public function voir($idClient) {
		
		$this->layout->ajouter_js('webcam/jquery.webcam');
		$this->layout->ajouter_js('webcam/webcam');
		
		$id = $this->session->userdata('idEvenementEnCours');
		
		$data = Array();

		// On récupère les informations sur le client.
		$data['client'] = $this->modelclient->getClientParId($idClient);
		$data['pays'] = $this->modelpays->getpays();
		$data['indicatif'] = $this->modelpays->getPaysParId($data['client']->pays)->indicatiftel;
		$data['evenements'] = $this->modelevenement->getEvenements();
		$data['categories'] = $this->modelcategorie->getCategorieDansEvenementToutBien();
		$data['zones'] = $this->modelzone->getZoneParEvenement($id);
		
		$data['accredAttente'] = array();
		$data['accredValide'] = array();
		
		$demandes = $this->modelaccreditation->getAccreditationsEnCourParClientParEvenement($idClient,$id);
		$validees = $this->modelaccreditation->getAccreditationsHistoriqueParClient($idClient);
		
		foreach($demandes as $demande) {
			$sortie['accred'] = $demande;
			$sortie['allZones'] = $this->modelzone->getZoneParEvenement($demande->idevenement);
			$sortie['zones'] = $this->modelzone->getZoneParAccredParEvenement($demande->idaccreditation, $demande->idevenement);
			$data['accredAttente'][] = $sortie;
		}
		
		foreach($validees as $validee) {
			$sortie['accred'] = $validee;
			$sortie['allZones'] = $this->modelzone->getZoneParEvenement($validee->idevenement);
			$sortie['zones'] = $this->modelzone->getZoneParAccredParEvenement($validee->idaccreditation, $validee->idevenement);
			$data['accredValide'][] = $sortie;
		}
		
		$this->layout->view('utilisateur/accreditation/UAVoir', $data);
		
	}
	
	public function voirEquipe($nomGroupe){
		$data = Array();
		$ref = Array();
		$pers = Array();
		$nomGroupe=str_replace('%20', ' ', $nomGroupe);;
		$idEvent = $this->session->userdata('idEvenementEnCours');
		$membres = $this->modelaccreditation->getAccreditationGroupeParEvenement( $nomGroupe, $idEvent);
		$zonesEvent = $this->modelzone->getZoneParEvenement($idEvent);
		foreach($membres as $m){
			$zonesAccred = $this->modelzone->getZoneParAccreditation($m->idaccreditation);
			foreach($zonesAccred as $z){
				$m->zonesAccred[] = $z->idzone;
			}
			if ($m->referent == null){
				$ref = $m;
			}
			else{
				$pers[] =$m;
				
			}
		}
		
		$data['zonesEvent'] = $zonesEvent;
		$data['ref'] = $ref;
		$data['personnes'] = $pers;
		$data['pays'] = $this->modelpays->getPaysParId($ref->pays);
		
		$this->layout->view('utilisateur/accreditation/UAVoirEquipe',$data);
		
		
	}
	public function rechercher() {
		
		$this->load->model('modelclient');
		$data['clients'] = $this->modelclient->getClients();
		
		$this->layout->view('utilisateur/accreditation/UARecherche', $data);
		
	}
		
	public function ajouter( $re = '' ) {
		
		$this->layout->ajouter_js('webcam/jquery.webcam');
		$this->layout->ajouter_js('webcam/webcam');
	
		/*
		 * Traitement du nom et du prénom : répercusion depuis la recherche
		 */
		$username = $this->input->post('username');
		$username = explode(' ', $username);
		
		$data['nom'] = '';
		$data['prenom'] = '';
		
		if(count($username)>0) {
			$data['nom'] = array_shift($username);
			$data['prenom'] = implode(' ', $username);
		}
		else
			$data['nom'] = $username;
		
		// Liste de zone et pays.
		$data['zones'] = $this->modelzone->getZoneParEvenement($this->session->userdata('idEvenementEnCours'));
		$data['pays'] = $this->modelpays->getPays();
		
		// Liste des catégories avec les zones associées.
		$cats = $this->listeCategorieToDisplay($this->session->userdata('idEvenementEnCours'));
		foreach($cats as $cat) {
			$push = array();
			$push['cat'] = $cat;
			$push['zones'] = '';
			$catZones = $this->modelzone->getZoneParCategorieEtEvenement($cat['db']->idcategorie, $this->session->userdata('idEvenementEnCours'));
			foreach($catZones as $cz) $push['zones'] .= $cz->idzone.'-';
			$data['categories'][] = $push;
		}
		
		// On passe les infos dans data.
		if(!empty($re)) {
			$data['re'] = $re;
		}

		$this->layout->view('utilisateur/accreditation/UAAjout', $data);
		
	}

	public function exeAjouter() {
		// mise en place de la vérification de CI.
		$config = array(
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
				'field'   => 'pays',
				'label'   => 'Pays', 
				'rules'   => ''
			),
			array(
				'field'   => 'tel',
				'label'   => 'Téléphone', 
				'rules'   => ''
			),
			array(
				'field'   => 'mail',
				'label'   => 'Mail', 
				'rules'   => 'valid_email'
			),
			array(
				'field'   => 'evenement',
				'label'   => 'Evènement', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'organisme',
				'label'   => 'Organisme / Société',
				'rules'   => ''
			),
			array(
				'field'   => 'fonction',
				'label'   => 'Fonction / Role', 
				'rules'   => ''
			),
			array(
				'field'   => 'organisme',
				'label'   => 'Organisme', 
				'rules'   => ''
			),
			array(
				'field'   => 'categorie',
				'label'   => 'Catégorie', 
				'rules'   => ''
			)
		);
		$this->form_validation->set_rules($config);
		
		$re = '';
		
		// Création du client.
		$client = array();

		$client['nom'] 		 = strtoupper($this->input->post('nom'));
		$client['prenom'] 	 = $this->input->post('prenom');
		$client['pays'] 	 = $this->input->post('pays');
		$client['tel'] 		 = $this->input->post('tel');
		$client['mail'] 	 = $this->input->post('mail');
		$client['organisme'] = $this->input->post('organisme');

		// Création de son accréditation.
		$accred = array();
		$accred['idevenement'] 	= $this->input->post('evenement');
		$accred['fonction'] 	= $this->input->post('fonction');
		$accred['idcategorie'] 	= $this->input->post('categorie');
		$accred['allaccess'] 	= ($this->input->post('allAccess'))? ALL_ACCESS : NON_ALL_ACCESS;
		
		// Construction du tableau de ses zones.
		$accredZone = array();
		if($this->input->post('zone')) {
			foreach( $this->input->post('zone') as $key => $value ) {
				$accredZone[$key] = $key;
			}
		}
		$mailOk = preg_match('/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/', $client['mail'] );
		
		// si le formulaire est correct.
		if ($this->form_validation->run() == true && $mailOk == 1) {
			// On ajoute le client.
			$this->modelclient->ajouter($client);
			$idClient = $this->modelclient->lastId();
			
			//upload ou webcam
			$webcam = $this->input->post('photo_webcam');
			if($webcam != null) {
				$png = imagecreatefrompng($webcam);
				$jpg = imagecreatetruecolor(IMG_WIDTH, IMG_HEIGHT);
				imagecopyresampled($jpg, $png, 0, 0, 0, 0, IMG_WIDTH, IMG_HEIGHT, IMG_WIDTH, IMG_HEIGHT);
				imagejpeg($jpg, UPLOAD_DIR . $idClient.".jpg", 100);
			}

			if($_FILES['photo_file']['size'] != 0)
				$this->upload($idClient);
            
			// On ajoute son accréditation.
			$accred['idclient'] = $idClient;
			$accred['etataccreditation'] = ACCREDITATION_VALIDE;
			$accred['dateaccreditation'] = time();
			$this->modelaccreditation->ajouter($accred);
			$idAccred = $this->modelaccreditation->lastId();
			
			// Mise en place de ses zones.
			if($this->input->post('zone')) {
				$values = array();
				if($this->input->post('zone')) {
					foreach( $this->input->post('zone') as $key => $value ) {
						$values[] = array('idaccreditation' => $idAccred, 'idzone' => $key);
					}
				}
				$this->modelzone->ajouterZonesAccreditation($values);
			}
			
			// redirection vers la fiche ainsi créer.
			redirect('accreditation/voir/' . $idClient);
			
		}
		else {
			// construction de la variable de retour d'informations.
			$re->client = $client;
			$re->accred = $accred;
			$re->zones = $accredZone;
			
			// Création des méssage d'erreur sur les champs du formulaire.
			if(empty($re->client['nom']))
				$re->erreurNom = 'Veuillez spécifier un nom.';
			if(empty($re->client['prenom']))
				$re->erreurPrenom = 'Veuillez spécifier un prénom.';
			
			if($mailOk == 0)
				$re->erreurMail = 'Veuillez spécifier un mail valide.';
		
			// On recharge le formulaire.
			$this->ajouter($re);
			
		}

	}

	public function ajouterGroupe( $re='' ) {
		
		// liste des zones pour l'evenement en cours.
		$data['zones'] = $this->modelzone->getZoneParEvenement($this->session->userdata('idEvenementEnCours'));
		
		// liste des pays.
		$data['pays'] = $this->modelpays->getPays();

		// Liste des catégories avec les zones associées.
		$cats = $this->listeCategorieToDisplay($this->session->userdata('idEvenementEnCours'));
		foreach($cats as $cat) {
			$push = array();
			$push['cat'] = $cat;
			$push['zones'] = '';
			$catZones = $this->modelzone->getZoneParCategorieEtEvenement($cat['db']->idcategorie, $this->session->userdata('idEvenementEnCours'));
			foreach($catZones as $cz) $push['zones'] .= $cz->idzone.'-';
			$data['categories'][] = $push;
		}
		
		// Info de reremplissage.
		$data['re'] = $re;
		
		// on appelle la vue.
		$this->layout->view('utilisateur/accreditation/UAjouterMembreDeGroupe', $data);
	}
	
	
	public function exeAjoutGroupe() {
		/* liste des champs obligatoire.
		verif info['groupe']	
		*/
		
		
		$info 		= $this->input->post('info');
		$ref 		= $this->input->post('ref');
		$personnes 	= $this->input->post('personne');
		$zones 		= $this->input->post('zone');
		
		/* Verification du formulaire */
		$verif = true;
		if(empty($info['groupe'])) {
			$verif = false;
		}
		if(empty($ref['nom']) or empty($ref['prenom']) or empty($ref['fonction'])) {
			$verif = false;
		}
		if($personnes) {
			foreach($personnes as $personne) {
				if(empty($personne['nom']) or empty($personne['prenom']) or empty($personne['fonction'])) {
					$verif = false;
				}
			}
		}
		
		
		if($verif) {
		
			// ajout du référent
			$ref['pays'] 		= $info['pays'];
			$ref['tel'] 		= $info['tel'];
			$ref['organisme'] 	= $info['societe'];
			$ref['mail'] 		= $info['mail'];
			$fonction 			= $ref['fonction'];
			unset($ref['fonction']);
			$this->modelclient->ajouter($ref);
			$id = $this->modelclient->lastId();
			
			// upload photo pour referent
			if($_FILES['photo_file']['size'] != 0) {
				
				$config['upload_path'] = UPLOAD_DIR;
				$config['allowed_types'] = 'jpg';
				$config['file_name'] = $id.".jpg";
				$config['overwrite'] = true;

				$this->load->library('upload', $config);
				$this->upload->do_upload('photo_file');
				$data = $this->upload->data();

				$this->load->helper('image');
				if($data['image_width'] > 160)
					resizeWidthRatio($data['full_path'], 160);
				
			}
			
			// ajout de son accred
			$aref = array();
			$aref['idclient'] 		= $id;
			$aref['idcategorie'] 	= $info['categorie'];
			$aref['idevenement'] 	= $this->session->userdata('idEvenementEnCours');
			$aref['fonction'] 		= $fonction;
			$aref['groupe'] 		= $info['groupe'];
			$aref['dateaccreditation'] = time();
			$this->modelaccreditation->ajouter($aref);
			$idAccredRef = $this->modelaccreditation->lastId();

			// ajout des zones
			$this->modelzone->supprimerZoneParAccreditation($idAccredRef);
			$values = array();
			foreach($zones as $key => $value )
				$values[] = array('idaccreditation' => $idAccredRef, 'idzone' => $key);
			$this->modelzone->ajouterZonesAccreditation($values);

			// boucle personnes
			foreach($personnes as $p) {
				
				// création du client
				$p['pays'] = $info['pays'];
				$p['organisme'] = $info['societe'];
				$p['tel']=$ref['tel'];
				$p['mail']=$ref['mail'];
				$fonction = $p['fonction'];
				unset($p['fonction']);
				$this->modelclient->ajouter($p);
				$pid = $this->modelclient->lastId();
				
				// duplication de l'image
				if($_FILES['photo_file']['size'] != 0)
					copy($data['full_path'], UPLOAD_DIR . '/' . $pid . '.jpg');
				
				// ajout de l'accred
				$ap = array();
				$ap['idclient'] = $pid;
				$ap['idcategorie'] = $info['categorie'];
				$ap['idevenement'] = $this->session->userdata('idEvenementEnCours');
				$ap['fonction'] = $fonction;
				$ap['groupe'] = $info['groupe'];
				$ap['referent'] = $id;
				$ap['dateaccreditation'] = time();
				$this->modelaccreditation->ajouter($ap);
				$idap = $this->modelaccreditation->lastId();
				
				// ajout des zones
				$this->modelzone->supprimerZoneParAccreditation($idap);
				$values = array();
				foreach($zones as $key => $value )
					$values[] = array('idaccreditation' => $idap, 'idzone' => $key);
				$this->modelzone->ajouterZonesAccreditation($values);
			}
			
			redirect('accreditation/voirEquipe/'.$info['groupe']);
		}
		else {
			$data = '';
			$data->info 	= $info;
			$data->ref 		= $ref;
			$data->personne = $personnes;
			
			$this->ajouterGroupe($data);
		}
		
		
	}
	


	public function modifier($idAccred) {

		$this->layout->ajouter_js('webcam/jquery.webcam');
		$this->layout->ajouter_js('webcam/webcam');

		/*
		 * Liste de zone et pays
		 */
		$data['zones'] = $this->modelzone->getZoneParEvenement($this->session->userdata('idEvenementEnCours'));
		$data['pays'] = $this->modelpays->getPays();


		/*
		 * Liste des catégories avec les zones associées
		 */
		$cats = $this->modelcategorie->getCategorieDansEvenement($this->session->userdata('idEvenementEnCours'));
		foreach($cats as $cat) {
			$push = array();
			$push['cat'] = $cat;
			$push['zones'] = '';
			$catZones = $this->modelzone->getZoneParCategorieEtEvenement($cat->idcategorie, $this->session->userdata('idEvenementEnCours'));
			foreach($catZones as $cz) $push['zones'] .= $cz->idzone.'-';
			$data['categories'][] = $push;
		}

		/*
		 * Accred et client
		 */
		$data['accred'] = $this->modelaccreditation->getAccreditationParId($idAccred);


		/*
		 * Liste des zones de l'accred
		 */
		$sortie = array();
		$zonesAccred = $this->modelzone->getZoneParAccreditation($idAccred);
		foreach($zonesAccred as $za)
			$sortie[] = $za->idzone;
		$data['zonesAccred'] = $sortie;


		$this->layout->view('utilisateur/accreditation/UAModifier', $data);

	}
	
	
	

	public function exeModifierClient() {
		
		$id				= $this->input->post('id');
		$data['nom']	= strtoupper($this->input->post('nom'));
		$data['prenom'] = $this->input->post('prenom');
		$data['pays']	= $this->input->post('pays');
		$data['tel']	= $this->input->post('tel');
		$data['mail']	= $this->input->post('mail');
		$data['organisme'] = $this->input->post('organisme');
		
		$webcam = $this->input->post('photo_webcam');
		if($webcam != null) {
			$png = imagecreatefrompng($webcam);
			$jpg = imagecreatetruecolor(160, 204);
			imagecopyresampled($jpg, $png, 0, 0, 0, 0, 160, 204, 160, 204);
			imagejpeg($jpg, UPLOAD_DIR . $id.".jpg", 100);
		}

		$this->modelclient->modifier($id, $data);

		if($_FILES['photo_file']['size'] != 0)
			$this->upload($id);
		else {
			redirect('accreditation/voir/' . $id);
		}
			
		
	}
	
	public function modifierGroupe($nomGroupe){		
		$data = Array();
		$ref = Array();
		$pers = Array();
		$nomGroupe=str_replace('%20', ' ', $nomGroupe);;
		$idEvent = $this->session->userdata('idEvenementEnCours');
		$membres = $this->modelaccreditation->getAccreditationGroupeParEvenement( $nomGroupe, $idEvent);
		$zonesEvent = $this->modelzone->getZoneParEvenement($idEvent);
		$pays = $this->modelpays->getPays();
		
		foreach($membres as $m){
			$zonesAccred = $this->modelzone->getZoneParAccreditation($m->idaccreditation);
			foreach($zonesAccred as $z){
				$m->zonesAccred[] = $z->idzone;
			}
			if ($m->referent == null){
				$ref = $m;
			}
			else{
				$pers[] =$m;
				
			}
		}
		
		$data['zonesEvent'] = $zonesEvent;
		$data['ref'] = $ref;
		$data['personnes'] = $pers;
		$data['pays'] = $this->modelpays->getPaysParId($ref->pays);

		// Liste des catégories avec les zones associées.
		$cats = $this->listeCategorieToDisplay($this->session->userdata('idEvenementEnCours'));
		foreach($cats as $cat) {
			$push = array();
			$push['cat'] = $cat;
			$push['zones'] = '';
			$catZones = $this->modelzone->getZoneParCategorieEtEvenement($cat['db']->idcategorie, $this->session->userdata('idEvenementEnCours'));
			foreach($catZones as $cz) $push['zones'] .= $cz->idzone.'-';
			$data['categories'][] = $push;
		}

		$data['pays'] = $pays;
		
		$this->layout->view('utilisateur/accreditation/UAModifierGroupe', $data);
	}
	
	public function exeModifierGroupe() {
	
		$info				= $this->input->post('info');
		$personnes				= $this->input->post('pers');
		if($_FILES['photo_file']['size'] != 0) {
			
			$config['upload_path'] = UPLOAD_DIR;
			$config['allowed_types'] = 'jpg';
			$config['file_name'] = $personnes['0']['idclient'].".jpg";
			$config['overwrite'] = true;

			$this->load->library('upload', $config);
			$this->upload->do_upload('photo_file');
			$data = $this->upload->data();

			$this->load->helper('image');
			if($data['image_width'] > 160)
				resizeWidthRatio($data['full_path'], 160);
			
		}
		
		foreach($personnes as $pers){
		
		//modification du client	
		$idClient = $pers['idclient'];
		$client = array();
		$client['nom'] = $pers['nom'];
		$client['prenom'] = $pers['prenom'];
		$client['pays'] = $info['pays'];
		$client['tel'] = $info['tel'];
		$client['mail'] = $info['mail'];
			
		$this->modelclient->modifier($idClient, $client);

		//modification de l'accreditation
		$idAccred = $pers['idaccreditation'];
		$accred = array();
		$accred['idclient'] = $idClient;
		$accred['idcategorie'] = $pers['categorie'];
		$accred['fonction'] = $pers['fonction'];
		//$accred['allaccess'] = ($this->input->post('allAccess'))? ALL_ACCESS : NON_ALL_ACCESS;

		$this->modelaccreditation->modifier($idAccred, $accred);
		
		// modification des zones (suppression puis ajout).
		$this->modelzone->supprimerZoneParAccreditation($idAccred);

		if($_FILES['photo_file']['size'] != 0)
				copy($data['full_path'], UPLOAD_DIR . '/' . $pid . '.jpg');
		
		$values = array();
		foreach( $pers['zone'] as $key => $value )
			$values[] = array('idaccreditation' => $idAccred, 'idzone' => $key);

			$this->modelzone->ajouterZonesAccreditation($values);
		}
		
		redirect('accreditation/voirEquipe/'.$info['groupe']);
	
	}
	
	
	public function supprimer( $id, $idClient ) {
		
		// suppression de toute les zones liée a l'accréditation.
		$this->modelzone->supprimerZoneParAccreditation( $id );
		
		// Suppression de notre accreditation.
		$this->modelaccreditation->supprimer( $id );
		
		redirect('accreditation/voir/' . $idClient);
		
	}
	
	public function supprimerMembreGroupe ($idaccred, $nomgroupe){
		// suppression de toute les zones liée a l'accréditation.
		$this->modelzone->supprimerZoneParAccreditation( $idaccred );
		
		// Suppression de notre accreditation.
		$this->modelaccreditation->supprimer( $idaccred );
		
		$nomGroupe=str_replace('%20', ' ', $nomgroupe);
		redirect('accreditation/modifierGroupe/' . $nomgroupe);
	}
	
	public function ajoutMembreGroupe($nomgroupe){
		
		$nomGroupe=str_replace('%20', ' ', $nomgroupe);;
		$idEvent = $this->session->userdata('idEvenementEnCours');
		$membres = $this->modelaccreditation->getAccreditationGroupeParEvenement( $nomGroupe, $idEvent);
		
		foreach($membres as $m){
			$zonesAccred = $this->modelzone->getZoneParAccreditation($m->idaccreditation);
			foreach($zonesAccred as $z){
				$m->zonesAccred[] = $z->idzone;
			}
			if ($m->referent != null){
				$membresgrp[] = $m;
			}
		}
		
		$data['info'] = $membresgrp[0];
		$data['info']->nompays = $this->modelpays->getPaysParId($membres[0]->pays);
		$data['pays'] = $this->modelpays->getPays();
		$data['zonesEvent'] = $this->modelzone->getZoneParEvenement($idEvent);

		// Liste des catégories avec les zones associées.
		$cats = $this->listeCategorieToDisplay($this->session->userdata('idEvenementEnCours'));
		foreach($cats as $cat) {
			$push = array();
			$push['cat'] = $cat;
			$push['zones'] = '';
			$catZones = $this->modelzone->getZoneParCategorieEtEvenement($cat['db']->idcategorie, $this->session->userdata('idEvenementEnCours'));
			foreach($catZones as $cz) $push['zones'] .= $cz->idzone.'-';
			$data['categories'][] = $push;
		}
		
		$this->layout->view('utilisateur/accreditation/UAModifierAjoutMembre', $data);
	}
	
	public function exeAjoutMembreGroupe(){
		
		// Création du client.
		$client = array();

		$client['nom'] 		 = strtoupper($this->input->post('nom'));
		$client['prenom'] 	 = $this->input->post('prenom');
		$client['pays'] 	 = $this->input->post('pays');
		$client['tel'] 		 = $this->input->post('tel');
		$client['mail'] 	 = $this->input->post('mail');
		$client['organisme'] = $this->input->post('organisme');

		// Création de son accréditation.
		$accred = array();
		$accred['idevenement'] 	= $this->input->post('evenement');
		$accred['fonction'] 	= $this->input->post('fonction');
		$accred['idcategorie'] 	= $this->input->post('categorie');
		$accred['referent']		= $this->input->post('referent');
		$accred['groupe']		= $this->input->post('groupe');
		$accred['allaccess'] 	= ($this->input->post('allAccess'))? ALL_ACCESS : NON_ALL_ACCESS;
		
		// Construction du tableau de ses zones.
		$accredZone = array();
		if($this->input->post('zone')) {
			foreach( $this->input->post('zone') as $key => $value ) {
				$accredZone[$key] = $key;
			}
		}
		
		// On ajoute le client.
		$this->modelclient->ajouter($client);
		$idClient = $this->modelclient->lastId();
			
		// On ajoute son accréditation.
		$accred['idclient'] = $idClient;
		$accred['etataccreditation'] = ACCREDITATION_VALIDE;
		$accred['dateaccreditation'] = time();
		$this->modelaccreditation->ajouter($accred);
		$idAccred = $this->modelaccreditation->lastId();

		// Mise en place de ses zones.
		if($this->input->post('zone')) {
			$values = array();
			if($this->input->post('zone')) {
				foreach( $this->input->post('zone') as $key => $value ) {
					$values[] = array('idaccreditation' => $idAccred, 'idzone' => $key);
				}
			}
			$this->modelzone->ajouterZonesAccreditation($values);
		}
		redirect('accreditation/voirEquipe/'.$this->input->post('groupe'));
	}
	
	public function supprimerClient ( $idClient ) {
		
		// on supprime les accréditation de ce membres.
		$this->modelcategorie->supprimerParClient( $idClient );
		
		// On supprime notre accréditation.
		$this->modelcategorie->supprimerClient();
		
		redirect('accreditation');
		
	}
	
	

	
	public function exeModifier() {
		// mise en place de la vérification de CI.
		// $config = array(
			// array(
				// 'field'   => 'nom',
				// 'label'   => 'Nom', 
				// 'rules'   => 'required'
			// ),
			// array(
				// 'field'   => 'prenom',
				// 'label'   => 'Prenom', 
				// 'rules'   => 'required'
			// ),
			// array(
				// 'field'   => 'pays',
				// 'label'   => 'Pays',
				// 'rules'   => ''
			// ),
			// array(
				// 'field'   => 'tel',
				// 'label'   => 'Téléphone',
				// 'rules'   => ''
			// ),
			// array(
				// 'field'   => 'mail',
				// 'label'   => 'e-Mail',
				// 'rules'   => ''
			// ),
			// array(
				// 'field'   => 'evenement',
				// 'label'   => 'Evènement', 
				// 'rules'   => 'required'
			// ),
			// array(
				// 'field'   => 'fonction',
				// 'label'   => 'Fonction / Role', 
				// 'rules'   => ''
			// ),
			// array(
				// 'field'   => 'categorie',
				// 'label'   => 'Catégorie', 
				// 'rules'   => ''
			// )
		// );
		// $this->form_validation->set_rules($config);
		
		$idClient = $this->input->post('idClient');
		$client = array();
		$client['nom'] = strtoupper($this->input->post('nom'));
		$client['prenom'] = $this->input->post('prenom');
		$client['pays'] = $this->input->post('pays');
		$client['tel'] = $this->input->post('tel');
		$client['mail'] = $this->input->post('mail');
		
		$webcam = $this->input->post('photo_webcam');
		if($webcam != null) {
			$png = imagecreatefrompng($webcam);
			$jpg = imagecreatetruecolor(160, 204);
			imagecopyresampled($jpg, $png, 0, 0, 0, 0, 160, 204, 160, 204);
			imagejpeg($jpg, UPLOAD_DIR . $idClient.".jpg", 100);
		}

		$this->modelclient->modifier($idClient, $client);
		
		$idAccred = $this->input->post('idAccred');
		$accred = array();
		$accred['idclient'] = $idClient;
		$accred['idcategorie'] = $this->input->post('categorie');
		$accred['fonction'] = $this->input->post('fonction');
		$accred['allaccess'] = ($this->input->post('allAccess'))? ALL_ACCESS : NON_ALL_ACCESS;
		
		$this->modelaccreditation->modifier($idAccred, $accred);
		
		// modification des zone.
		$this->modelzone->supprimerZoneParAccreditation($idAccred);
		
		$values = array();
		
		foreach( $this->input->post('zone') as $key => $value )
			$values[] = array('idaccreditation' => $idAccred, 'idzone' => $key);
		var_dump($values);
		$this->modelzone->ajouterZonesAccreditation($values);

		if($_FILES['photo_file']['size'] != 0)
			$this->upload($idClient);
		else
			redirect('accreditation/modifier/' . $idAccred);

	}
	
	
	public function nouvelle($idClient) {
		
		/*
		 * Client et liste de zone et pays
		 */
		$data['client'] = $this->modelclient->getClientParId($idClient);
		$data['zones'] = $this->modelzone->getZoneParEvenement($this->session->userdata('idEvenementEnCours'));
		$data['pays'] = $this->modelpays->getPays();
		/*
		 * Liste des catégories avec les zones associées
		 */
		$cats = $this->modelcategorie->getCategorieDansEvenement($this->session->userdata('idEvenementEnCours'));
		foreach($cats as $cat) {
			$push = array();
			$push['cat'] = $cat;
			$push['zones'] = '';
			$catZones = $this->modelzone->getZoneParCategorieEtEvenement($cat->idcategorie, $this->session->userdata('idEvenementEnCours'));
			foreach($catZones as $cz) $push['zones'] .= $cz->idzone.'-';
			$data['categories'][] = $push;
		}
		
		
		$this->layout->view('utilisateur/accreditation/UANouvelle', $data);
		
	}
	
	
	public function exeNouvelle() {
		
		$idClient = $this->input->post('idClient');
		$client = array();
		$client['nom'] = strtoupper($this->input->post('nom'));
		$client['prenom'] = $this->input->post('prenom');
		$client['pays'] = $this->input->post('pays');
		$client['tel'] = $this->input->post('tel');
		$client['mail'] = $this->input->post('mail');
		
		$this->modelclient->modifier($idClient, $client);
		
		$accred = array();
		$accred['idclient'] = $idClient;
		$accred['idevenement'] = $this->session->userdata('idEvenementEnCours');
		$accred['fonction'] = $this->input->post('fonction');
		$accred['idcategorie'] = $this->input->post('categorie');
		$accred['etataccreditation'] = ACCREDITATION_VALIDE;
		$accred['dateaccreditation'] = time();
		$this->modelaccreditation->ajouter($accred);
		
		$idAccred = $this->modelaccreditation->lastId();
		
		redirect('accreditation/modifier/' . $idAccred);
		
	}
	
	
	public function valider ($idAccreditation ) {
		
		$this->modelaccreditation->valideraccreditation( $idAccreditation );
			$data['zones'] = $this->modelzone->getZoneParEvenement($this->session->userdata('idEvenementEnCours'));
	
		redirect('accreditation/modifier/' . $idAccreditation); 
		
	}	
	

	
	/*
	 * Upload
	 * Recoit la photo à mettre à jours
	 */
	public function upload($id)
	{
		$client = $this->modelclient->getClientParId($id);
		
		$config['upload_path'] = UPLOAD_DIR;
		$config['allowed_types'] = 'jpg';
		$config['file_name'] = $id.".jpg";
		$config['overwrite'] = true;
		
		$this->load->library('upload', $config);
		$this->upload->do_upload('photo_file');
		echo $this->upload->display_errors();
		$data = $this->upload->data();
		
		$img = imagecreatefromjpeg(UPLOAD_DIR . $data['file_name']);
		
		$this->load->helper('url');
		$this->load->helper('image');
		
		if($data['image_width'] == IMG_WIDTH && $data['image_height'] == IMG_HEIGHT) {
			redirect('accreditation/voir/' . $id, 0.2);
		} elseif($data['image_width'] > IMG_WIDTH && $data['image_height'] > IMG_HEIGHT) {
			if($data['image_width'] > 940)
				resizeWidthRatio($data['full_path'], 940);
			redirect('accreditation/crop/' . $id);
		} else
			die('Image trop petite.');
	}
	
	/*
	 * Crop : coupe une image trop grande
	 */
	public function crop($id) {
		
		$data['client'] = $this->modelclient->getClientParId($id);
		$this->layout->view('utilisateur/accreditation/UACrop', $data);
		
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
		redirect('accreditation/voir/' . $id);
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