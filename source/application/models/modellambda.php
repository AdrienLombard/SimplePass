<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelLambda extends MY_Model {
	
	private $tableClient 	= 'courchevel_client';
	
	private $tablePays		= 'courchevel_pays';
	
	private $tableCategorie = 'courchevel_categorie';
	
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
						->order_by('nompays')
						->get()
						->result();
	}
	
	public function lastId() {
		return $this->db->insert_id();
	}
	
	public function listeCategorie() {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->get()
						->result();
	}
	
	public function listeSurCategorie() {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->where('surcategorie', NULL)
						->get()
						->result();
	}
	
	
	
	
	
}