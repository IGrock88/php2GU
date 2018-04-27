<?php
require "../config/config.php";
require "../vendor/autoload.php";

chdir(dirname(__DIR__));



$app = \engine\components\App::getInstance();
$app->init();


