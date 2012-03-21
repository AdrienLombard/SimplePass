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
		$this->load->library('form_validation');
		$this->layout->ajouter_css('utilisateur/accreditation');
		$this->layout->ajouter_js('utilisateur/CRUDAccred');
		
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
	public function ajouter() {
	
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
	
	
	
	public function exeAjouter() {
		
		$client = array();
		$client['nom'] = strtoupper($this->input->post('nom'));
		$client['prenom'] = $this->input->post('prenom');
		$client['pays'] = $this->input->post('pays');
		$client['tel'] = $this->input->post('tel');
		$client['mail'] = $this->input->post('mail');
		$this->modelclient->ajouter($client);
		
		$idClient = $this->modelclient->lastId();
		
		$accred = array();
		$accred['idclient'] = $idClient;
		$accred['idevenement'] = $this->input->post('evenement');
		$accred['fonction'] = $this->input->post('fonction');
		$accred['etataccreditation'] = ACCREDITATION_VALIDE;
		$accred['dateaccreditation'] = time();
		$accred['allaccess'] = ($this->input->post('allAccess'))? ALL_ACCESS : NON_ALL_ACCESS;
		$this->modelaccreditation->ajouter($accred);
		
		$idAccred = $this->modelaccreditation->lastId();
		
		// todo : ajout zones
		
		$this->load->helper('url');
		redirect('accreditation/voir/' . $idClient);		
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
		$message['titre']		= 'Modification';
		$message['redirect'] 	= 'accreditation/liste';
		$this->layout->view('utilisateur/UMessage', $message);
		$this->load->helper('url');
		redirect('accreditation/voir/' . $id);
		
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
}