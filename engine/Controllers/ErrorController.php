<?php

namespace engine\Controllers;


class ErrorController extends Controller
{
    public function error404()
    {
        $this->content['content'] = "pages/error404.tmpl";
        $this->view->generate($this->content);
    }

}