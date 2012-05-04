<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */

if(!isset($_GET['key']))
    die('Aucune clé pour l\'upload.');

$filename = date('YmdHis') . '.jpg';
$filename = $_GET['key'] . '.jpg';
$real = '../../images/photos/tmp/' . $filename;
$full = 'photos/tmp/' . $filename;
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

print $full;

?>
