<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelEvenement extends MY_Model {
	
	public function getEvenements(){
		
		return $this->db->get(DB_EVENEMENT)->result();
	
	}
	
	/**
	 * Fonction pour recuperer un evenement
	 * @return un Evenement pour un id d'evenement
	 */
	public function getEvenementParId($id){
		return $this->db->select('*')
						->from(DB_EVENEMENT)
						->where('idevenement',$id)
						->get()
						->result();
			
	}

	
	public function getCategoriesZonesPourEvenement( $idEvenment ) {
		return $this->db->select('*')
						->from(DB_CATEGORIE_EVENEMENT . ' ce')
						->join(DB_CATEGORIE . ' c', 'c.idcategorie = ce.idcategorie')
						->join(DB_CATEGORIE_ZONE . ' cz', 'cz.idcategorie = c.idcategorie')
						->where('ce.idevenement', $idEvenment)
						->get()
						->result();
	}
	
	
	public function getEvenementEnCours() {
		$current_date = time();
		
		 return $this->db->select('*')
				          ->from(DB_EVENEMENT)
						  ->where('datefin >', $current_date)
						  ->get()
				          ->result();
		
	}
	
	
	public function ajouter($libelle,$datedebut,$datefin){
		
		$data = array(
		 	'libelleevenement'	=> $libelle,
		 	'datedebut'			=> $datedebut,
		 	'datefin'			=> $datefin
		 );
		
		$this->db->insert(DB_EVENEMENT, $data);
	}
	
	
	/**
	 * Fonction pour ajouter les paramètre d'un évènment : trio evenement / zone / categorie.
	 * @param Array $parametre : le tableau associatif des ligne a insérer.
	 */
	public function ajouterDonnees( $parametre ) {
		return $this->db->insert_batch(DB_PARAMETRE_EVENEMENT, $parametre );
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $libelle
	 * @param unknown_type $datedebut
	 * @param unknown_type $datefin
	 * @param unknown_type $id
	 */
	public function modifier($libelle, $datedebut, $datefin, $id){

		$data = array(
		 	'libelleevenement' => $libelle,
		 	'datedebut' => $datedebut,
		 	'datefin' => $datefin
		 );
		
		 $this->db->where('idevenement', $id);
		 $this->db->update(DB_EVENEMENT, $data);
		
	}
	
	
	/**
	 * Supprimer l'evenement
	 * 
	 */
	public function supprimer($id){
		
		 //$this->db->delete('evenement', $id);
		$this->db->where('idevenement', $id);
        $this->db->delete(DB_EVENEMENT);
			                  
	}
	
}
?>
