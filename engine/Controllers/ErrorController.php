<?php
/**
 * Created by PhpStorm.
 * User: IGrock
 * Date: 04.03.2018
 * Time: 11:37
 */

namespace engine\Controllers;


class ErrorController extends Controller
{
    public function error404()
    {
        $this->content['content'] = "pages/error404.tmpl";
        $this->view->generate($this->content);
    }

}