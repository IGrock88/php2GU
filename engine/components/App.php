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
    public function init()
    {
        $db = DB::getInstance();
        $request = new Request();
        $auth = new Auth($db, $request);
        $render = new TwigRender();

        (Router::getInstance())->start($render, $db, $request, $auth);
    }

}