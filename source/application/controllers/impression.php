<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Impression extends The {
	
	
	public function __construct() {
		
		parent::__construct();
		
		// Chargement des modeles.
		$this->load->model('modelzone');
		$this->load->model('modelclient');
		$this->load->model('modelcategorie');
		$this->load->model('modelaccreditation');
		$this->load->model('modelevenement');
		$this->load->library('form_validation');
		$this->layout->ajouter_css('utilisateur/impressionaccred');
		//$this->layout->ajouter_js('utilisateur/CRUDAccred');
		
		// Mise en place de la sécurisation.
		//$this->securiseAll();
		
	}


	public function index($idclient, $idaccred, $idevenement, $facult='') {
		
		//$this->layout->view('utilisateur/accreditation/UAImprimer');
		
		include("phpToPDF.php");
		
		
		$client = $this->modelclient->getClientParId($idclient);
		$accred = $this->modelaccreditation->getAccreditationParId($idaccred);
		$zonesEvent = $this->modelzone->getZoneParEvenement($idevenement);
		$zones = $this->modelzone->getZoneParAccredParEvenement ($idaccred, $idevenement);
		$facult = str_replace('%20', ' ', $facult);
		$indice = 0;
		
		$pdf = new phpToPDF();
		$pdf->AddPage();
		$pdf->SetFont('helvetica', '', 12);
		if(img_url('photos/'.$client->idclient.'.jpg') != NULL){
			$pdf->Image(img_url('photos/'.$client->idclient.'.jpg'), Ximage, Yimage, 29, 37);
			
		}
		else{
			$pdf->Image(img_url('photos/0.jpg'), Ximage, Yimage, 29, 37);
		}
		$nomprenom = $accred->nom.' '.$accred->prenom;	
		$pdf->Text(Xinfo, Yinfo, utf8_decode($nomprenom));
		$pdf->Image(img_url('drapeaux/'.utf8_decode($client->pays).'.gif'), Xinfo, Yinfo+1);
		$pdf->Text(Xinfo+10, Yinfo+4, utf8_decode($client->pays));
		if ($accred->libellecategorie != null){
			$couleur = hexaToRGB($accred->couleur);
			$pdf->SetFillColor($couleur->red,$couleur->green,$couleur->blue);
			$pdf->Rect(Xinfo, Yinfo+5, 50, 5, 'DF');
			$pdf->Text(Xinfo+2, Yinfo+9, utf8_decode($accred->libellecategorie));
			$indice = $indice + 5;
		}
		if($facult != ''){
			$pdf->Text(Xinfo, Yinfo+9 + $indice, utf8_decode($facult));
			$indice = $indice + 4;
		}
		$pdf->Text(Xinfo, Yinfo+9 + $indice, utf8_decode($client->organisme));
		
		
		$pdf->SetFont('helvetica', 'B', 13);
		$nb = count($zonesEvent);
		$nbligne = ($nb % 6 == 0)?$nb / 6 : floor($nb / 6)+1;
		
		$px = 7;
		for($i=0;$i<$nbligne;$i++){
			$py = 0;
			for($j=0;$j<6 && ($j+$i*6)<$nb;$j++){
				$pyi = 0;
				if($this->zone_exist($zones, $zonesEvent[$j+$i*6]->codezone)){
					$pdf->SetFillColor(0,0,0);
					$pdf->Rect(Xzones + $py, Yzones + $px*$i, 6, 6, 'DF');
					$pdf->SetTextColor(255,255,255);
				}
				else{
					$pdf->SetTextColor(200,200,200);
				}
				if(strlen($zonesEvent[$j+$i*6]->codezone )== 1){
					$pyi = 1.2;
				}
				$pdf->Text(Xzones+ 0.5 + $py + $pyi, Yzones + 5 + $px*$i, $zonesEvent[$j+$i*6]->codezone);
				$py = $py + 8;
			}
		}
		$pdf->Output();	
	}
	
	private function zone_exist($tab, $champ){
		$test = false;
		foreach ($tab as $t){
			if ($t->codezone == $champ){
				$test = true;
			}
		}
		return $test;
	}
	
	public function impcarte($idclient, $idaccred, $idevenement, $facult=''){
		
		include("phpToPDF.php");
		
		
		$client = $this->modelclient->getClientParId($idclient);
		$accred = $this->modelaccreditation->getAccreditationParId($idaccred);
		$zonesEvent = $this->modelzone->getZoneParEvenement($idevenement);
		$zones = $this->modelzone->getZoneParAccredParEvenement($idaccred, $idevenement);
		$facult = str_replace('%20', ' ', $facult);
		$indice = 0;
		
		
		$pdf = new phpToPDF();
		$pdf->AddPage();
		$pdf->SetFont('helvetica', '', 12);
		if(img_url('photos/'.$client->idclient.'.jpg') != NULL){
			$pdf->Image(img_url('photos/'.$client->idclient.'.jpg'), Ximagec, Yimage, 25, 32);
			
		}
		else{
			$pdf->Image(img_url('photos/0.jpg'), Ximagec, Yimagec, 25, 32);
		}
		$nomprenom = $accred->nom.' '.$accred->prenom;	
		$pdf->Text(Xinfoc, Yinfoc, utf8_decode($nomprenom));
		$pdf->Image(img_url('drapeaux/'.utf8_decode($client->pays).'.gif'), Xinfoc, Yinfoc+2);
		$pdf->Text(Xinfoc+7, Yinfoc+5, utf8_decode($client->pays));
		if ($accred->libellecategorie != null){
			$couleur = hexaToRGB($accred->couleur);
			$pdf->SetFillColor($couleur->red,$couleur->green,$couleur->blue);
			$pdf->Rect(Xinfoc, Yinfoc+7, 44, 6, 'DF');
			$pdf->Text(Xinfoc+2, Yinfoc+12, utf8_decode($accred->libellecategorie));
			$indice = $indice + 6;
			
		}
		if($facult != ''){
			$pdf->Text(Xinfoc, Yinfoc+12 + $indice, $facult);
			$indice = $indice + 6;
		}
		$pdf->Text(Xinfoc, Yinfoc+12 + $indice, utf8_decode($client->organisme));
		$pdf->SetFont('helvetica', 'B', 12);
		$nb = count($zonesEvent);
		
		$nbligne = ($nb % 10 == 0)?$nb / 10 : floor($nb / 10)+1;

		$px = 7;
		for($i=0;$i<$nbligne;$i++){
			$py = 0;
			for($j=0;$j<10 && ($j+$i*10)<$nb;$j++){
				$pyi = 0;
				if($this->zone_exist($zones, $zonesEvent[$j+$i*10]->codezone)){
					$pdf->SetFillColor(0,0,0);
					$pdf->Rect(Xzonesc + $py, Yzonesc + $px*$i, 6, 6, 'DF');
					$pdf->SetTextColor(255,255,255);
				}
				else{
					$pdf->SetTextColor(200,200,200);
				}
				if(strlen($zonesEvent[$j+$i*10]->codezone )== 1){
						$pyi = 1;
				}
				$pdf->Text(Xzonesc+0.7 + $py + $pyi, Yzonesc+4.5 + $px*$i, $zonesEvent[$j+$i*10]->codezone);
				$py = $py + 7;
			}
		}
		
		$pdf->Output();
	}
	
	public function impgroupe($nomGroupe){
		
		include("phpToPDF.php");
		
		$nomGroupe=str_replace('%20', ' ', rawurldecode($nomGroupe));
		$idEvent = $this->session->userdata('idEvenementEnCours');
		$membres = $this->modelaccreditation->getAccreditationGroupeParEvenement( $nomGroupe, $idEvent);
		$zonesEvent = $this->modelzone->getZoneParEvenement($idEvent);				

		$pdf = new phpToPDF();
		foreach($membres as $m){
			$indice = 0;
			$pdf->AddPage();
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetTextColor(0,0,0);
			if(img_url('photos/'.$m->idclient.'.jpg') != NULL){
				$pdf->Image(img_url('photos/'.$m->idclient.'.jpg'), Ximage, Yimage, 29, 37);

			}
			else{
				$pdf->Image(img_url('photos/0.jpg'), Ximage, Yimage, 29, 37);
			}
			$nomprenom = $m->nom.' '.$m->prenom;	
			$pdf->Text(Xinfo, Yinfo, utf8_decode($nomprenom));
			$pdf->Image(img_url('drapeaux/'.utf8_decode($m->pays).'.gif'), Xinfo, Yinfo+1);
			$pdf->Text(Xinfo+10, Yinfo+4, utf8_decode($m->pays));
			if ($m->libellecategorie != null){
				$couleur = hexaToRGB($m->couleur);
				$pdf->SetFillColor($couleur->red,$couleur->green,$couleur->blue);
				$pdf->Rect(Xinfo, Yinfo+5, 50, 5, 'DF');
				$pdf->Text(Xinfo+2, Yinfo+9, utf8_decode($m->libellecategorie));
				$indice = $indice + 5;
			}

			$pdf->Text(Xinfo, Yinfo+9 + $indice, utf8_decode($m->organisme));

			$zones = $this->modelzone->getZoneParAccredParEvenement ($m->idaccreditation, $idEvent);
			$pdf->SetFont('helvetica', 'B', 13);
			$nb = count($zonesEvent);
			$nbligne = ($nb % 6 == 0)?$nb / 6 : floor($nb / 6)+1;
			$px = 7;
			for($i=0;$i<$nbligne;$i++){
				$py = 0;
				for($j=0;$j<6 && ($j+$i*6)<$nb;$j++){
					$pyi = 0;
					if($this->zone_exist($zones, $zonesEvent[$j+$i*6]->codezone)){
						$pdf->SetFillColor(0,0,0);
						$pdf->Rect(Xzones + $py, Yzones + $px*$i, 6, 6, 'DF');
						$pdf->SetTextColor(255,255,255);
					}
					else{
						$pdf->SetTextColor(200,200,200);
					}
					if(strlen($zonesEvent[$j+$i*6]->codezone )== 1){
						$pyi = 1.2;
					}
					$pdf->Text(Xzones +0.5 + $py + $pyi, Yzones + 5 + $px*$i, $zonesEvent[$j+$i*6]->codezone);
					$py = $py + 8;
				}
			}
		}
		$pdf->Output();
		
	}
	
	public function impcartegroupe($nomGroupe){
		
		include("phpToPDF.php");
		
		
		$nomGroupe=str_replace('%20', ' ', rawurldecode($nomGroupe));
		$idEvent = $this->session->userdata('idEvenementEnCours');
		$membres = $this->modelaccreditation->getAccreditationGroupeParEvenement( $nomGroupe, $idEvent);
		$zonesEvent = $this->modelzone->getZoneParEvenement($idEvent);				

		$pdf = new phpToPDF();
		foreach($membres as $m){
			$indice = 0;
			$pdf->AddPage();
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetTextColor(0,0,0);
			if(img_url('photos/'.$m->idclient.'.jpg') != NULL){
				$pdf->Image(img_url('photos/'.$m->idclient.'.jpg'), Ximagec, Yimagec, 25, 32);

			}
			else{
				$pdf->Image(img_url('photos/0.jpg'), Ximagec, Yimagec, 25, 32);
			}
			$nomprenom = $m->nom.' '.$m->prenom;	
			$pdf->Text(Xinfoc, Yinfoc, utf8_decode($nomprenom));
			$pdf->Image(img_url('drapeaux/'.utf8_decode($m->pays).'.gif'), Xinfoc, Yinfoc+2);
			$pdf->Text(Xinfoc+7, Yinfoc+5, utf8_decode($m->pays));
			if ($m->libellecategorie != null){
				$couleur = hexaToRGB($m->couleur);
				$pdf->SetFillColor($couleur->red,$couleur->green,$couleur->blue);
				$pdf->Rect(Xinfoc, Yinfoc+7, 44, 6, 'DF');
				$pdf->Text(Xinfoc+2, Yinfoc+12, utf8_decode($m->libellecategorie));
				$indice = $indice + 6;
			}

			$pdf->Text(Xinfoc, Yinfoc+12 + $indice, utf8_decode($m->organisme));

			$zones = $this->modelzone->getZoneParAccredParEvenement ($m->idaccreditation, $idEvent);
			$pdf->SetFont('helvetica', 'B', 12);
			$nb = count($zonesEvent);
			$nbligne = ($nb % 10 == 0)?$nb / 10 : floor($nb / 10)+1;
			$px = 7;
			for($i=0;$i<$nbligne;$i++){
				$py = 0;
				for($j=0;$j<10 && ($j+$i*10)<$nb;$j++){
					$pyi = 0;
					if($this->zone_exist($zones, $zonesEvent[$j+$i*10]->codezone)){
						$pdf->SetFillColor(0,0,0);
						$pdf->Rect(Xzonesc + $py, Yzonesc + $px*$i, 6, 6, 'DF');
						$pdf->SetTextColor(255,255,255);
					}
					else{
						$pdf->SetTextColor(200,200,200);
					}
					if(strlen($zonesEvent[$j+$i*10]->codezone )== 1){
						$pyi = 1;
					}
					$pdf->Text(Xzonesc+0.7 + $py + $pyi, Yzonesc +4.5 + $px*$i, $zonesEvent[$j+$i*10]->codezone);
					$py = $py + 7;
				}
			}
		}
		$pdf->Output();
		
	}
	
	public function imptableau($idevent){
		
		include("phpToPDF.php");
		
		$evenement = $this->modelevenement->getCategoriesZonesPourEvenement($idevent);
		$categorie = $this->modelcategorie->getcategories();
		$header = array('test1','test2','test3','test4','test5');
		
		
		$pdf = new phpToPDF();
		$pdf->AddPage();
		
		 foreach($header as $col){
			 $pdf->Cell(40,7,$col,1);
		 }
		 $pdf->Output();
	}
	
}