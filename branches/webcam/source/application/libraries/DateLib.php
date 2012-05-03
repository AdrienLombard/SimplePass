<?php
class DateLib {
	
	//variables
	private $timestamp;
	
	
	
	/**
	 * constructeur de base
	 */
	public function __construct($time = 0) {
		if(!empty($time)) {
			$this->timestamp = $time;
		}
		else {
			$this->timestamp = time();
		}
	}
	
	/**
	 * get_timestamp()
	 * to_date()
	 */
	
	/**
	 * definie le timestamp
	 * @param $time timestamp a definir
	 */
	public function set_timestamp($time) {
		if($time) {
			$this->timestamp = $time;
		}
	}
	
	/**
	 * definie le timestamp grace au element d'une date
	 * @todo doc a faire
	 */
	public function set_date($heure, $minute, $second, $mois, $jour, $annee) {
		$this->timestamp = mktime($heure, $minute, $second, $mois, $jour, $annee);
	}
	
	/**
	 * retourne le timestamp
	 * @return le timestamp
	 */
	public function get_timestamp() {
		return $this->timestamp;
	}
	
	/**
	 * retourne le numero du mois (1 à 12)
	 * @return numero du mois
	 */
	public function get_month() {
		return date("n", $this->timestamp);
	}
	
	/**
	 * retourne le numero du jour dans le mois (1 à 31)
	 * @return numero du jour dans le mois
	 */
	public function get_date() {
		return date("j", $this->timestamp);
	}
	
	/**
	 * retourne le numero du jour dans la semaine (1:lundi à 7:dimanche)
	 * @return numero du jour dans la samaine
	 */
	public function get_day() {
		return date("N", $this->timestamp);
	}
	
	/**
	 * retourne l'annee sur 4 chiffres
	 * @return numero l'année
	 */
	public function get_full_year() {
		return date("Y", $this->timestamp);
	}
	
	/**
	 * retourne le nombre d'heure (0 à 23)
	 * @return nombre d'heure
	 */
	public function get_hours() {
		return date("G", $this->timestamp);
	}
	
	/**
	 * retourne le nombre d'heure avec un zero (00 à 23)
	 * @return nombre d'heure
	 */
	public function get_hours_z() {
		return date("H", $this->timestamp);
	}
	
	/**
	 * retourne le nombre de minute (00 à 59)
	 * @return nombre de minute
	 */
	public function get_minutes() {
		return date("i", $this->timestamp);
	}
	
	/**
	 * retourne le nombre de seconde (00 à 59)
	 * @return nombre de seconde
	 */
	public function get_seconds() {
		return date("s", $this->timestamp);
	}
	
	/**
	 * retourne le numero de la semaine.
	 * @return numero de semaine
	 */
	public function get_week() {
		return date("w", $this->timestamp);
	}
	
	/**
	 * retourne 1 si bissextile et 0 sinon
	 * @return boolean sur année bissextile
	 */
	public function is_bissextile() {
		return date("L", $this->timestamp);
	}
	
	
	/*##################################################################################*/
	/*	FONCTION INDEPENDANTE DE LA CLASSE  											*/
	
	/**
	 * retourne le timestamp de la date passer en parametre
	 */
	public function to_timestamp($heure, $minute, $second, $mois, $jour, $annee) {
		return mktime($heure, $minute, $second, $mois, $jour, $annee);
	}
	
	/**
	 * retourne une date prete a etre aficher
	 */
	public function display_date($time) {
		$date = "";
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
		
		$this->set_timestamp($time);
		
		$date .=	$jour[$this->get_day()];
		$date .=	' ';
		$date .=	$this->get_date();
		$date .=	' ';
		$date .=	$mois[$this->get_month()];
		$date .=	' ';
		$date .=	$this->get_full_year();
		$date .=	' - ';
		$date .=	$this->get_hours_z();
		$date .= 	':';
		$date .=	$this->get_minutes();
		
		return $date;
	}
	
	/**
	 * retourne une date prete a etre aficher, sans l'heure
	 */
	public function display_day($time) {
		$date = "";
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
		
		$this->set_timestamp($time);
		
		$date .=	$jour[$this->get_day()];
		$date .=	' ';
		$date .=	$this->get_date();
		$date .=	' ';
		$date .=	$mois[$this->get_month()];
		$date .=	' ';
		$date .=	$this->get_full_year();
		
		return $date;
	}
	
	function toString($time) {
		$this->set_timestamp($time);

		$date  = '';
		$date .=	$this->get_date();
		$date .=	'/';
		$date .=	$this->get_month();
		$date .=	'/';
		$date .=	$this->get_full_year();
		$date .=	' ';
		$date .=	$this->get_hours_z();
		$date .= 	':';
		$date .=	$this->get_minutes();
		
		return $date;
	}
	
	/*###################################################################################
	
	//pour mettre les get_display_??()
	
	/**/
	

	
	
	

	
}//fin de la classe
	