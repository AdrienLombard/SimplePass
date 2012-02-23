<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelCategorie extends CI_Model {
	
	private $tableCategorie 	= 'courchevel_categorie';
	
	
	
	public function getCategorieMere() {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->where('surcategorie',null)
						->get()
						->result();
	}
	
	public function getCategorie() {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->get()
						->result();
	}
	
	public function getCategorieMereid($id) {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->where('idcategorie',$id)
						->get()
						->result();
	}
	
	public function getCategorieDansEvenement( $idEvenement ) {
		return $this->db->select('*')
						->from(DB_CATEGORIE . ' c')
						->join(DB_CATEGORIE_EVENEMENT . ' ca', 'ca.idcategorie = c.idcategorie')
						->where('idevenement',$idEvenement)
						->get()
						->result();
		
	}
	
	public function getCategorieDansEvenementToutBien($idEvenement) {
		$result =  $this->db->select('*')
						->from(DB_CATEGORIE . ' c')
						->join(DB_CATEGORIE_EVENEMENT . ' ca', 'ca.idcategorie = c.idcategorie')
						->where('idevenement',$idEvenement)
						->order_by('c.surcategorie')
						->get()
						->result();
		
		// tableau de sortie
		$sorted = array();
		
		// on boucle sur tout les elements de result (tableau trié par surcategorie)
		foreach($result as $cat){
			
			// variable qui check si une sous catégorie a été insérée
			$inserted = false;
			
			// on boucle sur le tabeau de sortie
			for($j=0; $j<=count($sorted); $j++) {
				
				// si la cat du tableau de sortie est mère de l'actuelle
				if(isset($sorted[$j]) && $sorted[$j]['db']->idcategorie == $cat->surcategorie) {
					
					// insertion de la cat après sa cat mère
					$before = array_slice($sorted, 0, $j+1);
					$before[] = array('db' => $cat, 'depth' => $depth = ++$sorted[$j]['depth']);
					$after = array_slice($sorted, $j+1);
					$sorted = array_merge($before, $after);
					
					// une cat a été insérer après sa mère
					$inserted = true;
					break;
				}
			}
			
			// si la cat courante n'a pas trouver de cat mère, on l'insère à la fin
			if(!$inserted)
				$sorted[] = array('db' => $cat, 'depth' => $depth = 0);
		}
		
		return $sorted;
	}
	
	
	public function ajouter($nom,$id) {
		$values=array('libellecategorie'=>$nom,'surcategorie'=>$id);
		$this->db->insert($this->tableCategorie, $values);
	}
	
	public function getSousCategorie($id) {
		return $this->db->select('*')
						->from($this->tableCategorie)
						->where('surcategorie',$id)
						->get()
						->result();
	}
	public function lastId() {
		return $this->db->insert_id();
	}
	
	public function supprimerCategorie($id) {
		
		$this->db->where('idcategorie', $id);
		
        $this->db->delete($this->tableCategorie);
	}
	
	public function supprimersousCategorie($id) {
		
		$this->db->where('surcategorie', $id);
        $this->db->delete($this->tableCategorie);
	}
	
	public function modifier($id,$nom) {
		return $this->db->update($this->tableCategorie, array( 'libellecategorie' => $nom), 'idcategorie = '.$id);
	}
	
	
	
}