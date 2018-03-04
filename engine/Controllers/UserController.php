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
        $this->content['content'] = 'templates/registration.php';
        $this->view->generate($this->content);
    }

    public function account(){
        $this->content['content'] = 'templates/account.php';
        $this->view->generate($this->content);
    }
}