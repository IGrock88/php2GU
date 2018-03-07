<?php

namespace engine\Controllers;


use engine\components\Request;


class MainController extends Controller
{
    public function index()
    {
        $this->content['content'] = "pages/index.tmpl";
        $this->view->generate($this->content);
    }
}