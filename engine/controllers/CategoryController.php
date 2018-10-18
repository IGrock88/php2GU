<?php

namespace engine\controllers;


use engine\components\response\AbstractResponse;
use engine\components\response\ResponseJson;
use engine\models\GoodsModel;
use engine\components\App;
use engine\components\response\ResponsePage;

class CategoryController extends AbstractController
{
    private $categoryes = [
      "men" => 2,
      "women" => 1,
        "kids" => 3
    ];



    public function men():AbstractResponse
    {
        $this->content['content'] = 'pages/category.tmpl';
        $goodsModel = new GoodsModel($this->db);
        $this->content['designers'] = $goodsModel->getDesigner();
        $this->content['idCategory'] = $this->categoryes['men'];
        $this->content['breadCrumbCategory'] = 'men';
        return new ResponsePage($this->render->render($this->content));
    }

    public function women():AbstractResponse
    {
        $this->content['content'] = 'pages/category.tmpl';
        $goodsModel = new GoodsModel($this->db);
        $this->content['designers'] = $goodsModel->getDesigner();
        $this->content['idCategory'] = $this->categoryes['women'];
        $this->content['breadCrumbCategory'] = 'women';
        return new ResponsePage($this->render->render($this->content));
    }

    public function kids():AbstractResponse
    {
        $this->content['content'] = 'pages/category.tmpl';
        $goodsModel = new GoodsModel($this->db);
        $this->content['designers'] = $goodsModel->getDesigner();
        $this->content['idCategory'] = $this->categoryes['kids'];
        $this->content['breadCrumbCategory'] = 'kids';
        return new ResponsePage($this->render->render($this->content));
    }

    public function ajaxLoadGoodsByCategory():AbstractResponse
    {
        $goodsModel = new GoodsModel($this->db);

        $idCategory = $this->request->getPostParams()['idCategory'];
        $date = $goodsModel->getGoodsByCategory($idCategory,
            $this->request->getPostParams()['startIndex'],
            $this->request->getPostParams()['quantityGoods']);
        if($date){
            $result['goods'] = $date;
            $result['quantity'] = count($date);
            $result['result'] = JSON_SUCCESS;
            $result['totalQuantity'] = $goodsModel->getGoodsQuantityByCategory($idCategory);
            return new ResponseJson($result);
        }
    }

//    private function prepareContent(){
//        $goodsModel = new GoodsModel($this->db);
//        $this->content['designers'] = $goodsModel->getDesigner();
//        $this->content['categories'] = $goodsModel->getCategories();
//    }

}