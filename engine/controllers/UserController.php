<?php

namespace engine\controllers;


use engine\components\response\AbstractResponse;
use engine\components\response\ResponseJson;
use engine\models\OrderModel;
use engine\models\UserModel;
use engine\components\response\ResponsePage;


class UserController extends AbstractController
{

    public function registration():AbstractResponse
    {
        $userModel = new UserModel($this->db);
        $this->content['regStatus'] = $userModel->runRegistration();
        $this->content['content'] = 'pages/registration.tmpl';
        return new ResponsePage($this->render->render($this->content));
    }

    public function account():AbstractResponse
    {
        $this->content['content'] = 'pages/account.tmpl';
        return new ResponsePage($this->render->render($this->content));
    }

    public function orders():AbstractResponse
    {
        $orderModel = new OrderModel($this->db);
        $this->content['content'] = 'pages/orders.tmpl';
        $this->content['orders'] = $orderModel->getOrdersByUser($this->auth->getUser()->getId());
        return new ResponsePage($this->render->render($this->content));
    }

    public function order():AbstractResponse
    {
        $orderModel = new OrderModel($this->db);
        $this->content['content'] = 'pages/single-order.tmpl';
        $this->content['singleOrder'] = $orderModel->loadOrderById($this->auth->getUser()->getId(), $this->request->getItemId());
        $totalPriceOrder = 0;
        foreach ($this->content['singleOrder'] as $key => $item) {
            $totalPriceOrder = $totalPriceOrder + ($item['price'] * $item['quantity']);
        }
        $this->content['totalPriceOrder'] = $totalPriceOrder;
        return new ResponsePage($this->render->render($this->content));
    }

    public function delorder():AbstractResponse
    {
        if ($this->content['isAuth']) {
            $orderModel = new OrderModel($this->db);
            $orderModel->deleteOrderById($this->request->getItemId(), $this->auth->getUser()->getId());
            header("location: /user/orders");
        }
    }

    public function ajaxCheckout():AbstractResponse
    {
        $userModel = new UserModel($this->db);
        if ($userModel->createOrder($this->auth->getUser())) {
            return new ResponseJson(["result" => JSON_SUCCESS]);
        }
        else{
            return new ResponseJson(['result' => JSON_FAILURE]);
        }

    }

}