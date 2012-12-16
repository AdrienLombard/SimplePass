<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Config pour déploiement
 */

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| If this is not set then CodeIgniter will guess the protocol, domain and
| path to your installation.
|
*/
$configTab['BASE_URL'] = 'http://www.accreditation.sportcourchevel.com/';

/*
| -------------------------------------------------------------------
| DATABASE TABLE NAME
| -------------------------------------------------------------------
*/
$configTab['DB_TABLE']['DB_ACCREDITATION'] 			= 'courchevel_accreditation';
$configTab['DB_TABLE']['DB_ACCREDITATION_ZONES'] 	= 'courchevel_accreditation_zones';
$configTab['DB_TABLE']['DB_CATEGORIE'] 				= 'courchevel_categorie';
$configTab['DB_TABLE']['DB_CLIENT'] 				= 'courchevel_client';
$configTab['DB_TABLE']['DB_EVENEMENT'] 				= 'courchevel_evenement';
$configTab['DB_TABLE']['DB_PARAMETRES_EVENEMENTS'] 	= 'courchevel_parametres_evenements';
$configTab['DB_TABLE']['DB_PAYS'] 					= 'courchevel_pays';
$configTab['DB_TABLE']['DB_UTILISATEUR'] 			= 'courchevel_utilisateur';
$configTab['DB_TABLE']['DB_ZONE'] 					= 'courchevel_zone';
$configTab['DB_TABLE']['DB_PRESSE'] 				= 'courchevel_presse';


/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
*/

$configTab['DB_CONNECT']['BDD_HOSTNAME'] = 'db414944902.db.1and1.com';
$configTab['DB_CONNECT']['BDD_USERNAME'] = 'dbo414944902';
$configTab['DB_CONNECT']['BDD_PASSWORD'] = 'sfa73courchevel';
$configTab['DB_CONNECT']['BDD_DATABASE'] = 'db414944902';

$_GLOBAL['SIMPLE_PASS_CONFIG'] = $configTab;





