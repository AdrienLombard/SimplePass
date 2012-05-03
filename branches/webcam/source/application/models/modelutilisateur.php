<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelUtilisateur extends MY_Model {
	
	
	/*
	 * READ
	 */
	
	public function getUtilisateurs() {
		return $this->db->get(DB_UTILISATEUR)->result();
	}
	
	public function getUtilisateurParId($id) {
		$result = $this->db->select('*')
							->from(DB_UTILISATEUR . ' u')
							->where('u.idutilisateur', $id)
							->get()
							->result();
		return $result[0];
	}

	public function getMDP($login){
			return $this->db->select('login, mdp')
							->from(DB_UTILISATEUR)
							->where('login', $login)
							->get()
							->result();
	}
	
	
	/*
	 * CREATE
	 */
	
	public function ajouter($values) {
		$this->db->insert(DB_UTILISATEUR, $values);
		return $this->lastId();
	}
	
	
	/*
	 * UPDATE
	 */
	
	public function modifier($id, $values) {
		$this->db->update(DB_UTILISATEUR, $values, array('idutilisateur = ' . $id));
	}
	
	
	/*
	 * DELETE
	 */
	
	public function supprimer($id) {
		$this->db->delete(DB_UTILISATEUR, array('idutilisateur = ' . $id));
	}

}