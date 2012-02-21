<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelAccreditation extends MY_Model {
	
	
	/*
	 * READ
	 */

	public function getAccreditations() {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
						->get()
						->result();
	}

	
	public function getAccreditationParId($id) {
		$result = $this->db->select('*')
							->from(DB_ACCREDITATION . ' a')
							->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
							->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
							->where('a.idaccreditation', $id)
							->get()
							->result();
		return $result[0];
	}
	
	public function getAccreditationsParEvenement($idEvenement) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
						->where('a.idevenement', $idEvenement)
						->get()
						->result();
	}
	
	public function getAccreditationsParClient($idClient) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
						->where('a.idclient', $idClient)
						->get()
						->result();
	}
	
	
	/*
	 * CREATE
	 */
	
	public function ajouter($values) {
		$this->db->insert(DB_ACCREDITATION, $values);
		return $this->lastId();
	}
	
	
	/*
	 * UPDATE
	 */
	
	public function modifier($id, $values) {
		$this->db->update(DB_ACCREDITATION, $values, array('idaccreditation = ' . $id));
	}
	
	
	/*
	 * DELETE
	 */
	
	public function supprimer($id) {
		$this->db->delete(DB_ACCREDITATION, array('idaccreditation = ' . $id));
	}
	
}