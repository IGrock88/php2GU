<?php

namespace engine\Controllers;


use engine\Views\AdminView;

class AdminController extends Controller
{
    protected $view;

    public function __construct()
    {
        parent::__construct();
        if($this->content['userRole'] != 2){
            header("location: /");
        }
        $this->view = new AdminView();
    }

    public function index(){
        $this->view->generate($this->content);
    }

    public function orders(){
        echo "заказы";
    }

}