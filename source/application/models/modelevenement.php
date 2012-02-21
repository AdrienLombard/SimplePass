<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelEvenement extends MY_Model {
	
	public function getEvenement(){
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
	
	/**
	 * Fonction pour recuperer l'id d'un evenement
	 * @return l'id Evenement 
	 */
	public function getIdEvenement($libelle){
		   return $this->db->select('libelleevenement')
				           ->form($this->tabEvenement)
						   ->where('libelleevenement',$libelle)
						   ->get()
				           ->result();
		
	} 
	
	/**
	 * Supprimer l'evenement
	 * 
	 */
	public function supprimer($id){
		
		//$this->db->delete('evenement', $id);
		$this->db->where('idevenement', $id);
        $this->db->delete($this->tabEvenement);
	
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $libelle
	 * @param unknown_type $datedebut
	 * @param unknown_type $datefin
	 */
	public function ajouter($libelle,$datedebut,$datefin){
		    
		$data = array(
                           'libelleevenement' => $libelle ,
                           'datedebut' => $datedebut,
                            'datefin' =>$datefin
                       );

                       $this->db->insert($this->tabEvenement, $data); 
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $libelle
	 * @param unknown_type $datedebut
	 * @param unknown_type $datefin
	 * @param unknown_type $id
	 */
	public function modifier($libelle,$datedebut,$datefin,$id){
		
		 
		 $data = array(
		 	'libelleevenement' => $libelle,
		 	'datedebut' => $datedebut,
		 	'datefin' => $datefin
		 );
		
		 $this->db->where('idevenement', $id);
		 $this->db->update($this->tabEvenement, $data);
			                  
	}
	
}
?>
