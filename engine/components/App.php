<?php
/**
 * User: IGrock
 * Date: 27.03.2018
 * Time: 19:45
 */

namespace engine\components;


use engine\components\Builder\ControllerBuilder;
use engine\components\Response\Invoker;
use engine\components\Response\SendCommand;
use engine\DB\DB;
use engine\Router\Router;
use engine\Views\TwigAdapter;
use engine\Views\TwigRender;

class App
{
    use Singleton;

    public function init()
    {
        $db = DB::getInstance();
        $request = new Request();
        $auth = new Auth($db, $request);

        // инстанцирование адаптера
        $render = new TwigAdapter(new TwigRender());


        $router = Router::getInstance();

        // Начало строительства контроллера
        $controllerBuilder = new ControllerBuilder();
        $controllerBuilder->setAuth($auth);
        $controllerBuilder->setDb($db);
        $controllerBuilder->setRequest($request);
        $controllerBuilder->setRender($render);

        $response = $router->start($controllerBuilder, $request);

        // Паттерн команда
        $sendCommand = new SendCommand($response);
        $invoker = new Invoker($sendCommand);
        $invoker->sendResponse();
    }
}