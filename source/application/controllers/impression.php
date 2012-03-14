<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Impression extends The {
	
	
	public function __construct() {
		
		parent::__construct();
		
		// Chargement des modeles.
		$this->load->library('form_validation');
		$this->layout->ajouter_css('utilisateur/impressionaccred');
		//$this->layout->ajouter_js('utilisateur/CRUDAccred');
		
	}


	public function index() {
		
		//$this->layout->view('utilisateur/accreditation/UAImprimer');
		
		include("phpToPDF.php");
		
		$accred = new phpToPDF();
		$accred->AddPage();
		$accred->SetFont('helvetica', '', 12);
		$accred->Image(img_url('ombre.jpg'), 25, 17);
		
		$accred->Text(25, 73, "Nom");
		$accred->Text(55, 73, "Prenom");
		$accred->Image(img_url('drapeaux/fra.gif'), 25, 74);
		$accred->Text(31, 77, "FRA");
		$accred->Text(25, 81, "Categorie");
		$accred->Text(25, 85, "Societe");
		$accred->Text(25, 89, "Facultatif");
		
		$accred->SetFont('helvetica', '', 18);
		$accred->Text(25, 105, "1 - 2 - 3 - 5");
		$accred->Output();
		
	}
	
}