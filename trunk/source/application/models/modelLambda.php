<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelLambda extends CI_Model {
	
	private $tableClient = 'client';
	
	public function getClient() {
			return $this->db->select('*')
							->from($this->tableClient)
							->get()
							->result();
	}
	
	public function ajouterClient($values) {
		return $this->db->insert_batch($values);
	}
	
}