<?php

if ( ! function_exists('resizeWidthRatio'))
{
	// redim une image suivant une largeur en conservant le ratio
	function resizeWidthRatio($url, $w) {
		
		$src = imagecreatefromjpeg($url);
		$h = $w * imagesy($src) / imagesx($src);
		$img = imagecreatetruecolor($w, $h);
		imagecopyresampled($img, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
		unlink($url);
		imagejpeg($img, $url, 100);
		
	}
}

if ( ! function_exists('resizeHeightRatio'))
{
	// redim une image suivant une largeur en conservant le ratio
	function resizeHeightRatio($url, $h) {
		
		$src = imagecreatefromjpeg($url);
		$w = $h * imagesx($src) / imagesy($src);
		$img = imagecreatetruecolor($w, $h);
		imagecopyresampled($img, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
		unlink($url);
		imagejpeg($img, $url, 100);
		
	}
}

if ( ! function_exists('resize'))
{
	// redim une image
	function resize($url, $w, $h) {
		
		$src = imagecreatefromjpeg($url);
		$img = imagecreatetruecolor($w, $h);
		imagecopyresampled($img, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
		unlink($url);
		imagejpeg($img, $url, 100);
		
	}
}
	
if ( ! function_exists('crop'))
{
	// crop une image
	function crop($url, $x, $y, $w, $h) {
		
		$src = imagecreatefromjpeg($url);	
		$img = imagecreatetruecolor(IMG_WIDTH, IMG_HEIGHT);
		imagecopyresampled($img, $src, 0, 0, $x, $y, IMG_WIDTH, IMG_HEIGHT, $w, $h);
		imagejpeg($img, $url, 100);
		
	}
}

?>
