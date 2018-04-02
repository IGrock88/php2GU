<?php
/**
 * User: IGrock
 * Date: 10.03.2018
 * Time: 16:17
 */

namespace engine\Controllers;
use engine\components\Response;


class MainController extends Controller
{
    public function index()
    {
        $this->content['content'] = "pages/index.tmpl";
        return new Response($this->render->render($this->content));
    }
}