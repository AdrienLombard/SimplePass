<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends Caramel {
	
	
	public function __construct() {
		parent::__construct();
	}


	public function generate($id) {
			
		header ("Content-type: image/png");
		
		$image = imagecreatefromjpeg(img_url('photos/' . $id . '.jpg'));
		imagejpeg($image);
		
	}

}