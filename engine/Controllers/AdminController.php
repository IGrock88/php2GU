<?php

namespace engine\Controllers;


use engine\components\App;
use engine\components\Response\AbstractResponse;
use engine\components\Response\ResponseJson;
use engine\components\response\ResponsePage;
use engine\Models\AdminModel;
use engine\Models\GoodsModel;
use engine\Models\ImageUploadModel;
use engine\Views\IRender;

class AdminController extends AbstractController
{
    private $adminModel;
    protected $basisTmpl = "adminBase.tmpl";
    const ADMIN_ROLE_ID = 2;
    const DEFAULT_GOODS_QUANTITY_ON_PAGE = 12;
    const GOODS_IMG_DIR = "public/img/goods/";
    const IMG_DIR_DB = "img/goods/";

    public function __construct(IRender $render)
    {
        parent::__construct($render);
        if ($this->content['user']->getRole() != self::ADMIN_ROLE_ID) {
            return new ResponsePage('Access denied', 403, ["location: /"]);
        }
        $this->render->setBaseTmpl($this->basisTmpl);
        $this->adminModel = new AdminModel(App::$db);
    }

    public function index():AbstractResponse
    {
        $this->content['content'] = "admin/indexAdmin.tmpl";
        return new ResponsePage($this->render->render($this->content));
    }

    public function orders():AbstractResponse
    {
        $this->content['content'] = "admin/orders.tmpl";
        return new ResponsePage($this->render->render($this->content));
    }

    public function getOrders():AbstractResponse
    {
        $ordersDate = $this->adminModel->getOrders();
        $result['orders'] = $ordersDate;
        $result['orders_quantity'] = count($ordersDate);
        return new ResponseJson($result);
    }

    public function deleteOrder():AbstractResponse
    {
        if ($this->adminModel->deleteOrderById(App::$request->getPostParams()['idOrder'])) {
            return new ResponseJson(['result' => JSON_SUCCESS]);
        } else {
            return new ResponseJson(['result' => JSON_FAILURE]);
        }
    }

    public function approveOrder():AbstractResponse
    {
        if ($this->adminModel->approveOrder(App::$request->getPostParams()['idOrder'])) {
            return new ResponseJson(['result' => JSON_SUCCESS]);
        } else {
            return new ResponseJson(['result' => JSON_FAILURE]);
        }
    }

    public function cancelApproveOrder():AbstractResponse
    {
        if ($this->adminModel->cancelApproveOrder(App::$request->getPostParams()['idOrder'])) {
            return new ResponseJson(['result' => JSON_SUCCESS]);
        } else {
            return new ResponseJson(['result' => JSON_FAILURE]);
        }
    }

    public function showOrderDetail():AbstractResponse
    {
        $ordersDate = $this->adminModel->showOrderDetail(App::$request->getPostParams()['idOrder']);
        if ($ordersDate) {
            $result['orderDetail'] = $ordersDate;
            $result['quantity'] = count($ordersDate);
            $result['result'] = JSON_SUCCESS;
            return new ResponseJson($result);
        } else {
            $result['result'] = JSON_FAILURE;
            return new ResponseJson($result);
        }
    }

    public function addGoods():AbstractResponse
    {
        $goodsModel = new GoodsModel(App::$db);
        $this->content['content'] = "admin/addGoods.tmpl";
        $this->content['designers'] = $goodsModel->getDesigner();
        $this->content['categories'] = $goodsModel->getCategories();
        $this->content['materials'] = $this->adminModel->getMaterials();
        return new ResponsePage($this->render->render($this->content));
    }

    public function addNewProduct():AbstractResponse
    {

        $request = App::$request;
        $newProductData = $request->getPostParams()['newProductData'];
        if($this->adminModel->addNewProduct($newProductData)){
            $result['result'] = JSON_SUCCESS;
        }
        else{
            $result['result'] = JSON_FAILURE;
        }
        return new ResponseJson($result);
    }

    public function goods():AbstractResponse
    {
        $activePage = App::$request->getUrl()[3];
        $quantityGoods = self::DEFAULT_GOODS_QUANTITY_ON_PAGE;
        $this->content['content'] = "admin/goodsAdmin.tmpl";
        $goodsDate = $this->adminModel->getGoods($activePage, $quantityGoods);
        $this->content['activePage'] = $activePage;
        $this->content['products'] = $goodsDate;

        $this->content['quantityPages'] = ceil($this->adminModel->getGoodsQuantity() / $quantityGoods);
        return new ResponsePage($this->render->render($this->content));
    }

    public function goodsTitleImage():AbstractResponse
    {
        $this->content['content'] = "admin/goodsTitleImage.tmpl";
        $this->content['idProduct'] = App::$request->getUrl()[3];
        return new ResponsePage($this->render->render($this->content));
    }

    public function addTitleImage():AbstractResponse
    {
        $imageModel = new ImageUploadModel(App::$db);
        $request = App::$request;
        $result = $imageModel->uploadFile($request->getPostParams()['idProduct'], $request->getFiles()['titleImage'],
            self::GOODS_IMG_DIR, self::IMG_DIR_DB);
        if($result){
            return new ResponseJson(['result' => JSON_SUCCESS]);
        }
        else{
            return new ResponseJson(['result' => $result]);
        }
    }

    public function getTitleImg():AbstractResponse
    {
        $result = $this->adminModel->getTitleImg(App::$request->getPostParams()['idProduct']);
        if($result){
            $result['result'] = JSON_SUCCESS;
            return new ResponseJson($result);
        }
        else{
            return new ResponseJson(['result' => JSON_FAILURE]);
        }

    }

}