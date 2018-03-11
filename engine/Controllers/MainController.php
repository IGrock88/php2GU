<?php
/**
 * User: IGrock
 * Date: 10.03.2018
 * Time: 16:17
 */

namespace engine\Controllers;


class MainController extends Controller
{
    public function index()
    {
        $this->content['content'] = "pages/index.tmpl";
        $this->view->generate($this->content);
    }
}