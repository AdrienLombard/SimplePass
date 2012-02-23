<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accreditation extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		
		// Chargement des modeles.
		$this->load->model('modelaccreditation');
		$this->load->model('modelzone');
		
		$this->layout->ajouter_css('utilisateur/accreditation');
		$this->layout->ajouter_js('utilisateur/CRUDAccred');
		
	}


	public function index() {
		
		$data['accreds'] = $this->modelaccreditation->getAccreditationsParEvenement(1);
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	/**
	 * Fonction pour afficher la liste des demandes en cours.
	 */
	public function demandes( $idEvenement ) {
		
		$data['accreditations'] = $this->modelaccreditation->getAccreditationsEnAttente( $idEvenement );
		
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	
	/**
	 * Fonction pour voire les informations précises d'une accréditation.
	 * @param int $idClient : id du client dont on veut voire les accréditation.
	 */
	public function voir($idClient) {
		
		$this->load->model('modelclient');
		$this->load->model('modelpays');
		
		$data = Array();
		
		// On récupère les informations sur le client.
		$data['client'] = $this->modelclient->getClientParId($idClient);
		$data['pays'] = $this->modelpays->getpays();
		
		// On récpère les accréditations de ce client.
		$accreditation = $this->modelaccreditation->getAccreditationsParClient( $idClient );
		$data['accredAttente'] = array();
		$data['accredValide'] = array();
		foreach ($accreditation as $accred) {
			if($accred->etataccreditation == ACCREDITATION_A_VALIDE) {
				$data['accredAttente'][] = $accred;
			}
			else {
				$data['accredValide'][] = $accred;
			}
			$idAccred[] = $accred->idaccreditation;
			$idCategories[] = $accred->idcategorie;
		}
		
		// On récupère et on traite la liste des zones utilisé par les accréditation de ce client.
		$zonesCate = $this->modelzone->getZoneParIdMultiple( $idCategories );
		$cateZones = Array();
		foreach($zonesCate as $zones) {
			$cateZones[$zones->idcategorie][$zones->idzone] = true;
			
		}
		foreach($accreditation as $accred) {
			$listeZonesAccred[$accred->idaccreditation] = $cateZones[$accred->idcategorie];
		}
		
		// on prend les zone + accred.
		$accredZones = $this->modelzone->getZoneParAccreditationMultiple( $idAccred );
		
		// on merge dans le meme tableau, avec [idaccred][idzone] = true; de la meme facon.
		foreach ($accredZones as $key => $zones) {
			$listeZonesAccred[$zones->idacreditation][$zones->idzone] = true;
		}
		
		$data['listeZonesAccred'] = $listeZonesAccred;
		
		$this->layout->view('utilisateur/accreditation/UAVoir', $data);
		
	}
	
	public function ajouter() {
		
		$this->layout->view('utilisateur/accreditation/UAAjout');
		
	}
	
	public function ajouterClient() {
		
	}
	
	public function exeAjouterClient() {
		
	}
	
	public function ajouterAccreditation() {
		
	}
	
	public function exeAjouterAccreditation() {
		
	}

}