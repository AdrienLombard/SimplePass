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
		
		$data['accreds'] = $this->modelaccreditation->getAccreditationsValidees(1);
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	/**
	 * Fonction pour afficher la liste des demandes en cours.
	 */
	public function demandes() {
		
		//$data['accreds'] = $this->modelaccreditation->getAccreditationsEnAttente($idEvenement);
		$data['accreds'] = $this->modelaccreditation->getAccreditationsEnAttente(1);
		$this->layout->view('utilisateur/accreditation/UADemandes', $data);
		
	}
	
	
	/**
	 * Fonction pour voire les informations précises d'une accréditation.
	 * @param int $idClient : id du client dont on veut voire les accréditation.
	 */
	public function voir($idClient) {
		
		
		$data = Array();
		
		// On récupère les informations sur le client.
		$data['client'] = $this->modelclient->getClientParId($idClient);
		$data['pays'] = $this->modelpays->getpays();
		$data['evenements'] = $this->modelevenement->getEvenements();
		$data['categories'] = $this->modelcategorie->getCategorieDansEvenementToutBien();
		$data['zones'] = $this->modelzone->getZones();
		
		$data['accredAttente'] = array();
		$data['accredValide'] = array();
		
		$demandes = $this->modelaccreditation->getDemandesParClient($idClient);
		$validees = $this->modelaccreditation->getAccreditationsValideesParClient($idClient);
		
		foreach($demandes as $demande) {
			$sortie['accred'] = $demande;
			$sortie['allZones'] = $this->modelzone->getZoneParEvenement($demande->idevenement);
			$sortie['zones'] = $this->modelzone->getZoneParAccreditation($demande->idaccreditation);
			$data['accredAttente'][] = $sortie;
		}
		
		foreach($validees as $validee) {
			$sortie['accred'] = $validee;
			$sortie['allZones'] = $this->modelzone->getZoneParEvenement($validee->idevenement);
			$sortie['zones'] = $this->modelzone->getZoneParAccreditation($validee->idaccreditation);
			$data['accredValide'][] = $sortie;
		}
		
		$this->layout->view('utilisateur/accreditation/UAVoir', $data);
		
	}
	public function voirEquipe($idClient, $idEvenement){
		$data=Array();
		
		$data['client'] = $this->modelclient->getClientParId($idClient);
		$data['accreditation'] = $this->modelaccreditation->getAccreditationsReferentParEvenement($idClient, $idEvenement);
		//$data['equipe']=$this->modelaccreditation->getAccreditationsGroupeParEvenement($idClient);
		$data['pays'] = $this->modelpays->getpays();
		$data['evenements'] = $this->modelevenement->getEvenements();
		$data['categories'] = $this->modelcategorie->getCategorieDansEvenement( $idEvenement );
		$data['zones'] = $this->modelzone->getZoneParEvenement( $idEvenement );
		$data['accredAttente'] = array();
		$data['accredValide'] = array();
		//$data['demandes'] = $this->modelaccreditation->getDemandesParClient($idClient);
		
		// On récpère les accréditations de ce client.
		$equipe = $this->modelaccreditation->getAccreditationsGroupeParEvenement( $idClient , $idEvenement);
		
		$idCategories = array();
		foreach ($equipe as $accred) {
			if($accred->idclient != $idClient) {
				if($accred->etataccreditation == ACCREDITATION_A_VALIDE) {
					$data['accredAttente'][] = $accred;
				}
				else {
					$data['accredValide'][] = $accred;
				}
				$idAccred[] = $accred->idaccreditation;
				$data['accredMembre'] = $accred;
				$idCategories[] = $accred->idcategorie;
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
			/*foreach($equipe as $accred) {
				$listeZonesAccred[$accred->idaccreditation] = $cateZones[$accred->idcategorie];
			}*/

			// on prend les zone + accred.
			//$accredZones = $this->modelzone->getZoneParAccreditationMultiple( $idAccred );

			// on merge dans le meme tableau, avec [idaccred][idzone] = true; de la meme facon.
			/*foreach ($accredZones as $key => $zones) {
				$listeZonesAccred[$zones->idacreditation][$zones->idzone] = true;
			}*/

			$data['listeZonesAccred'] = $cateZones;
		
		}
		$this->layout->view('utilisateur/accreditation/UAVoirEquipe',$data);
		
		
	}
	public function rechercher() {
		
		$this->load->model('modelclient');
		$data['clients'] = $this->modelclient->getClients();
		
		$this->layout->view('utilisateur/accreditation/UARecherche', $data);
		
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
		 * Liste de catégorie, zone et pays
		 */
		
		$data['evenements'] = $this->modelevenement->getEvenements();
		$data['zones'] = $this->modelzone->getZones();
		$data['pays'] = $this->modelpays->getPays();
		
		/*
		 * Liste des catégories avec les zones associées
		 */
		$cats = $this->modelcategorie->getCategories();
		foreach($cats as $cat) {
			$push = array();
			$push['cat'] = $cat;
			$push['zones'] = '';
			$catZones = $this->modelzone->getZoneParCategorie($cat->idcategorie);
			foreach($catZones as $cz) $push['zones'] .= $cz->idzone.'-';
			$data['categories'][] = $push;
		}
		
		$this->layout->view('utilisateur/accreditation/UAAjout', $data);
		
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
		$accred['etataccreditation'] = 0;
		$accred['dateaccreditation'] = time();
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
		
	     display_tab($this->input->post('data'));
		
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
			}
		}
		$dataAccred = array();
		
		$dataAccred['fonction'] = $this->input->post('fonctionRef');
		
		if(empty($dataAccred['fonction'])) {
			$dataAccred['fonction'] = "";
		}
		$this->modelaccreditation->modifier($idAccred, $dataAccred);
		
		//display_tab($this->input->post('groupe'));
		
		/* Modification des membres du groupe */
		
 		foreach($this->input->post('groupe') as $ligne) {
			
			/* Modification de l'accréditation */
			$accred = array();
			$accred['idcategorie'] = $ligne['categorie'];
			$accred['idevenement'] = $this->input->post('evenement');
			$accred['idclient'] = $ligne['idClient'];
			
			if(!empty($ligne['fonction'])) {
				$accred['fonction'] = $ligne['fonction'];
			}
			else
				$accred['fonction'] = "";
			
			$accred['etataccreditation'] = 0;
			$this->modelaccreditation->modifier($ligne['idAccreditation'], $accred);
			$message['titre']		= 'Modification';
			$message['message']= 'l accreditation  à bien été modifié.';
			$message['redirect'] 	= 'accreditation/demandes';
		    $this->layout->view('utilisateur/UMessage', $message);
			
		}
		
		
		//redirect('accreditation/voir/' . $id);
	
	}
	
	
	public function supprimer( $id ) {
		
		// suppréssion de toute les zones liée a l'accréditation.
		$this->modelzone->supprimerZonesParAccreditation( $id );
		
		// Suppréssion de notre accreditation.
		$this->modelaccreditation->supprimer( $id );
		
		$data['titre']		= 'Suppression';
		$data['message']	= 'Votre accréditation à bien été supprimée.';
		$this->layout->view('utilisateur/UMessage', $data);
		
	}
	
	public function supprimerClient ( $idClient ) {
		
		// on supprime les accréditation de ce membres.
		$this->modelcategorie->supprimerParClient( $idClient );
		
		// On supprime notre accréditation.
		$this->modelcategorie->supprimerClient();
		
		$data['titre']		= 'Suppression';
		$data['message']	= 'Votre client et ses accréditation ont bien été supprimée.';
		$this->layout->view('utilisateur/UMessage', $data);
		
	}
	
	
	public function valider ($idAccreditation ) {
		
		$this->modelaccreditation->valideraccreditation( $idAccreditation );
				
		$data['titre']		= 'Validation';
		$data['message']	= 'L\'accréditation a été validée avec succes.';
		$this->layout->view('utilisateur/UMessage', $data);	 
		
	}
}