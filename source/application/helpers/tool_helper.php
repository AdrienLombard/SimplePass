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