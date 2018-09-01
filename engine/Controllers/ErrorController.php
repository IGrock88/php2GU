<?php

namespace engine\Controllers;

use engine\components\response\ResponsePage;

class ErrorController extends AbstractController
{
    public function error404()
    {
        $this->content['content'] = "pages/error404.tmpl";
        return new ResponsePage($this->render->render($this->content));
    }

}