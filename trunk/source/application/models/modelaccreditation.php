<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelAccreditation extends MY_Model {

	public function incPrint( $idAccreditation) {
		$count = $this->getPrint( $idAccreditation );

		$this->db->update(DB_ACCREDITATION, array('print' => (int)($count+1) ), array('idaccreditation' => $idAccreditation));
	}

	public function getPrint( $idAccreditation ) {
		$res = $this->db->select('print')
			->from(DB_ACCREDITATION . ' a')
			->where('idaccreditation', $idAccreditation)
			->get()
			->result();

		return $res[0]->print;
	}

	public function addCols() {
		$this->db->query('ALTER TABLE courchevel_accreditation ADD print int default 0');
	}

	public function addTable() {
		$this->db->query('CREATE TABLE courchevel_constante ( name varchar(32) PRIMARY KEY, value text )');
	}
	
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
						//->where('a.referent', NULL)
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
	
	public function getAccreditationsExport($idEvenement, $indiv, $groupe, $valide, $demande) {
		$requete = $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' cl', 'a.idclient = cl.idclient', 'left')
						->join(DB_CATEGORIE . ' ca', 'a.idcategorie = ca.idcategorie', 'left')
						->where('a.idevenement', $idEvenement);
		
		if($indiv && !$groupe)
			$requete = $this->db->where('a.groupe IS NULL');
		elseif(!$indiv && $groupe)
			$requete = $this->db->where('a.groupe IS NOT NULL');
		elseif(!$indiv && !$groupe)
			return null;
			
		if($valide && !$demande)
			$requete = $this->db->where('a.etataccreditation = ' . ACCREDITATION_VALIDE);
		elseif(!$valide && $demande)
			$requete = $this->db->where('a.etataccreditation = ' . ACCREDITATION_A_VALIDE);
		elseif(!$valide && !$demande)
			return null;
			
						
		return $this->db->Order_by('a.etataccreditation')
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
						->Group_by('a.idclient')
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
						->where('e.datefin <', (int)($current_date-3600*24))
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
	
	
	/**
	 * M�thode pour v�rifier si un groupe existe d�ja.
	 */
	public function getGroupeExist( $nomGroupe ) {
		$result = $this->db->select('*')
						->from(DB_ACCREDITATION)
						->where('groupe', $nomGroupe)
						->get()
						->result();
						
		if($result)
			return true;
		else
			return false;
	
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
		
		if(!empty($res)) {
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
		
		return true;
		//else {
		//	return false;
		//}
		
	}
	
	public function getAccreditationGroupeParEvenement( $nomGroupe, $idEvent) {
		return $this->db->select('*')
						->from(DB_ACCREDITATION . ' a')
						->join(DB_CLIENT . ' c', 'c.idclient = a.idclient')
						->join(DB_CATEGORIE . ' ct', 'ct.idcategorie = a.idcategorie', 'left')
						->where('a.groupe', $nomGroupe)
						->where('a.idevenement', $idEvent)
						->get()
						->result();
	}	
	
}