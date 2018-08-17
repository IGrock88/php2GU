<?php
/**
 * User: IGrock
 * Date: 27.03.2018
 * Time: 19:45
 */

namespace engine\components;


use engine\DB\DB;
use engine\Router\Router;
use engine\Views\TwigRender;

class App
{
    use Singleton;

    public static $db;
    public static $request;
    public static $auth;

    public function init()
    {
        self::$db = DB::getInstance();
        self::$request = new Request();
        self::$auth = new Auth(self::$db, self::$request);
        $render = new TwigRender();
        $router = Router::getInstance();
        $response = $router->start($render, self::$request);
        $response->send();
    }
}