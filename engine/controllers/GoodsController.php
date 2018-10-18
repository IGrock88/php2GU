<?php

namespace engine\controllers;



use engine\components\response\AbstractResponse;
use engine\components\response\ResponseJson;
use engine\models\GoodsModel;
use engine\components\response\ResponsePage;

class GoodsController extends AbstractController
{
    public function featureGoods():AbstractResponse
    {
        $goodsModel = new GoodsModel($this->db);
        if(isset($this->request->getPostParams()['featureGoods'])){

            $result['goods'] = $goodsModel->getFeatureGoods($this->request->getPostParams()['featureGoods'], $this->request->getPostParams()['startIndex']);
            if($result['goods']){
                $result['quantity'] = count($result['goods']);
                return new ResponseJson($result);
            }
            else{
                return new ResponseJson(['result' => JSON_WRONG]);
            }
        }
        else{
            return new ResponseJson(['result' => JSON_WRONG]);
        }

    }

    public function view():AbstractResponse
    {
        $goodsModel = new GoodsModel($this->db);
        $this->content['selectedGoods'] = $goodsModel->getGoodsById($this->request->getItemId());
        if($this->content['selectedGoods']){
            $this->content['content'] = 'pages/goods.tmpl';
            $this->content['recommendedProducts'] = $goodsModel->getFeatureGoods(4);
            $category = $this->content['selectedGoods']['category'];
            $category = substr($category, 0, stripos($category, "Collection"));
            $this->content['breadCrumbCategory'] = $category;
            return new ResponsePage($this->render->render($this->content));
        }
        else{
            return new ResponsePage('Упс, страницы нету', 404, ['Location: /error/error404']);
        }
    }
}