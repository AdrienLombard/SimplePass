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


	public function updateConfig( $t_values )
	{
		$this->db->update_batch(DB_CONSTANTE, $t_values, 'name');
	}

	public function getConfig( $name )
	{
		$result = $this->db->select('*')
							->from(DB_CONSTANTE)
							->where('name', $name)
							->get()
							->result();

		return $result[0]->value;
	}

	public function getAllConfig()
	{
		return $this->db->select('*')
			->from(DB_CONSTANTE)
			->get()
			->result();
	}

	public function initConfig( $t_values )
	{
		$this->db->insert_batch(DB_CONSTANTE, $t_values );
	}
	
/*
	public function test(){
		$res = $this->db->query('SELECT * FROM courchevel_accreditation WHERE idevenement = 4')->result();
		
	}
	
	public function plop(){
		$this->db->query("UPDATE courchevel_accreditation SET referent = null WHERE referent = -1");
	
		$listeAccred = $this->db->query("SELECT idaccreditation, groupe, idclient FROM courchevel_accreditation WHERE referent IS NULL AND groupe <> '' ")->result();
		
		foreach($listeAccred as $accred){
			//$this->db->query("UPDATE courchevel_accreditation SET referent = ".$accred->idclient." WHERE groupe = '".$accred->groupe."' AND referent = 0");
			echo "UPDATE courchevel_accreditation SET referent = ".$accred->idclient." WHERE groupe = '".$accred->groupe."' AND referent = 0 <br/>";
		}
		
		echo "FIN !";
	}*/

	
	
	
	
	
	


}