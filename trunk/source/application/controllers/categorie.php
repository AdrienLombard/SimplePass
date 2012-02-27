<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorie extends Cafe {
	
	
	public function __construct() {
		
		parent::__construct();
		$this->load->model('modelCategorie');
		$this->load->library('form_validation');
		$this->layout->ajouter_js('utilisateur/scriptDate');
		
		
	}


	/*public function index() {
		
		$data['categories'] = $this->modelCategorie->getCategorieMere();
		$this->layout->view('utilisateur/categorie/UCIndex', $data);
		
	}*/

	
	public function liste() {
		
		$this->layout->ajouter_css('utilisateur/liste');
		
		$data['resultats']=$this->modelCategorie->getCategorieMere();
		
		$this->layout->view('utilisateur/categorie/UCIndex', $data);
	}
	
	public function voir($id) {
		
		$this->layout->ajouter_css('utilisateur/details');
		$data['nom']=$this->modelCategorie->getCategorieMereid($id);
		$data['resultats']=$this->modelCategorie->getSousCategorie($id);
		$data['id'] = $id;
		$this->layout->view('utilisateur/categorie/VoirCateg', $data);
	}
	
	public function ajouter($values='') {
		
		$data['info'] = $values;
		$data['categories']=$this->modelCategorie->getCategories();
		$this->layout->view('utilisateur/categorie/AjoutCateg', $data);
		
	}
	public function exeAjouter() {
	$config = array(
		array(
					'field'   => 'nom',
					'label'   => 'Nom', 
					'rules'   => 'required'
		));
		$this->form_validation->set_rules($config);
		
		$nom 		= $this->input->post('nom');
		
		echo $nom;
		
		if ($this->form_validation->run() == true ) {
	    	$data['titre']		= 'Ajout';
			$data['message']	= 'Votre catégorie a bien été ajoutée.';
			$data['redirect'] 	= 'categorie/liste';
			$idcategorie=$_POST['categories'];
			
			if( $idcategorie!=-1)
			$this->modelCategorie->ajouter( $nom,$idcategorie);
			else
				$this->modelCategorie->ajouter( $nom,NULL);
			$this->layout->view('utilisateur/UMessage', $data);	 
		}
		else {
			
			$values->nom		= $nom;
			
			$this->ajouter($values);
		}
		
	}
	
	public function supprimer($id) {
		
		/*$categories =$this->modelCategorie->getCategorieMereid($id);
	
		foreach ($categories as $categorie)
		{
			
			echo $categorie->surcategorie;
                if($categorie->surcategorie==null)
				{
					$this->modelCategorie->supprimerCategorie($id);
                    $this->modelCategorie->supprimersousCategorie($categorie->idcategorie);
				}

	     else 
			$this->modelCategorie->supprimerCategorie($id);
		 
		}*/
		
		$categories =$this->modelCategorie->getSousCategorieid($id);
		
		if(isset($categories) && !empty($categories)) {
		
			foreach ($categories as $categorie)
			{
				$this->modelCategorie->supprimerCategorie($categorie->idcategorie);
			}
		}
		
		$this->modelCategorie->supprimerCategorie($id);
		
		$data['titre']		= 'Suppression';
		$data['message']	= 'Votre catégorie a bien été supprimée.';
		$data['redirect'] 	= 'categorie/liste';
		$this->layout->view('utilisateur/UMessage', $data);
		
	}
	
	public function modifier($id,$re=false) {
		
		// Traitement
		$data['id'] = $id;
		if($re)
		{
			$data['nom'] 		= $re['nom'];
	   	
		}
		else {
			
			$reponse = $this->modelCategorie->getCategorieMereid($id);
			$data['nom']= $reponse[0]->libellecategorie;
			
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
			$resultat = $this->modelCategorie->modifier( $id,$nom );
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
	
	public function exeSupprimer()
	{
		
	}
}