<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zone extends Cafe {
	
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model('modelzone');
		$this->load->model('modelevenement');
		
		$this->load->library('form_validation');
		
		$this->layout->ajouter_js('utilisateur/CRUDZone');
		
		$this->layout->ajouter_css('utilisateur/zone');
		
		// Mise en place de la sécurisation.
		$this->securiseAll();
	}


	public function index() {
		
		$this->liste();
		
	}
	
	/**
	 * Méthode Listing du CRUD. 
	 */
	public function liste() {
		// Chargement du css.
		$this->layout->ajouter_css('utilisateur/liste');
		
		// Récupération des données dans la base.
		$data['resultats']=$this->modelzone->getZones();
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/zone/UZIndex', $data);
	}
	
	
	/**
	 * Méthode Read du CRUD.
	 * @param  $id : Id de la données à afficher.
	 */
	public function voir($id) {
		// Chargement du css.
		$this->layout->ajouter_css('utilisateur/details');
		
		// Récupération des données sur la données corréspondant a l'id.
		$data['resultats']=$this->modelzone->getZoneParId( $id );;
		$data['id'] = $id;
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/zone/UZVoir', $data);
	}
	
	/**
	 * Méthode Create du CRUD.
	 */
	public function ajouter($values='') {
		
		// Traitement.
		$data['info'] = $values;
		
		// Appel de la vue.
		$this->layout->view('utilisateur/zone/UZajout', $data);
		
	}
	
	/**
	 * Méthode de traitement pour l'ajout.
	 */
	public function exeAjouter() {
		$config = array(
			array(
				'field'   => 'libelle',
				'label'   => 'Nom', 
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		$libelle = $this->input->post('libelle');
		
		if ($this->form_validation->run() == true) {
			$this->modelzone->ajouter( $libelle );		 
		}
		
		redirect('zone/liste');
		
	}

	
	/**
	 * Méthode Update du CRUD.
	 * @param $id : Id de la données à modifiée.
	 */
	public function modifier($id, $re=false) {
		
		// Traitement
		$data['id'] = $id;
		
		if($re) {
			$data['libelle'] = $re['libelle'];
			$data['info'] = $re['info'];
		}
		else {
			$reponse = $this->modelzone->getZoneParId( $id );
			$data['libelle'] = ($reponse) ? $reponse[0]->libellezone : null;
		}
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/zone/UZModification',$data);
	}
	
	/**
	 * Méthode traitement de l'Update du CRUD.
	 */
	public function exeModifier( $id ) {
		$config = array(
			array(
				'field'   => 'libelle',
				'label'   => 'Nom', 
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		$libelle = $this->input->post('libelle');
		
		if ($this->form_validation->run() == true) {
			$resultat = $this->modelzone->modifier( $id, $libelle );
		}
		
		redirect('zone/liste');
	}
	
	
	/**
	 * Methode Delete du CRUD.
	 * @param $id : Id de la données a supprimer.
	 */
	public function exeSupprimer( $id ) {
		
		// On supprime les paramètres d'évènement qui utilisent cette zone.
		$this->modelevenement->supprimerParametreParZone( $id );
		
		// on supprime les liens entre les accréditations et cette zone.
		$this->modelzone->supprimerZoneParZone( $id );
		
		// On supprime la zone.
		$this->modelzone->supprimer( $id );
		
		redirect('zone/liste');
	}
	

}