<?php
$username = $_POST['sended'];

require '../../core/config.php';
require '../../core/database.php';
$DB = new Database();
$DB->connect(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);

$search = $DB->find(array(
    'table' => 'users',
    'likename' => 'username',
    'like' => $username
));

$users = array();

foreach ($search as $v) {
    $user = new StdClass();

    $user->id = $v->id;
    $user->username = $v->username;
    $user->avatar = $v->avatar;

    $users[] = $user;
}

echo(json_encode($users));
die();
