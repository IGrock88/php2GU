<?php

namespace engine\Controllers;


use engine\components\Auth;
use engine\components\Request;
use engine\DB\DB;
use engine\Views\MainView;
use engine\Views\View;

class Controller
{
    protected $view;
    protected $content;
    protected $db;
    protected $request;
    private $basisTmpl = "base.tmpl";

    public function __construct()
    {
        $this->db = DB::getInstance();
        $this->request = new Request();
        $auth = new Auth($this->db, $this->request);
        $this->content['isAuth'] = $auth->isAuth();
        $this->content['user'] = $auth->getUser();
        $this->view = new View($this->basisTmpl);
    }

    public function index()
    {
        $this->content['content'] = "pages/index.tmpl";
        $this->view->generate($this->content);
    }
}