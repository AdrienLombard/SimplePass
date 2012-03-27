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
		
		$this->layout->ajouter_js('webcam/jquery.webcam');
		
		// Chargement des librairie.
		$this->load->library('form_validation');
		
		// Mise en place de la sécurisation.
		$this->securiseAll();
		
	}


	public function index() {
		
		$id = $this->session->userdata('idEvenementEnCours');
		$data['accreds'] = $this->modelaccreditation->getAccreditationsParEvenement($id);
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
	public function voirEquipe($idClient, $idEvenement){
		$data=Array();
		
		$data['idevenement'] = $idEvenement;
		$data['client'] = $this->modelclient->getClientParId($idClient);
		$data['accreditation'] = $this->modelaccreditation->getAccreditationsReferentParEvenement($idClient, $idEvenement);
		$data['pays'] = $this->modelpays->getpays();
		$data['evenements'] = $this->modelevenement->getEvenements();
		$data['zones'] = $this->modelzone->getZoneParEvenement( $idEvenement );
		$data['accredAttente'] = array();
		$data['accredValide'] = array();
		
		// On récpère les accréditations de ce client.
		$equipe = $this->modelaccreditation->getAccreditationsGroupeParEvenement( $idClient , $idEvenement);
		
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
		
		
		
		$idCategories = array();
		foreach ($equipe as $accred) {
		       
			if($accred->idclient != $idClient ) {
				if($accred->etataccreditation == ACCREDITATION_A_VALIDE) {
					$data['accredAttente'][] = $accred;
				}
				else {
					$data['accredValide'][] = $accred;
				}
				$idAccred[] = $accred->idaccreditation;
				$data['accredMembre'] = $accred;
				$idCategories[] = $accred->idcategorie;
				
				
				/*
				 * Liste des zones de l'accred
				 */
				$sortie = array();
				$zonesAccred = $this->modelzone->getZoneParAccreditation($accred->idaccreditation);
				foreach($zonesAccred as $za)	
					$sortie[] = $za->idzone;

					
				$zonesAccred = array();
				$zonesAccred = $this->modelzone->getZoneParCategorieEtEvenement( $accred->idcategorie, $this->session->userdata('idEvenementEnCours') );
				
				foreach($zonesAccred as $za)
					$sortie[] = $za->idzone;
				

				$data['zonesAccred'][$accred->idaccreditation] = $sortie;
			}
			
		}
		
		$listeZonesAccred = array();
		if(count($idCategories)) {

			// On récupère et on traite la liste des zones utilisé par les accréditation de ce client.
			$zonesCate = $this->modelzone->getZoneParIdMultipleParEvenement( $idCategories , $idEvenement );
			$cateZones = Array();
			
			foreach($zonesCate as $zones) {
				$cateZones[$zones->idcategorie][$zones->idzone] = true;

			}

			$data['listeZonesAccred'] = $cateZones;
		
		}
		
		$this->layout->view('utilisateur/accreditation/UAVoirEquipe',$data);
		
		
	}
	public function rechercher() {
		
		$this->load->model('modelclient');
		$data['clients'] = $this->modelclient->getClients();
		
		$this->layout->view('utilisateur/accreditation/UARecherche', $data);
		
	}
	
	public function rechercherReferent() {
		
		$this->load->model('modelclient');
		$data['referents'] = $this->modelclient->getReferents();
		$this->layout->view('utilisateur/accreditation/UAjouterGroupe', $data);
		
	}
	
	public function ajouter( $re = '' ) {
	
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
		$cats = $this->modelcategorie->getCategorieDansEvenement($this->session->userdata('idEvenementEnCours'));
		foreach($cats as $cat) {
			$push = array();
			$push['cat'] = $cat;
			$push['zones'] = '';
			$catZones = $this->modelzone->getZoneParCategorieEtEvenement($cat->idcategorie, $this->session->userdata('idEvenementEnCours'));
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
				'label'   => 'Téléphone', 
				'rules'   => ''
			),
			array(
				'field'   => 'mail',
				'label'   => 'e-Mail', 
				'rules'   => ''
			),
			array(
				'field'   => 'evenement',
				'label'   => 'Evènement', 
				'rules'   => 'required'
			),
			array(
				'field'   => 'fonction',
				'label'   => 'Fonction / Role', 
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
		$client['nom'] 		= strtoupper($this->input->post('nom'));
		$client['prenom'] 	= $this->input->post('prenom');
		$client['pays'] 	= $this->input->post('pays');
		$client['tel'] 		= $this->input->post('tel');
		$client['mail'] 	= $this->input->post('mail');
		
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
		
		// si le formulaire est correct.
		if ($this->form_validation->run() == true) {
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
				$valuess = array();
				if($this->input->post('zone')) {
					foreach( $this->input->post('zone') as $key => $value ) {
						$values[] = array('idaccreditation' => $idAccred, 'idzone' => $key);
					}
				}
				$this->modelzone->ajouterZonesAccreditation($values);
			}
			
			
			// redirection vers la fiche ainsi créer.
			$this->load->helper('url');
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
				$re->erreurPrenom = 'Veuillez spécifier un prenom.';
		
			// On recharge le formulaire.
			$this->ajouter($re);
			
		}

	}

	public function ajouterGroupe() {
	
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
		
		$this->layout->view('utilisateur/accreditation/UAjouterMembreDeGroupe', $data);
		
	}
	
	
	

	public function exeModifierClient() {
		
		$id				= $this->input->post('id');
		$data['nom']	= strtoupper($this->input->post('nom'));
		$data['prenom'] = $this->input->post('prenom');
		$data['pays']	= $this->input->post('pays');
		$data['tel']	= $this->input->post('tel');
		$data['mail']	= $this->input->post('mail');
		$message['message']= 'Votre l accreditation  de client  à bien été modifié.';
		$this->modelclient->modifier($id, $data);

		$this->upload($id);
		
	}
	
	
	public function exeModifierGroupe($ref=false) {
	
		/* Modification des infos du référent */
		$id				= $this->input->post('idRef');
		$idAccred = $this->input->post('idAccredRef');
		if($ref)
		{
		
			$data['nom']	= $this->input->post('nomRef');
			$data['prenom'] = $this->input->post('prenomRef');
			$data['pays']	= $this->input->post('paysRef');
			$data['organisme'] = $this->input->post('organismeRef');
			$data['tel']	= $this->input->post('telRef');
			$data['mail']	= $this->input->post('mailRef');
			$data['role']   =$this->input->post('fonctionRef');
		

	    //display_tab($this->input->post('data'));
		
		$this->modelclient->modifier($id, $data);
			$this->load->model('modelclient');
			$this->load->model('modelaccreditation');
			$this->load->model('modelzone');
			
			$this->modelclient->modifier($id, $data);

		}
		else 
		{
			$reponse=$this->modelaccreditation->getDemandesParClient($id);
			if($reponse)
			{
				$data['nom'] 		= $reponse[0]->nom;
				$data['prenom'] 	= $reponse[0]->prenom;
				$data['pays'] 	= $reponse[0]->pays;
				$data['organisme'] = $reponse[0]->organisme;
		        $data['tel']	= $reponse[0]->tel;
		        $data['mail']	= $reponse[0]->mail;
				$data['role']   =$reponse[0]->fonction;
			}
			//$dataAccred['etataccreditation'] = 0;
		}
		$dataAccred = array();
		
		$dataAccred['fonction'] = $this->input->post('fonctionRef');
		
		
		if(empty($dataAccred['fonction'])) {
			$dataAccred['fonction'] = "";
		}
		
		$idAccred = $this->input->post('idAccredRef');
		
		$this->modelaccreditation->modifier($idAccred, $dataAccred);
		
		//display_tab($this->input->post('groupe'));
		
		$idevenement = $this->input->post('evenement');

		
		/* Modification des membres du groupe */
		
 		foreach($this->input->post('groupe') as $ligne) {
			
			/* Modification de l'accréditation */
 			$accred = array();
 			$accred['idevenement'] = $idevenement;
			$accred['idcategorie'] = $ligne['categorieGroupe'];

			//$accred['idevenement'] = $this->input->post('evenement');

			$accred['idclient'] = $ligne['idClient'];
			
			if(!empty($ligne['fonction'])) {
				$accred['fonction'] = $ligne['fonction'];
			}
			else {
				$accred['fonction'] = "";
			}
			
			$zonesCategorie = $this->modelzone->getZoneParCategorieEtEvenement( $ligne['categorieGroupe'], $idevenement );
		
			$zonesAccreditation = $this->modelzone->getZoneParAccreditation( $ligne['idAccreditation'] );
			
			$this->modelzone->supprimerZoneParAccreditation ( $ligne['idAccreditation'] );
			
			foreach($ligne['zone'] as $idzone => $etat) {
				$this->modelzone->ajouterZoneAccreditation( $ligne['idAccreditation'], $idzone );
			}
			
			$accred['etataccreditation'] = 0;
			$this->modelaccreditation->modifier($ligne['idAccreditation'], $accred);
			$message['titre']		= 'Modification';
			$message['message']= 'l accreditation a bien été modifiée.';
			$message['redirect'] 	= 'accreditation/demandes';
			
		
		}
		
		redirect('accreditation/index');
	
	}
	
	
	public function supprimer( $id, $idClient ) {
		
		// suppréssion de toute les zones liée a l'accréditation.
		$this->modelzone->supprimerZoneParAccreditation( $id );
		
		// Suppréssion de notre accreditation.
		$this->modelaccreditation->supprimer( $id );
		
		$this->load->helper('url');
		redirect('accreditation/voir/' . $idClient);
		
	}
	
	public function supprimerClient ( $idClient ) {
		
		// on supprime les accréditation de ce membres.
		$this->modelcategorie->supprimerParClient( $idClient );
		
		// On supprime notre accréditation.
		$this->modelcategorie->supprimerClient();
		
		$this->load->helper('url');
		redirect('accreditation');
		
	}
	
	
	public function modifier($idAccred) {
		
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
		foreach( $this->input->post('zone') as $key => $value ) {
			
			$values[] = array('idaccreditation' => $idAccred, 'idzone' => $key);
		}
		
		$this->modelzone->ajouterZonesAccreditation($values);
		
		
		$this->load->helper('url');
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
		
		// todo : modif zones
		
		$this->load->helper('url');
		redirect('accreditation/modifier/' . $idAccred);
		
	}
	
	
	public function valider ($idAccreditation ) {
		
		$this->modelaccreditation->valideraccreditation( $idAccreditation );
			$data['zones'] = $this->modelzone->getZoneParEvenement($this->session->userdata('idEvenementEnCours'));
	
		$this->load->helper('url');
		redirect('accreditation/modifier/' . $idAccreditation); 
		
	}
	
	
	public function AjouterGroupeUtilisateur() {	
		
	    echo $this->input->post('nomsociete');
		$membre['tel']=$this->input->post('tel');
		$membre['pays']=$this->input->post('pays');
		$membre['categorie']=$this->input->post('categorie');
		$var=$this->input->post('nomsociete');
		
		//display_tab($membre);
		foreach($this->input->post('nompersonne') as $ligne) {
			// création du client
			$membre = null;
			$membre['nom'] = $ligne['nom'];
			$membre['prenom'] = $ligne['prenom'];
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
			$tab = $ligne['categorie'];
			$temp = -1;
			while($temp == -1) {
				$temp = array_pop($tab);
			}
			$accred['idcategorie'] = $temp;
			$this->modelaccreditation->ajouter($accred);
		}	
		$this->layout->view('utilisateur/accreditation/UAjouterMembreDeGroupe',$membre);

	}
	
	
	public function exeAjoutGroupe() {
		
		$info = $this->input->post('info');
		$ref = $this->input->post('ref');
		$personnes = $this->input->post('personne');
		$zones = $this->input->post('zone');
		
		// ajout du référent
		$ref['pays'] = $info['pays'];
		$ref['tel'] = $info['tel'];
		$ref['organisme'] = $info['societe'];
		$ref['mail'] = $info['mail'];
		$fonction = $ref['fonction'];
		unset($ref['fonction']);
		$this->modelclient->ajouter($ref);
		$id = $this->modelclient->lastId();
		
		// ajout de son accred
		$aref = array();
		$aref['idclient'] = $id;
		$aref['idcategorie'] = $info['categorie'];
		$aref['idevenement'] = $this->session->userdata('idEvenementEnCours');
		$aref['fonction'] = $fonction;
		$aref['groupe'] = $info['groupe'];
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
			$fonction = $p['fonction'];
			unset($p['fonction']);
			$this->modelclient->ajouter($p);
			$pid = $this->modelclient->lastId();
			
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
		
		$this->load->helper('url');
		redirect('accreditation/index');
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
		
		echo UPLOAD_DIR . $data['file_name'];
		
		$this->load->helper('url');
		$this->load->helper('image');
		
		$update['urlphoto'] = $data['file_name'];
		$client = $this->modelclient->modifier($id, $update);
		
		if($data['image_width'] == IMG_WIDTH && $data['image_height'] == IMG_HEIGHT)
			redirect('accreditation/voir/' . $id);
		elseif($data['image_width'] > IMG_WIDTH && $data['image_height'] > IMG_HEIGHT) {
			if($data['image_width'] > 940)
				resizeWidthRatio($data['full_path'], 940);
			redirect('accreditation/crop/' . $id);
		} else
			die('Image trop petite.');
	}

	public function generer( )
	{
//	header("Content-type: text/csv");
//    header('Content-Disposition: attachment; filename="liste_des_demandes.csv"');
//    
///* Récupérer les données de la base de données par exemple */
// //echo " liste"."\n";
//  $id = $this->session->userdata('idEvenementEnCours');
//  echo $id;
// $tableau=$this->modelaccreditation->getAccreditationsEnAttente($id);
// //envoi des headers csv
//	//header('Content-Type: application/csv-tab-delimited-table');
//	//nommage du fichier avec la date du jour
//	//header('Content-disposition: filename=monfichier_'.date('Ymd').'.csv');
//
// 
// echo "      Liste des demandes     "."\n";	
//echo "Nom;Prenom;Civilité;Pays;Organisme;Tel;Mail"."\n";
//foreach($tableau as $ligne)
//	
//	   {
//	//Pour chaque ligne, création d'une ligne dans le csv.
//	//Les champs sont entourés de guillemets, séparés par des points-virgules
//	//Les lignes sont terminées par un retour-chariot.
//	
//	echo '"'.$ligne->nom.'";"'.$ligne->prenom.'";"'.$ligne->civilite.'";"'.$ligne->pays.'";"'.$ligne->organisme.'";"'.$ligne->tel.'";"'.$ligne->mail.'"'."\n";
//	   }
//	 
//	mysql_close();
//
//	exit;
	
include "Spreadsheet/Excel/Writer.php";

// Création d'un manuel de travail
$workbook = new Spreadsheet_Excel_Writer();

// Envoi des en-têtes HTTP
$workbook->send('test.xls');

// Création d'une feuille de travail
$worksheet =& $workbook->addWorksheet('My first worksheet');

// Les données actuelles
$worksheet->write(0, 0, 'Nom');
$worksheet->write(0, 1, 'Age');
$worksheet->write(1, 0, 'John Smith');
$worksheet->write(1, 1, 30);
$worksheet->write(2, 0, 'Johann Schmidt');
$worksheet->write(2, 1, 31);
$worksheet->write(3, 0, 'Juan Herrera');
$worksheet->write(3, 1, 32);

// Envoi du fichier
$workbook->close();
 
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
		crop(UPLOAD_DIR . $client->urlphoto, $x, $y, $w, $h);
		
		$this->load->helper('url');
		redirect('accreditation/voir/' . $id);
	}

}