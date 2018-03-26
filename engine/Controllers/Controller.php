<?php

namespace engine\Controllers;


use engine\components\Auth;
use engine\components\Request;
use engine\DB\DB;
use engine\Views\IRender;


class Controller
{
    protected $content;
    protected $db;
    protected $request;
    protected $basisTmpl = "base.tmpl";

    public function __construct()
    {
        $this->db = DB::getInstance();
        $this->request = new Request();
        $auth = new Auth($this->db, $this->request);
        $this->content['isAuth'] = $auth->isAuth();
        $this->content['user'] = $auth->getUser();
    }

    protected function render(IRender $render)
    {
        $render->render($this->content);
    }

}