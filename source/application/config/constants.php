<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
 * Mise en place des constantes pour l'état d'une accréditation.
 */
define('ACCREDITATION_A_VALIDE', 1);
define('ACCREDITATION_VALIDE', 0);

define('NON_ALL_ACCESS', 0);
define('ALL_ACCESS', 1);

define('FIXE', 			0);
define('PORTABLE', 	1);
define('DIRECT', 		2);

/*
 * Nom des tables de la bdd.
 */
define('DB_ACCREDITATION',			'courchevel_accreditation');
define('DB_ACCREDITATION_ZONES',	'courchevel_accreditation_zones');
define('DB_CATEGORIE',				'courchevel_categorie');
define('DB_CLIENT',					'courchevel_client');
define('DB_EVENEMENT',				'courchevel_evenement');
define('DB_PARAMETRES_EVENEMENTS',	'courchevel_parametres_evenements');
define('DB_PAYS',					'courchevel_pays');
define('DB_UTILISATEUR',			'courchevel_utilisateur');
define('DB_ZONES_ACCREDITATION', 	'courchevel_accreditation_zones');
define('DB_ZONE',					'courchevel_zone');
define ('DB_PRESSE',                'courchevel_presse');
/*
 * DIMENSIONS DES IMAGES
 */
define('UPLOAD_DIR', './assets/images/photos/');
define('IMG_WIDTH', 160);
define('IMG_HEIGHT', 204);

/*
 * INFORMATIONS DU MAIL
 */
define('MAIL_EXPEDITEUR', 'accreditation@sportcourchevel.com');
define('NOM_EXPEDITEUR', 'Courchevel Accreditations');
define('MAIL_COPIE', 'accreditation@sportcourchevel.com');
define('OBJET_MAIL', 'Accreditations FIS Alpine Ski World Cup Courchevel');
define('CHER', 'Cher(e) ');
define('DEAR', 'Dear ');
define('INTRO_MAIL', 	'<p>Nous vous remercions pour votre demande d\'accréditation.<br />' .
						'Thank you very much for your application for accreditation.</p>' .
						'<p>Pour rappel, voici le résumé des informations fournies : <br />' .
						'As a reminder, please find below your information : </p>');
					
define('TRAITEMENT_MAIL',	'<p>Nous les traiterons dans les plus brefs délais.<br />' .
							'Please allow a while for the processing</p>');
						
define('SIGNATURE_MAIL',	'<p>Sincères salutations, <br />' .
							'Best Regards, </p>' .
							'<p>Comité d\'organisation de la Coupe du Monde FIS de Ski - Courchevel<br />' .
							'FIS Alpine Ski World Cup Organizing Committee - Courchevel</p>' .
							'<p>Club des Sports de Courchevel<br />' .
							'Le Forum<br />' .
							'BP 10<br />' .
							'F - 73 121 Courchevel<br />' .
							'tel: +33 (0)4 79 08 08 21<br />' .
							'fax: +33 (0)4 79 08 40 93<br /></p>' .
							'<p>www.courchevel.com/skiworldcup</p>');


/*
 * Informations pour les accreditations papier
 * Les dimensions sont en mm
 */ 

/* 
 *		format quart de A4
 */ 
// haut gauche de la photo
 define('Ximage',24);
 define('Yimage',19);
// haut gauche de la zone d'information
 define('Xinfo',25);
 define('Yinfo',71);
// haut gauche de la zone de zones
 define('Xzones',25);
 define('Yzones',97);
 
 /*
  *		format carte
  */
// haut gauche de la photo 
 define('Ximagec',30);
 define('Yimagec',22);
 // haut gauche de la zone d'information
 define('Xinfoc',58);
 define('Yinfoc',28);
 // haut gauche de la zone de zones
 define('Xzonesc',30);
 define('Yzonesc',55);
 
/* End of file constants.php */
/* Location: ./application/config/constants.php */