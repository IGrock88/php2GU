<?php

namespace engine\Controllers;


use engine\components\App;
use engine\components\Response\ResponseJson;
use engine\components\response\ResponsePage;
use engine\Models\BasketModel;


class BasketController extends AbstractController
{

    const NOT_AUTH_STATUS = 2;

    public function addProduct()
    {
        $basketModel = new BasketModel(App::$db);
        $quantity = App::$request->getPostParams()['productQuantity'];
        if ($this->content['isAuth'] && $quantity > 0) {
            $result = $basketModel->addProduct(App::$request->getPostParams()['id_product'],
                $this->content['user']->getId(),
                $quantity);
            return new ResponseJson(["result" => $result]);
        } else {
            return new ResponseJson(["result" => self::NOT_AUTH_STATUS]);
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function loadBasket()
    {
        $basketModel = new BasketModel(App::$db);
        if ($this->content['isAuth']) {
            return new ResponseJson($basketModel->getBasket($this->content['user']->getId()));
        } else {
            echo "under construct";
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function deleteProduct()
    {
        $basketModel = new BasketModel(App::$db);
        if ($this->content['isAuth']) {
            $result = $basketModel->delProduct(App::$request->getPostParams()['id_product'], $this->content['user']->getId());
            return new ResponseJson(["result" => $result]);
        } else {
            echo "under construct";
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function checkout()
    {
        $this->content['content'] = 'pages/checkout.tmpl';
        return new ResponsePage($this->render->render($this->content));
    }

    public function cart()
    {
        $this->content['content'] = 'pages/cart.tmpl';
        return new ResponsePage($this->render->render($this->content));
    }

    public function ajaxChangeQuantity()
    {
        $basketModel = new BasketModel(App::$db);
        $productQuantity = App::$request->getPostParams()['productQuantity'];
        if($productQuantity >= 0){
            $result = $basketModel->updateProduct(App::$request->getPostParams()['id_product'],
                                                        $this->content['user']->getId(),
                                                        $productQuantity);
            return new ResponseJson(["result" => $result]);
        }
        else{
            return new ResponseJson(["result" => JSON_WRONG]);
        }

    }
}