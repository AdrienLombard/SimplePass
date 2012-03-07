<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelZone extends MY_Model {
	
	public function getZones() {
		return $this->db->select('*')
						->from(DB_ZONE)
						->get()
						->result();
			
	}
	
	
	public function getZonesAvecCode($idEvenement) {
		// ne pas changer le select !! conflit de champs entre les 2 tables !! Merci ^^ (Aymeric)
		return $this->db->select('z.idzone, z.codezone, z.libellezone, ze.idevenement, ze.idcategorie, ze.codezone, ze.idzone as enable')
						->from(DB_ZONE . ' z')
						->join(DB_PARAMETRES_EVENEMENTS . ' ze', 'z.idzone = ze.idzone AND ze.idevenement = ' . $idEvenement, 'left')
						->group_by('z.idzone')
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
	
	public function getZoneParCategorieEtEvenement( $idCategorie, $idEvenement ) {
		return $this->db->select('*')
						->from(DB_PARAMETRES_EVENEMENTS)
						->where('idcategorie', $idCategorie)
						->where('idevenement', $idEvenement)
						->get()
						->result();

	}
	
	public function getZoneParCategorie( $idCategorie ) {
		return $this->db->select('*')
						->from(DB_PARAMETRES_EVENEMENTS)
						->where('idcategorie', $idCategorie)
						->get()
						->result();

	}
	
	public function getZoneParIdMultipleParEvenement( $idCategorie, $idEvenement ) {
		$where = '';
		$k = true;
		foreach($idCategorie as $id) {
			if($k) {
				$where .= '( idcategorie = ' . $id;
				$k = false;
			}
			else {
				$where .= ' OR idcategorie = ' . $id;
			}
		}
		$where .= ' )';
		
		return $this->db->select('*')
						->from(DB_PARAMETRES_EVENEMENTS)
						->where($where)
						->where('idevenement', $idEvenement)
						->get()
						->result();

	}
	
	public function getZoneParIdMultiple( $idCategorie ) {
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
						->from(DB_PARAMETRES_EVENEMENTS)
						->where($where)
						->get()
						->result();

	}
	
	public function getZoneParAccreditation ( $idAccred ) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION_ZONES)
						->where('idaccreditation', $idAccred)
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
						->from(DB_ACCREDITATION_ZONES)
						->where($where)
						->get()
						->result();

	}
	
	
	public function getZoneParEvenement( $idEvenement ) {
		return $this->db->select('*')
					    ->from(DB_ZONE . ' z')
					    ->join(DB_PARAMETRES_EVENEMENTS . ' ze', 'z.idzone = ze.idzone', 'left')
						->where('ze.idevenement', $idEvenement)
						->group_by('z.idzone')
					    ->order_by('z.idzone', 'asc')
						->order_by('ze.idcategorie', 'asc')
					    ->get()
					    ->result();
	}
	
	public function ajouterZoneAccreditation( $idAccreditation, $idZone ) {
		return $this->db->insert(DB_ACCREDITATION_ZONES, array('idaccreditation' => $idAccreditation, 'idzone' => $idZone));
	}
	
	
	public function ajouter( $libelle ) {
		return $this->db->insert(DB_ZONE, array('libellezone' => $libelle) );
	}
	
	
	public function modifier( $idZone, $libelle ) {
		return $this->db->update(DB_ZONE, array( 'libellezone' => $libelle), 'idzone = '.$idZone);
	}
	
	
	public function supprimer( $idZone ) {
		return $this->db->delete(DB_ZONE, array('idzone' => $idZone) );
	}
	
	
	public function supprimerZoneParAccreditation ( $idAccred ) {
		return $this->db->delete(DB_ZONES_ACCREDITATION, array('idaccreditation' => $idAccred) );
	}
	
	public function supprimerZoneParZone ( $idzone ) {
		return $this->db->delete(DB_ZONES_ACCREDITATION, array('idzone' => $idzone) );
	}
	
	
	
	
	
	
	
}
?>
