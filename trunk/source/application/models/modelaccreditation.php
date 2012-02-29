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
	
	public function getAccreditationsReferentParEvenement($idclient, $idEvenement) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
						->join(DB_EVENEMENT . ' e', 'e.idevenement = a.idevenement')
						->where('cl.idclient', $idclient)
				        ->where('e.idevenement', $idEvenement)
						->get()
						->result();
	}
	
	public function getAccreditationsGroupeParEvenement($idclient, $idEvenement) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
						->join(DB_EVENEMENT . ' e', 'e.idevenement = a.idevenement')
						->where('cl.referent', $idclient)
				        ->where('e.idevenement', $idEvenement)
						->get()
						->result();
	}
	
	public function getAccreditationsParEvenement($idEvenement) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient', 'left')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->where('a.idevenement', $idEvenement)
						->get()
						->result();
	}
	
	public function getAccreditationsParClient($idClient) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
						->join(DB_EVENEMENT . ' e', 'e.idevenement = a.idevenement')
						->where('a.idclient', $idClient)
						->get()
						->result();
	}
	
	public function getDemandesParClient($idClient) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
						->join(DB_EVENEMENT . ' e', 'e.idevenement = a.idevenement')
						->where('a.idclient', $idClient)
						->where('etataccreditation', ACCREDITATION_A_VALIDE)
						->get()
						->result();
	}
	
	public function getAccreditationsValideesParClient($idClient) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie')
						->join(DB_EVENEMENT . ' e', 'e.idevenement = a.idevenement')
						->where('a.idclient', $idClient)
						->where('etataccreditation', ACCREDITATION_VALIDE)
						->get()
						->result();
	}
	
	public function getAccreditationsValidees( $idEvenement ) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient', 'left')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->where('a.idevenement', $idEvenement)
						->where('a.etataccreditation', ACCREDITATION_VALIDE)
						->get()
						->result();
	}
	
	public function getAccreditationsEnAttente( $idEvenement ) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient', 'left')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->where('a.idevenement', $idEvenement)
				        ->where('cl.referent', Null)
						->where('a.etataccreditation', ACCREDITATION_A_VALIDE)
						->get()
						->result();
	}
	
	public function verificationAccred( $event, $nom, $prenom, $pays ) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' c', 'c.idclient = a.idclient')
						->where('idevenement', $event)
						->where('nom', $nom)
						->where('prenom', $prenom)
						->where('pays', $pays)
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
	
	public function valideraccreditation( $id ) {
		$this->db->set('etataccreditation', ACCREDITATION_VALIDE)
				 ->where('idaccreditation', $id) 
				 ->update();
	}
	
	
	/*
	 * DELETE
	 */
	
	public function supprimer($id) {
		$this->db->delete(DB_ACCREDITATION, array('idaccreditation = ' . $id));
	}
	
}