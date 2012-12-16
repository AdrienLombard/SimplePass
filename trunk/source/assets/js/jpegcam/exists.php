<?php

if(!$file = $_GET['file'])
    die('0');
else
{
    $base = dirname(dirname(dirname(__FILE__)));
    $file = $base . '/images/' . $file;
    $res = file_exists($file) ? '1' : '0';
    die($res);
}