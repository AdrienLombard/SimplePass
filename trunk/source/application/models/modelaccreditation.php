<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelAccreditation extends CI_Model {
	
	private $tableAccreditation 	= 'courchevel_accreditation';
	private $tableCategorie			= 'courchevel_categorie';
	private $tableEvenement			= 'courchevel_evenement';
	private $tableClient			= 'courchevel_client';
	
	public function getAccreditation() {
		return $this->db->select('*')
						->from($this->tableAccreditation . ' a')
						->join($this->tableClient . ' cl', 'a.idclient = cl.idclient')
						->join($this->tableCategorie . ' ca', 'a.idcategorie = ca.idcategorie')
						->get()
						->result();
	}
	
	public function ajouter($values) {
		$this->db->insert($this->tableAccreditation, $values);
	}
	
	public function lastId() {
		return $this->db->insert_id();
	}
	
}