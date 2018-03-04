<?php

namespace engine\Router;


use engine\components\Singleton;

class Router
{
    use Singleton;

    private $controllers = [
        ""      => "MainController",
        "goods" => "GoodsController",
        "user" => "UserController",
        "admin" => "AdminController"
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
        $controllerPath = $route[1];
        $methodPath = $route[2];

        $controller = $this->controllers[$controllerPath];
        $method = $this->methods[$controller][$methodPath];

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