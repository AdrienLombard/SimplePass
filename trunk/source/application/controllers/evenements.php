<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evenements extends Cafe {
	
	
    public function __construct() {
            parent::__construct();
			$this->load->model('Evenement');
    }


    public function index() {
        // TODO
		$this->layout->ajouter_css('utilisateur/liste');
        $this->layout->view('utilisateur/evenement/UEIndex');
		
    }
    /*@la fonction qui permet de consulter l'evenement
	 * 
	 */
    public function voir() {
        // TODO
		$this->layout->ajouter_css('utilisateur/details');
		$this->layout->view('utilisateur/evenement/UEVoir');
		
    }
    /*@ la fonction qui permet l'ajout d'un evenement
	 * 
	 */
    public function ajout() {
	
        $this->layout->view('utilisateur/evenement/UEAjout');
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
	
    public function modification() {
        // TODO
		$this->layout->view('utilisateur/evenement/UEModification');
		$nom=$this->input->post('nom');
		$datedebut=$this->input->post('datedebut');
		$datefin=$this->input->post('datefin');
		
		$resultat = $this->Evenement->modifierEvenement($nom,$datedebut,$datefin);
		$data['modifier']='Evenement modifier';
		$this->load->view('utilisateur/evenement/UEModification',$data);
    }
    /*@la fonction qui permet de supprimer un evenement
	 * 
	 */
	
    public function suppression() {
        // TODO
		$resultat = $this->Evenement->supprimerEvenenement($id);
    }
}