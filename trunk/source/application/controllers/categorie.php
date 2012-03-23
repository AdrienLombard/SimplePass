<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorie extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->model('modelcategorie');
		$this->load->model('modelevenement');
		$this->load->model('modelaccreditation');
		
		$this->load->library('form_validation');
		
		$this->layout->ajouter_js('utilisateur/scriptDate');
		
		// Mise en place de la sécurisation.
		$this->securiseAll();
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
		
		$data['libellecategorie'] = ucfirst($this->input->post('nom'));
		$data['couleur'] = $this->input->post('couleur');
		$data['surcategorie'] = $this->input->post('surcategorie');
		
		if($data['surcategorie'] == -1)
			$data['surcategorie'] = null;
		
		if($this->form_validation->run() == true )
				$this->modelcategorie->ajouter($data);	

		$this->load->helper('url');
		redirect('categorie/liste');
		
	}
	
	
	public function exeModifier() {
		
		$config = array(
			'field'   => 'nom',
			'label'   => 'Nom', 
			'rules'   => 'alpha'
		);
		
		$this->form_validation->set_rules($config);
		
		$id = $this->input->post('id');
		$info['libellecategorie'] = $this->input->post('nom');
		$info['couleur'] = $this->input->post('couleur');
		$surcategorie = $this->input->post('surcategorie');
		
		if($surcategorie != -1  && !empty($surcategorie))
			$info['surcategorie'] = $surcategorie;
		
		if($this->form_validation->run()==true) {
			$resultat = $this->modelcategorie->modifier($id, $info);
			$this->modelcategorie->majCouleur();
		}
		
		$this->load->helper('url');
		redirect('categorie/liste');
		
	}
	
	
	public function exeSupprimer($id) {
		
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
		
		$this->load->helper('url');
		redirect('categorie/liste');
		
	}
	
	
}