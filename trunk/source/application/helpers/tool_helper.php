<?php

if ( ! function_exists('display_tab'))
{
	function display_tab ($tab)
	{
		echo '<pre>';
		echo print_r($tab);
		echo '</pre>';
		die('FIN');
	}
}

if ( ! function_exists('repeat'))
{
	function repeat($str, $occur)
	{
		for($i=0;$i<$occur;$i++)
			echo $str;
	}
}

if ( ! function_exists('zoneIsIn'))
{
	function zoneIsIn($zone, $zones)
	{
		foreach($zones as $z)
			if($z->idzone == $zone->idzone)
				return true;
		return false;
	}
}


if ( ! function_exists('hexaToRGB'))
{
	/**
	 * fonction qui convertie une chaine hexadecimal de couleur en composante RGB.
	 * @param $hexa la chaine hexa de la couleur.
	 * @return un objet qui contient la composante rgb ou null si la chaine hexa est non valide.
	 */
	function hexaToRGB( $hexa ) {
		
		if(strlen($hexa) != 6 or empty($hexa)) {
			return null;
		}
		else {
			$trad = Array(
				'0' => 0,
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
				'9' => 9,
				'a' => 10,
				'A' => 10,
				'b' => 11,
				'B' => 11,
				'c' => 12,
				'C' => 12,
				'D' => 13,
				'd' => 13,
				'E' => 14,
				'e' => 14,
				'F' => 15,
				'f' => 15
			);
			
			
			$chaine = str_split($hexa);
			
			$rgb->red 	= $trad[$chaine[0]]*16 + $trad[$chaine[1]];
			$rgb->green	= $trad[$chaine[2]]*16 + $trad[$chaine[3]];
			$rgb->blue 	= $trad[$chaine[4]]*16 + $trad[$chaine[5]];
			
			return $rgb;
		}
	}
	
	
	
	
	
	
}













