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
        echo "добавили товар";
    }

    public function loadBasket()
    {
        if($this->content['isAuth']) {
            echo $this->basketModel->loadBasketGoods($this->content['user']->getId());
        }
        else{
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function deleteProduct(){

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