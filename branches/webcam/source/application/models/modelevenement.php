<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelEvenement extends MY_Model {
	
	public function getEvenements(){
		
		return $this->db->get(DB_EVENEMENT)->result();
	
	}
	
	/**
	 * Fonction pour recuperer un evenement
	 * @return un Evenement pour un id d'evenement
	 */
	public function getEvenementParId($id){
		return $this->db->select('*')
						->from(DB_EVENEMENT)
						->where('idevenement',$id)
						->get()
						->result();
			
	}

	
	public function getCategoriesZonesPourEvenement( $idEvenement ) {
		return $this->db->select('*')
						->from(DB_PARAMETRES_EVENEMENTS. ' pe')
						->join(DB_CATEGORIE. ' c', 'pe.idcategorie = c.idcategorie', 'left')
						->join(DB_ZONE. ' z', 'z.idzone = pe.idzone', 'left')
						->join(DB_EVENEMENT. ' e', 'e.idevenement = pe.idevenement', 'left')
						->where('pe.idevenement', $idEvenement)
						->get()
						->result();
	}
	
	
	public function getEvenementEnCours() {
		
		$current_date = time();
		return $this->db->select('*')
				        ->from(DB_EVENEMENT)
						->where('datefin >=', $current_date)
						->get()
				        ->result();
		
	}
	
	public function getLastEvenement() {
		$req = $this->db->select('*')
				          ->from(DB_EVENEMENT)
						  ->order_by('idevenement', 'desc')
						  ->limit(1)
						  ->get()
				          ->result();
		return $req[0];
	}
	
	
	public function ajouter($libelle,$datedebut,$datefin){
		
		$data = array(
		 	'libelleevenement'	=> $libelle,
		 	'datedebut'			=> $datedebut,
		 	'datefin'			=> $datefin
		 );
		
		$this->db->insert(DB_EVENEMENT, $data);
	}
	
	public function ajouterAvecTextMail($libelle,$datedebut,$datefin, $textmail){
		
		$data = array(
		 	'libelleevenement'	=> $libelle,
		 	'datedebut'			=> $datedebut,
		 	'datefin'			=> $datefin,
			'textmail'			=> $textmail
		 );
		
		$this->db->insert(DB_EVENEMENT, $data);
	}
	
	
	/**
	 * Fonction pour ajouter les paramètre d'un évènment : trio evenement / zone / categorie.
	 * @param Array $parametre : le tableau associatif des ligne a insérer.
	 */
	public function ajouterDonnees( $parametre ) {
		return $this->db->insert_batch(DB_PARAMETRES_EVENEMENTS, $parametre );
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $libelle
	 * @param unknown_type $datedebut
	 * @param unknown_type $datefin
	 * @param unknown_type $id
	 */
	public function modifier($libelle, $datedebut, $datefin, $id){

		$data = array(
		 	'libelleevenement' => $libelle,
		 	'datedebut' => $datedebut,
		 	'datefin' => $datefin
		 );
		
		 $this->db->where('idevenement', $id);
		 $this->db->update(DB_EVENEMENT, $data);
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $libelle
	 * @param unknown_type $datedebut
	 * @param unknown_type $datefin
	 * @param unknown_type $id
	 * @param unknown_type $textmail
	 */
	public function modifierAvecTextMail($libelle, $datedebut, $datefin, $id, $textmail){

		$data = array(
		 	'libelleevenement' => $libelle,
		 	'datedebut' => $datedebut,
		 	'datefin' => $datefin,
			'textmail' => $textmail
		 );
		
		 $this->db->where('idevenement', $id);
		 $this->db->update(DB_EVENEMENT, $data);
		
	}
	
	
	/**
	 * Supprimer l'evenement
	 */
	public function supprimer($id){
		
		 //$this->db->delete('evenement', $id);
		$this->db->where('idevenement', $id);
        $this->db->delete(DB_EVENEMENT);
			                  
	}
	
	public function supprimerParametreParEvenement( $idEvenement ) {
		$this->db->delete(DB_PARAMETRES_EVENEMENTS, array( 'idevenement' => $idEvenement));
	}
	
	public function supprimerParametreParZone ( $idZone ) {
		$this->db->delete(DB_PARAMETRES_EVENEMENTS, array( 'idzone' => $idZone));
	}
	
	public function supprimerparametreParCategorie( $idCategorie ) {
		$this->db->delete(DB_PARAMETRES_EVENEMENTS, array( 'idcategorie' => $idCategorie));
	}
	
	
	
	
	
}
?>
