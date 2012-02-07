
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelUtilisateur extends CI_Model {
	
	private $tableUser = 'courchevel_utilisateur';
	
	public function getUtilisateur() {
			return $user = $this->db->select('*')
							->from($this->tableUser)
							->get()
							->result();
	}
	
	/*
	 * @login
	 * retourne le mot de passe associé au login passé en paramètre
	 * @return mdp
	 */
	public function getMDP($login){
			return $this->db->select('login, mdp')
							->from($this->tableUser)
							->where('login', $login)
							->get()
							->result();
	}
	
	
}