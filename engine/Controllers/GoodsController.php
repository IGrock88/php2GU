<?php

namespace engine\Controllers;



use engine\Models\GoodsModel;
use engine\components\App;

class GoodsController extends Controller
{
    public function featureGoods()
    {
        $goodsModel = new GoodsModel(App::$db);
        if(isset(App::$request->getPostParams()['featureGoods'])){

            $result['goods'] = $goodsModel->getFeatureGoods(App::$request->getPostParams()['featureGoods'], App::$request->getPostParams()['startIndex']);
            if($result['goods']){
                $result['quantity'] = count($result['goods']);
                echo json_encode($result);
            }
            else{
                echo json_encode(['result' => 2]);
            }
        }
        else{
            echo json_encode(['result' => 2]);
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
            $this->render->render($this->content);
        }
        else{
            header('Location: /error404');
        }
    }
}