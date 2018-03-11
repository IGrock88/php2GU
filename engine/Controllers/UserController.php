<?php

namespace engine\Controllers;


use engine\Models\UserModel;

class UserController extends Controller
{

    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel($this->db);
    }

    public function registration()
    {
        $this->content['regStatus'] = $this->userModel->runRegistration();
        $this->content['content'] = 'pages/registration.tmpl';
        $this->view->generate($this->content);
    }

    public function account()
    {
        $this->content['content'] = 'pages/account.tmpl';
        $this->view->generate($this->content);
    }

    public function orders()
    {
        $this->content['content'] = 'pages/orders.tmpl';
        $this->view->generate($this->content);
    }

}