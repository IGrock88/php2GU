<?php

namespace engine\Router;
/*
Напоминалка)
1. Все контроллеры должны лежать в одной директории, путь задается в переменной $controllerDir
2. Обязательно должен быть основной контроллер, для главной страницы. - $mainControllerName
3. Все имена контроллеров должны заканчиваться на "Controller"
4. Названия методов будут совпадать с третьей частью url.
напр. localhost/goods/view - загрузится контроллер GoodsController и вызовется метод view()
5. В каждом контроллере можно задать метод по умолчанию index, туда будут перенаправлятся запросы без третьей части url
напр. localhost/goods/ - загрузится контроллер GoodsController и вызовется метод index()
6. Обязательно создать контроллер для обработки ошибок, он нужен чтобы перенаправлять ошибочные запросы. Название
можно задать в $errorControllerName
*/

use engine\components\Singleton;

class Router
{
    use Singleton;
    private $controllerDir = "engine/Controllers"; // путь к дериктории с контроллерами
    private $mainControllerName = "Controller"; // основной контроллер, на него идёт перенаправление если не задан путь к контроллеру
    private $errorControllerName = "ErrorController"; // контроллер для обработки ошибок
    private $defaultMethod = "index"; //дефолтный метод в контроллере, на него будет перенаправление, если не задана третья часть пути отвечающая за выбор метода
    private $controllers = [];

    public function start()
    {
        $this->getControllers();
        $route = explode("/", $_SERVER['REQUEST_URI']);
        $controllerPath = $route[1];
        $method = $route[2];

        if($method == ""){
            $method = $this->defaultMethod;
        }

        if(isset($this->controllers[$controllerPath])){
            $controller = 'engine\\controllers\\' . $this->controllers[$controllerPath];
            $controllerObj = new $controller();
            if(method_exists($controllerObj, $method)){
                $controllerObj->$method();
                exit(); //если успешно подгружен нужный класс и метод завершаем выполнение
            }
        }
        $errorController = "\\engine\\controllers\\" . $this->errorControllerName;
        (new $errorController())->error404(); // перенаправляем на страницу 404
    }

    private function getControllers() // получаем имена всех контроллеров, и добавляем в ассоциативный массив
    {
        $files = scandir($this->controllerDir);
        for ($i = 2; $i < count($files); $i++) {
            $str = explode(".", $files[$i])[0];
            if ($str == $this->mainControllerName) {
                $this->controllers[""] = $this->mainControllerName;
            } else {
                $key = strtolower(substr($str, 0, stripos($str, "Controller"))); // обрезаем название по Controller
                $this->controllers[$key] = $str;
            }
        }
    }
}