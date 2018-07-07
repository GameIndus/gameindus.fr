<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class GalerieController extends Controller
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

    public function index($params)
    {
        $this->setTitle('Galerie des jeux');

        $d = new stdClass();
        $d->types = $this->projectTypes;
        $d->search = null;

        $limits = array(0, 20);

        if (isPost()) {
            $post = getPost();

            if (!empty($post->search) && !empty($post->category)) {
                $post->category = stringToSlug($post->category);
                if ($post->category != "all") redirect("/galerie/{$post->category}/{$post->search}");
                else redirect("/galerie/{$post->search}");
            }
        }

        if (count($params) >= 1) {
            $category = (count($params) >= 2) ? $params[0] : "all";
            $search = (count($params) == 1) ? $params : $params[1];
            $result = null;

            $sql = "SELECT *, projects.name as project_name, users.username AS user_name, projects.id AS id
					FROM projects 
					INNER JOIN users ON projects.owner_id = users.id
					WHERE type = :category AND public = 1 AND name LIKE :search
					ORDER BY date_created DESC
					LIMIT {$limits[0]},{$limits[1]}";
            if ($category == "all") $sql = preg_replace("/type = :category AND /", '', $sql);

            $pre = $this->DB->pdo->prepare($sql);

            if ($category != "all") $pre->bindValue("category", $category, PDO::PARAM_STR);
            $pre->bindValue("search", $search, PDO::PARAM_STR);

            $pre->execute();
            $result = $pre->fetchAll(PDO::FETCH_OBJ);

            $d->search = (object)array(
                'category' => $category,
                'search' => $search,
                'result' => $result
            );
        }

        if ($d->search == null) {
            $d->defaultSearch = $this->DB->req("SELECT *, projects.name as project_name, users.username AS user_name, projects.id AS id FROM projects INNER JOIN users ON projects.owner_id = users.id WHERE public = 1 ORDER BY date_created DESC LIMIT {$limits[0]},{$limits[1]}");
        }

        $this->set($d);
    }

}
