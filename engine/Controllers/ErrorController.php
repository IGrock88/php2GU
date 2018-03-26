<?php

namespace engine\Controllers;


use engine\Views\TwigRender;

class ErrorController extends Controller
{
    public function error404()
    {
        $this->content['content'] = "pages/error404.tmpl";
        $this->render(new TwigRender());
    }

}