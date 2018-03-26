<?php

namespace engine\Controllers;


use engine\Models\AdminModel;
use engine\Views\AdminView;
use engine\Views\TwigRender;

class AdminController extends Controller
{
    private $adminModel;
    protected $basisTmpl = "adminBase.tmpl";

    public function __construct()
    {
        parent::__construct();
        if ($this->content['user']->getRole() != 2) {
            header("location: /");
        }
        $this->view = new TwigRender($this->basisTmpl);
        $this->adminModel = new AdminModel($this->db);
    }

    public function index()
    {
        $this->content['content'] = "admin/indexAdmin.tmpl";
        $this->render(new TwigRender($this->basisTmpl));
    }

    public function orders()
    {
        $this->content['content'] = "admin/orders.tmpl";
        $this->render(new TwigRender($this->basisTmpl));
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