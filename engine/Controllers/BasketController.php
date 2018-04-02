<?php

namespace engine\Controllers;


use engine\components\App;
use engine\components\Response;
use engine\Models\BasketModel;


class BasketController extends Controller
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
            return new Response(json_encode(["result" => $result]));
        } else {
            return new Response(json_encode(["result" => self::NOT_AUTH_STATUS]));
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function loadBasket()
    {
        $basketModel = new BasketModel(App::$db);
        if ($this->content['isAuth']) {
            return new Response($basketModel->getJSONBasket($this->content['user']->getId()));
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
            return new Response(json_encode(["result" => $result]));
        } else {
            echo "under construct";
            //TODO: сделать корзину для не авторизованных пользователй с помощью куки
        }
    }

    public function checkout()
    {
        $this->content['content'] = 'pages/checkout.tmpl';
        return new Response($this->render->render($this->content));
    }

    public function cart()
    {
        $this->content['content'] = 'pages/cart.tmpl';
        return new Response($this->render->render($this->content));
    }

    public function ajaxChangeQuantity()
    {
        $basketModel = new BasketModel(App::$db);
        $productQuantity = App::$request->getPostParams()['productQuantity'];
        if($productQuantity >= 0){
            $result = $basketModel->updateProduct(App::$request->getPostParams()['id_product'],
                                                        $this->content['user']->getId(),
                                                        $productQuantity);
            return new Response(json_encode(["result" => $result]));
        }
        else{
            return new Response(json_encode(["result" => JSON_WRONG]));
        }

    }
}