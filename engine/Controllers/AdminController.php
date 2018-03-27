<?php

namespace engine\Controllers;


use engine\components\Auth;
use engine\components\Request;
use engine\DB\DB;
use engine\Models\AdminModel;
use engine\Views\AdminView;
use engine\Views\IRender;

class AdminController extends Controller
{
    private $adminModel;
    protected $basisTmpl = "adminBase.tmpl";
    const ADMIN_ROLE_ID = 2;

    public function __construct(IRender $render, DB $db, Request $request, Auth $auth)
    {
        parent::__construct($render, $db, $request, $auth);
        if ($this->content['user']->getRgitole() != self::ADMIN_ROLE_ID) {
            header("location: /");
        }
        $this->render->setBaseTmpl($this->basisTmpl);
        $this->adminModel = new AdminModel($this->db);
    }

    public function index()
    {
        $this->content['content'] = "admin/indexAdmin.tmpl";
        $this->render->render($this->content);
    }

    public function orders()
    {
        $this->content['content'] = "admin/orders.tmpl";
        $this->render->render($this->content);
    }

    public function getOrders()
    {
        $ordersDate = $this->adminModel->getOrders();
        $result['orders'] = $ordersDate;
        $result['orders_quantity'] = count($ordersDate);
        echo json_encode($result);
    }

    public function deleteOrder()
    {
        if ($this->adminModel->deleteOrderById($this->request->getPostParams()['idOrder'])) {
            echo json_encode(['result' => JSON_SUCCESS]);
        } else {
            echo json_encode(['result' => JSON_FAILURE]);
        }
    }

    public function approveOrder()
    {
        if ($this->adminModel->approveOrder($this->request->getPostParams()['idOrder'])) {
            echo json_encode(['result' => JSON_SUCCESS]);
        } else {
            echo json_encode(['result' => JSON_FAILURE]);
        }
    }

    public function cancelApproveOrder()
    {
        if ($this->adminModel->cancelApproveOrder($this->request->getPostParams()['idOrder'])) {
            echo json_encode(['result' => JSON_SUCCESS]);
        } else {
            echo json_encode(['result' => JSON_FAILURE]);
        }
    }

    public function showOrderDetail()
    {
        $ordersDate = $this->adminModel->showOrderDetail($this->request->getPostParams()['idOrder']);
        if ($ordersDate) {
            $result['orderDetail'] = $ordersDate;
            $result['quantity'] = count($ordersDate);
            $result['result'] = JSON_SUCCESS;
            echo json_encode($result);
        } else {
            $result['result'] = JSON_FAILURE;
            echo json_encode($result);
        }
    }

}