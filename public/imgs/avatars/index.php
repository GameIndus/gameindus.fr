<?php
$username = (isset($_GET['username']) && !empty($_GET['username'])) ? $_GET['username'] : null;
if ($username == null) die();

define('BASE', 'http://gameindus.fr/');

error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
ini_set('memory_limit', '-1');

require '../../core/config.php';
require '../../core/database.php';
require '../../core/Controller.php';
require '../../core/functions.php';

// Init Database
$DB = new Database();
$DB->connect(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);

$user = $DB->findFirst(array('table' => 'users', 'conditions' => array('username' => addslashes(htmlentities($username)))));

$file = basename($user->avatar);
$ext = preg_split("/\./", $file)[1];

if (!@imagecreatefromjpeg($file)) {
    $ext = "png";

    if (!@imagecreatefrompng($file)) $ext = "gif";
}


if ($ext == "jpg") {

    $image = imagecreatefromjpeg($file);
    header('Content-Type: image/jpeg');
    imagejpeg($image);
    imagedestroy($image);

} else if ($ext == "png") {

    $image = imagecreatefrompng($file);
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);

} else if ($ext == "gif") {

    $image = imagecreatefromgif($file);
    header('Content-Type: image/gif');
    imagegif($image);
    imagedestroy($image);

}
?>