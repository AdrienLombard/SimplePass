<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelAccreditation extends MY_Model {
	
	
	/*
	 * READ
	 */

	public function getAccreditations() {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->get()
						->result();
	}
	
	public function getNbAccreditationsParEvenement($idEvenement) {
		return $this->db->select('COUNT(idaccreditation) as count')
						->from(DB_ACCREDITATION . ' a')
						->where('a.idevenement', $idEvenement)
						->where('a.referent', NULL)
						->get()
						->result();
	}
	
	public function getNbAccreditationsEnAttenteParEvenement($idEvenement) {
		return $this->db->select('COUNT(idaccreditation) as count')
						->from(DB_ACCREDITATION . ' a')
						->where('a.idevenement', $idEvenement)
						->where('a.etataccreditation', ACCREDITATION_A_VALIDE)
						->where('a.referent', NULL)
						->get()
						->result();
	}
	
	public function getAccreditationParId($id) {
		$result = $this->db->select('*')
							->from(DB_ACCREDITATION . ' a')
							->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
							->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
							->where('a.idaccreditation', $id)
							->get()
							->result();
		return $result[0];
	}
	
	public function getAccreditationsReferentParEvenement($idclient, $idEvenement) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
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
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
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
						->Order_by('a.etataccreditation')
						->get()
						->result();
	}
	
	public function getAccreditationsParEvenementSansMembre($idEvenement) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient', 'left')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->where('a.idevenement', $idEvenement)
						->where('a.referent', null)
						->Order_by('a.etataccreditation')
						->get()
						->result();
	}
	
	public function getAccreditationsParClient($idClient) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->join(DB_EVENEMENT . ' e', 'e.idevenement = a.idevenement')
						->where('a.idclient', $idClient)
						->get()
						->result();
	}
	
		public function getAccreditationsHistoriqueParClient($idClient) {
		$current_date = time();
		
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->join(DB_EVENEMENT . ' e', 'e.idevenement = a.idevenement')
						->where('a.idclient', $idClient)
						->where('e.datefin <', $current_date)
						->get()
						->result();
	}
	
		public function getAccreditationsEnCourParClientParEvenement($idClient, $idevenement) {
			return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->join(DB_EVENEMENT . ' e', 'e.idevenement = a.idevenement')
						->where('a.idclient', $idClient)
						->where('e.idevenement', $idevenement)
						->get()
						->result();
	}
	
	public function getDemandesParClient($idClient) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
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
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
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
				        ->where('a.referent', Null)
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
		$this->db->update(DB_ACCREDITATION, $values, array('idaccreditation' => $id));
	}
	
	public function valideraccreditation( $id ) {
		$this->db->update(DB_ACCREDITATION, array('etataccreditation' => 0), array('idaccreditation' => $id));
	}
	
	
	/*
	 * DELETE
	 */
	
	
	public function supprimer($id) {
		
		$this->db->delete(DB_ACCREDITATION, array('idaccreditation' => $id));
		
	}
	
	
	public function supprimerParClient( $idClient ) {
		$this->db->delete(DB_ACCREDITATION, array ( 'idclient' => $idClient));
	}
	
	
	public function supprimerParCategorie ( $idCategorie ) {
		// recup des evenement que l'on peut supprimer.
		$res = $this->db->select('idevenement')
						->where('datefin <=', time())
						->from(DB_EVENEMENT)
						->get()
						->result();
		
		$where = '';
		$k = true;
		foreach($res as $id) {
			if($k) {
				$where .= '( idevenement = ' . $id->idevenement;
				$k = false;
			}
			else {
				$where .= ' OR idevenement = ' . $id->idevenement;
			}
		}
		$where .= ' )';
		
		$this->db->where($where)
				 ->where('idcategorie', $idCategorie)
				 ->delete(DB_ACCREDITATION);
	}
	
	public function getAccreditationGroupeParEvenement( $nomGroupe, $idEvent) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' c', 'c.idclient = a.idclient')
						->join(DB_CATEGORIE . ' ct', 'ct.idcategorie = a.idcategorie')
						->where('a.groupe', $nomGroupe)
						->where('a.idevenement', $idEvent)
						->get()
						->result();
	}	
	
}