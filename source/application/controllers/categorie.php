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
	
	
	public function exeAjouter() {
		
		$config = array(
			array(
				'field'   => 'nom',
				'label'   => 'Nom', 
				'rules'   => 'required'
			)
		);
		
		$this->form_validation->set_rules($config);
		
		$nom = ucfirst($this->input->post('nom'));
		$id = $this->input->post('categorie');
		$couleur = $this->input->post('couleur');
		
		if ($this->form_validation->run() == true ) {
			
			if($idcategorie != -1)
				$this->modelcategorie->ajouter( $nom, $id);
			else
				$this->modelcategorie->ajouter( $nom, NULL);	
			
		}
		
		$this->load->helper('url');
		redirect('categorie/liste');
		
	}
	
	
	public function exeModifier($id) {
		
		$config = array(
			'field'   => 'nom',
			'label'   => 'Nom', 
			'rules'   => 'alpha'
		);
		
		$this->form_validation->set_rules($config);
		
		$nom = $this->input->post('nom');
		$couleur = $this->input->post('couleur');
		$id = $this->input->post('id');
		$surCategorie = $this->input->post('surcategorie');

		if ($this->form_validation->run()==true)
			$resultat = $this->modelcategorie->modifier( $id, $nom );
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