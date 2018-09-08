<?php

namespace engine\Controllers;


use engine\components\App;
use engine\components\Response\AbstractResponse;
use engine\components\Response\ResponseJson;
use engine\components\response\ResponsePage;
use engine\Models\BasketModel;


class BasketController extends AbstractController
{

    const NOT_AUTH_STATUS = 2;

    public function addProduct():AbstractResponse
    {
        $basketModel = new BasketModel($this->db);
        $quantity = $this->request->getPostParams()['productQuantity'];
        if ($this->content['isAuth'] && $quantity > 0) {
            $result = $basketModel->addProduct($this->request->getPostParams()['id_product'],
                $this->auth->getUser()->getId(),
                $quantity);
            return new ResponseJson(["result" => $result]);
        } else {
            return new ResponseJson(["result" => self::NOT_AUTH_STATUS]);
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function loadBasket():AbstractResponse
    {
        $basketModel = new BasketModel($this->db);
        if ($this->content['isAuth']) {
            return new ResponseJson($basketModel->getBasket($this->auth->getUser()->getId()));
        } else {
            echo "under construct";
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function deleteProduct():AbstractResponse
    {
        $basketModel = new BasketModel($this->db);
        if ($this->content['isAuth']) {
            $result = $basketModel->delProduct($this->request->getPostParams()['id_product'], $this->auth->getUser()->getId());
            return new ResponseJson(["result" => $result]);
        } else {
            echo "under construct";
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function checkout():AbstractResponse
    {
        $this->content['content'] = 'pages/checkout.tmpl';
        return new ResponsePage($this->render->render($this->content));
    }

    public function cart():AbstractResponse
    {
        $this->content['content'] = 'pages/cart.tmpl';
        return new ResponsePage($this->render->render($this->content));
    }

    public function ajaxChangeQuantity():AbstractResponse
    {
        $basketModel = new BasketModel($this->db);
        $productQuantity = $this->request->getPostParams()['productQuantity'];
        if($productQuantity >= 0){
            $result = $basketModel->updateProduct($this->request->getPostParams()['id_product'],
                                                        $this->auth->getUser()->getId(),
                                                        $productQuantity);
            return new ResponseJson(["result" => $result]);
        }
        else{
            return new ResponseJson(["result" => JSON_WRONG]);
        }

    }
}