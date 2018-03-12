<?php

namespace engine\Controllers;


use engine\Models\BasketModel;
use engine\Models\UserModel;

class UserController extends Controller
{

    public function registration()
    {
        $userModel = new UserModel($this->db);
        $this->content['regStatus'] = $userModel->runRegistration();
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

    public function ajaxCheckout(){
        $userModel = new UserModel($this->db);
        if($userModel->checkout($this->content['user']->getId())){
            echo json_encode(["result" => JSON_SUCCESS]);
        }

    }

}