<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
ini_set('memory_limit', '-1');

if (!isset($_GET["file"]) || empty($_GET["file"])) die("error");
$filename = "/home/gameindus/system/assets/{$_GET["file"]}";

require "/home/gameindus/site/core/libs/getid3/getid3.php";
$getID3 = new getID3();

$id3_info = $getID3->analyze($filename);

list($t_min, $t_sec) = explode(':', $id3_info['playtime_string']);
$time = ($t_min * 60) + $t_sec;

if (isset($_GET["time"])) {
    echo $time;
    die();
}

$preview = $time / 29; // Preview time of 30 seconds  

$handle = fopen($filename, 'r');
$content = fread($handle, filesize($filename));

$length = strlen($content);

$length = round(strlen($content) / $preview);
$content = substr($content, $length * .66 /* Start extraction ~20 seconds in */, $length);

var_dump($id3_info['mime_type']);
var_dump($length);
die();

header("Content-Type: {$id3_info['mime_type']}");
header("Content-Length: {$length}");
print $content;

?>