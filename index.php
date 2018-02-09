<?php

/*require_once(__DIR__."/lib/SplClassLoader.php");
$loader = new SplClassLoader('lib', __DIR__);
$loader->register();*/

require_once("lib/Router.php");
require_once("lib/Controller.php");
require_once("lib/View.php");
require_once("lib/Model.php");
require_once("lib/Database.php");

require_once("config/paths.php");
require_once("config/database.php");

$router = new Router();
