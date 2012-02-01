<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelLambda extends CI_Model {
	
	private $tableClient 	= 'client';
	
	private $tablePays		= 'pays';
	
	public function getClient() {
		return $this->db->select('*')
						->from($this->tableClient)
						->get()
						->result();
	}
	/*
	public function ajouterClient($values) {
		foreach($values as $key => $value) {
			$this->db->set($key, $value);
		}
		$this->db->insert
	}
	 * */
	
	
	public function ajouterClient($values) {
		$this->db->insert($this->tableClient, $values);
	}
	
	
	public function listePays() {
		return $this->db->select('*')
						->from($this->tablePays)
						->get()
						->result();
	}
	
}