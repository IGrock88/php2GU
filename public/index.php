<?php
require "../config/config.php";
require "../vendor/autoload.php";

use engine\Router\Router;

chdir(dirname(__DIR__));

$router = Router::getInstance();
$router->start();

?>