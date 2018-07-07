<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

session_start();


$config = json_decode(file_get_contents('../../config.json'));

require '../../core/functions.php';
require '../../core/database.php';

if (!getUser()) {
    echo(json_encode(((object)array('error' => 'Vous devez être connecté.'))));
    die();
}

$currentProjectId = $_SESSION['user']->currentProjectId;

$DB = new Database();
$DB->connect($config->database->host, $config->database->user, $config->database->password, $config->database->database);

$currentProject = $DB->findFirst(array(
    'table' => 'projects',
    'conditions' => array('id' => $currentProjectId)
));
if (empty($currentProject)) die(json_encode(((object)array('error' => 'Les informations du projet sont incorrectes.'))));

$maxSize = 5;

if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

$h = getallheaders();
$o = new stdClass();

$source = file_get_contents("php://input");
$user = getUser();
$filename = $currentProjectId . ".jpg";

if ($source == null || !$h["x-file-size"]) {
    if (unlink("../../imgs/projects/" . $filename)) {
        $o->name = $filename;
        $DB->save(array("table" => "projects", "where" => "id", "wherevalue" => $currentProject->id, "fields" => array("image" => "/imgs/projects/unknown.png")));
    } else {
        $o->error = "Le fichier n'a pas pu être supprimé.";
    }

    echo(json_encode($o));
    die();
}

if ($h["x-file-size"] > $maxSize * 1000000) {
    $o->error = "Le fichier est trop volumineux (max: {$maxSize}mb) !";
    echo(json_encode($o));
    die();
}


if (file_put_contents("../../imgs/projects/" . $filename, $source)) {
    $o->name = $filename;
} else {
    $o->error = "Le fichier n'a pas pu être déplacé.";
}


echo(json_encode($o));
