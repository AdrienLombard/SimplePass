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
	public function getZoneParId( $idZone ) {
	   return $this->db->select('*')
					   ->from(DB_ZONE)
					   ->where('idzone', $idZone)
					   ->get()
					   ->result();
		
	}
	
	public function getZoneParIdMultiple ( $idCategorie ) {
		$where = '';
		$k = true;
		foreach($idCategorie as $id) {
			if($k) {
				$where .= 'idcategorie = ' . $id;
				$k = false;
			}
			else {
				$where .= ' OR idcategorie = ' . $id;
			}
		}
		
		return $this->db->select('*')
						->from(DB_CATEGORIE_ZONE)
						->where($where)
						->get()
						->result();

	}
	
	public function getZoneParAccreditationMultiple ( $idAccred ) {
		$where = '';
		$k = true;
		foreach($idAccred as $id) {
			if($k) {
				$where .= 'idaccreditation = ' . $id;
				$k = false;
			}
			else {
				$where .= ' OR idaccreditation = ' . $id;
			}
		}
		
		return $this->db->select('*')
						->from(DB_PERMET)
						->where($where)
						->get()
						->result();

	}
	
	
	public function getZoneParEvenement( $idEvenement ) {
		return $this->db->select('*')
					   ->from(DB_ZONE . ' z')
					   ->join(DB_ZONES_EVENEMENT . ' ze', 'z.idzone = ze.idzone', 'left')
					   ->where('idevenement', $idEvenement)
					   ->get()
					   ->result();
	}
	
	
	public function ajouter($libelle ) {
		return $this->db->insert(DB_ZONE, array('libellezone' => $libelle) );
	}
	
	
	public function modifier( $idZone, $libelle ) {
		return $this->db->update(DB_ZONE, array( 'libellezone' => $libelle), 'idzone = '.$idZone);
	}
	
	
	public function supprimer( $idZone ) {
		return $this->db->delete(DB_ZONE, array('idzone' => $idZone) );
	}
	
}
?>