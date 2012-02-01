<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelAccreditation extends CI_Model {
	
	private $table 	= 'accreditation';
	
	public function getAccreditation() {
		return $this->db->select('*')
						->from($this->table)
						->get()
						->result();
	}
	
	public function ajouter($values) {
		$this->db->insert($this->table, $values);
	}
	
	public function lastId() {
		return $this->db->insert_id();
	}
	
}