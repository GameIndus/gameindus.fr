<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

namespace GameIndus\Controller;

use GameIndus\Core\Controller;
use GameIndus\Lib\ImageManipulator;

class ProjectController extends Controller
{

    private $projectTypes = array(
        'adventure' => 'Aventure',
        'arcade' => 'Arcade',
        'cards' => 'Jeu de cartes',
        'online' => 'Jeu en ligne',
        'fps' => 'Jeu de tir (1ère personne)',
        'tps' => 'Jeu de tir (3ème personne)',
        'minigame' => 'Mini-jeu',
        'plateformer' => 'Plateforme',
        'rpg' => 'RPG',
        'simulation' => 'Jeu de simulation',
        'strategy' => 'Jeu de stratégie',
        'other' => 'Autre'
    );

    public function index($id)
    {
        if (empty($id)) redirect("account");
        $userSession = getUser();

        if (strpos($id, "-") !== false) $id = explode("-", $id)[0];

        $project = $this->DB->findFirst(array(
            'table' => 'projects',
            'conditions' => array('id' => $id)
        ));

        // Data from comments section
        if (isPost() && getPost("comment") != null && getUser()) {
            $user = getUser();
            $comment = addslashes(htmlentities(getPost("comment")));

            $this->DB->save(array(
                "table" => "projects_comments",
                "fields" => array(
                    "comment" => $comment,
                    "user_id" => $user->id,
                    "project_id" => $project->id
                )
            ));

            setNotif("Votre commentaire a bien été posté !");
            redirect("/project/{$project->id}#comments");
        }

        // Print project view page
        if (!$project) redirect("/");
        $project->author = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $project->owner_id)));

        $users = array();
        $adminusers = preg_split('/,/', $project->adminusers_id);

        foreach (preg_split('/,/', $project->users_id) as $v) {
            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $v)));

            if ($user) {
                $users[] = $user;
            }
        }

        /*if (strpos($project->users_id, ',') === false)
            $users = (Object)array('0' => $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $project->users_id))));*/

        $project->users = $users;
        $project->gameType = $this->projectTypes[$project->type];
        $project->comments = $this->DB->req("
			SELECT *, projects_comments.id AS id, users.username AS comment_username
			FROM projects_comments 
			INNER JOIN users ON projects_comments.user_id = users.id 
			WHERE projects_comments.project_id = {$project->id}
			ORDER BY date DESC");

        if (getUser()) {
            $project->userFollow = $this->DB->findFirst(array("table" => "users_projectsliked", "conditions" => array("user_id" => getUser()->id, "project_id" => $project->id)));
            $project->currentRequest = $this->DB->findFirst(array("table" => "projects_invitations", "conditions" => array("user_id" => getUser()->id, "project_id" => $project->id, "origin" => 1, "accepted" => 0)));
        }

        $this->setTitle('Projet "' . $project->name . '" par ' . $project->author->username);

        $this->set($project);
    }

    public function view($id)
    {
        if (empty($id)) redirect("/");
        $userSession = getUser();

        if (strpos($id, "-") !== false) $id = explode("-", $id)[0];

        $project = $this->DB->findFirst(array(
            'table' => 'projects',
            'conditions' => array('id' => $id)
        ));
        if (!$project || !isMemberOfProject($project, $userSession)) {
            redirect('/project/' . $id);
        }

        $users = array();
        $adminusers = preg_split('/,/', $project->adminusers_id);
        $project->gameType = $this->projectTypes[$project->type];
        $project->likes = $this->DB->count(array("table" => "users_projectsliked", "conditions" => array("project_id" => $project->id)));

        foreach (preg_split('/,/', $project->users_id) as $v) {
            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $v)));
            $users[] = $user;
        }

        if (strpos($project->users_id, ',') === false)
            $users = (Object)array('0' => $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $project->users_id))));

        $this->set((Object)array('users' => $users, 'project' => $project, 'adminusers' => $adminusers));
    }

    public function create()
    {
        privatePage();
        $user = getUser();

        if (isPost()) {
            $post = getPost();

            $name = addslashes(htmlentities($post->name));
            $description = addslashes($post->description);
            $engine = "2D";
            $type = addslashes(htmlentities($post->type));
            $public = (isset($post->public) && addslashes(htmlentities($post->public)) == 'on') ? 1 : 0;

            if ($name != "" && $description != "" && $type != "") {
                // Dynamic editor_ID
                $projs = $this->DB->find(array('table' => 'projects', 'order' => 'editor_id ASC'));
                $eID = -1;

                $i = 1;
                foreach ($projs as $v) {
                    if ($v->editor_id != $i) {
                        $eID = $i;
                        break;
                    }
                    $i++;
                }
                if ($eID == -1) $eID = count($projs) + 1;

                $projSave = $this->DB->save(array(
                    'insert' => true,
                    'table' => 'projects',
                    'fields' => array(
                        'name' => $name,
                        'description' => $description,
                        'engine' => $engine,
                        'type' => $type,
                        'owner_id' => $user->id,
                        'users_id' => $user->id,
                        'adminusers_id' => $user->id,
                        'public' => $public,
                        'editor_id' => $eID
                    )
                ));

                if ($projSave) {
                    setNotif("Le projet a bien été créé !");
                } else {
                    setNotif("Le projet n'a pas pu être créé.", "danger");
                }

                @header('Location: /account/projects');
                die();
            } else {
                setNotif("Un des champs a mal été rempli.", "danger");
                @header('Location: /project/create');
                die();
            }
        }

        $this->set($this->projectTypes);
    }


    public function editor($id)
    {
        privatePage();
        if (empty($id)) redirect("account");

        $userSession = getUser();
        $token = uniqid();

        $project = $this->DB->findFirst(array(
            'table' => 'projects',
            'conditions' => array('id' => $id)
        ));

        if (empty($userSession)) redirect('/index');
        if (empty($project)) redirect('/account/projects');
        if (!isMemberOfProject($project, $userSession)) redirect('/account/projects');

        $projectId = $project->editor_id;
        sendCredentials($token, $projectId);

        function cryptWithKey($data, $key256, $passphrase)
        {
            // TODO This method seems to be depreacated since PHP 7.1.0 ...
            $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = $passphrase;

            mcrypt_generic_init($cipher, $key256, $iv);
            $cipherText256 = mcrypt_generic($cipher, $data);

            mcrypt_generic_deinit($cipher);
            $cipherHexText256 = bin2hex($cipherText256);

            return $cipherHexText256;
        }

        $_SESSION['project'] = $project;
        $_SESSION["user"]->auth = (object)array(
            "token" => cryptWithKey($token, $this->config->auth->key, $this->config->auth->passphrase),
            "projectId" => $projectId
        );

        @header('Location: /editor');
        die();
    }

    public function edit($id)
    {
        privatePage();
        if (empty($id)) redirect("account");

        $userSession = getUser();

        $project = $this->DB->findFirst(array(
            'table' => 'projects',
            'conditions' => array('id' => $id)
        ));

        if (empty($project)) redirect("/account/projects");

        if (!memberIsAdmin($project, $userSession)) {
            setNotif('Vous devez être administrateur afin de modifier les options du projet.', 'danger');
            redirect('/project/' . $id . "/view");
        }

        $users = array();
        $adminusers = preg_split('/,/', $project->adminusers_id);

        foreach (preg_split('/,/', $project->users_id) as $v) {
            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $v)));
            $users[] = $user;
        }

        if (!empty($_SESSION['user'])) $_SESSION['user']->currentProjectId = $id;
        // Save infos (when data is posted)
        if (isPost()) {
            $post = getPost();

            $description = addslashes($post->description);
            $engine = "2D";
            $type = addslashes(htmlentities($post->type));
            $public = (isset($post->public) && addslashes(htmlentities($post->public)) == 'on') ? 1 : 0;
            $allowJoins = (isset($post->allowjoins) && addslashes(htmlentities($post->allowjoins)) == 'on') ? 1 : 0;

            $fields = array(
                'description' => $description,
                'engine' => $engine,
                'type' => $type,
                'public' => $public,
                'authorize_joins' => $allowJoins
            );

            if (isset($post->imageUpload))
                $fields["image"] = addslashes(htmlentities($post->imageUpload));

            if ($description == "") {
                setNotif("La description ne peut pas être vide.", "danger");
                @header('Location: /project/' . $id . '/edit');
                die();
            }

            $projSave = $this->DB->save(array(
                'table' => 'projects',
                'fields' => $fields,
                'where' => 'id',
                'wherevalue' => $project->id
            ));

            if ($projSave) {
                setNotif("Les informations du projet ont bien été modifiées.");
                $project = $this->DB->findFirst(array(
                    'table' => 'projects',
                    'conditions' => array('id' => $id)
                ));
            } else {
                setNotif("Les informations n'ont pas pu être enregistrées.", "danger");
            }
        }

        $project->types = $this->projectTypes;

        $this->set((object)array("users" => $users, "project" => $project));
    }

    public function members($id)
    {
        privatePage();
        if (empty($id)) redirect("account");

        $userSession = getUser();

        $project = $this->DB->findFirst(array(
            'table' => 'projects',
            'conditions' => array('id' => $id)
        ));

        if (empty($project)) redirect("/account/projects");

        if (!isMemberOfProject($project, getUser())) {
            setNotif('Vous ne pouvez pas afficher cette page.', 'danger');
            redirect('/project/' . $id . "/view");
        }

        $users = array();

        foreach (preg_split('/,/', $project->users_id) as $v) {
            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $v)));
            $users[] = $user;
        }

        if (!empty($_SESSION['user'])) $_SESSION['user']->currentProjectId = $id;

        $requests = $this->DB->req("SELECT * FROM projects_invitations INNER JOIN users ON projects_invitations.user_id = users.id WHERE project_id = {$project->id} AND accepted = 0 AND origin = 1 ORDER BY date DESC LIMIT 0,3");

        $project->types = $this->projectTypes;
        $this->set((object)array("users" => $users, "project" => $project, "requests" => $requests));
    }

    public function useraction($id)
    {
        $action = getGet("a");
        $userId = getGet("uid");
        $user = getUser();

        $baseUrl = "/project/$id/members";

        if (empty($user)) redirectWithNotif("/", "Vous devez être connecté pour pouvoir executer cette action", "danger");
        if (!is_numeric($userId)) redirectWithNotif($baseUrl, "Paramètres incorrects. Veuillez réessayer.", "danger");

        $project = $this->DB->findFirst(array('table' => 'projects', 'conditions' => array('id' => $id)));
        if (empty($project)) redirectWithNotif($baseUrl, "Projet inexistant. Veuillez réessayer.", "danger");

        function permissionDenied($projId)
        {
            redirectWithNotif("/project/$projId/members", "Vous n'avez pas les droits d'effectuer cette action.", "danger");
        }

        if ($action == "rlink") $action = "uwj";

        switch ($action) {
            case "uto":
                if (!memberIsOwner($project, $user) || $user->id == $userId) permissionDenied($id);

                $this->DB->save(array("table" => 'projects', 'fields' => array('owner_id' => $userId), 'where' => 'id', 'wherevalue' => $id));
                redirectWithNotif($baseUrl, "Cet utilisateur est maintenant chef de projet. Vous avez donc perdu votre grade.", "success");
                break;
            case "uta":
                if (!memberIsAdmin($project, $user) || $user->id == $userId) permissionDenied($id);

                $oldAdmins = explode(",", $project->adminusers_id);
                array_push($oldAdmins, $userId);
                $newAdmins = implode(",", $oldAdmins);

                $this->DB->save(array("table" => 'projects', 'fields' => array('adminusers_id' => $newAdmins), 'where' => 'id', 'wherevalue' => $id));
                redirectWithNotif($baseUrl, "Cet utilisateur est maintenant Administrateur.", "success");
                break;
            case "dtm":
                if (!memberIsAdmin($project, $user) || $user->id == $userId) permissionDenied($id);

                $newAdmins = implode(",", array_diff(explode(",", $project->adminusers_id), [$userId]));
                $this->DB->save(array("table" => 'projects', 'fields' => array('adminusers_id' => $newAdmins), 'where' => 'id', 'wherevalue' => $id));
                redirectWithNotif($baseUrl, "Cet utilisateur est maintenant Membre.", "success");
                break;
            case "eu":
                if (!memberIsAdmin($project, $user) || $user->id == $userId) permissionDenied($id);

                $newUsers = implode(",", array_diff(explode(",", $project->users_id), [$userId]));
                $newAdmins = implode(",", array_diff(explode(",", $project->adminusers_id), [$userId]));

                $this->DB->save(array("table" => 'projects', 'fields' => array('users_id' => $newUsers, 'adminusers_id' => $newAdmins), 'where' => 'id', 'wherevalue' => $id));
                redirectWithNotif($baseUrl, "Cet utilisateur a bien été exclu du projet.", "success");
                break;
            case "uwj":
                if (isMemberOfProject($project, $user) || $user->id != $userId)
                    redirectWithNotif("/project/{$project->id}", "Vous n'avez pas les droits d'effectuer cette action.", "danger");
                if (!$project->authorize_joins)
                    redirectWithNotif("/project/{$project->id}", "Ce projet n'accepte pas de nouvelles demandes.", "danger");

                $exists = $this->DB->findFirst(array("table" => "projects_invitations", "conditions" => array("user_id" => $user->id, "project_id" => $project->id, "origin" => 1, "accepted" => 0)));

                if ($exists)
                    redirectWithNotif("/project/{$project->id}", "Vous avez déjà effectué une demande pour ce projet.", "danger");

                $this->DB->save(array("table" => "projects_invitations", "fields" => array(
                    "origin" => 1,
                    "user_id" => $user->id,
                    "project_id" => $project->id
                )));

                redirectWithNotif("/project/{$project->id}", "Votre demande a bien été envoyée. Elle pourra être acceptée ou refusée par le chef du projet.", "success");
                break;
            case "aur":
                if (!memberIsAdmin($project, $user) || $user->id == $userId) permissionDenied($id);
                if (in_array($userId, explode(",", $project->users_id)))
                    redirectWithNotif("/project/{$project->id}/members", "Ce membre fait déjà parti du projet.", "danger");

                $request = $this->DB->findFirst(array("table" => "projects_invitations", "conditions" => array("project_id" => $project->id, "user_id" => $userId, "origin" => 1, "accepted" => 0)));

                if (!$request)
                    redirectWithNotif("/project/{$project->id}/members", "Cette requête n'existe pas. Veuillez contacter un administrateur.", "danger");

                $oldUsers = explode(",", $project->users_id);
                array_push($oldUsers, $userId);
                $newUsers = implode(",", $oldUsers);

                $this->DB->save(array("table" => "projects_invitations", "fields" => array("accepted" => 1, "project_action_date" => date('Y-m-d H:i:s', time())), "where" => "id", "wherevalue" => $request->id));
                $this->DB->save(array("table" => "projects", "fields" => array("users_id" => $newUsers), "where" => "id", "wherevalue" => $project->id));

                redirectWithNotif("/project/{$project->id}/members", "Ce membre fait maintenant parti du projet. Bonne création !", "success");
                break;
            case "rur":
                if (!memberIsAdmin($project, $user) || $user->id == $userId) permissionDenied($id);
                if (in_array($userId, explode(",", $project->users_id)))
                    redirectWithNotif("/project/{$project->id}/members", "Ce membre fait déjà parti du projet.", "danger");

                $request = $this->DB->findFirst(array("table" => "projects_invitations", "conditions" => array("project_id" => $project->id, "user_id" => $userId, "origin" => 1, "accepted" => 0)));

                if (!$request)
                    redirectWithNotif("/project/{$project->id}/members", "Cette requête n'existe pas. Veuillez contacter un administrateur.", "danger");

                $this->DB->save(array("table" => "projects_invitations", "fields" => array("accepted" => 2, "project_action_date" => date('Y-m-d H:i:s', time())), "where" => "id", "wherevalue" => $request->id));

                redirectWithNotif("/project/{$project->id}/members", "Vous venez de rejeter cette demande.", "success");
                break;
        }

        setNotif("Action inexistante. Veuillez contacter un administrateur.", "danger");
        redirect($baseUrl);
    }

    public function delete($id)
    {
        privatePage();
        $user = getUser();

        // Check if projet owner is the connected user
        $project = $this->DB->findFirst(array(
            'table' => 'projects',
            'conditions' => array('id' => $id)
        ));
        if (!$project) {
            setNotif("Vous ne pouvez pas supprimer ce projet.", "danger");
            redirect("/account/projects");
        }

        $projUser = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $project->owner_id)));
        if (!$projUser || $projUser->id != $user->id) {
            setNotif("Vous ne pouvez pas supprimer ce projet.", "danger");
            redirect("/account/projects");
        }

        // $this->DB->save(array(
        // 	'table' => 'projects',
        // 	'fields' => array('removed' => 1),
        // 	'where' => 'id',
        // 	'wherevalue' => $id
        // ));
        $this->DB->delete(array(
            'table' => 'projects',
            'where' => 'id',
            'wherevalue' => $id
        ));

        // Send message to main server to delete files in /home/gameindus/system/projects/...
        $formattedId = str_pad($project->editor_id, 4, "0", STR_PAD_LEFT);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://127.0.0.1/');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('blabla'));
        curl_setopt($ch, CURLOPT_PORT, 20001);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $data = array('action' => 'delete', 'PID' => $formattedId);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $ctn = curl_exec($ch);
        curl_close($ch);

        setNotif("Projet supprimé avec succès !");
        redirect("/account/projects");
    }


    public function asset($id)
    {
        if (empty($_SESSION) && isset($_GET["t"])) {
            session_destroy();
            session_id($_GET["t"]);
            session_start();
        }

        $asset = $_GET["-"];
        if ($asset == null || empty($asset)) redirect("/");
        if ($id == null || empty($id)) redirect("/");

        $proj = $this->DB->findFirst(array("table" => "projects", "conditions" => array("editor_id" => $id)));
        if ($proj == null || empty($proj)) redirect("/");

        function printAsset($id, $asset)
        {
            $file = "/home/gameindus/system/projects/" . str_pad($id, 4, "0", STR_PAD_LEFT) . "/assets/$asset";

            if (!file_exists($file)) {
                header("HTTP/1.0 404 Not Found");

                die();
                exit;
            }
            header('Content-Type: ' . get_mime_type($file));
            header('Content-Length: ' . filesize($file));
            readfile($file);

            exit;
        }

        if (!$proj->public) {
            $user = getUser();
            if ($user == null || empty($user)) redirect('/');

            if (isMemberOfProject($proj, $user))
                printAsset($proj->editor_id, $asset);
            else
                redirect("/");
        } else {
            printAsset($proj->editor_id, $asset);
        }
    }

    public function preview($params)
    {
        $id = $params[0];
        $width = $params[1];
        $height = $params[2];

        if (empty($id) || empty($width) || empty($height)) redirect("/");

        $file = ROOT . DS . 'imgs' . DS . 'projects' . DS . $id . '.jpg';
        $cfile = ROOT . DS . 'imgs' . DS . 'cropped' . DS . "project{$id}-{$width}x{$height}.jpg";

        function getTime($path)
        {
            clearstatcache($path);
            $dateUnix = shell_exec('stat --format "%y" ' . $path);
            $date = explode(".", $dateUnix);
            return filemtime($path) . "." . substr($date[1], 0, 8);
        }

        if (!file_exists($file) || $id == "noimage")
            $file = ROOT . DS . 'imgs' . DS . 'projects' . DS . 'unknown.jpg';

        // Check if file already exists
        $diff = 0;
        $expires = 60 * 5;
        if (file_exists($cfile)) {
            $lastModifTime = getTime($cfile);
            $diff = time() - $lastModifTime;

            if ($diff <= $expires) {
                header('Content-Type: ' . get_mime_type($cfile));
                header('Content-Length: ' . filesize($cfile));
                readfile($cfile);

                die();
            }
        }

        require SRC . DS . 'Lib/ImageManipulator.php';

        $im = new ImageManipulator($file);
        // $centreX = round($im->getWidth() / 2);
        // $centreY = round($im->getHeight() / 2);

        // $x1 = $centreX - $width / 2;
        // $y1 = $centreY - $height / 2;

        // $x2 = $centreX + $width / 2;
        // $y2 = $centreY + $height / 2;

        // $im->crop($x1, $y1, $x2, $y2);
        $im->resample($width, $height, true);

        $im->save($cfile);

        header('Content-Type: ' . get_mime_type($cfile));
        header('Content-Length: ' . filesize($cfile));
        readfile($cfile);
    }

    public function download($id)
    {
        if ($id == null || empty($id)) redirect("/");
        if (!getUser()) redirect("/");

        // Temp dev 0.2
        if (!isPremium(getUser())) redirect("/account");

        $proj = $this->DB->findFirst(array("table" => "projects", "conditions" => array("editor_id" => $id)));
        if ($proj == null || empty($proj)) redirect("/");

        $users = explode(",", $proj->users_id);
        if (!in_array(getUser()->id, $users)) redirect("/");

        function downloadZip($id)
        {
            $file = "/home/gameindus/system/projects/" . str_pad($id, 4, "0", STR_PAD_LEFT) . "/export.zip";

            if (!file_exists($file)) {
                header("HTTP/1.0 404 Not Found");
                die();
            }

            header('Content-Type: ' . get_mime_type($file));
            header('Content-Length: ' . filesize($file));
            header('Content-Disposition: attachment; filename=' . basename($file));

            readfile($file);

            unlink($file);
            exit;
        }

        downloadZip($id);
    }

}
