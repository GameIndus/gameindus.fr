<?php

class HelpcenterController extends Controller
{

    public function index()
    {
        $this->setTitle('Notre support');
    }

    public function faq()
    {
        $this->setTitle('Support : Les questions fréquentes');

        $d = new StdClass();
        $faq = $this->DB->find(array('table' => 'faq'));

        foreach ($faq as $v) {
            $category = $v->category;
            if (!isset($d->$category)) {
                $d->$category = array();
            }

            $tmpC = $d->$category;
            $tmpC[] = $v;
            $d->$category = $tmpC;
        }

        $this->set($d);
    }

    public function issues()
    {
        $this->setTitle('Support : Les bogues rapportés');

        $d = new StdClass();
        $d->maxBugsPrinted = 10000;

        $d->bugs = $this->DB->find(array('table' => 'bugs', 'order' => 'date DESC', 'limit' => '0,' . $d->maxBugsPrinted));
        $d->bugsNum = $this->DB->count(array('table' => 'bugs'));

        foreach ($d->bugs as $k => $v) {
            $user = $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $v->user_id)));
            unset($user->password);
            $d->bugs[$k]->user = $user;
        }

        $this->set($d);
    }

    public function submitissue()
    {
        $this->setTitle('Support : rapporter un problème');

        if (isset($_GET["badcaptcha"])) {
            setNotif("Code de sécurité incorrect.", "danger");
            redirect("/helpcenter/submitissue");
            die();
        }

        if (isPost() && getUser()) {
            $user = getUser();
            $description = addslashes(htmlentities(getPost("description")));
            $captcha = addslashes(htmlentities(getPost("captcha")));
            $tags = addslashes(htmlentities(getPost("tags")));

            if ($description != "" && $captcha != "") {
                if (md5($captcha) == $_SESSION["captcha"]) {
                    $bugId = $this->DB->count(array('table' => 'bugs')) + 1;

                    $this->DB->save(array(
                        'table' => 'bugs',
                        'fields' => array(
                            'id' => $bugId,
                            'description' => $description,
                            'status' => 5,
                            'resolve_date' => null,
                            'tags' => $tags,
                            'user_id' => $user->id
                        )
                    ));

                    $bugsPosted = $this->DB->count(array('table' => 'bugs', 'conditions' => array('user_id' => $user->id)));

                    if ($bugsPosted == 5) completeBadge($this->DB, $user, 1);
                    else if ($bugsPosted == 10) completeBadge($this->DB, $user, 2);
                    else if ($bugsPosted == 50) completeBadge($this->DB, $user, 3);

                    emailTemplate(
                        'contact@gameindus.fr',
                        "{$user->username} vient de soumettre un problème. Voici son descriptif :<br><br><b>" . stripslashes($bug) . "</b><br><br>Bonne journée.",
                        "Centre d'aide | {$user->username} a soumis un problème",
                        "noreply"
                    );

                    setNotif("Votre bug a bien été envoyé ! Merci de votre contribution.");
                    redirect("/helpcenter/issues");
                    die();
                } else {
                    setNotif("Code de sécurité incorrect.", "danger");
                }
            } else {
                setNotif("Vous devez remplir tous les champs.", "danger");
            }

            redirect("/helpcenter/submitissue");
        }
    }

    public function submitidea()
    {
        $this->setTitle('Support : soumettre une idée');
    }

}
