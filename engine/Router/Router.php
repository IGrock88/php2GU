<?php

namespace engine\Router;


use engine\components\Singleton;

class Router
{
    use Singleton;

    private $controllers = [
        ""      => ['controller' => "MainController"],
        "goods" => ['controller' => "GoodsController"],
        "user" => ['controller' => "UserController"],
        "admin" => ['controller' => "AdminController"]
    ];

    private $methods = [
        "GoodsController" => [
            "view" => "view",
            "ajaxFeatureGoods" => "featureGoods"
        ],
        "UserController" => [
            "account" => "account",
            "register" => "registration"
        ],
        "MainController" => [
            "" => "index"
        ],
        "AdminController" => [
            "" => "index",
            "orders" => "orders",
        ]

     ];

    public function start()
    {
        $route = explode("/", $_SERVER['REQUEST_URI']);
        $controller = $this->controllers[$route[1]]['controller'];
        $method = $this->methods[$controller][$route[2]];

        if(isset($controller) && isset($method)){
            $controller = 'engine\\Controllers\\' . $controller;
            $controllerObject = new $controller();
            $controllerObject->$method();
        }
        else{
            $controllerObject = new \engine\Controllers\ErrorController();
            $controllerObject->error404();
        }

    }
}