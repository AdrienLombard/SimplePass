<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelCategorie extends CI_Model {
	
	private $tableCategorie 	= 'courchevel_categorie';
	
	
	
	public function getCategorieMere() {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->where('surcategorie',null)
						->get()
						->result();
	}
	
	public function getCategorie() {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->get()
						->result();
	}
	
	public function getCategorieMereid($id) {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->where('idcategorie',$id)
						->get()
						->result();
	}
	
	public function getCategorieDansEvenement( $idEvenement ) {
		return $this->db->select('*')
						->from(DB_CATEGORIE . ' c')
						->join(DB_CATEGORIE_EVENEMENT . ' ca', 'ca.idcategorie = c.idcategorie')
						->where('idevenement',$idEvenement)
						->get()
						->result();
		
	}
	
	
	public function ajouter($nom,$id) {
		$values=array('libellecategorie'=>$nom,'surcategorie'=>$id);
		$this->db->insert($this->tableCategorie, $values);
	}
	
	public function getSousCategorie($id) {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->where('surcategorie',$id)
						->get()
						->result();
	}
	public function lastId() {
		return $this->db->insert_id();
	}
	
	public function supprimerCategorie($id) {
		
		$this->db->where('idcategorie', $id);
		
        $this->db->delete($this->tableCategorie);
	}
	
	public function supprimersousCategorie($id) {
		
		$this->db->where('surcategorie', $id);
        $this->db->delete($this->tableCategorie);
	}
	
	public function modifier($id,$nom) {
		return $this->db->update($this->tableCategorie, array( 'libellecategorie' => $nom), 'idcategorie = '.$id);
	}
	
	
	
}