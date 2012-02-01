<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evenements extends Cafe {
	
	
    public function __construct() {
            parent::__construct();
			$this->load->model('Evenement');
    }


    public function index() {
        // TODO
		$this->layout->ajouter_css('utilisateur/liste');
		
		$data['resultats']=$this->Evenement->getEvenement();		
		
        $this->layout->view('utilisateur/evenement/UEIndex', $data);
		
    }
    /*@la fonction qui permet de consulter l'evenement
	 * 
	 */
    public function voir($id) {
        // TODO
		$this->layout->ajouter_css('utilisateur/details');
		  
		$data['resultats']=$this->Evenement->getEvenementid($id);
		$data['id'] = $id;
		
		$this->layout->view('utilisateur/evenement/UEVoir', $data);
    }
    /*@ la fonction qui permet l'ajout d'un evenement
	 * 
	 */
    public function ajout() {
	
        $this->layout->view('utilisateur/evenement/UEAjout');
		// on recupere les donnees entrees 
		$nom=$this->input->post('nom');
		$datedebut=$this->input->post('datedebut');
		$datefin=$this->input->post('datefin');
		
		 if(isset($datedebut) && !empty($datedebut)  
				                 && isset($datefin) && !empty($datefin)) {
				
				$result=$this->Evenement->ajouterEvenement($nom,$datedebut,$datefin);
				
		        $data['ajoute']='Evenement ajoute';
		
			}
		
		
    }
	/*@la fonction qui permet de modifier un evenement
	 * 
	 */
	
    public function modification($id) {
		
		$valid = $this->input->post('valider');
		if($valid) {
			// on recupere les donnees entrees 
			$nom=$this->input->post('nom');
			$datedebut=$this->input->post('datedebut');
			$datefin=$this->input->post('datefin');

			$resultat = $this->Evenement->modifierEvenement($nom,$datedebut,$datefin,$id);
			
			
		}
		
		
		$data['resultats']=$this->Evenement->getEvenementid($id);
		
		//display_tab($data['resultats']);
		
		$this->layout->view('utilisateur/evenement/UEModification',$data);
    }
	
	
	
    /*@la fonction qui permet de supprimer un evenement
	 * 
	 */
	
    public function supprimer($id) {
        // TODO
	
		$data['resultats']=$this->Evenement->getEvenementid($id);
		
		$this->layout->view('utilisateur/evenement/UEsupprimer');
		
		
		
    }
	/*@afficher tous la liste des evennement
	 * 
	 */
	 public function tous() {
        // TODO
		
		$this->layout->view('utilisateur/evenement/UEVoir');
		
    }
	/*@ la liste des evennements valide
	 * 
	 */
	
	 public function valide() {
        // TODO
		
		$this->layout->view('utilisateur/evenement/UEVoir');
		
    }
	
	/*@ la liste des  evenement non valide
	 * 
	 */
	
	public function Avalide() {
        // TODO
		
		$this->layout->view('utilisateur/evenement/UEVoir');
		
    }
}