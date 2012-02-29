<?php

if ( ! function_exists('display_tab'))
{
	function display_tab ($tab)
	{
		echo '<pre>';
		echo print_r($tab);
		echo '</pre>';
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