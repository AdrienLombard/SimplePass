<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelZone extends MY_Model {
	  
	public function getZones() {
		return $this->db->select('*')
						->from(DB_ZONE)
						->get()
						->result();
			
	}
	/**
	 * Fonction pour recuperer l'id d'un evenement
	 * @return l'id Evenement 
	 */
	public function getZoneById( $idZone ) {
	   return $this->db->select('*')
					   ->from(DB_ZONE)
					   ->where('idzone', $idZone)
					   ->get()
					   ->result();
		
	}
	
	public function ajouter($libelle, $code) {
		return $this->db->insert(DB_ZONE, array('libellezone' => $libelle, 'codezone' => $code) );
	}
	
	
	public function modifier( $idZone, $libelle) {
		return $this->db->update(DB_ZONE, array( 'libellezone' => $libelle, 'codezone' => $code), 'idzone = '.$idZone);
	}
	
	
	public function supprimer( $idZone ) {
		return $this->db->delete(DB_ZONE, array('idzone' => $idZone) );
	}
	
}
?>
