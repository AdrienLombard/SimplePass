<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evenements extends Cafe {
	
	
	public function __construct() {
		parent::__construct();
		$this->load->model('modelEvenement');
		
		$this->load->library('form_validation');
		
		$this->layout->ajouter_js('utilisateur/scriptDate');
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
		$data['resultats']=$this->modelEvenement->getEvenement();
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/evenement/UEIndex', $data);
	}
	
	
	/**
	 * Méthode Read du CRUD.
	 * @param  $id : Id de la données à afficher.
	 */
	public function voir($id) {
		// Chargement du css.
		$this->layout->ajouter_css('utilisateur/details');
		
		// Récupération des données sur la données corréspondant a l'id.
		$data['resultats']=$this->modelEvenement->getEvenementid($id);
		$data['id'] = $id;
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/evenement/UEVoir', $data);
	}
	
	/**
	 * Méthode Create du CRUD.
	 */
	public function ajouter() {
		
		// Traitement
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/evenement/UEAjout');
		
	}
	
	/**
	 * Méthode de traitement pour l'ajout.
	 */
	public function exeAjouter() {
		$config = array(
		array(
					'field'   => 'nom',
					'label'   => 'Nom', 
					'rules'   => 'required'
		),
		array(
					'field'   => 'datedebut',
					'label'   => 'Date de début', 
					'rules'   => ''
		),
		array(
					'field'   => 'datefin',
					'label'   => 'Date de fin', 
					'rules'   => ''
		)
		);
		$this->form_validation->set_rules($config);
		
		
		$nom 		= $this->input->post('nom');
		$datedebut 	= $this->input->post('datedebut');
		$datefin 	= $this->input->post('datefin');
		
		 $datedebutTstmp= date_to_timestamp($datedebut);
		 $datefinTstmp  = date_to_timestamp($datefin);
		
		if ($this->form_validation->run() == true && $datedebutTstmp < $datefinTstmp) {
			//$result = $this->Evenement->ajouterEvenement($nom, $datedebut, $datefin);
			
           //$newId = $this->Evenement->lastId();
			
			
			$data['titre']		= 'Ajout';
			$data['message']	= 'Votre évènement à bien été ajouté.';
			$data['redirect'] 	= 'evenements/liste';
			$this->modelEvenement->ajouterEvenement( $nom,$datedebut,$datefin);
			$this->layout->view('utilisateur/evenement/uMessage', $data);	 
		}
		else {
			
			$this->ajouter();
		}
	}

	
	/**
	 * Méthode Update du CRUD.
	 * @param $id : Id de la données à modifiée.
	 */
	public function modifier($id, $re=false) {
		
		// Traitement
		$data['id'] = $id;
		
		if($re) {
			$data['nom'] 		= $re['nom'];
			$data['datedebut'] 	= date_to_timestamp($re['datedebut']);
			$data['datefin'] 	= date_to_timestamp($re['datefin']);
		}
		else {
			$reponse = $this->modelEvenement->getEvenementid($id);
			$data['nom'] 		= $reponse[0]->libelleevenement;
			$data['datedebut'] 	= $reponse[0]->datedebut;
			$data['datefin'] 	= $reponse[0]->datefin;
		}
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/evenement/UEModification',$data);
	}
	
	/**
	 * Méthode traitement de l'Update du CRUD.
	 */
	public function exeModifier($id) {
		$data['id'] = $id;
		
		$config = array(
		array(
			'field'   => 'nom',
			'label'   => 'Nom', 
			'rules'   => 'required'
		),
		array(
			'field'   => 'datedebut',
			'label'   => 'Date de début', 
			'rules'   => ''
		),
		array(
			'field'   => 'datefin',
			'label'   => 'Date de fin', 
			'rules'   => ''
		)
		);
		$this->form_validation->set_rules($config);
		
		$nom 		= $this->input->post('nom');
		$datedebut 	= $this->input->post('datedebut');
		$datefin 	= $this->input->post('datefin');
		$datedebutTstmp= date_to_timestamp($datedebut);
		$datefinTstmp  = date_to_timestamp($datefin);
		if ($this->form_validation->run() == true && $datedebutTstmp < $datefinTstmp ) {
			
			$resultat = $this->modelEvenement->modifierEvenement($nom, $datedebut, $datefin, $id);
			
			$data['titre']		= 'Modification';
			$data['message']	= 'Votre évènement à bien été modifié.';
			$data['redirect'] 	= 'evenement/liste';
			$this->layout->view('utilisateur/evenement/uMessage', $data);
			
		}
		else {
			$donnees['nom'] 		= $nom;
			$donnees['datedebut'] 	= $datedebut;
			$donnees['datefin'] 	= $datefin;
			$this->modifier($id, $donnees);
		}
	}
	
	
	/**
	 * Methode Delete du CRUD.
	 * @param $id : Id de la données a supprimer.
	 */
	public function supprimer($id) {
	   
		$this->modelEvenement->supprimerEvenement($id);
		$this->layout->view('utilisateur/evenement/UEsupprimer');
		
		
	}
	
	
	 public function valide() {
		// TODO
		$this->layout->view('utilisateur/evenement/UEVoir');
		
	}
	
	public function Avalide() {
		// TODO
		$this->layout->view('utilisateur/evenement/UEVoir');
		
	}

}