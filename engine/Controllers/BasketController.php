<?php

namespace engine\Controllers;


use engine\Models\BasketModel;

class BasketController extends Controller
{

    private $basketModel;

    public function __construct()
    {
        parent::__construct();
        $this->basketModel = new BasketModel($this->db);
    }

    public function addProduct()
    {
        if($this->content['isAuth']) {
           $result = $this->basketModel->addProduct($this->request->getPostParams()['id_product'], $this->content['user']->getId());
           echo json_encode(["result" => $result]);
        }
        else{
            echo json_encode(["result" => 2]);
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function loadBasket()
    {
        if($this->content['isAuth']) {
            echo $this->basketModel->getJSONBasket($this->content['user']->getId());
        }
        else{
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function deleteProduct()
    {
        if($this->content['isAuth']) {
            $result = $this->basketModel->delProduct($this->request->getPostParams()['id_product'] ,$this->content['user']->getId());
            echo json_encode(["result" => $result]);
        }
        else{
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function checkout()
    {
        $this->content['content'] = 'pages/checkout.tmpl';
        $this->view->generate($this->content);
    }

    public function cart()
    {
        $this->content['content'] = 'pages/cart.tmpl';
        $this->view->generate($this->content);
    }
}