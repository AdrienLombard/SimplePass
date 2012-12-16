<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
//if( !isset($_GET['key'])) return false;

$key = (isset($_GET['key']))? $_GET['key'] : uniqid() . '-' . rand() * 10;

echo 'plop1';

var_dump(file_get_contents('php://input'));

echo 'plop2';

$filename = $key . '.jpg';
$real = '../../images/photos/tmp/' . $filename;
$full = 'photos/tmp/' . $filename;
$result = file_put_contents($real, file_get_contents('php://input') );

echo 'plop3';

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

echo 'plop4';

print $full;

?>
