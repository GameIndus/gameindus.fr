<?php
session_start();
$currentProjectEditorId = $_SESSION['user']->currentProject;
$maxSize = 2000000;

require '../../core/config.php';
require '../../core/database.php';
$DB = new Database();
$DB->connect(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);

$currentProject = $DB->findFirst(array(
    'table' => 'projects',
    'conditions' => array('editor_id' => $currentProjectEditorId)
));

if (empty($currentProject)) die("bad_project_infos");
$currentProjectId = $currentProject->id;

$dir = '/home/gameindus/site/imgs/projects/';
$file = $_FILES['imageProject'];
$type = preg_split('/\//', $file['type']);
$ext = preg_split('/\./', $file['name'])[1];

if ($file == null) die('error');

if (count($type) > 0 && $type[0] == 'image') {
    if ($file['error'] == 0) {
        if ($file['size'] > 0) {
            if (move_uploaded_file($file['tmp_name'], $dir . $currentProjectId . '.jpg')) {
                $projSave = $DB->save(array(
                    'table' => 'projects',
                    'fields' => array('image' => '/imgs/projects/' . $currentProjectId . '.jpg'),
                    'where' => 'id',
                    'wherevalue' => $currentProjectId
                ));

                if ($projSave) {
                    die('ok');
                } else {
                    die('saving_bdd_error');
                }
            } else {
                die('saving_error');
            }
        } else {
            die('too_big_small');
        }
    } else {
        die('error_in_file: #' . $file["error"]);
    }
} else {
    die('bad_format');
}

?>