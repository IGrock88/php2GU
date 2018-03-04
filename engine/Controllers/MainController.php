<?php

namespace engine\Controllers;


use engine\components\Request;


class MainController extends Controller
{
    public function index()
    {
        $this->content['content'] = "templates/index.php";
        $this->view->generate($this->content);
    }
}