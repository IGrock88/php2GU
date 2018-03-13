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
        $userModel = new UserModel($this->db);
        $this->content['content'] = 'pages/orders.tmpl';
        $this->content['orders'] = $userModel->getOrdersByUser($this->content['user']->getId());
        $this->view->generate($this->content);
    }

    public function order()
    {
        $basketModel = new BasketModel($this->db);

    }

    public function delorder()
    {
        if($this->content['isAuth']){
            $basketModel = new BasketModel($this->db);
            $basketModel->deleteOrderById($this->request->getUrl()[3], $this->content['user']->getId());
            header("location: /user/orders");
        }
    }

    public function ajaxCheckout(){
        $userModel = new UserModel($this->db);
        if($userModel->checkout($this->content['user']->getId())){
            echo json_encode(["result" => JSON_SUCCESS]);
        }

    }

}