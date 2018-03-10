<?php
require "../config/config.php";
require "../vendor/autoload.php";

chdir(dirname(__DIR__));

(engine\Router\Router::getInstance())->start();


