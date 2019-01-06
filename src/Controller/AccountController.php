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

class AccountController extends Controller
{

    public function index()
    {
        privatePage();
        $this->setTitle('Mon compte');

        if (isset($_GET['logout'])) {
            unset($_SESSION['user']);
            header('Location: ' . BASE);
            die();
        }

        $user = clone getUser();
        $user->projects = $this->DB->find(array("table" => "projects", "conditions" => array("owner_id" => $user->id)));

        $sql = "SELECT *, projects.name AS projectname, projects.id AS projectid FROM users_projectsliked
				INNER JOIN projects ON users_projectsliked.project_id = projects.id 
				INNER JOIN users ON projects.owner_id = users.id
				WHERE users_projectsliked.user_id = :user_id ORDER BY date_liked DESC LIMIT 0,3";

        $user->projectsFollowed = $this->DB->req($sql, array('user_id' => $user->id));
        $user->todayWheelTrial = $this->DB->findFirst(array("table" => "users_wheeltrials", "fields" => array('win', 'date'), "conditions" => array("user_id" => $user->id, "date" => date("Y-m-d", time()))));

        if ($user->friend_key_activated) {
            $fKey = $this->DB->findFirst(array("table" => "dev_keys", "conditions" => array("generated_by" => $user->id)))->devKey;
            $fKeyFormatted = substr($fKey, 0, 4) . "-" . substr($fKey, 4, 4) . "-" . substr($fKey, 8, 4) . "-" . substr($fKey, 12, 4);
            $user->friend_key = $fKeyFormatted;
        }

        $this->set($user);
    }

    public function edit()
    {
        privatePage();
        $this->setTitle('Editer mon compte');

        $user = getUser();

        if (isPost()) {
            $post = getPost();

            $bio = addslashes(htmlentities($post->bio));
            $website = addslashes(htmlentities($post->website));
            $twitter_username = addslashes(htmlentities($post->twitter_username));
            $password = addslashes(htmlentities($post->password));
            $password2 = addslashes(htmlentities($post->password2));
            $avatar = null;
            $newsletter = 0;

            if (isset($post->newsletter))
                if (addslashes(htmlentities($post->newsletter)) == "on")
                    $newsletter = 1;
            if (isset($post->avatarUpload))
                $avatar = addslashes(htmlentities($post->avatarUpload));

            $fields = array(
                'bio' => $bio,
                'newsletter' => $newsletter,
                'website' => $website,
                'twitter_username' => $twitter_username
            );

            if (!empty($password)) {
                if ($password == $password2) {
                    $fields['password'] = sha1($password);
                } else {
                    setNotif("Les mots de passe envoyés ne correspondent pas.", "danger");
                    redirect("/account/edit");
                }
            }
            if ($avatar != NULL)
                $fields['avatar'] = $avatar;

            $userSaved = $this->DB->save(array(
                'table' => 'users',
                'fields' => $fields,
                'where' => 'id',
                'wherevalue' => $user->id
            ));

            if ($userSaved) {
                $user->bio = $bio;
                $user->newsletter = $newsletter;
                $user->website = $website;
                $user->twitter_username = $twitter_username;
                if ($avatar != null) $user->avatar = $avatar;

                setNotif("Les informations ont bien été modifiées.");
            } else {
                setNotif("Une erreur est survenue lors de la sauvegarde des informations.", "danger");
            }
        }

        $this->set($user);
    }

    public function badges()
    {
        privatePage();
        $this->setTitle('Mes badges');

        $user = getUser();

        // Get badges
        $sql = "SELECT * FROM users_completedbadges
				INNER JOIN users_badges ON users_completedbadges.badge_id = users_badges.id 
				WHERE users_completedbadges.user_id = :user_id";

        $badges = $this->DB->find(array('table' => 'users_badges'));
        $completedbadges = $this->DB->req($sql, array('user_id' => $user->id));

        foreach ($completedbadges as $v) {
            foreach ($badges as $v2) {
                if ($v->badge_id == $v2->id) {
                    $v2->completed = true;
                }
            }
        }

        $d = $user;
        $d->badges = $badges;

        $this->set($d);
    }

    public function projects()
    {
        privatePage();
        $user = getUser();

        $this->setTitle('Mes projets');

        // userAlreadyConnected error
        if (isset($_GET['err']) && $_GET['err'] == "userAlreadyConnected") {
            setNotif('Un utilisateur est déjà connecté depuis votre adresse IP sur l\'éditeur.', 'danger');
            @header('Location: ' . BASE . 'account/projects');
            die();
        }
        // connectionHackServer error
        if (isset($_GET['err']) && $_GET['err'] == "connectionHackServer") {
            setNotif('Un de nos serveurs est en cours de redémarrage ou vous avez essayé de contourner notre système.<br>Nous nous excusons du dérangement causé.', 'danger');
            @header('Location: ' . BASE . 'account/projects');
            die();
        }

        $projects = array();
        $projectsDB = $this->DB->find(array('table' => 'projects', 'order' => 'date_created DESC'));

        foreach ($projectsDB as $v) {
            $users = preg_split('/,/', $v->users_id);
            $usernames = array();

            foreach (explode(',', $v->users_id) as $w) {
                $curUser = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $w)));
                $usernames[] = $curUser->username;
            }

            $v->users_str = implode(', ', $usernames);
            if (in_array($user->id, $users)) $projects[] = $v;
        }

        // Get invitations
        $invitations = $this->DB->find(array(
            'table' => 'projects_invitations',
            'conditions' => array('user_id' => $user->id)
        ));

        foreach ($invitations as $v) {
            $proj = $this->DB->findFirst(array('table' => 'projects', 'conditions' => array('id' => $v->project_id)));
            $v->project = $proj;
        }

        $d = $user;
        $d->projects = $projects;
        $d->invitations = $invitations;

        $this->set($d);
    }

    public function followproject($id)
    {
        privatePage();

        $project = $this->DB->findFirst(array("table" => "projects", "conditions" => array("id" => $id)));
        if (!$project) redirect("/account");

        $hasAlreadyLiked = $this->DB->findFirst(array("table" => "users_projectsliked", "conditions" => array("user_id" => getUser()->id, "project_id" => $project->id)));

        if ($hasAlreadyLiked) {
            $this->DB->delete(array("table" => "users_projectsliked", "where" => "id", "wherevalue" => $hasAlreadyLiked->id));
        } else {
            $this->DB->save(array(
                "insert" => true,
                "table" => "users_projectsliked",
                "fields" => array(
                    "user_id" => getUser()->id,
                    "project_id" => $project->id
                )
            ));
        }

        redirect("/project/" . $id);
    }

    public function generatefriendkey()
    {
        privatePage();

        $user = getUser();

        if ($user->friend_key_activated) redirect("/account");
        else {
            // Get others keys
            $dbKeys = $this->DB->find(array("table" => "dev_keys", "order" => "id DESC"));
            $keys = array();
            foreach ($dbKeys as $v) $keys[] = $v->devKey;

            // Generate randomly (and exclude keys already generated)
            $curKey = strtoupper(generateRandomString(16));
            while (in_array($curKey, $keys)) {
                $curKey = strtoupper(generateRandomString(16));
            }

            // Update database
            $key = $curKey;
            $this->DB->save(array("table" => "users", "fields" => array("friend_key_activated" => true), "where" => "id", "wherevalue" => $user->id));
            $this->DB->save(array("table" => "dev_keys", "fields" => array("devKey" => $key, "generated_by" => $user->id)));

            // Update session
            $user->friend_key_activated = true;

            setNotif("Votre clé pour inviter un ami a bien été générée !");
            redirect("/account");
        }
    }

    public function wheelprocess()
    {
        $action = getGet("action");
        $user = getUser();
        extract($_GET);

        function returnJson($array)
        {
            die(json_encode((object)$array));
        }

        if ($action == null) returnJson(array("error" => "undefined_action"));
        if ($user == null) returnJson(array("error" => "undefined_user"));

        switch ($action) {
            case "startWheelProcess":
                $hasAlreadyPlayed = $this->DB->findFirst(array("table" => "users_wheeltrials", "conditions" => array("user_id" => $user->id, "date" => date("Y-m-d", time()))));

                if ($hasAlreadyPlayed) returnJson(array("error" => "already_played"));
                if (isPremium($user)) returnJson(array("error" => "user_premium"));

                $probability = floatval($this->DB->findFirst(array("table" => "config", "conditions" => array("configKey" => "wheelProbability")))->configValue);

                $random = rand(0, 100);
                $win = ($random <= $probability * 100);
                $date = date("Y-m-d", time());

                if ($this->DB->count(array("table" => "users_wheeltrials", "conditions" => array("user_id" => $user->id))) <= 5) $win = false;

                $_SESSION["user"]->currentWheelTrial = (object)array(
                    "win" => $win,
                    "date" => $date
                );

                returnJson(array("success" => true, "win" => $win, "date" => $date));
                break;
            case "saveWheelTrial":
                $hasAlreadyPlayed = $this->DB->findFirst(array("table" => "users_wheeltrials", "conditions" => array("user_id" => $user->id, "date" => date("Y-m-d", time()))));

                if ($hasAlreadyPlayed) returnJson(array("error" => "already_played"));
                if (empty($user->currentWheelTrial)) returnJson(array("error" => "unknown_wheeltrial"));
                if (isPremium($user)) returnJson(array("error" => "user_premium"));

                $this->DB->save(array("table" => "users_wheeltrials", "fields" => array(
                    "user_id" => $user->id,
                    "date" => $_SESSION["user"]->currentWheelTrial->date,
                    "win" => ($_SESSION["user"]->currentWheelTrial->win) ? 1 : 0
                )));

                // Give temp rank to the user
                if ($_SESSION["user"]->currentWheelTrial->win) {
                    $time = ($user->premium_finish_date != null) ? strtotime($user->premium_finish_date) : time();
                    if ($time < time()) $time = time();

                    $calculatedDate = date("Y-m-d H:i:s", strtotime("+1 month", $time));

                    $this->DB->save(array("table" => "users", "fields" => array(
                        "premium" => 1,
                        "premium_finish_date" => $calculatedDate
                    ), "where" => "id", "wherevalue" => $user->id));

                    $_SESSION["user"]->premium = 1;
                    $_SESSION["user"]->premium_finish_date = $calculatedDate;
                }

                unset($_SESSION["user"]->currentWheelTrial);

                returnJson(array("success" => true));
                break;
            case "userError":
                if (empty($errorKey)) redirect("/account");
                switch ($errorKey) {
                    case "already_played":
                        redirectWithNotif("/account", "Vous avez déjà tourné la roue aujourd'hui.", "danger");
                    case "undefined_user":
                        redirectWithNotif("/", "Vous devez être connecté pour pouvoir faire cela.", "danger");
                    case "undefined_action":
                        redirectWithNotif("/account", "Action inconnue. Veuillez contacter un administrateur.", "danger");
                    case "unknown_wheeltrial":
                        redirectWithNotif("/account", "Vous devez tourner la roue avant de faire cela.", "danger");
                    case "user_premium":
                        redirectWithNotif("/account", "Vous ne pouvez pas profiter de l'offre en étant déjà premium.", "danger");
                }
                break;
        }
    }


    public function confirm()
    {
        connectPage();
        $this->setTitle('Confirmation de votre compte');

        if (empty($_GET['email']) || empty($_GET['token'])) {
            @header('Location: ' . BASE);
            die();
        }

        if (isPost()) {

            $email = addslashes(htmlentities($_GET['email']));
            $token = addslashes(htmlentities($_GET['token']));
            $password = sha1(addslashes(htmlentities(getPost()->password)));

            $user = $this->DB->findFirst(array(
                'table' => 'users',
                'conditions' => array('email' => $email)
            ));

            if ($user) {
                if ($user->token == $token) {
                    if (!$user->active) {
                        if ($user->password == $password) {
                            $userSave = $this->DB->save(array(
                                'table' => 'users',
                                'fields' => array('active' => 1),
                                'where' => 'id',
                                'wherevalue' => $user->id
                            ));

                            if ($userSave) {
                                setNotif("Votre compte a bien été confirmé. Vous pouvez maintenant vous connecter.");
                                @header("Location: " . BASE . "login");
                                die();
                            } else {
                                setNotif("Il y a eu un problème durant la sauvegarde. Merci de réessayer.", "danger");
                            }
                        } else {
                            setNotif("Mot de passe incorrect.", "danger");
                        }
                    } else {
                        setNotif("Votre compte a déjà été confirmé.", 'danger');
                        @header("Location: " . BASE . "login");
                        die();
                    }
                } else {
                    setNotif("Clé secrète incorrecte. Merci de réessayer.", "danger");
                }
            } else {
                setNotif("Compte introuvable. Merci de réessayer.", "danger");
            }
        }
    }

    public function lostpassword()
    {
        connectPage();
        $this->setTitle('Récupération de mot de passe');

        if (isPost()) {
            $post = getPost();

            $username = addslashes(htmlentities($post->username));
            $email = addslashes(htmlentities($post->email));

            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('username' => $username, 'email' => $email)));

            if ($user) {
                $newPass = generateRandomString(8);
                $date = date('d/m/Y à H:i:s', time());
                $message = "
				Bonjour {$user->username},<br><br>
				une demande de réinitialisation de mot de passe à été effectuée le {$date} (IP: {$_SERVER['REMOTE_ADDR']}).<br>
				Si ce n'est pas vous, nous vous conseillons d'améliorer la sécurité de votre compte.<br><br>
				Dans le cas contraire, vous pouvez dorénavant vous connecter sur GameIndus grâce à ce mot de passe : <b>{$newPass}</b>.<br>
				<br>
				Merci de votre confiance et à bientôt sur GameIndus !
				";

                if (emailTemplate($email, $message, 'Récupération de mot de passe', 'noreply')) {
                    $dbSave = $this->DB->save(array(
                        'table' => 'users',
                        'fields' => array('password' => sha1($newPass)),
                        'where' => 'id',
                        'wherevalue' => $user->id
                    ));

                    if ($dbSave) {
                        setNotif("Le mot de passe a bien été réinitialisé. Vous devrez le recevoir sous peu via e-mail.");
                        redirect("/login");
                    } else {
                        setNotif("Une erreur est survenue : vous avez bien reçu l'email mais le mot de passe n'a pas pu être réinitialisé. Merci de contacter un administrateur.", "danger");
                    }
                } else {
                    setNotif("Nous n'avons pas pu envoyer l'email. Veuillez réessayer.", "danger");
                }
            } else {
                setNotif("Les informations passées sont incorrectes. Veuillez réessayer.", "danger");
            }
        }
    }

    public function active()
    {
        privatePage(true);
        $user = getUser();

        if ($user->active || (!$user->active && !$user->activated_with_premium)) redirect("/account");

        if (isset($_GET["logout"])) {
            unset($_SESSION["user"]);
            redirect("/");
        }

        if (isPost()) {
            $post = getPost();

            $key1 = strval(addslashes(htmlentities($post->key1)));
            $key2 = strval(addslashes(htmlentities($post->key2)));
            $key3 = strval(addslashes(htmlentities($post->key3)));
            $key4 = strval(addslashes(htmlentities($post->key4)));

            $keyPosted = $key1 . $key2 . $key3 . $key4;

            $keys = $this->DB->find(array('table' => 'dev_keys'));
            $key = false;
            foreach ($keys as $v) {
                if ($v->devKey == $keyPosted) $key = $v;
            }

            if ($key) {
                if (!$key->used) { // After all conditions -> register the user
                    // Register key
                    $keySave = $this->DB->save(array(
                        'table' => 'dev_keys',
                        'fields' => array('used' => 1, 'used_by' => $user->username),
                        'where' => 'devKey',
                        'wherevalue' => $key->devKey
                    ));

                    $userSave = $this->DB->save(array(
                        'insert' => false,
                        'table' => 'users',
                        'fields' => array(
                            'active' => 1
                        ),
                        'where' => 'id',
                        'wherevalue' => $user->id
                    ));

                    $_SESSION["user"]->active = true;

                    if ($userSave && $keySave) { // Send e-mail because account is now activated
                        $message = "
							Bonjour, " . $user->username . " !<br><br>
							Félicitations ! Vous venez d'activer votre compte GameIndus. Merci pour votre participation !
							<br>
							Vous avez maintenant accès à l'ensemble des fonctionnalités gratuites de la plateforme. Si vous souhaitez avoir plus de fonctionnalités, nous vous conseillons de soucrire à abonnement Premium mensuel via cette adresse: <a href='https://gameindus.fr/premium'>https://gameindus.fr/premium</a>.
							<br>
							En espérant vous revoir bientôt sur GameIndus ! L'équipe vous souhaite une très bonne création de jeux vidéo.
						";
                        if (emailTemplate($user->email, $message, 'Votre compte vient d\'etre active !', 'noreply')) {
                            setNotif("Activation terminée. Vous avez maintenant accès aux fonctions gratuites de la plateforme.");
                            redirect("/account");
                        } else {
                            setNotif("L'email n'a pas pu vous être envoyé. Merci de réessayer.", "danger");
                        }
                    } else {
                        setNotif("La clé n'a pas pu être enregistrée. Contactez un administrateur.", "danger");
                    }
                } else {
                    setNotif("La clé envoyée est déjà utilisée.", "danger");
                }
            } else {
                setNotif("La clé envoyée n'est pas correcte.", "danger");
            }
        }
    }

    public function activejohnbadge()
    {
        if (!getUser()) redirect("/");

        completeBadge($this->DB, getUser(), 4);
        setNotif("Vous venez d'activer le badge <b>John</b> ! Bravo !", "success");
        redirect("/account");
    }

}
