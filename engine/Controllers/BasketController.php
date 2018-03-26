<?php

namespace engine\Controllers;


use engine\Models\BasketModel;
use engine\Views\TwigRender;

class BasketController extends Controller
{

    const NOT_AUTH_STATUS = 2;

    public function addProduct()
    {
        $basketModel = new BasketModel($this->db);
        $quantity = $this->request->getPostParams()['productQuantity'];
        if ($this->content['isAuth'] && $quantity > 0) {
            $result = $basketModel->addProduct($this->request->getPostParams()['id_product'],
                $this->content['user']->getId(),
                $quantity);
            echo json_encode(["result" => $result]);
        } else {
            echo json_encode(["result" => self::NOT_AUTH_STATUS]);
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
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function cart()
    {
        $this->content['content'] = 'pages/cart.tmpl';
        $this->render(new TwigRender($this->basisTmpl));
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