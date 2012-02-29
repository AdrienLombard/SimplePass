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
		
		$data['accreds'] = $this->modelaccreditation->getAccreditationsValidees(1);
		$this->layout->view('utilisateur/accreditation/UAIndex', $data);
		
	}
	
	/**
	 * Fonction pour afficher la liste des demandes en cours.
	 */
	public function demandes() {
		
		$data['accreds'] = $this->modelaccreditation->getAccreditationsEnAttente(1);
		$this->layout->view('utilisateur/accreditation/UADemandes', $data);
		
	}
	
	
	/**
	 * Fonction pour voire les informations précises d'une accréditation.
	 * @param int $idClient : id du client dont on veut voire les accréditation.
	 */
	public function voir($idClient) {
		
		$this->load->model('modelclient');
		$this->load->model('modelpays');
		$this->load->model('modelaccreditation');
		$this->load->model('modelevenement');
		$this->load->model('modelcategorie');
		$this->load->model('modelzone');
		
		$data = Array();
		
		// On récupère les informations sur le client.
		$data['client'] = $this->modelclient->getClientParId($idClient);
		$data['pays'] = $this->modelpays->getpays();
		$data['evenements'] = $this->modelevenement->getEvenements();
		$data['categories'] = $this->modelcategorie->getCategories();
		$data['zones'] = $this->modelzone->getZones();
		
		$data['accredAttente'] = array();
		$data['accredValide'] = array();
		//$data['demandes'] = $this->modelaccreditation->getDemandesParClient($idClient);
		
		// On récpère les accréditations de ce client.
		$accreditation = $this->modelaccreditation->getAccreditationsParClient( $idClient );
		$idCategories = array();
		foreach ($accreditation as $accred) {
			if($accred->etataccreditation == ACCREDITATION_A_VALIDE) {
				$data['accredAttente'][] = $accred;
			}
			else {
				$data['accredValide'][] = $accred;
			}
			$idAccred[] = $accred->idaccreditation;
		}
		
		$listeZonesAccred = array();
		if(count($idCategories)) {

		// On récupère et on traite la liste des zones utilisé par les accréditation de ce client.
		$zonesAccreds = $this->modelzone->getZoneParAccreditationMultiple( $idAccred );
		foreach ($zonesAccreds as $zones) {
			$listeZonesAccred[$zones->idaccreditation][] = $zones->idzone;
		}
		
		$data['listeZonesAccred'] = $listeZonesAccred;
		
		}
		
		$this->layout->view('utilisateur/accreditation/UAVoir', $data);
		
	}
	
	public function ajouter() {
		
		$this->load->model('modelclient');
		$data['clients'] = $this->modelclient->getClients();
		
		$this->layout->view('utilisateur/accreditation/UAAjout', $data);
		
	}
	
	public function ajouterClient() {
		
	}
	
	public function exeAjouterClient() {
		
	}
	
	public function ajouterAccreditation() {
		
	}
	
	public function exeAjouterAccreditation() {
		
	}

	public function exeModifierClient() {
		
		$id				= $this->input->post('id');
		$data['nom']	= $this->input->post('nom');
		$data['prenom'] = $this->input->post('prenom');
		$data['pays']	= $this->input->post('pays');
		$data['tel']	= $this->input->post('tel');
		$data['mail']	= $this->input->post('mail');
		
		$this->load->model('modelclient');
		$this->modelclient->modifier($id, $data);
		
		$this->load->helper('url');
		redirect('accreditation/voir/' . $id);
		
	}
	
	public function valider ($idAccreditation ) {
		
		$this->modelaccreditation->valideraccreditation( $idAccreditation );
				
		$data['titre']		= 'Validation';
		$data['message']	= 'L\'accréditation a été validée avec succes.';
		$this->layout->view('utilisateur/UMessage', $data);	 
		
	}

}