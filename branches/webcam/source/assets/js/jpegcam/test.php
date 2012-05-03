<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */

$filename = date('YmdHis') . '.jpg';
$real = '../../images/photos/tmp/' . $filename;
$result = file_put_contents($real, file_get_contents('php://input') );

$w = 160;
$h = 204;
$src = imagecreatefromjpeg($real);
$img = imagecreatetruecolor($w, $h);
imagecopyresampled($img, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
unlink($real);
imagejpeg($img, $real, 100);

if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $real;
print "$url";

?>
