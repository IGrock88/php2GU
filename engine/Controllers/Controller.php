<?php

namespace engine\Controllers;


use engine\components\Auth;
use engine\components\Request;
use engine\DB\DB;
use engine\Views\IRender;


abstract class Controller
{
    protected $content;
    protected $db;
    protected $request;
    protected $render;


    public function __construct(IRender $render, DB $db, Request $request, Auth $auth)
    {
        $this->db = $db;
        $this->request = $request;
        $this->content['isAuth'] = $auth->isAuth();
        $this->content['user'] = $auth->getUser();
        $this->render = $render;
    }

}