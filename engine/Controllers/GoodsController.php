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
        if(isset($_POST['featureGoods'])){

            $result['goods'] = $this->goodsModel->getFeatureGoods($_POST['featureGoods'], $_POST['startIndex']);
            if($result['goods']){
                $result['quantity'] = count($result['goods']);
                echo json_encode($result);
            }
            else{
                echo json_encode(['result' => 2]);
            }
        }
        else{
            echo json_encode("не удача");
        }

    }

    public function view()
    {
        $this->content['selected-goods'] = $this->goodsModel->getGoodsById(explode("/", $_SERVER['REQUEST_URI'])[3]);
        if($this->content['selected-goods']){
            $this->content['content'] = 'templates/goods.php';
            $this->content['recommended-products'] = $this->goodsModel->getFeatureGoods(4);
            $this->view->generate($this->content);
        }
        else{
            header('Location: /error404');
        }
    }
}