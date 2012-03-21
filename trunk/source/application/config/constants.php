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
define('DB_ZONE',					'courchevel_zone');
define('DB_ZONES_ACCREDITATION', 	'courchevel_accreditation_zones');

/*
 * DIMENSIONS DES IMAGES
 */
define('IMG_WIDTH', 160);
define('IMG_HEIGHT', 204);

/* End of file constants.php */
/* Location: ./application/config/constants.php */