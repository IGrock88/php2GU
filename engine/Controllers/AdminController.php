<?php

namespace engine\Controllers;


use engine\components\App;
use engine\components\Auth;
use engine\components\Request;
use engine\components\Response;
use engine\DB\DB;
use engine\Models\AdminModel;
use engine\Models\GoodsModel;
use engine\Models\ImageUploadModel;
use engine\Views\AdminView;
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
            return new Response('Access denied', 403, ["location: /"]);
        }
        $this->render->setBaseTmpl($this->basisTmpl);
        $this->adminModel = new AdminModel(App::$db);
    }

    public function index()
    {
        $this->content['content'] = "admin/indexAdmin.tmpl";
        return new Response($this->render->render($this->content));
    }

    public function orders()
    {
        $this->content['content'] = "admin/orders.tmpl";
        return new Response($this->render->render($this->content));
    }

    public function getOrders()
    {
        $ordersDate = $this->adminModel->getOrders();
        $result['orders'] = $ordersDate;
        $result['orders_quantity'] = count($ordersDate);
        return new Response(json_encode($result));
    }

    public function deleteOrder()
    {
        if ($this->adminModel->deleteOrderById(App::$request->getPostParams()['idOrder'])) {
            return new Response(json_encode(['result' => JSON_SUCCESS]));
        } else {
            return new Response(json_encode(['result' => JSON_FAILURE]));
        }
    }

    public function approveOrder()
    {
        if ($this->adminModel->approveOrder(App::$request->getPostParams()['idOrder'])) {
            return new Response(json_encode(['result' => JSON_SUCCESS]));
        } else {
            return new Response(json_encode(['result' => JSON_FAILURE]));
        }
    }

    public function cancelApproveOrder()
    {
        if ($this->adminModel->cancelApproveOrder(App::$request->getPostParams()['idOrder'])) {
            return new Response(json_encode(['result' => JSON_SUCCESS]));
        } else {
            return new Response(json_encode(['result' => JSON_FAILURE]));
        }
    }

    public function showOrderDetail()
    {
        $ordersDate = $this->adminModel->showOrderDetail(App::$request->getPostParams()['idOrder']);
        if ($ordersDate) {
            $result['orderDetail'] = $ordersDate;
            $result['quantity'] = count($ordersDate);
            $result['result'] = JSON_SUCCESS;
            return new Response(json_encode($result));
        } else {
            $result['result'] = JSON_FAILURE;
            return new Response(json_encode($result));
        }
    }

    public function addGoods()
    {
        $goodsModel = new GoodsModel(App::$db);
        $this->content['content'] = "admin/addGoods.tmpl";
        $this->content['designers'] = $goodsModel->getDesigner();
        $this->content['categories'] = $goodsModel->getCategories();
        $this->content['materials'] = $this->adminModel->getMaterials();
        return new Response($this->render->render($this->content));
    }

    public function addNewProduct()
    {

        $request = App::$request;
        $newProductData = $request->getPostParams()['newProductData'];
        if($this->adminModel->addNewProduct($newProductData)){
            $result['result'] = JSON_SUCCESS;
        }
        else{
            $result['result'] = JSON_FAILURE;
        }
        return new Response(json_encode($result));
    }

    public function goods()
    {
        $activePage = App::$request->getUrl()[3];
        $quantityGoods = self::DEFAULT_GOODS_QUANTITY_ON_PAGE;
        $this->content['content'] = "admin/goodsAdmin.tmpl";
        $goodsDate = $this->adminModel->getGoods($activePage, $quantityGoods);
        $this->content['activePage'] = $activePage;
        $this->content['products'] = $goodsDate;

        $this->content['quantityPages'] = ceil($this->adminModel->getGoodsQuantity() / $quantityGoods);
        return new Response($this->render->render($this->content));
    }

    public function goodsTitleImage()
    {
        $this->content['content'] = "admin/goodsTitleImage.tmpl";
        $this->content['idProduct'] = App::$request->getUrl()[3];
        return new Response($this->render->render($this->content));
    }

    public function addTitleImage()
    {
        $imageModel = new ImageUploadModel(App::$db);
        $request = App::$request;
        $result = $imageModel->uploadFile($request->getPostParams()['idProduct'], $request->getFiles()['titleImage'],
            self::GOODS_IMG_DIR, self::IMG_DIR_DB);
        if($result){
            return new Response(json_encode(['result' => JSON_SUCCESS]));
        }
        else{
            return new Response(json_encode(['result' => $result]));
        }
    }

    public function getTitleImg()
    {
        $result = $this->adminModel->getTitleImg(App::$request->getPostParams()['idProduct']);
        if($result){
            $result['result'] = JSON_SUCCESS;
            return new Response(json_encode($result));
        }
        else{
            return new Response(json_encode(['result' => JSON_FAILURE] ));
        }

    }

}