<?php

/**
 * affiche la date du timestamp passé en parametre au format :
 *  - days/month/years hours:minutes:seconds
 */
if ( !function_exists('display_date_time'))
{
	function display_date_time($t)
	{
		return date('d/m/Y H:i:s', $t);
	}
}


/**
 * affiche la date du timestamp passé en parametre au format :
 *  - days/month/years
 */
if ( !function_exists('display_date'))
{
	function display_date ($t)
	{
		return date('d/m/Y', $t);
	}
}


/**
 * affiche l'heure de la date du timestamp passé en parametre au format :
 *  - hours:minutes:seconds
 */
if ( !function_exists('display_time'))
{
	function display_time ($t)
	{
		return date('H:i:s', $t);
	}
}


/**
 * affiche la date du timestamp passé en parametre en toute lettre.
 */
if ( !function_exists('display_date_full'))
{
	function display_date_full ($t, $time = TRUE)
	{
		$mois = Array(
			'',
			'janvier',
			'fevrier',
			'mars',
			'avril',
			'mai',
			'juin',
			'juillet',
			'aout',
			'septembre',
			'octobre',
			'novembre',
			'decembre'
		);
		$jour = Array(
			'',
			'lundi',
			'mardi',
			'mercredi',
			'jeudi',
			'vendredi',
			'samedi',
			'dimanche'
		);
		
		$date .= '';
		$date .= 'Le '.$jour[date('N', $t)].' ';
		$date .= date('d', $t).' ';
		$date .= $mois[date('m', $t)].' ';
		$date .= date('Y', $t).' à ';
		
		if($time)
		{
			$date .= date('H', $t).' ';
			$date .= date('i', $t).' ';
			$date .= date('s', $t).' ';
		}
		
		return $date;
	}
}


/**
 * transforme une date + mois + année en timestamp
 */
if ( !function_exists('create_date'))
{
	function create_date ($day, $month, $year)
	{
		return mktime(0, 0, 0, $month, $year, $day);
	}
}


/**
 * transforme une date + mois + année + heures + minutes + secondes en timestamp
 */
if ( !function_exists('create_date'))
{
	function create_date_time ($day, $month, $year, $hours, $minutes, $seconds)
	{
		return mktime($hours, $minutes, $seconds, $month, $year, $day);
	}
}


/**
 * transforme une date + mois + année en timestamp
 */
if ( !function_exists('date_to_timestamp'))
{
	function date_to_timestamp2 ($date)
	{
		$tab_date = explode('/', $date); 
		return mktime(0, 0, 0, $tab_date[1], $tab_date[0], $tab_date[2]);
	}
}

/**
* transforme une date + mois + année en timestamp
*/
if ( !function_exists('date_to_timestamp'))
{
	function date_to_timestamp ($date)
	{
		$tab_date = explode('-', $date);
		return mktime(0, 0, 0, $tab_date[1], $tab_date[2], $tab_date[0]);
	}
}













