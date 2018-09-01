<?php
/**
 * User: IGrock
 * Date: 10.03.2018
 * Time: 16:17
 */

namespace engine\Controllers;
use engine\components\Response\AbstractResponse;
use engine\components\response\ResponsePage;


class MainController extends AbstractController
{
    public function index():AbstractResponse
    {
        $this->content['content'] = "pages/index.tmpl";
        return new ResponsePage($this->render->render($this->content));
    }
}