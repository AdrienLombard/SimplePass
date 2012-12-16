<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends Caramel {
	
	
	public function __construct() {
		parent::__construct();
	}


	public function generate($id) {
			
		header ("Content-type: image/jpg");
        $this->load->helper('image');
		$image = imagecreatefrom(img_url('photos/' . $id . '.jpg'));
		imagejpeg($image);
		
	}

}