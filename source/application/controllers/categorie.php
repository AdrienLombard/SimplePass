<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorie extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('modelcategorie');
		$this->load->model('modelevenement');
		$this->load->model('modelaccreditation');
		
		$this->load->library('form_validation');
		
		$this->layout->ajouter_js('utilisateur/scriptDate');
	}


	public function index() {
		
		$this->liste();
		
	}
	
	public function liste() {
		
		$this->layout->ajouter_css('utilisateur/categorie');
		$this->layout->ajouter_js('utilisateur/CRUDCategorie');
		
		$data['resultats']=$this->modelcategorie->getCategorieDansEvenementToutBien();
		
		$this->layout->view('utilisateur/categorie/UCIndex', $data);
	}
	
	public function voir($id) {
		
		$this->layout->ajouter_css('utilisateur/details');
		
		$data['nom']		= $this->modelcategorie->getCategorieMereid($id);
		$data['resultats']	= $this->modelcategorie->getSousCategorie($id);
		$data['id']			= $id;
		
		$this->layout->view('utilisateur/categorie/VoirCateg', $data);
	}
	
	public function ajouter($values='') {
		
		$data['info'] = $values;
		
		$data['categories'] = $this->modelcategorie->getCategorieDansEvenementToutBien();
		
		$this->layout->view('utilisateur/categorie/UCAjout', $data);
	}



	public function exeAjouter() {
		$config = array(
			array(
				'field'   => 'nom',
				'label'   => 'Nom', 
				'rules'   => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		$nom = $this->input->post('nom');
		
		echo $nom;
		
		if ($this->form_validation->run() == true ) {
	    	$data['titre']		= 'Ajout';
			$data['message']	= 'Votre catégorie a bien été ajoutée.';
			$data['redirect'] 	= 'categorie/liste';
			$idcategorie=$_POST['categories'];
			
			if( $idcategorie!=-1)
			$this->modelcategorie->ajouter( $nom,$idcategorie);
			else
				$this->modelcategorie->ajouter( $nom,NULL);
			$this->layout->view('utilisateur/UMessage', $data);	 
		}
		else {
			
			$values->nom		= $nom;
			
			$this->ajouter($values);
		}
		
	}
	
	
	public function modifier($id,$re=false) {
		
		// Traitement
		$data['id'] = $id;
		if($re)
		{
			$data['nom'] = $re['nom'];
	   	
		}
		else {
			
			$reponse = $this->modelcategorie->getCategorieMereid($id);
			$data['nom'] = ($reponse) ? $reponse[0]->libellecategorie : null;
			
		}
		$this->layout->view('utilisateur/categorie/UCModifier',$data);
	}
	
	
	public function exeModifier($id) {
		$config = array(
			'field'   => 'nom',
			'label'   => 'Nom', 
			'rules'   => 'alpha'
		);
		
		$this->form_validation->set_rules($config);
		
		$nom 		= $this->input->post('nom');
		echo $nom;
		if ($this->form_validation->run()==true)
	{ 
			$resultat = $this->modelcategorie->modifier( $id,$nom );
			$data['titre']		= 'Modification';
			$data['message']	= 'Votre catégorie à bien été modifié.';
			$data['redirect'] 	= 'categorie/liste';
			$this->layout->view('utilisateur/UMessage', $data);
		

	}
		else {
			
			$donnees['nom'] = $nom;
			$this->modifier($id, $donnees);
		}
		
	}
	
	
	public function supprimer($id) {
		
		// on supprime les accréditations liées à cette catégorie qui sont déjà passé.
		$this->modelaccreditation->supprimerParcategorie( $id );
		
		// On supprime les entrées dans la tables des paramètres des évènement.
		$this->modelevenement->supprimerparametreParCategorie( $id );
		
		// on supprimes les catégorie et ses sous-catégorie.
		$categories =$this->modelcategorie->getSousCategorieid($id);
		
		if(isset($categories) && !empty($categories)) {
		
			foreach ($categories as $categorie)
			{
				$this->modelcategorie->supprimerCategorie($categorie->idcategorie);
			}
		}
		
		$this->modelcategorie->supprimerCategorie($id);
		
		$data['titre']		= 'Suppression';
		$data['message']	= 'Votre catégorie a bien été supprimée.';
		$data['redirect'] 	= 'categorie/liste';
		$this->layout->view('utilisateur/UMessage', $data);
		
	}
	
	
}