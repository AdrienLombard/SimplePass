<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evenement extends Cafe {
	
	
	public function __construct() {
		parent::__construct();
		
		// Chargement des modeles.
		$this->load->model('modelevenement');
		$this->load->model('modelzone');
		$this->load->model('modelcategorie');
		
		
		$this->load->library('form_validation');
		$this->layout->ajouter_js('utilisateur/scriptDate');
		
		$this->securise(array('voir'));
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
		$data['resultats']=$this->modelevenement->getEvenement();
		
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
		$data['resultats']=$this->modelevenement->getEvenementParId($id);
		$data['id'] = $id;
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/evenement/UEVoir', $data);
	}
	
	/**
	 * Méthode Create du CRUD.
	 */
	public function ajouter($values='') {
		
		// Traitement.
		$data['resultats']=$this->modelevenement->getEvenement();
		$data['info'] = $values;
		
		// Appel de la vue.
		$this->layout->view('utilisateur/evenement/UEAjout', $data);
		
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
			
			$idEvenement = $this->input->post('choix');
			
			// $this->modelevenement->ajouter( $nom, $datedebutTstmp, $datefinTstmp);
			
			$id = $this->modelevenement->lastId();
			
			$this->donnes( $id, $idEvenement );
		}
		else {
			
			$values->nom		= $nom;
			$values->dateDebut	= $datedebut;
			$values->dateFin	= $datefin;
			
			
			$this->ajouter($values);
		}
	}
	

	/**
	 * Fonction pour mettre les zones et les catégories liées à notre évènement.
	 */
	public function donnes( $id, $idEvenement=0 ) {
		
		$data['listeZones'] = $this->modelzone->getZoneParEvenement( $idEvenement );
		
		if($idEvenement != 0) {
			// On traite la récupération des catégorie de l'évènement modèle.
			$categories = $this->modelcategorie->getCategorieDansEvenement( $idEvenement );
			$data['listeCategorie']		= $categories;
			
			// on construit un tableau avec les id des catégorie pour récupérer tous les couples zone/catégorie.
			$idCategorie = Array();
			foreach($categories as $cate) {
				$idcategorie[] = $cate->idcategorie;
			}
			$categoriesZones = $this->modelzone->getZoneParIdMultiple ( $idcategorie );
			
			// On construit le tableau qui va organisé les zones et les catégories.
			$listeCatgorieZone = Array();
			foreach($categoriesZones as $categorie) {
				$listeCatgorieZone[$categorie->idcategorie][$categorie->idzone] = 1;
			}
			
			$data['listeCatgorieZone'] 	= $listeCatgorieZone;
			
			// On traite la récupération des infos sur les zones.
			
			
			
		}
		
		$this->layout->view('utilisateur/evenement/UEAjout2', $data);
		
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
			$reponse = $this->modelevenement->getEvenementParId($id);
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
			
			$resultat = $this->modelevenement->modifier($nom, $datedebutTstmp, $datefinTstmp, $id);
			
			$data['titre']		= 'Modification';
			$data['message']	= 'Votre évènement à bien été modifié.';
			$data['redirect'] 	= 'evenement/liste';
			$this->layout->view('utilisateur/UMessage', $data);
			
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
	   
		$this->modelevenement->supprimer($id);
		
		$data['titre']		= 'Suppression';
		$data['message']	= 'Votre évènement a bien été supprimé.';
		$data['redirect'] 	= 'evenement/liste';
		$this->layout->view('utilisateur/UMessage', $data);

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