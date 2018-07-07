<?php
session_start();

require '../../core/config.php';
require '../../core/database.php';
require '../../core/functions.php';
$DB = new Database();
$DB->connect(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);

$maxSize = 5;

if (!getUser() || !isPremium(getUser())) {
    echo(json_encode(((object)array('error' => 'Vous devez être connecté (et être premium).'))));
    die();
}

$filenames = $DB->find(array('table' => 'assets', 'fields' => 'filename'));
$filenamesArr = array();
foreach ($filenames as $v) $filenamesArr[] = $v->filename;

$h = getallheaders();
$o = new stdClass();
$source = file_get_contents("php://input");

if ($h["x-file-size"] > $maxSize * 1000000) {
    $o->error = "Le fichier est trop volumineux (max: {$maxSize}mb) !";
    echo(json_encode($o));
    die();
}

$s = explode('.', $h["x-file-name"]);
$ext = $s[count($s) - 1];
$randomName = generateRandomString(10);

while (in_array($randomName, $filenamesArr)) $randomName = generateRandomString(10);

$filename = $randomName . "." . $ext;

if (file_put_contents("../../../system/assets/" . $filename, $source)) {
    $o->name = $filename;
} else {
    $o->error = "Le fichier n'a pas pu être déplacé.";
}

echo(json_encode($o));
?>