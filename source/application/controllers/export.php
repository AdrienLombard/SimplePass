<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export extends The {
	
	
	public function __construct() {
		
		parent::__construct();
		
		// Chargement des modeles.
		$this->load->model('modelzone');
		$this->load->model('modelclient');
		$this->load->model('modelcategorie');
		$this->load->model('modelaccreditation');
		$this->load->model('modelevenement');
		
		require_once('phpToXLS.php');
		
	}
	
	
	public function accreds($idEvenement, $indiv, $groupe, $valide, $demande) {
		
		//error_reporting(0);

		$evenement = $this->modelevenement->getEvenementParId($idEvenement);

		// en-tête
		$colums = array(
			'nom'		=> array('title' => 'Nom', 'type' => ExcelExport::STRING),
			'prenom'	=> array('title' => 'Prenom', 'type' => ExcelExport::STRING),
			'pays'		=> array('title' => 'Pays', 'type' => ExcelExport::STRING),
			'groupe'	=> array('title' => 'Groupe', 'type' => ExcelExport::STRING),
			'cat'		=> array('title' => 'Catégorie', 'type' => ExcelExport::STRING),
			'zones'		=> array('title' => 'Zones', 'type' => ExcelExport::STRING),
			'organisme' => array('title' => 'Organisme', 'type' => ExcelExport::STRING),
			'fonction'	=> array('title' => 'Fonction', 'type' => ExcelExport::STRING),
			'tel'		=> array('title' => 'Tel', 'type' => ExcelExport::STRING),

			'mail'		=> array('title' => 'Mail', 'type' => ExcelExport::STRING),		    
			'numeropresse'=>array('title'=>'Numero de presse','type' => ExcelExport::STRING),
			'adresse'	=> array('title' => 'Adresse', 'type' => ExcelExport::STRING)

		);
		

		// lignes : accreditations
		$content = array();
		$accreds = $this->modelaccreditation->getAccreditationsExport($idEvenement, $indiv, $groupe, $valide, $demande);	
		 
		foreach($accreds as $accred) {
			if(isset($accred->numeropresse) && !empty($accred->numeropresse) && $accred->numeropresse != '') {
				
				$zones = $this->modelzone->getZoneParAccreditation($accred->idaccreditation);
				$strZones = '';
				foreach($zones as $zone)
					$strZones .= $zone->codezone . ' -';
				
				$groupe = '';
				
				if(isset($accred->groupe) && !empty($accred->groupe) && $accred->groupe != '') {
					$groupe = $accred->groupe;
				}
				
				$nom = $accred->nom;
				
				if($groupe != '' && $accred->referent != null)
					$nom = '	- ' . $nom;
				
				if($groupe != '' && $accred->referent == null)
					$groupe .= ' (Référent)';
				
				$content[] = array(
					'nom'		=> $nom,
					'prenom'	=> $accred->prenom,
					'pays'		=> $accred->pays,
					'groupe'	=> $groupe,
					'cat'		=> $accred->libellecategorie,
					'zones'		=> $strZones,
					'organisme' => $accred->organisme,
					'fonction'	=> $accred->fonction,
					'numero presse' => $accred->numeropresse,
					'tel'		=> $accred->tel,
					'adresse'	=> $accred->adresse,
					'mail'		=> $accred->mail
				);
			}
			else {
			
				$zones = $this->modelzone->getZoneParAccreditation($accred->idaccreditation);
				$strZones = '';
				foreach($zones as $zone)
					$strZones .= $zone->codezone . ' -';
				
				$groupe = '';
				
				if(isset($accred->groupe) && !empty($accred->groupe) && $accred->groupe != '') {
					$groupe = $accred->groupe;
				}
				
				$nom = $accred->nom;
				
				if($groupe != '' && $accred->referent != null)
					$nom = '	- ' . $nom;
				
				if($groupe != '' && $accred->referent == null)
					$groupe .= ' (Référent)';
				
				$content[] = array(
					'nom'		=> $nom,
					'prenom'	=> $accred->prenom,
					'pays'		=> $accred->pays,
					'groupe'	=> $groupe,
					'cat'		=> $accred->libellecategorie,
					'zones'		=> $strZones,
					'organisme' => $accred->organisme,
					'fonction'	=> $accred->fonction,
					'numero presse' => ' - ',
					'tel'		=> $accred->tel,
					'adresse'	=> ' - ',
					'mail'		=> $accred->mail
				);
				
			}

		}
		
		// export
		$excel = new ExcelExport($colums, 'fr');
		$excel->addContent($content);
		$excel->download('Accreditations - ' . $evenement[0]->libelleevenement . '.xls');
		
	}
	
		public function accreds_valide($idEvenement) {
		
		error_reporting(0);

		// evenement
		$evenement = $this->modelevenement->getEvenementParId($idEvenement);

		// en-tête
		$colums = array(
			'nom'		=> array('title' => 'Nom', 'type' => ExcelExport::STRING),
			'prenom'	=> array('title' => 'Prenom', 'type' => ExcelExport::STRING),
			'pays'		=> array('title' => 'Pays', 'type' => ExcelExport::STRING),
			'cat'		=> array('title' => 'Catégorie', 'type' => ExcelExport::STRING),
			'zones'		=> array('title' => 'Zones', 'type' => ExcelExport::STRING),
			'organisme' => array('title' => 'Organisme', 'type' => ExcelExport::STRING),
			'fonction'	=> array('title' => 'Fonction', 'type' => ExcelExport::STRING),
			'tel'		=> array('title' => 'Tel', 'type' => ExcelExport::STRING),
			'mail'		=> array('title' => 'Mail', 'type' => ExcelExport::STRING),
		    'numeropresse'=>array('title'=>'Numero de presse','type' => ExcelExport::STRING)
		);

		// lignes : accreditations
		$content = array();
		$accreds = $this->modelaccreditation->getAccreditationsParEvenement($idEvenement);
		foreach($accreds as $accred) {
			
			$zones = $this->modelzone->getZoneParAccreditation($accred->idaccreditation);
			$strZones = '';
			foreach($zones as $zone)
				$strZones .= $zone->idzone . ' -';
			
			$content[] = array(
				'nom'		=> $accred->nom,
				'prenom'	=> $accred->prenom,
				'pays'		=> $accred->pays,
				'cat'		=> $accred->libellecategorie,
				'zones'		=> $strZones,
				'organisme' => $accred->organisme,
				'fonction'	=> $accred->fonction,
				'tel'		=> $accred->tel,
				'mail'		=> $accred->mail,
				'numeropresse'=>$accred->numeropresse
			);
			
		}
		
	}
	
	public function evenement($idEvenement) {
		
		// evenement
		$evenement = $this->modelevenement->getEvenementParId($idEvenement);
		
		// Récupération de la liste des zones.
		$zones = $this->modelzone->getZonesAvecCode($idEvenement);
		
		// en-tête
		$columns = array();
		$columns['cat'] = array('title' => ' ', 'type' => ExcelExport::STRING);
		foreach($zones as $zone)
			$columns[$zone->idzone] = array('title' => $zone->libellezone, 'type' => ExcelExport::STRING);		
		
		// Récupérer les catégories
		$categories = $this->modelcategorie->getCategorieDansEvenementToutBien($idEvenement);
		$ids = Array();
		foreach($categories as $cate)
			$ids[] = $cate['db']->idcategorie;
		$catzone = $this->modelzone->getZoneParIdMultipleParEvenement($ids, $idEvenement);
		
		// construction du tableau d'association
		$assoc = Array();
		foreach($catzone as $cz) {
			$assoc[$cz->idcategorie][$cz->idzone] = 1;
		}
		
		// content
		$content = array();
		
		$input = array();
		
		$input['cat'] = '';
		
		
		foreach($zones as $zone) {
			$input[$zone->idzone] = $zone->codezone;
		}
		
		$content[] = $input;
		
		foreach($categories as $cat) {
			
			$input = array();
			
			// affichage nom de la cat
			$decal = '';
			for($i = 0; $i < $cat['depth']; $i++)
				$decal .= '-  ';
			$input['cat'] = $decal . $cat['db']->libellecategorie;

			// affichage en fonction de l'association
			foreach($zones as $zone)
				$input[$zone->idzone] = isset($assoc[$cat['db']->idcategorie][$zone->idzone])? 'x' : ' ';
			
			// insertion de la ligne
			$content[] = $input;
		}

		/*
		$data['listeCatgorieZone'] = Array();
		if($categories) {
			// on construit un tableau avec les id des catégorie pour récupérer tous les couples zone/catégorie.
			$idCategorie = Array();
			foreach($categories as $cate) {
				$idcategorie[] = $cate['db']->idcategorie;
			}
			$categoriesZones = $this->modelzone->getZoneParIdMultipleParEvenement ( $idcategorie, $idEvenement );

			// On construit le tableau qui va organiser les zones et les catégories.
			$listeCatgorieZone = Array();
			foreach($categoriesZones as $categorie) {
				$listeCatgorieZone[$categorie->idcategorie][$categorie->idzone] = 1;
			}

			$data['listeCatgorieZone'] 	= $listeCatgorieZone;
		}
		*/
		
		// export
		$excel = new ExcelExport($columns, 'fr', true);
		$excel->addContent($content);
		$excel->download('Synthèse - ' . $evenement[0]->libelleevenement . '.xls');
		
	}
	
	
}