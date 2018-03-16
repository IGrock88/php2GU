<?php

namespace engine\Controllers;


use engine\Models\BasketModel;

class BasketController extends Controller
{

    const NOT_AUTH_STATUS = 2;

    public function addProduct()
    {
        $basketModel = new BasketModel($this->db);
        if ($this->content['isAuth']) {
            $result = $basketModel->addProduct($this->request->getPostParams()['id_product'],
                $this->content['user']->getId(),
                $this->request->getPostParams()['productQuantity']);
            echo json_encode(["result" => $result]);
        } else {
            echo json_encode(["result" => NOT_AUTH_STATUS]);
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function loadBasket()
    {
        $basketModel = new BasketModel($this->db);
        if ($this->content['isAuth']) {
            echo $basketModel->getJSONBasket($this->content['user']->getId());
        } else {
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function deleteProduct()
    {
        $basketModel = new BasketModel($this->db);
        if ($this->content['isAuth']) {
            $result = $basketModel->delProduct($this->request->getPostParams()['id_product'], $this->content['user']->getId());
            echo json_encode(["result" => $result]);
        } else {
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

    public function ajaxChangeQuantity()
    {
        $basketModel = new BasketModel($this->db);
        $productQuantity = $this->request->getPostParams()['productQuantity'];
        if($productQuantity >= 0){
            $result = $basketModel->updateProduct($this->request->getPostParams()['id_product'],
                                                        $this->content['user']->getId(),
                                                        $productQuantity);
            echo json_encode(["result" => $result]);
        }
        else{
            echo json_encode(["result" => JSON_WRONG]);
        }

    }
}