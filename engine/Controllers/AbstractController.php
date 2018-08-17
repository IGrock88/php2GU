<?php

namespace engine\Controllers;

use engine\components\App;
use engine\Views\IRender;

abstract class AbstractController
{
    protected $content;
    protected $render;

    public function __construct(IRender $render)
    {
        $this->content['isAuth'] = App::$auth->isAuth();
        $this->content['user'] = App::$auth->getUser();
        $this->render = $render;
    }

}