<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evenement extends CI_Model{
	  
	private $tabEvenement= 'evenement';
	
	/*@Fonction pour recuperer un evenement
	 * @ return un Evenement pour un id d'evenement
	 */
	public function getEvenementid($id){
			
		return $this->db->select('*')
							->from($this->tabEvenement)
				            ->where('idevenement',$id)
							->get()
							->result();
			
	}
	
	public function getEvenement(){
			
		return $this->db->select('*')
							->from($this->tabEvenement)
							->get()
							->result();
			
	}
	/*@Fonction pour recuperer l'id d'un evenement
	 *@return l'id Evenement 
	 */
	public function getIdEvenement($libelle){
		   return $this->db->select('libelleevenement')
				           ->form($this->tabEvenement)
						   ->where('libelleevenement',$libelle)
						   ->get()
				           ->result();
		
	} 
	
	/*@ Supprimer l'evenement
	 * 
	 */
	public function supprimerEvenement($id){
		
	$this->db->delete('evenement', $id);
			
	}
	
	/*@
	 * Ajouter un evenement
	 * @return
	 */
	public function ajouterEvenement($libelle,$datedebut,$datefin){
		    
		$data = array(
                           'libelleevenement' => $libelle ,
                           'datedebut' => $datedebut,
                            'datefin' =>$datefin
                       );

                       $this->db->insert('evenement', $data); 
		
	}
	/*@ Modifier un evenement
	 * @return
	 */
	public function modifierEvenement($libelle,$datedebut,$datefin){
		
		 
		 $data = array(
                              'libelleevenement' => $libelle,
                              'datedebut' => $datedebut,
			                  'datefin' => $datefin
                      );

                   
                    $this->db->update('evenement', $data); 
	}
	
}
?>
