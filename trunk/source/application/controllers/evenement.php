<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evenement extends Cafe {
	
	
	public function __construct() {
		parent::__construct();
		
		// Chargemnent des module de codeigniter.
		$this->load->library('form_validation');
		
		// Chargement des modeles.
		$this->load->model('modelevenement');
		$this->load->model('modelzone');
		$this->load->model('modelcategorie');
		
		// Chargement des fichier javascript.
		$this->layout->ajouter_js('utilisateur/scriptDate');
		$this->layout->ajouter_js('utilisateur/CRUDEvenement');
		
		// Mise en place des vérification sur l'authentification.
		$this->layout->ajouter_css('utilisateur/evenement');
		$this->securise(array('voir'));
	}


	public function index() {
		
		$this->liste();
		
	}
	
	/**
	 * MÃƒÂ©thode Listing du CRUD. 
	 */
	public function liste() {
		// Chargement du css.
		$this->layout->ajouter_css('utilisateur/liste');
		
		// RÃƒÂ©cupÃƒÂ©ration des donnÃƒÂ©es dans la base.
		$data['resultats']=$this->modelevenement->getEvenements();
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/evenement/UEIndex', $data);
	}
	
	/**
	 * MÃƒÂ©thode Read du CRUD.
	 * @param  $id : Id de la donnÃƒÂ©es ÃƒÂ  afficher.
	 */
	public function voir($id) {
		// Chargement du css.
		$this->layout->ajouter_css('utilisateur/details');
		
		// RÃƒÂ©cupÃƒÂ©ration des donnÃƒÂ©es sur la donnÃƒÂ©es corrÃƒÂ©spondant a l'id.
		$data['resultats']=$this->modelevenement->getEvenementParId($id);
		$data['id'] = $id;
		
		// Appelle de la vue.
		$this->layout->view('utilisateur/evenement/UEVoir', $data);
	}
	
	/**
	 * MÃƒÂ©thode Create du CRUD.
	 */
	public function ajouter($values='') {
		
		// Traitement.
		$data['resultats']=$this->modelevenement->getEvenements();
		$data['info'] = $values;
		
		// Appel de la vue.
		$this->layout->view('utilisateur/evenement/UEAjout', $data);
		
	}
	
	
	/**
	 * MÃƒÂ©thode de traitement pour l'ajout.
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
					'label'   => 'Date de dÃƒÂ©but', 
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
	 * Fonction pour mettre les zones et les catÃƒÂ©gories liÃƒÂ©es ÃƒÂ  notre ÃƒÂ©vÃƒÂ¨nement.
	 */
	public function donnes( $id, $idEvenement=0 ) {
		
		$data['listeZones'] = $this->modelzone->getZoneParEvenement( $idEvenement );
		
		if($idEvenement != 0) {
			// On traite la rÃƒÂ©cupÃƒÂ©ration des catÃƒÂ©gorie de l'ÃƒÂ©vÃƒÂ¨nement modÃƒÂ¨le.
			$categories = $this->modelcategorie->getCategorieDansEvenementToutBien($idEvenement);
			
			$data['listeCategorie'] = $categories;
			
			// on construit un tableau avec les id des catÃƒÂ©gorie pour rÃƒÂ©cupÃƒÂ©rer tous les couples zone/catÃƒÂ©gorie.
			$idCategorie = Array();
			foreach($categories as $cate) {
				$idcategorie[] = $cate['db']->idcategorie;
			}
			$categoriesZones = $this->modelzone->getZoneParIdMultiple ( $idcategorie );
			
			// On construit le tableau qui va organisÃƒÂ© les zones et les catÃƒÂ©gories.
			$listeCatgorieZone = Array();
			foreach($categoriesZones as $categorie) {
				$listeCatgorieZone[$categorie->idcategorie][$categorie->idzone] = 1;
			}
			
			$data['listeCatgorieZone'] 	= $listeCatgorieZone;
			
			// On traite la rÃƒÂ©cupÃƒÂ©ration des infos sur les zones.
			
			
			
		}
		
		$this->layout->view('utilisateur/evenement/UEAjout2', $data);
		
	}
	
	
	/**
	 * MÃƒÂ©thode Update du CRUD.
	 * @param $id : Id de la donnÃƒÂ©es ÃƒÂ  modifiÃƒÂ©e.
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
	 * MÃƒÂ©thode traitement de l'Update du CRUD.
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
			'label'   => 'Date de dÃƒÂ©but', 
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
			$data['message']	= 'Votre ÃƒÂ©vÃƒÂ¨nement ÃƒÂ  bien ÃƒÂ©tÃƒÂ© modifiÃƒÂ©.';
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
	 * @param $id : Id de la donnÃƒÂ©es a supprimer.
	 */
	public function supprimer($id) {
	   
		$this->modelevenement->supprimer($id);
		
		$data['titre']		= 'Suppression';
		$data['message']	= 'Votre ÃƒÂ©vÃƒÂ¨nement a bien ÃƒÂ©tÃƒÂ© supprimÃƒÂ©.';
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