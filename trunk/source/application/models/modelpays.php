<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelPays extends MY_Model {

	public function getPays() {
		return $this->db->get(DB_PAYS)->result();
	}
	
	public function getPaysParId($id) {
		$pays = $this->db->select('*')
						->from(DB_PAYS)
						->where('idpays',$id)
						->get()
						->result();
		
		return $pays[0];
	}
	
}