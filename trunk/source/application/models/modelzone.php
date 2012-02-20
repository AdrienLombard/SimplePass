<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelzone extends CI_Model{
	  
	private $tabZone= 'courchevel_zone';
	
	
	public function getZones() {
		return $this->db->select('*')
						->from($this->tabZone)
						->get()
						->result();
			
	}
	/**
	 * Fonction pour recuperer l'id d'un evenement
	 * @return l'id Evenement 
	 */
	public function getZoneById( $idZone ) {
	   return $this->db->select('*')
					   ->from($this->tabZone)
					   ->where('idzone', $idZone)
					   ->get()
					   ->result();
		
	}
	
	public function ajouterZone( $libelle, $code ) {
		return $this->db->insert($this->tabZone, array('libellezone' => $libelle, 'codezone' => $code) );
	}
	
	
	public function modifierZone( $idZone, $libelle ) {
		return $this->db->update($this->tabZone, array( 'libellezone' => $libelle, 'codezone' => $code), 'idzone = '.$idZone);
	}
	
	
	public function supprimerZone( $idZone ) {
		return $this->db->delete($this->tabZone, array('idzone' => $idZone) );
	}
	
	public function lastId() {
		return $this->db->insert_id();
	}
	
}
?>
