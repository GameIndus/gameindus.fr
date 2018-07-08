<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

session_start();

require '../../Core/config.php';
require '../../Core/database.php';
require '../../Core/functions.php';
$DB = new Database();
$DB->connect(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);

$maxSize = 5;

if (!getUser()) {
    echo(json_encode(((object)array('error' => 'Vous devez être connecté.'))));
    die();
}

$h = getallheaders();
$o = new stdClass();

if (md5($_GET["captcha"]) == $_SESSION["captcha"]) {

    $newId = $DB->count(array('table' => 'bugs')) + 1;
    $source = file_get_contents("php://input");

    if ($h["x-file-size"] > $maxSize * 1000000) {
        $o->error = "Le fichier est trop volumineux (max: {$maxSize}mb) !";
        echo(json_encode($o));
        die();
    }

    $filename = $newId . ".jpg";

    if (file_put_contents("../../imgs/helpcenter/" . $filename, $source)) {
        $o->name = $filename;
    } else {
        $o->error = "Le fichier n'a pas pu être déplacé.";
    }

} else {
    $o->error = "bad_captcha";
}

echo(json_encode($o));
