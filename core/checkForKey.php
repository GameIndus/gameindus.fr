<?php
require 'config.php';
require 'database.php';

// Init Database
$DB = new Database();
$DB->connect(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);

$postedKey = addslashes(htmlentities(($_POST['key'])));
$keys = $DB->find(array('table' => 'dev_keys'));
$key = false;

foreach ($keys as $v) {
    if ($v->devKey == $postedKey)
        $key = $v;
}

if (!$key) die('error');
if ($key) {
    if ($key->used) die('used');
    else die('free');
}
