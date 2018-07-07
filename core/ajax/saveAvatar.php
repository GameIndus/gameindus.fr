<?php
session_start();

require '../../core/config.php';
require '../../core/functions.php';

$maxSize = 5;

if (!getUser()) {
    echo(json_encode(((object)array('error' => 'Vous devez être connecté.'))));
    die();
}

$h = getallheaders();
$o = new stdClass();

$source = file_get_contents("php://input");
$user = getUser();

if ($h["x-file-size"] > $maxSize * 1000000) {
    $o->error = "Le fichier est trop volumineux (max: {$maxSize}mb) !";
    echo(json_encode($o));
    die();
}

$filename = $user->id . ".jpg";

if (file_put_contents("../../imgs/avatars/" . $filename, $source)) {
    $o->name = $filename;
} else {
    $o->error = "Le fichier n'a pas pu être déplacé.";
}


echo(json_encode($o));
?>