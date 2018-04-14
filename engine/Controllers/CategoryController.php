<?php

namespace engine\Controllers;


use engine\Models\GoodsModel;
use engine\components\App;
use engine\components\Response;

class CategoryController extends Controller
{
    private $categoryes = [
      "men" => 2,
      "women" => 1,
        "kids" => 3
    ];


    public function men(){
        $this->content['content'] = 'pages/category.tmpl';
        $this->content['idCategory'] = $this->categoryes['men'];
        $this->content['breadCrumbCategory'] = 'men';
        return new Response($this->render->render($this->content));
    }

    public function women(){
        $this->content['content'] = 'pages/category.tmpl';
        $this->content['idCategory'] = $this->categoryes['women'];
        $this->content['breadCrumbCategory'] = 'women';
        return new Response($this->render->render($this->content));
    }

    public function kids(){
        $this->content['content'] = 'pages/category.tmpl';
        $this->content['idCategory'] = $this->categoryes['kids'];
        $this->content['breadCrumbCategory'] = 'kids';
        return new Response($this->render->render($this->content));
    }

    public function ajaxLoadGoodsByCategory()
    {
        $goodsModel = new GoodsModel(App::$db);

        $idCategory = App::$request->getPostParams()['idCategory'];
        $date = $goodsModel->getGoodsByCategory($idCategory,
            App::$request->getPostParams()['startIndex'],
            App::$request->getPostParams()['quantityGoods']);
        if($date){
            $result['goods'] = $date;
            $result['quantity'] = count($date);
            $result['result'] = JSON_SUCCESS;
            $result['totalQuantity'] = $goodsModel->getGoodsQuantityByCategory($idCategory);
            return new Response(json_encode($result));
        }
    }

}