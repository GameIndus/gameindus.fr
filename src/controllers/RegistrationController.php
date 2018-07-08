<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class RegistrationController extends Controller
{

    public function index()
    {
        connectPage();
        $this->setTitle('Inscription à la plateforme');
        $this->setDescription('Inscrivez-vous dès maintenant pour pouvoir créer vos jeux vidéo gratuitement et facilement, directement en ligne !');

        if (isPost()) {
            $post = getPost();
            $premium = false;

            if (!isset($post->key1)) $post->key1 = "";
            if (!isset($post->key2)) $post->key2 = "";
            if (!isset($post->key3)) $post->key3 = "";
            if (!isset($post->key4)) $post->key4 = "";

            $username = addslashes(htmlentities(($post->username)));
            $email = addslashes(htmlentities(($post->email)));
            $password = addslashes(htmlentities(($post->password)));
            $password2 = addslashes(htmlentities(($post->password2)));
            $key1 = strval(addslashes(htmlentities($post->key1)));
            $key2 = strval(addslashes(htmlentities($post->key2)));
            $key3 = strval(addslashes(htmlentities($post->key3)));
            $key4 = strval(addslashes(htmlentities($post->key4)));
            $keyPosted = $key1 . $key2 . $key3 . $key4;
            $newsletter = (isset($post->newsletter)) ? addslashes(htmlentities(($post->newsletter))) : "off";
            $experience = (isset($post->experience) && !empty($post->experience)) ? addslashes(htmlentities(($post->experience))) : "intermediate";

            $captcha = addslashes(htmlentities(($_POST["g-recaptcha-response"])));

            // Check for premium mode
            if ($key1 == "" && $key2 == "" && $key3 == "" && $key4 == "" && isGet("premium")) {
                $premium = true;
            }

            // Check Captcha
            if (!checkCaptcha($captcha, "6LejGSITAAAAAFgZn6UeluRRJV-exnO58DSlEJi3")) {
                setNotif("La vérification n'a pas été accomplie. Veuillez réessayer.", "danger");
                redirect("inscription?" . (($premium) ? 'premium' : 'form'));
            }

            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('username' => $username)));
            $userE = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('email' => $email)));

            if (!$user && !$userE) {
                if (preg_match("/^[a-zA-Z0-9\-]+$/", $username) && preg_match("/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i", $email)) {
                    if ($password == $password2) {
                        if ($premium) {
                            $password = sha1($password);
                            $token = substr(md5(microtime()), rand(0, 26), 16);
                            if ($newsletter == "on") $newsletter = 1; else $newsletter = 0;

                            $userSave = $this->DB->save(array(
                                'insert' => true,
                                'table' => 'users',
                                'fields' => array(
                                    'username' => $username,
                                    'password' => $password,
                                    'email' => $email,
                                    'grade' => 'member',
                                    'date_registered' => date('Y-m-d H:i:s', time()),
                                    'active' => 0,
                                    'activated_with_premium' => 1,
                                    'token' => $token,
                                    'newsletter' => $newsletter,
                                    'experience' => $experience
                                )
                            ));
                            if ($userSave) {
                                setNotif("L'utilisateur a bien été créé. Merci de poursuivre la procédure.", "success");

                                $user = $this->DB->findFirst(array("table" => "users", "conditions" => array("username" => $username)));
                                unset($user->password);
                                $_SESSION["user"] = $user;
                                redirect("/premium/proceed");
                            } else {
                                setNotif("L'utilisateur n'a pas pu être enregistré. Contactez un administrateur.", "danger");
                            }
                        } else {
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
                                        'fields' => array('used' => 1, 'used_by' => $username),
                                        'where' => 'devKey',
                                        'wherevalue' => $key->devKey
                                    ));

                                    $password = sha1($password);
                                    $token = substr(md5(microtime()), rand(0, 26), 16);
                                    if ($newsletter == "on") $newsletter = 1; else $newsletter = 0;

                                    $userSave = $this->DB->save(array(
                                        'insert' => true,
                                        'table' => 'users',
                                        'fields' => array(
                                            'username' => $username,
                                            'password' => $password,
                                            'email' => $email,
                                            'grade' => 'member',
                                            'date_registered' => date('Y-m-d H:i:s', time()),
                                            'active' => 0,
                                            'token' => $token,
                                            'newsletter' => $newsletter,
                                            'experience' => $experience
                                        )
                                    ));
                                    if ($userSave && $keySave) { // Send e-mail to confirm account
                                        $message = "
											Bienvenue sur GameIndus, " . $username . " !<br><br>
											Cette adresse e-mail a été utilisée pour la création d'un compte au service de GameIndus (disponible à cette adresse: <a href='https://gameindus.fr/'>http://gameindus.fr/</a>).<br>
											Si ce n'est pas le cas, merci d'ignorer ce message : nous nous excusons de la gène occasionnée.<br>
											<br>
											Pour confirmer votre compte, merci de cliquez <a href='https://gameindus.fr/account/confirm?email=" . $email . "&token=" . $token . "'>ici</a>. Une fois votre compte confirmé, vous pourrez accéder aux différents servcies de GameIndus. Si néanmoins vous souhaitez avoir plus de contenus, n'hésitez pas à souscrire à un compte premium <a href='https://gameindus.fr/premium'>ici</a>.<br>
											<br>
											Si vous ne pouvez pas cliquer sur le lien, copiez-collez le lien ci-dessous dans votre navigateur : https://gameindus.fr/account/confirm?email=" . $email . "&token=" . $token . ".<br>
											<br>
											En espérant vous voir bientôt sur GameIndus ! L'équipe vous souhaite une très bonne création de jeux vidéo.
										";
                                        if (emailTemplate($email, $message, 'Confirmation de votre compte', 'noreply')) {
                                            setNotif("Inscription terminée. Nous venons de vous envoyer un e-mail afin de confirmer votre compte.");
                                        } else {
                                            setNotif("L'email n'a pas pu vous être envoyé. Merci de réessayer.", "danger");
                                        }
                                    } else {
                                        setNotif("L'utilisateur n'a pas pu être enregistré. Contactez un administrateur.", "danger");
                                    }
                                } else {
                                    setNotif("La clé envoyée est déjà utilisée.", "danger");
                                }
                            } else {
                                setNotif("La clé envoyée n'est pas correcte.", "danger");
                            }
                        }
                    } else {
                        setNotif("Les mots de passe envoyés ne sont pas identiques.", "danger");
                    }
                } else {
                    setNotif("Le nom d'utilisateur ou l'adresse e-mail envoyé(e) n'est pas valable.", "danger");
                }
            } else {
                setNotif("Un utilisateur existe déjà avec ce même pseudonyme et/ou e-mail.", "danger");
            }
        }
    }

    public function subscription()
    {
        connectPage();

        if (isPost()) {
            $email = addslashes(htmlentities(getPost("email")));
            if (empty($email)) redirect("/inscription");

            $ex = $this->DB->findFirst(array("table" => "subscribers", "conditions" => array("email" => $email)));
            if ($ex) redirect("/inscription");

            $this->DB->save(array(
                "insert" => true,
                "table" => "subscribers",
                "fields" => array(
                    "email" => $email
                )
            ));

            setNotif("Email enregistré avec succès !");
            redirect("/inscription");
        } else {
            redirect("/inscription");
        }
    }

}
