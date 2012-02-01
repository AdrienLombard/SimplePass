<?php

Class Utilisateur extends Cofe{
    
    
   public function __construct()
	{
		parent::__construct();
		/* on charge le model user*/
		
	}
        
   
  
      
        
 public function listingUser() {
		
		$resultat = $this->utilisateur_model->getUser();
		
		$data['users'] = $resultat;
		
		//$this->layout->view('user_list', $data);
		
		
	}

}
?>
