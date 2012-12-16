<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelClient extends MY_Model {
	
/*
	 * CREATE
	 */
	
	public function ajouter($values) {
		$this->db->insert(DB_PRESSE, $values);
		return $this->lastId();
	}
	
	/*
	 * READ
	 */

	public function getClients_presse() {
		return $this->db->get(DB_PRESSE)->result();
	}
	
	
	public function getClient_Presse_ParId($id) {
		$result = $this->db->select('*')
							->from(DB_PRESSE . ' c')
							->where('c.idclientpresse', $id)
							->get()
							->result();
		return $result[0];
	}
	
	public function getClients_Presse_AvecAccred() {
		return $this->db->select('*')
							->from(DB_PRESSE . ' c')
							->join(DB_ACCREDITATION . ' a', 'a.idclientpresse = c.idclientpresse')
							->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
							->get()
							->result();
	}
	
	public function getReferents_Presse() {
		
		return $this->db->select('*')
							->from(DB_PRESSE )
							->where('referent',NULL)
							->get()
							->result();
		
	}
	
	/*
	 * UPDATE
	 */
	
	public function modifier($id, $values) {
		$this->db->where('idclientpresse', $id);
		$this->db->update(DB_PRESSE, $values);
	}
	
	
	/*
	 * DELETE
	 */
	
	public function supprimer($id) {
		$this->db->delete(DB_PRESSE, array('idclientpresse' => $id));
	}
	
}
