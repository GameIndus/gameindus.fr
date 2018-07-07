<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

ini_set('session.cookie_domain', '.gameindus.fr');
session_start();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('BASE', dirname($_SERVER["SCRIPT_NAME"]) . '/');

$config = json_decode(file_get_contents('config.json'));

if ($config->development) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    ini_set('memory_limit', '-1');
}

date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');


require 'core/libs/mobileDetect.php';
require 'core/helpers/Html.php';
require 'core/database.php';
require 'core/functions.php';
require 'core/Controller.php';
require 'core/Router.php';


$router = new Router($config);

$router->addRoute("account/**", "account");
$router->addRoute("blog/*", "blog/view");
$router->addRoute("releases/*", "releases");
$router->addRoute("project/**", "project[.]");
$router->addRoute("project/preview/*", "project/preview");
$router->addRoute("project/download/*", "project/download");
$router->addRoute("premium/order/**", "premium/order");
$router->addRoute("presentation", "about/presentation");
$router->addRoute("galerie/*", "galerie");

// $router->addRedirection("helpcenter(.*)", "community");

$router->addRoute("market/search/*", "market/search");
$router->addRoute("market/subcategory/**", "market/subcategory");
$router->addRoute("market/category/**", "market/category");
$router->addRoute("market/asset/*", "market/asset");
$router->addRoute("market/tag/*", "market/tag");
$router->addRoute("market/editasset/*", "market/editasset");
$router->addRoute("market/preview/*", "market/preview");

$router->load();

// @header("Expires: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
// @header("Last-Modified: " . gmdate('D, d M Y H:i:s', time()) . ' GMT');