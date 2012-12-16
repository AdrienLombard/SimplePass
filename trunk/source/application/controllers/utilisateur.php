<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class utilisateur extends Cafe {
	/**
	 * constucteur de notre classe de base.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('modelutilisateur');
		$this->load->model('modelaccreditation');
		$this->load->model('modelpays');

		$this->load->library('form_validation');
		
		$this->lang->load('fr');
		
	}
	
	
	public function index($message = '')
	{
		if($this->session->userdata('login')) {
			
			$data['evenement'] = $this->modelevenement->getEvenementParId($this->session->userdata('idEvenementEnCours'));
			$data['nb'] = count($this->modelevenement->getEvenements());
			$data['nbAccreds'] = $this->modelaccreditation->getNbAccreditationsParEvenement($this->session->userdata('idEvenementEnCours'));
			$data['nbDemandes'] = $this->modelaccreditation->getNbAccreditationsEnAttenteParEvenement($this->session->userdata('idEvenementEnCours'));
			$this->layout->view('utilisateur/UWelcome', $data);
			
		}
		else {
			
			$data['message'] = $message;
			$this->layout->ajouter_css('utilisateur/login');
			$this->layout->view('utilisateur/ULogin', $data);
			
		}
	}
	 
	
	public function connexion(){
		// On récupère les données entrée par l'utilisateur.
		$login 	= $this->input->post('login');
		$mdp 	= $this->input->post('mdp');
		
		
		if($login && $mdp) {
			// On crypte le password.
			$pass = sha1($mdp);
			
			// On regarde dans la base si l'utilisateur existe.
			$donnesUtilisateur = $this->modelutilisateur->getMDP($login);

			if(!empty($donnesUtilisateur)){
				if($donnesUtilisateur[0]->mdp == $pass) {
					$this->session->set_userdata('login', $donnesUtilisateur[0]->login);
					
					$this->load->model('modelevenement');			
					$evenement = end($this->modelevenement->getEvenementEnCours());
					
					if($evenement != null) {
						$this->session->set_userdata('idEvenementEnCours', $evenement->idevenement);
						$this->session->set_userdata('libelleEvenementEnCours', $evenement->libelleevenement);
					}

					$this->layout->add_redirect('utilisateur', 0.1);
					$this->layout->view('utilisateur/UWelcome');
				}
				else {
					$message = 'Le mot de passe est incorrect.';
					$this->index($message);
				}
			}
			else {
				$message = "L'utilisateur " . $login . " n'existe pas.";
				$this->index($message);
			}
		}
		else {
			$message = "Veuillez remplir tous les champs.";
			$this->index($message);
		}

	}
	
	
	public function deconnexion() {
		if($this->session->userdata('login')) {
			$this->session->unset_userdata('login');
		}
		//$this->layout->add_redirect('utilisateur', 0.1);
		
		$data['titre']		= 'Déconnexion';
		$data['message']	= 'Vous avez bien été déconnecté.';
		$data['redirect'] 	= 'utilisateur/index';
		$this->layout->view('utilisateur/UMessage', $data);
	}
	
	
	public function change($event, $url) {
		
		$this->session->set_userdata('idEvenementEnCours', $event);
		
		$this->load->model('modelevenement');
		$e = $this->modelevenement->getEvenementParId($event);
		$this->session->set_userdata('libelleEvenementEnCours', $e[0]->libelleevenement);
		
		$this->load->helper('url');
		redirect(str_replace('__', '/', $url));
		
	}


	/******* Gestion modification ********/

	public function configAccred()
	{
		$config = array(
			array('field'   => 'Ximage',    'label'   => 'Yimage',  'rules'   => 'required'),
			array('field'   => 'Yimage',    'label'   => 'Yimage',  'rules'   => 'required'),
			array('field'   => 'Xinfo',     'label'   => 'Xinfo',   'rules'   => 'required'),
			array('field'   => 'Yinfo',     'label'   => 'Yinfo',   'rules'   => 'required'),
			array('field'   => 'Xzones',    'label'   => 'Xzones',  'rules'   => 'required'),
			array('field'   => 'Yzones',    'label'   => 'Yzones',  'rules'   => 'required'),

			array('field'   => 'Ximagec',   'label'   => 'Yimagec', 'rules'   => 'required'),
			array('field'   => 'Yimagec',   'label'   => 'Yimagec', 'rules'   => 'required'),
			array('field'   => 'Xinfoc',    'label'   => 'Xinfoc',  'rules'   => 'required'),
			array('field'   => 'Yinfoc',    'label'   => 'Yinfoc',  'rules'   => 'required'),
			array('field'   => 'Xzonesc',   'label'   => 'Xzonesc', 'rules'   => 'required'),
			array('field'   => 'Yzonesc',   'label'   => 'Yzonesc', 'rules'   => 'required')
		);
		$this->form_validation->set_rules($config);

		// Variable pour accred classique.
		$t_values = Array();
		$t_values['Ximage'] = array('name' => 'Ximage', 'value' => $this->input->post('Ximage') );
		$t_values['Yimage'] = array('name' => 'Yimage', 'value' => $this->input->post('Yimage') );
		$t_values['Xinfo'] = array('name' => 'Xinfo', 'value' => $this->input->post('Xinfo') );
		$t_values['Yinfo'] = array('name' => 'Yinfo', 'value' => $this->input->post('Yinfo') );
		$t_values['Xzones'] = array('name' => 'Xzones', 'value' => $this->input->post('Xzones') );
		$t_values['Yzones'] = array('name' => 'Yzones', 'value' => $this->input->post('Yzones') );

		// Variable pour accred format carte.
		$t_values['Ximagec'] = array('name' => 'Ximagec', 'value' => $this->input->post('Ximagec') );
		$t_values['Yimagec'] = array('name' => 'Yimagec', 'value' => $this->input->post('Yimagec') );
		$t_values['Xinfoc'] = array('name' => 'Xinfoc', 'value' => $this->input->post('Xinfoc') );
		$t_values['Yinfoc'] = array('name' => 'Yinfoc', 'value' => $this->input->post('Yinfoc') );
		$t_values['Xzonesc'] = array('name' => 'Xzonesc', 'value' => $this->input->post('Xzonesc') );
		$t_values['Yzonesc'] = array('name' => 'Yzonesc', 'value' => $this->input->post('Yzonesc') );

		$data = array();
		$dim = array();
		$dim['Ximage'] = $this->modelutilisateur->getConfig('Ximage');
		$dim['Yimage'] = $this->modelutilisateur->getConfig('Yimage');
		$dim['Xinfo']  = $this->modelutilisateur->getConfig('Xinfo');
		$dim['Yinfo']  = $this->modelutilisateur->getConfig('Yinfo');
		$dim['Xzones'] = $this->modelutilisateur->getConfig('Xzones');
		$dim['Yzones'] = $this->modelutilisateur->getConfig('Yzones');

		$dim['Ximagec'] = $this->modelutilisateur->getConfig('Ximagec');
		$dim['Yimagec'] = $this->modelutilisateur->getConfig('Yimagec');
		$dim['Xinfoc']  = $this->modelutilisateur->getConfig('Xinfoc');
		$dim['Yinfoc']  = $this->modelutilisateur->getConfig('Yinfoc');
		$dim['Xzonesc'] = $this->modelutilisateur->getConfig('Xzonesc');
		$dim['Yzonesc'] = $this->modelutilisateur->getConfig('Yzonesc');

		$data['dim'] = $dim;

		if ($this->form_validation->run() == true)
		{

			//die('dans la base');
			$this->modelutilisateur->updateConfig( $t_values );
		}

		$this->layout->view('utilisateur/params/UPAccreds.php', $data);


	}

	public function configMail()
	{
		$config = array(
			array('field'   => 'mail_expediteur',   'label'   => 'mail_expediteur',     'rules'   => 'required'),
			array('field'   => 'nom_expediteur',    'label'   => 'nom_expediteur    ',  'rules'   => 'required'),
			array('field'   => 'mail_copie',        'label'   => 'mail_copie',          'rules'   => 'required'),
			array('field'   => 'objet_mail',        'label'   => 'objet_mail',          'rules'   => 'required'),
			array('field'   => 'cher',              'label'   => 'cher',                'rules'   => 'required'),
			array('field'   => 'dear',              'label'   => 'dear',                'rules'   => 'required'),
			array('field'   => 'intro_mail',        'label'   => 'intro_mail',          'rules'   => 'required'),
			array('field'   => 'traitement_mail',   'label'   => 'traitement_mail',     'rules'   => 'required'),
			array('field'   => 'signature_mail',    'label'   => 'signature_mail',      'rules'   => 'required'),

		);
		$this->form_validation->set_rules($config);

		// Variable pour accred classique.
		$t_values = Array();
		$t_values['mail_expediteur'] = array('name' => 'mail_expediteur', 'value' => $this->input->post('mail_expediteur') );
		$t_values['nom_expediteur'] = array('name' => 'nom_expediteur', 'value' => $this->input->post('nom_expediteur') );
		$t_values['mail_copie'] = array('name' => 'mail_copie', 'value' => $this->input->post('mail_copie') );
		$t_values['objet_mail'] = array('name' => 'objet_mail', 'value' => $this->input->post('objet_mail') );
		$t_values['cher'] = array('name' => 'cher', 'value' => $this->input->post('cher') );
		$t_values['dear'] = array('name' => 'dear', 'value' => $this->input->post('dear') );
		$t_values['intro_mail'] = array('name' => 'intro_mail', 'value' => $this->input->post('intro_mail') );
		$t_values['traitement_mail'] = array('name' => 'traitement_mail', 'value' => $this->input->post('traitement_mail') );
		$t_values['signature_mail'] = array('name' => 'signature_mail', 'value' => $this->input->post('signature_mail') );


		$data = array();
		$mail = array();
		$mail['mail_expediteur'] = utf8_decode($this->modelutilisateur->getConfig('mail_expediteur'));
		$mail['nom_expediteur'] = utf8_decode($this->modelutilisateur->getConfig('nom_expediteur'));
		$mail['mail_copie'] = utf8_decode($this->modelutilisateur->getConfig('mail_copie'));
		$mail['objet_mail'] = utf8_decode($this->modelutilisateur->getConfig('objet_mail'));
		$mail['cher'] = utf8_decode($this->modelutilisateur->getConfig('cher'));
		$mail['dear'] = utf8_decode($this->modelutilisateur->getConfig('dear'));
		$mail['intro_mail'] = utf8_decode($this->modelutilisateur->getConfig('intro_mail'));
		$mail['traitement_mail'] = utf8_decode($this->modelutilisateur->getConfig('traitement_mail'));
		$mail['signature_mail'] = utf8_decode($this->modelutilisateur->getConfig('signature_mail'));


		$data['mail'] = $mail;

		if ($this->form_validation->run() == true)
		{

			//die('dans la base');
			$this->modelutilisateur->updateConfig( $t_values );
		}

		$this->layout->view('utilisateur/params/UPMail.php', $data);


	}

	public function test() {
		$t_values = Array();

		$t_values['mail_expediteur'] = array('name' => 'mail_expediteur', 'value' => 'accreditation@sportcourchevel.com' );
		$t_values['nom_expediteur'] = array('name' => 'nom_expediteur', 'value' => 'Courchevel Accreditations' );
		$t_values['mail_copie'] = array('name' => 'mail_copie', 'value' => 'accreditation@sportcourchevel.com' );
		$t_values['objet_mail'] = array('name' => 'objet_mail', 'value' => 'Accreditations FIS Alpine Ski World Cup Courchevel' );
		$t_values['cher'] = array('name' => 'cher', 'value' => 'Cher(e) ' );
		$t_values['dear'] = array('name' => 'dear', 'value' => 'Dear ' );
		$t_values['intro_mail'] = array('name' => 'intro_mail', 'value' => '<p>Nous vous remercions pour votre demande d\'accréditation.<br />' .
			'Thank you very much for your application for accreditation.</p>' .
			'<p>Pour rappel, voici le résumé des informations fournies : <br />' .
			'As a reminder, please find below your information : </p>' );
		$t_values['traitement_mail'] = array('name' => 'traitement_mail', 'value' => '<p>Nous les traiterons dans les plus brefs délais.<br />' .
			'Please allow a while for the processing</p>' );
		$t_values['signature_mail'] = array('name' => 'signature_mail', 'value' => '<p>Sincères salutations, <br />' .
			'Best Regards, </p>' .
			'<p>Comité d\'organisation de la Coupe du Monde FIS de Ski - Courchevel<br />' .
			'FIS Alpine Ski World Cup Organizing Committee - Courchevel</p>' .
			'<p>Club des Sports de Courchevel<br />' .
			'Le Forum<br />' .
			'BP 10<br />' .
			'F - 73 121 Courchevel<br />' .
			'tel: +33 (0)4 79 08 08 21<br />' .
			'fax: +33 (0)4 79 08 40 93<br /></p>' .
			'<p>www.courchevel.com/skiworldcup</p>' );



		//$this->modelutilisateur->initConfig( $t_values );
	}
	
	public function bidouille() {
		$this->modelutilisateur->dump_MySQL('db414944902.db.1and1.com', 'dbo414944902', 'sfa73courchevel', 'db414944902', 2);
	}

	public function test2() {
		
		//$this->modelutilisateur->getAllConfig();



		//$result = $this->modelutilisateur->dump();

		/*
		foreach ($result->result_array() as $row)
		{
			$liste = array();
			foreach($row as $key => $value){
				$liste[] = $value;
			}
			echo implode(';', $liste).'<br/>';
		}
		/**/

		//display_tab($row);

		//echo sha1('club@sport73');
		
		$this->modelutilisateur->plop();



	}
	
	public function addpayscc()
	{
		//$this->modelpays->addPays();
	}
	
	
}

/* End of file utilisateur.php */
/* Location: ./application/controllers/utilisateur.php */
