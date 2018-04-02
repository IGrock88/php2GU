<?php

namespace engine\Controllers;

use engine\components\Response;

class ErrorController extends Controller
{
    public function error404()
    {
        $this->content['content'] = "pages/error404.tmpl";
        return new Response($this->render->render($this->content));
    }

}