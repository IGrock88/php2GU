<?php

namespace engine\Controllers;


class BasketController extends Controller
{

    public function add()
    {
        echo "добавили товар";
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