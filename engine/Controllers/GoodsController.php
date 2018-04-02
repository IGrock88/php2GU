<?php

namespace engine\Controllers;



use engine\Models\GoodsModel;
use engine\components\App;
use engine\components\Response;

class GoodsController extends Controller
{
    public function featureGoods()
    {
        $goodsModel = new GoodsModel(App::$db);
        if(isset(App::$request->getPostParams()['featureGoods'])){

            $result['goods'] = $goodsModel->getFeatureGoods(App::$request->getPostParams()['featureGoods'], App::$request->getPostParams()['startIndex']);
            if($result['goods']){
                $result['quantity'] = count($result['goods']);
                return new Response(json_encode($result));
            }
            else{
                return new Response(json_encode(['result' => JSON_WRONG]));
            }
        }
        else{
            return new Response(json_encode(['result' => JSON_WRONG]));
        }

    }

    public function view()
    {
        $goodsModel = new GoodsModel(App::$db);
        $this->content['selectedGoods'] = $goodsModel->getGoodsById(App::$request->getUrl()[3]);
        if($this->content['selectedGoods']){
            $this->content['content'] = 'pages/goods.tmpl';
            $this->content['recommendedProducts'] = $goodsModel->getFeatureGoods(4);
            $category = $this->content['selectedGoods']['category'];
            $category = substr($category, 0, stripos($category, "Collection"));
            $this->content['breadCrumbCategory'] = $category;
            return new Response($this->render->render($this->content));
        }
        else{
            return new Response('Упс, страницы нету', 404, ['Location: /error/error404']);
        }
    }
}