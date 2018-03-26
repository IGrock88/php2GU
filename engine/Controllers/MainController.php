<?php
/**
 * User: IGrock
 * Date: 10.03.2018
 * Time: 16:17
 */

namespace engine\Controllers;


use engine\Views\TwigRender;

class MainController extends Controller
{
    public function index()
    {
        $this->content['content'] = "pages/index.tmpl";
        $this->render->render($this->content);
    }
}