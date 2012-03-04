<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelClient extends MY_Model {
	
	
	/*
	 * READ
	 */

	public function getClients() {
		return $this->db->get(DB_CLIENT)->result();
	}
	
	public function getClientParId($id) {
		$result = $this->db->select('*')
							->from(DB_CLIENT . ' c')
							->where('c.idclient', $id)
							->get()
							->result();
		return $result[0];
	}
	
	public function getClientsAvecAccred() {
		return $this->db->select('*')
							->from(DB_CLIENT . ' c')
							->join(DB_ACCREDITATION . ' a', 'a.idclient = c.idclient')
							->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
							->get()
							->result();
	}
	
	
	/*
	 * CREATE
	 */
	
	public function ajouter($values) {
		$this->db->insert(DB_CLIENT, $values);
		return $this->lastId();
	}
	
	
	/*
	 * UPDATE
	 */
	
	public function modifier($id, $values) {
		$this->db->where('idclient', $id);
		$this->db->update(DB_CLIENT, $values);
	}
	
	
	/*
	 * DELETE
	 */
	
	public function supprimer($id) {
		$this->db->delete(DB_CLIENT, array('idclient' => $id));
	}
	
}