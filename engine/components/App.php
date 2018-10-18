<?php
/**
 * User: IGrock
 * Date: 27.03.2018
 * Time: 19:45
 */

namespace engine\components;


use engine\components\builder\ControllerBuilder;
use engine\db\DB;
use engine\router\Router;
use engine\views\TwigRender;

class App
{
    use Singleton;

    public function init()
    {
        $db = DB::getInstance();
        $request = new Request();
        $auth = new Auth($db, $request);

        $render = new TwigRender();

        $router = Router::getInstance();

        // Начало строительства контроллера
        $controllerBuilder = new ControllerBuilder();
        $controllerBuilder->setAuth($auth);
        $controllerBuilder->setDb($db);
        $controllerBuilder->setRequest($request);
        $controllerBuilder->setRender($render);

        $response = $router->start($controllerBuilder, $request);
        $response->send();
    }
}