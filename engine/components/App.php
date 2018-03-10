<?php
/**
 * Created by PhpStorm.
 * User: IGrock
 * Date: 10.03.2018
 * Time: 10:09
 */

namespace engine\components;


class App
{

    use Singleton;

    public static $requests;
    public static $db;
    public static $auth;

    public function init()
    {
        $requests = new Request();

    }


}