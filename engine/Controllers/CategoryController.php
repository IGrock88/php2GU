<?php

namespace engine\Controllers;


use engine\Models\GoodsModel;
use engine\Views\TwigRender;

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
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function women(){
        $this->content['content'] = 'pages/category.tmpl';
        $this->content['idCategory'] = $this->categoryes['women'];
        $this->content['breadCrumbCategory'] = 'women';
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function kids(){
        $this->content['content'] = 'pages/category.tmpl';
        $this->content['idCategory'] = $this->categoryes['kids'];
        $this->content['breadCrumbCategory'] = 'kids';
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function ajaxLoadGoodsByCategory()
    {
        $goodsModel = new GoodsModel($this->db);
        $idCategory = $this->request->getPostParams()['idCategory'];
        $date = $goodsModel->getGoodsByCategory($idCategory,
                                        $this->request->getPostParams()['startIndex'],
                                        $this->request->getPostParams()['quantityGoods']);
        if($date){
            $result['goods'] = $date;
            $result['quantity'] = count($date);
            $result['result'] = 1;
            $result['totalQuantity'] = $goodsModel->getGoodsQuantityByCategory($idCategory);
            echo json_encode($result);
        }
    }

}