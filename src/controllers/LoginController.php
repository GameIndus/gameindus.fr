<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class LoginController extends Controller
{

    public function index()
    {
        connectPage();

        $this->setTitle('Connexion à l\'espace membre');
        $this->setDescription('Connectez-vous dès maintenant pour pouvoir créer vos jeux vidéo gratuitement, et facilement, directement en ligne !');

        if (isPost()) {
            $post = getPost();

            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('username' => addslashes(htmlentities($post->username)))));

            if ($user) {
                if (sha1($post->password) == $user->password) {
                    if ($user->active || (!$user->active && $user->activated_with_premium)) {
                        unset($user->password);

                        $this->DB->save(array(
                            'table' => 'users',
                            'fields' => array('last_login' => date('Y-m-d H:i:s', time()), 'last_login_ip' => $_SERVER["REMOTE_ADDR"]),
                            'where' => 'id',
                            'wherevalue' => $user->id
                        ));

                        $_SESSION['user'] = $user;

                        if ($post->nfp) {
                            header('Location: ' . base64_decode($post->nfp));
                        } else {
                            redirect("account");
                        }
                    } else {
                        setNotif("Vous devez confirmer votre compte afin de vous connecter.", "danger");
                    }
                } else {
                    setNotif("Mot de passe incorrect. Veuillez réessayer.", "danger");
                }
            } else {
                setNotif("Compte inexistant. Merci de vous inscrire avant.", "danger");
            }
        }
    }

}
