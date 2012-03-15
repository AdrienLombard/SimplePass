<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Impression extends The {
	
	
	public function __construct() {
		
		parent::__construct();
		
		// Chargement des modeles.
		$this->load->model('modelzone');
		$this->load->model('modelclient');
		$this->load->model('modelcategorie');
		$this->load->model('modelaccreditation');
		$this->load->library('form_validation');
		$this->layout->ajouter_css('utilisateur/impressionaccred');
		//$this->layout->ajouter_js('utilisateur/CRUDAccred');
		
	}


	public function index($idclient, $idaccred, $idevenement) {
		
		//$this->layout->view('utilisateur/accreditation/UAImprimer');
		
		include("phpToPDF.php");
		
		
		$client = $this->modelclient->getClientParId($idclient);
		$accred = $this->modelaccreditation->getAccreditationParId($idaccred);
		$zones = $this->modelzone->getZoneParAccredParEvenement ($idaccred, $idevenement);
		$couleur = hexaToRGB($accred->couleur);
		
		$pdf = new phpToPDF();
		$pdf->AddPage();
		$pdf->SetFont('times', '', 12);
		if(img_url($client->nom.'.jpg') != NULL){
			$pdf->Image(img_url($client->nom.'.jpg'), 25, 17);
			
		}
		else{
			$pdf->Image(img_url('ombre.jpg'), 25, 17);
		}
			
		$pdf->Text(25, 73, $accred->nom);
		$pdf->Text(55, 73, $accred->prenom);
		$pdf->Image(img_url('drapeaux/'.$client->pays.'.gif'), 25, 74);
		$pdf->Text(35, 77, $client->pays);
		$pdf->SetFillColor($couleur->red,$couleur->green,$couleur->blue);
		$pdf->Rect(25, 78, 50, 5, 'DF');
		$pdf->Text(30, 82, $accred->libellecategorie);
		$pdf->Text(30, 87, $client->organisme);
		$pdf->Text(30, 91, "Facultatif");
		
		$pdf->SetFont('helvetica', '', 18);
		$nb = count($zones);
		$nbligne = ($nb % 4 == 0)?$nb / 4 : round(($nb / 4), 0, PHP_ROUND_HALF_DOWN)+1;
		$zonetxt = "- ";
		$px = 6;
		for($i=0;$i<$nbligne;$i++){
			for($j=0;$j<4 && ($j+$i*4)<$nb;$j++){
				$zonetxt = $zonetxt.$zones[$j+$i*4]->codezone." - ";
			}
			$pdf->Text(25, 105 + $px*$i, $zonetxt);
			$zonetxt = '- ';
		}
		$pdf->Output();
		
	}
	
}