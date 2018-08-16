<?php

namespace engine\Controllers;


use engine\components\App;
use engine\Models\OrderModel;
use engine\Models\UserModel;
use engine\components\Response;


class UserController extends AbstractController
{

    public function registration()
    {
        $userModel = new UserModel(App::$db);
        $this->content['regStatus'] = $userModel->runRegistration();
        $this->content['content'] = 'pages/registration.tmpl';
        return new Response($this->render->render($this->content));
    }

    public function account()
    {
        $this->content['content'] = 'pages/account.tmpl';
        return new Response($this->render->render($this->content));
    }

    public function orders()
    {
        $orderModel = new OrderModel(App::$db);
        $this->content['content'] = 'pages/orders.tmpl';
        $this->content['orders'] = $orderModel->getOrdersByUser($this->content['user']->getId());
        return new Response($this->render->render($this->content));
    }

    public function order()
    {
        $orderModel = new OrderModel(App::$db);
        $this->content['content'] = 'pages/single-order.tmpl';
        $this->content['singleOrder'] = $orderModel->loadOrderById($this->content['user']->getId(), App::$request->getUrl()[3]);
        $totalPriceOrder = 0;
        foreach ($this->content['singleOrder'] as $key => $item) {
            $totalPriceOrder = $totalPriceOrder + ($item['price'] * $item['quantity']);
        }
        $this->content['totalPriceOrder'] = $totalPriceOrder;
        return new Response($this->render->render($this->content));
    }

    public function delorder()
    {
        if ($this->content['isAuth']) {
            $orderModel = new OrderModel(App::$db);
            $orderModel->deleteOrderById(App::$request->getUrl()[3], $this->content['user']->getId());
            header("location: /user/orders");
        }
    }

    public function ajaxCheckout()
    {
        $userModel = new UserModel(App::$db);
        if ($userModel->checkout($this->content['user']->getId())) {
            return new Response(json_encode(["result" => JSON_SUCCESS]));
        }

    }

}