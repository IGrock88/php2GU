<?php

namespace engine\Controllers;


use engine\Models\OrderModel;
use engine\Models\UserModel;
use engine\Views\TwigRender;

class UserController extends Controller
{

    public function registration()
    {
        $userModel = new UserModel($this->db);
        $this->content['regStatus'] = $userModel->runRegistration();
        $this->content['content'] = 'pages/registration.tmpl';
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function account()
    {
        $this->content['content'] = 'pages/account.tmpl';
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function orders()
    {
        $orderModel = new OrderModel($this->db);
        $this->content['content'] = 'pages/orders.tmpl';
        $this->content['orders'] = $orderModel->getOrdersByUser($this->content['user']->getId());
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function order()
    {
        $orderModel = new OrderModel($this->db);
        $this->content['content'] = 'pages/single-order.tmpl';
        $this->content['singleOrder'] = $orderModel->loadOrderById($this->content['user']->getId(), $this->request->getUrl()[3]);
        $totalPriceOrder = 0;
        foreach ($this->content['singleOrder'] as $key => $item){
            $totalPriceOrder = $totalPriceOrder + ($item['price'] * $item['quantity']);
        }
        $this->content['totalPriceOrder'] = $totalPriceOrder;
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function delorder()
    {
        if($this->content['isAuth']){
            $orderModel = new OrderModel($this->db);
            $orderModel->deleteOrderById($this->request->getUrl()[3], $this->content['user']->getId());
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