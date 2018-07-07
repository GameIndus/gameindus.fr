<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

class Controller
{

    /**
     * @var object Object d'accès à la configuration du site
     */
    public $config = null;

    /**
     * @var PDO Objet d'accès à la base de données
     */
    public $DB = null;

    /**
     * @var array Tableau des données à passer à la vue
     */
    public $d = array();

    protected $title = null;

    protected $description = null;

    public function __construct($config, $DB)
    {
        $this->config = $config;
        $this->DB = $DB;
    }

    public function getData()
    {
        return $this->d;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    protected function set($d)
    {
        $this->d = $d;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getUserById($ID)
    {
        return $this->DB->findFirst(array('table' => 'users', 'conditions' => array('id' => $ID)));
    }

}