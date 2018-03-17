<?php

namespace engine\Controllers;


use engine\Models\GoodsModel;

class CategoryController extends Controller
{
    private $categoryes = [
      "men" => 2,
      "women" => 1
    ];


    public function man(){
        $this->content['content'] = 'pages/category.tmpl';
        $goodsModel = new GoodsModel($this->db);
        $this->content['goods'] = $goodsModel->getGoodsByCategory($this->categoryes['men']);
        $this->view->generate($this->content);
    }

    public function women(){
        $this->content['content'] = 'pages/category.tmpl';
        $goodsModel = new GoodsModel($this->db);
        $this->content['goods'] = $goodsModel->getGoodsByCategory($this->categoryes['women']);
        $this->view->generate($this->content);
    }
}