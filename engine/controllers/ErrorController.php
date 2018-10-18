<?php

namespace engine\controllers;

use engine\components\response\ResponsePage;
use engine\components\response\AbstractResponse;

class ErrorController extends AbstractController
{
    public function error404():AbstractResponse
    {
        $this->content['content'] = "pages/error404.tmpl";
        return new ResponsePage($this->render->render($this->content));
    }

}