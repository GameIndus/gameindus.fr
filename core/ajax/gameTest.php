<?php
ini_set('session.cookie_domain', '.gameindus.fr');
session_start();

require '../../core/config.php';
require '../../core/functions.php';
require '../../core/database.php';

// Init request
$pId = $_SESSION["last_game_id"];

// Init Database       
$DB = new Database();
$DB->connect(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);
$project = $DB->findFirst(array('table' => 'projects', 'conditions' => array('id' => $pId)));

if (!$project) die();
if (!$project->public) die();

$fPId = str_pad($project->editor_id, 4, "0", STR_PAD_LEFT);

$scripts = glob("/home/gameindus/system/projects/$fPId/scripts/*.js");
$fSc = array();

foreach ($scripts as $v) {
    if (basename($v) == "engine.js") continue;
    if (basename($v) == "app.js") continue;

    $fSc[] = basename($v);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test du projet "<?= $project->name ?>"</title>

    <style type="text/css">
        body {
            margin: 0;
            padding: 0
        }
    </style>
</head>
<body>

<canvas id="canvas"></canvas>

<script type="text/javascript" src="https://gameindus.fr:30000/?2d"></script>
<script type="text/javascript">Config.assetsDir = 'https://gameindus.fr/static/<?= $fPId ?>/assets/';</script>
<script type="text/javascript" src="https://gameindus.fr/static/<?= $fPId ?>/scripts/app.js"></script>

<?php foreach ($fSc as $v): ?>
    <script type="text/javascript" src="https://gameindus.fr/static/<?= $fPId ?>/scripts/<?= $v ?>"></script>
<?php endforeach ?>

<script type="text/javascript">
    window.addEventListener('load', function () {
        var cvs = document.getElementById('canvas');
        cvs.style.position = 'absolute';
        cvs.style.left = (window.innerWidth / 2 - cvs.width / 2) + 'px';
        cvs.style.top = (window.innerHeight / 2 - cvs.height / 2) + 'px';
    });
    window.alert = function (text) {
        console.log("[Alert] " + text)
    }
</script>

</body>
</html>