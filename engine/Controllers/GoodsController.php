<?php

namespace engine\Controllers;



use engine\Models\GoodsModel;

class GoodsController extends Controller
{
    private $goodsModel;

    public function __construct()
    {
        parent::__construct();
        $this->goodsModel = new GoodsModel($this->db);
    }

    public function featureGoods()
    {
        if(isset($this->request->getPostParams()['featureGoods'])){

            $result['goods'] = $this->goodsModel->getFeatureGoods($this->request->getPostParams()['featureGoods'], $this->request->getPostParams()['startIndex']);
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
        $this->content['selectedGoods'] = $this->goodsModel->getGoodsById($this->request->getUrl()[3]);
        if($this->content['selectedGoods']){
            $this->content['content'] = 'pages/goods.tmpl';
            $this->content['recommendedProducts'] = $this->goodsModel->getFeatureGoods(4);
            $this->view->generate($this->content);
        }
        else{
            header('Location: /error404');
        }
    }
}