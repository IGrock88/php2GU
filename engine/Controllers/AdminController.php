<?php

namespace engine\Controllers;


use engine\components\App;
use engine\components\Auth;
use engine\components\Request;
use engine\components\Response;
use engine\DB\DB;
use engine\Models\AdminModel;
use engine\Views\AdminView;
use engine\Views\IRender;

class AdminController extends Controller
{
    private $adminModel;
    protected $basisTmpl = "adminBase.tmpl";
    const ADMIN_ROLE_ID = 2;

    public function __construct(IRender $render)
    {
        parent::__construct($render);
        if ($this->content['user']->getRole() != self::ADMIN_ROLE_ID) {
            header("location: /");
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
        $this->content['content'] = "admin/addGoods.tmpl";
        return new Response($this->render->render($this->content));
    }

    public function goods()
    {
        $this->content['content'] = "admin/goods.tmpl";
        $adminModel = new AdminModel(DB::getInstance());

        var_dump(App::$request->getUrl()[3]);
        $goodsDate = $adminModel->getGoods(App::$request->getUrl()[3]);

        $this->content['products'] = $goodsDate;


        return new Response($this->render->render($this->content));
    }

}