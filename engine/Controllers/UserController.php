<?php

namespace engine\Controllers;


use engine\components\App;
use engine\components\Response\AbstractResponse;
use engine\components\Response\ResponseJson;
use engine\Models\OrderModel;
use engine\Models\UserModel;
use engine\components\response\ResponsePage;


class UserController extends AbstractController
{

    public function registration():AbstractResponse
    {
        $userModel = new UserModel(App::$db);
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
        $orderModel = new OrderModel(App::$db);
        $this->content['content'] = 'pages/orders.tmpl';
        $this->content['orders'] = $orderModel->getOrdersByUser($this->content['user']->getId());
        return new ResponsePage($this->render->render($this->content));
    }

    public function order():AbstractResponse
    {
        $orderModel = new OrderModel(App::$db);
        $this->content['content'] = 'pages/single-order.tmpl';
        $this->content['singleOrder'] = $orderModel->loadOrderById($this->content['user']->getId(), App::$request->getUrl()[3]);
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
            $orderModel = new OrderModel(App::$db);
            $orderModel->deleteOrderById(App::$request->getUrl()[3], $this->content['user']->getId());
            header("location: /user/orders");
        }
    }

    public function ajaxCheckout():AbstractResponse
    {
        $userModel = new UserModel(App::$db);
        if ($userModel->checkout($this->content['user']->getId())) {
            return new ResponseJson(["result" => JSON_SUCCESS]);
        }

    }

}