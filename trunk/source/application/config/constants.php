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


/*
 * Nom des tables de la bdd.
 */
define('DB_ACCREDITATION',			'courchevel_accreditation');
define('DB_CATEGORIE',				'courchevel_categorie');
define('DB_CATEGORIE_EVENEMENT',	'courchevel_categories_evenements');
define('DB_CATEGORIE_ZONE', 		'courchevel_donne_acces');
define('DB_ZONES_EVENEMENT',		'courchevel_zones_evenement');
define('DB_CLIENT',					'courchevel_client');
define('DB_DONNE_ACCES',			'courchevel_donne_acces');
define('DB_EVENEMENT',				'courchevel_evenement');
define('DB_PAYS',					'courchevel_pays');
define('DB_PERMET',					'courchevel_permet');
define('DB_POSSEDE',				'courchevel_possede');
define('DB_UTILISATEUR',			'courchevel_utilisateur');
define('DB_ZONE',					'courchevel_zone');


/* End of file constants.php */
/* Location: ./application/config/constants.php */