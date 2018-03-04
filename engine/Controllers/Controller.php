<?php

namespace engine\Controllers;


use engine\components\Auth;
use engine\DB\DB;
use engine\Views\View;

class Controller
{
    protected $view;
    protected $content;
    protected $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
        $auth = new Auth($this->db);
        $this->content['isAuth'] = $auth->isAuth();
        $this->content['userRole'] = $auth->getUserRole();
        $this->view = new View();
    }
}