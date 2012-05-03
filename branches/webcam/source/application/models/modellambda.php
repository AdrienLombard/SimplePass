<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelLambda extends MY_Model {
	
	
	public function listePays() {
		return $this->db->select('*')
						->from(DB_PAYS)
						->order_by('nompays')
						->get()
						->result();
	}
	
	
	
	
	
}