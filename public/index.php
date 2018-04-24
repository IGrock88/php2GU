<?php
require "../config/config.php";
require "../vendor/autoload.php";

chdir(dirname(__DIR__));
//start

(\engine\components\App::getInstance())->init();


