<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

namespace GameIndus\Core;

use Mobile_Detect;

class Router
{

    public $routes = array();
    public $redirects = array();
    public $params = array();

    public $page = "";
    public $template = null;
    public $lang = null;

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->lang = $this->config->template->lang;
    }

    public function load()
    {
        $this->format();
        $this->parse();
        $this->hook();
        $this->loadPage();
    }


    public function format()
    {
        $suffix = "";
        $this->page = explode('?', trim(str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']), '/'))[0];

        // Custom langs
        if (in_array(substr($this->page, 0, 3), $this->config->template->other_langs)) {
            $this->lang = substr($this->page, 0, 2);
            $this->page = (strlen($this->page) > 2) ? substr($this->page, 2) : 'index';

            if (strpos($this->page, "/") === 0) $this->page = substr($this->page, 1);

            define('BASE', BASE . $this->lang . DS);
            setlocale(LC_TIME, 'en_US.utf8', 'eng');
        } else {
            define('LANG_BASE', BASE);
        }

        require SRC . '/core/lang/' . $this->lang . '.php';
        if (isset($strings)) $GLOBALS["strings"] = $strings;

        if ($this->page == 'home' || $this->page == '') $this->page = 'index';
        if ($this->page == "\'\'\'") redirect(BASE);

        if ($this->page == "connexion") $this->page = "login";
        if ($this->page == "inscription") $this->page = "registration";
        if ($this->page == "inscription/subscription") $this->page = "registration/subscription";
        if ($_SERVER['HTTP_HOST'] == "market.gameindus.fr") {
            $this->page = "market/" . $this->page;
            define("MARKETPLACE", true);
            if ($this->page == "market/index" || $this->page == "market/home") $this->page = "market";
        } else define("MARKETPLACE", false);
        if (strpos($this->page, "market") !== false && $_SERVER['HTTP_HOST'] != "market.gameindus.fr") $this->page = "56468468481";
    }

    public function parse()
    {

        // Redirections
        foreach ($this->redirects as $regex => $v) {
            $regex = "/" . preg_replace("/\//", "\/", $regex) . "/";

            if (preg_match($regex, $this->page)) {
                redirect($v);
            }
        }

        // Routes
        foreach ($this->routes as $regex => $v) {
            $regex = preg_replace("/\*\*/", "([0-9]+)", $regex);
            $reg = "/" . preg_replace("/\//", "\/", preg_replace("/\*/", "(.*)", $regex)) . "/";
            $matches = array();

            $subpath = (strpos($v, "[.]") !== false);
            if ($subpath) $v = str_replace("[.]", "", $v);

            if (preg_match($reg, $this->page, $matches)) {

                if (empty($matches)) continue;
                array_shift($matches);

                if ($subpath) {
                    $f = $this->page;
                    foreach ($matches as $v) $f = str_replace($v, "", $f);

                    $v = str_replace("//", "/", $f);
                    if (substr($v, -1) == "/") $v = substr($v, 0, -1);
                }
                $this->page = $v;

                if (count($matches) == 1) {
                    $this->params = addslashes(htmlentities($matches[0]));
                    continue;
                }

                foreach ($matches as $v) $this->params[] = addslashes(htmlentities($v));
            }
        }

        if (is_array($this->params)) {
            foreach ($this->params as $k => $v) {
                if (strpos($v, "/") !== false) {
                    $this->params[$k] = explode("/", $v);
                }
            }
        } else {
            if (strpos($this->params, "/") !== false) {
                $this->params = explode("/", $this->params);

                if (count($this->params) == 2 && empty($this->params[1]))
                    $this->params = $this->params[0];
            }
        }
    }

    public function hook()
    {
        $split = preg_split("/\//", $this->page);
        if (count($split) > 0 && $split[0] === $this->config->admin_prefix) {
            if (count($split) > 1 && $split[1] == "project" && isset($_GET['id'])) $split[2] = "view";

            if (count($split) > 2)
                $this->page = $split[1] . '/admin_' . $split[2];
            else if (count($split) > 1 && $split[1] != "")
                $this->page = $split[1] . '/admin_index';
            else
                $this->page = "index/admin_index";

            $this->template = "admin";
        } else {
            $this->template = $this->config->template->name;
        }

        $detect = new Mobile_Detect;
        if ($detect->isMobile()) $this->template = "mobile_" . $this->template;

        if (MARKETPLACE) $this->template = $this->config->miscellaneous->market_template;
    }

    public function loadPage()
    {
        if ($this->page == null) return false;
        global $DB;

        // Call the controller
        $fileExist = (file_exists(SRC . DS . 'views' . DS . $this->page . '.php')) ? true : false;
        $ctrlName = "Index";
        $action = "index";

        if (!$fileExist) {
            header("HTTP/1.0 404 Not Found");
            $this->page = "errors/error404";
        }
        $split = preg_split("/\//", $this->page);
        if (count($split) > 0) $ctrlName = ucfirst($split[0]);
        if (count($split) > 1) $action = ucfirst($split[1]);

        // Connect to the database before running the controller
        $DB = new Database(
            $this->config->database->host,
            $this->config->database->user,
            $this->config->database->password,
            $this->config->database->database
        );

        $ctrlClass = 'GameIndus\\Controller\\' . $ctrlName . 'Controller';
        $ctrl = new $ctrlClass($this->config, $DB);

        $ctrl->setTitle($this->config->template->title);
        $ctrl->setDescription($this->config->template->description);

        $action = strtolower($action);
        $ctrl->$action($this->params);

        // foreach ($ctrl->getData() as $k => $v) ${$k} = $v;
        $d = $ctrl->getData();

        $content_for_layout = false;

        // Custom vars
        $header = ($this->page == 'index') ? true : false;

        $page = $this->page;
        $lang = $this->lang;
        $config = $this->config;

        /*$doMaintenance = false;
        $shouldMaintenance = (Config::$maintenance === true || (is_array(Config::$maintenance) && in_array($page, Config::$maintenance)));

        if (Config::$maintenance === true && (!getUser() || (getUser()->grade != "administrateur" && getUser()->grade != "administrator")) && $ctrlName != "LoginController")
            $doMaintenance = true;
        if (is_array(Config::$maintenance) && in_array($page, Config::$maintenance) && (!getUser() || !isAdmin(getUser())) && $ctrlName != "LoginController")
            $doMaintenance = true;

        if ($shouldMaintenance) Config::$pageInDev = true;

        if ($doMaintenance) {
            $protocol = "HTTP/1.0";
            if ("HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"]) $protocol = "HTTP/1.1";

            header("$protocol 503 Service Unavailable", true, 503);
            header("Retry-After: 3600");
            $this->page = "errors/error503";
        }*/

        ob_start();
        require SRC . '/views/' . $this->page . '.php';
        $content_for_layout = ob_get_clean();
        require SRC . '/views/templates/' . $this->template . '.php';
    }


    public function addRoute($regex, $to)
    {
        $this->routes[$regex] = $to;
    }

    public function addRedirection($regex, $to)
    {
        $this->redirects[$regex] = $to;
    }

}