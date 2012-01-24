<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	private $tableUser = 'forum_user';
	
	public function getUtilisateur() {
			return $this->db->select('*')
							->from($this->tableUser)
							->get()
							->result();
	}
	
	
	
}